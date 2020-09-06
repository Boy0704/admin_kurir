<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Data_driver extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Data_driver_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . 'data_driver/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'data_driver/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'data_driver/index.html';
            $config['first_url'] = base_url() . 'data_driver/index.html';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Data_driver_model->total_rows($q);
        $data_driver = $this->Data_driver_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'data_driver_data' => $data_driver,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
            'judul_page' => 'data_driver/data_driver_list',
            'konten' => 'data_driver/data_driver_list',
        );
        $this->load->view('v_index', $data);
    }

    public function read($id) 
    {
        $row = $this->Data_driver_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id_driver' => $row->id_driver,
		'id_user' => $row->id_user,
		'jenis_kendaraan' => $row->jenis_kendaraan,
		'no_plat' => $row->no_plat,
		'alamat' => $row->alamat,
		'lat' => $row->lat,
		'lng' => $row->lng,
		'status' => $row->status,
	    );
            $this->load->view('data_driver/data_driver_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('data_driver'));
        }
    }

    public function create() 
    {
        $data = array(
            'judul_page' => 'data_driver/data_driver_form',
            'konten' => 'data_driver/data_driver_form',
            'button' => 'Create',
            'action' => site_url('data_driver/create_action'),
	    'id_driver' => set_value('id_driver'),
	    'id_user' => set_value('id_user'),
	    'jenis_kendaraan' => set_value('jenis_kendaraan'),
	    'no_plat' => set_value('no_plat'),
	    'alamat' => set_value('alamat'),
	    'lat' => set_value('lat'),
	    'lng' => set_value('lng'),
	    'status' => set_value('status'),
	);
        $this->load->view('v_index', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'id_user' => $this->input->post('id_user',TRUE),
		'jenis_kendaraan' => $this->input->post('jenis_kendaraan',TRUE),
		'no_plat' => $this->input->post('no_plat',TRUE),
		'alamat' => $this->input->post('alamat',TRUE),
		'lat' => $this->input->post('lat',TRUE),
		'lng' => $this->input->post('lng',TRUE),
		'status' => $this->input->post('status',TRUE),
	    );

            $this->Data_driver_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('data_driver'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Data_driver_model->get_by_id($id);
        $rows=$this->db->get_where('users',array('id_user'=>$id))->row();

        if ($row) {
            $data = array(
                'judul_page' => 'data_driver/data_driver_form',
                'konten' => 'data_driver/data_driver_form2',
                'button' => 'Update',
                'action' => site_url('data_driver/update_action'),
		'id_driver' => set_value('id_driver', $row->id_driver),
		'id_user' => set_value('id_user', $row->id_user),
		'nama_lengkap' => set_value('nama_lengkap', $rows->nama_lengkap),
		'username' => set_value('username', $rows->username),
		'password' => set_value('password', $rows->password),
		'jenis_kendaraan' => set_value('jenis_kendaraan', $row->jenis_kendaraan),
		'no_plat' => set_value('no_plat', $row->no_plat),
		'alamat' => set_value('alamat', $row->alamat),
		'lat' => set_value('lat', $row->lat),
		'lng' => set_value('lng', $row->lng),
		'status' => set_value('status', $row->status),
	    );
            $this->load->view('v_index', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('data_driver'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_user', TRUE));
        } else {
            $data = array(
		'id_user' => $this->input->post('id_user',TRUE),
		'jenis_kendaraan' => $this->input->post('jenis_kendaraan',TRUE),
		'no_plat' => $this->input->post('no_plat',TRUE),
		'alamat' => $this->input->post('alamat',TRUE),
		'lat' => $this->input->post('lat',TRUE),
		'lng' => $this->input->post('lng',TRUE),
		'status' => $this->input->post('status',TRUE),
	    );

            $this->Data_driver_model->update($this->input->post('id_user', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('data_driver'));
        }
    }
    
    public function confirm($id) 
    {
        $row = $this->Data_driver_model->get_by_id($id);
        $rows=$this->db->get_where('users',array('id_user'=>$id))->row();

        if ($row) {
            $data = array(
                'judul_page' => 'data_driver/data_driver_form',
                'konten' => 'data_driver/data_driver_form',
                'button' => 'Konfirmasi',
                'action' => site_url('data_driver/confirm_action'),
		'id_driver' => set_value('id_driver', $row->id_driver),
		'id_user' => set_value('id_user', $row->id_user),
		'nama_lengkap' => set_value('nama_lengkap', $rows->nama_lengkap),
		'username' => set_value('username', $rows->username),
		'password' => set_value('password', $rows->password),
		'jenis_kendaraan' => set_value('jenis_kendaraan', $row->jenis_kendaraan),
		'no_plat' => set_value('no_plat', $row->no_plat),
		'alamat' => set_value('alamat', $row->alamat),
		'lat' => set_value('lat', $row->lat),
		'lng' => set_value('lng', $row->lng),
		'status' => set_value('status', $row->status),
	    );
            $this->load->view('v_index', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('data_driver'));
        }
    }
    
    public function confirm_action() 
    {
        $id=$this->input->post('id_user');
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->confirm($this->input->post('id_user', TRUE));
        } else {
            $data = array(
		'status' => '1',
	    );

            $this->db->query("update data_driver set status='1' where id_user='$id'");
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('data_driver'));
        }
    }
    

    public function delete($id) 
    {
        $row = $this->Data_driver_model->get_by_id($id);

        if ($row) {
            $this->Data_driver_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('data_driver'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('data_driver'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('id_user', 'id user', 'trim|required');
	$this->form_validation->set_rules('jenis_kendaraan', 'jenis kendaraan', 'trim|required');
	$this->form_validation->set_rules('no_plat', 'no plat', 'trim|required');
	$this->form_validation->set_rules('alamat', 'alamat', 'trim|required');
	

	$this->form_validation->set_rules('id_driver', 'id_driver', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Data_driver.php */
/* Location: ./application/controllers/Data_driver.php */
/* Please DO NOT modify this information : */
/* Generated by Boy Kurniawan 2020-09-06 09:46:18 */
/* https://jualkoding.com */