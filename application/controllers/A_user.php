<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class A_user extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('A_user_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . 'a_user/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'a_user/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'a_user/index.html';
            $config['first_url'] = base_url() . 'a_user/index.html';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->A_user_model->total_rows($q);
        $a_user = $this->A_user_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'a_user_data' => $a_user,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
            'judul_page' => 'Users List',
            'konten' => 'a_user/a_user_list',
        );
        $this->load->view('v_index', $data);
    }

    public function read($id) 
    {
        $row = $this->A_user_model->get_by_id($id);
        if ($row) {
            $data = array(
        'id_user' => $row->id_user,
        'nama_lengkap' => $row->nama_lengkap,
        'username' => $row->username,
        'password' => $row->password,
        'level' => $row->level,
        'foto' => $row->foto,
        );
            $this->load->view('a_user/a_user_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('a_user'));
        }
    }

    public function create() 
    {
        $data = array(
            'judul_page' => 'Users/Create',
            'konten' => 'a_user/a_user_form',
            'button' => 'Create',
            'action' => site_url('a_user/create_action'),
        'id_user' => set_value('id_user'),
        'nama_lengkap' => set_value('nama_lengkap'),
        'username' => set_value('username'),
        'password' => set_value('password'),
        'level' => set_value('level'),
        'foto' => set_value('foto'),
        'jenis_kendaraan' => set_value('jenis_kendaraan'),
        'no_plat' => set_value('no_plat'),
        'alamat' => set_value('alamat'),
    );
        $this->load->view('v_index', $data);
    }
    
    public function create_driver()
    {
        $id_user=$this->input->post('id_user');
        $jenis_kendaraan=$this->input->post('jenis_kendaraan');
        $no_plat=$this->input->post('no_plat');
        $alamat=$this->input->post('alamat');

        $data=array(
            'id_user'=>$id_user,
            'jenis_kendaraan'=>$jenis_kendaraan,
            'no_plat'=>$no_plat,
            'alamat'=>$no_plat
        );

        $this->db->insert('data_driver',$data);
    }

    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $img = upload_gambar_biasa('user', 'image/user/', 'jpg|png|jpeg', 10000, 'foto');
            $data = array(
        'nama_lengkap' => $this->input->post('nama_lengkap',TRUE),
        'username' => $this->input->post('username',TRUE),
        'password' => $this->input->post('password',TRUE),
        'level' => $this->input->post('level',TRUE),
        'foto' => $img,
        );

        $this->A_user_model->insert($data);
        $id_usernya=$this->db->query("select id_user from users order by id_user DESC")->row_array();
        if($this->input->post('level')=="driver")
        {
        $id_user=$this->input->post('id_user');
        $jenis_kendaraan=$this->input->post('jenis_kendaraan');
        $no_plat=$this->input->post('no_plat');
        $alamat=$this->input->post('alamat');

        $data_driver=array(
            'id_user'=>$id_usernya['id_user'],
            'jenis_kendaraan'=>$jenis_kendaraan,
            'no_plat'=>$no_plat,
            'alamat'=>$alamat
        );

        $this->db->insert('data_driver',$data_driver);
        }
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('a_user'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->A_user_model->get_by_id($id);
        $row_driver=$this->db->query("select * from data_driver where id_user='$id'")->row_array();
        if ($row) {
            $data = array(
                'judul_page' => 'Users/Update',
                'konten' => 'a_user/a_user_form',
                'button' => 'Update',
                'action' => site_url('a_user/update_action'),
        'id_user' => set_value('id_user', $row->id_user),
        'nama_lengkap' => set_value('nama_lengkap', $row->nama_lengkap),
        'username' => set_value('username', $row->username),
        'password' => set_value('password', $row->password),
        'level' => set_value('level', $row->level),
        'foto' => set_value('foto', $row->foto),
        'jenis_kendaraan' => set_value('jenis_kendaraan',$row_driver['jenis_kendaraan']),
        'no_plat' => set_value('no_plat',$row_driver['no_plat']),
        'alamat' => set_value('alamat',$row_driver['alamat']),
        );
            $this->load->view('v_index', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('a_user'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();
        $id=$this->input->post('id_user');
        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_user', TRUE));
        } else {
            $data = array(
        'nama_lengkap' => $this->input->post('nama_lengkap',TRUE),
        'username' => $this->input->post('username',TRUE),
        'password' => $retVal = ($this->input->post('password') == '') ? $_POST['password_old'] :$this->input->post('password',TRUE),
        'level' => $this->input->post('level',TRUE),
        'foto' => $retVal = ($_FILES['foto']['name'] == '') ? $_POST['foto_old'] : upload_gambar_biasa('user', 'image/user/', 'jpeg|png|jpg|gif', 10000, 'foto'),
        );

            $this->A_user_model->update($this->input->post('id_user', TRUE), $data);

            if($this->input->post('level')=="driver")
                {
                    $jenis_kendaraan=$this->input->post('jenis_kendaraan');
                    $no_plat=$this->input->post('no_plat');
                    $alamat=$this->input->post('alamat');
                    $this->db->query("update data_driver set jenis_kendaraan='$jenis_kendaraan',no_plat='$no_plat',alamat='$alamat' where id_user='$id'");
                }

            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('a_user'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->A_user_model->get_by_id($id);

        if ($row) {
            $this->A_user_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('a_user'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('a_user'));
        }
    }

    public function _rules() 
    {
    $this->form_validation->set_rules('nama_lengkap', 'nama lengkap', 'trim|required');
    $this->form_validation->set_rules('username', 'username', 'trim|required');
    // $this->form_validation->set_rules('password', 'password', 'trim|required');
    $this->form_validation->set_rules('level', 'level', 'trim|required');
    // $this->form_validation->set_rules('foto', 'foto', 'trim|required');

    $this->form_validation->set_rules('id_user', 'id_user', 'trim');
    $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file A_user.php */
/* Location: ./application/controllers/A_user.php */
/* Please DO NOT modify this information : */
/* Generated by Boy Kurniawan 2019-11-21 01:33:36 */
/* https://jualkoding.com */