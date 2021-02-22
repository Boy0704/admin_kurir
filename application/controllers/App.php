<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class App extends CI_Controller {


    public function log_user()
    {
        if ($this->session->userdata('level') == '') {
            redirect('login');
        }
        $data = array(
            'konten' => 'a_user/log_user',
            'judul_page' => 'Log User',
        );
        $this->load->view('v_index', $data);
    }
	
	public function index()
	{
        if ($this->session->userdata('level') == '') {
            redirect('login');
        }
		$data = array(
			'konten' => 'home_admin',
            'judul_page' => 'Dashboard',
		);
		$this->load->view('v_index', $data);
    }

    public function reset_pass()
    {
        if ($_POST) {
            $username = $this->input->post('username');
            $this->db->where('username', $username);
            $cek = $this->db->get('users');
            if ($cek->num_rows() > 0) {
                $this->db->where('username', $username);
                $this->db->update('users', array('password'=>'123456'));
                $this->session->set_flashdata('message', alert_biasa('Password berhasil di reset 123456 di akun '.$username.', silahkan ubah password di menu profil anda ','success'));
                redirect('login','refresh');
            } else {
                $this->session->set_flashdata('message', alert_biasa('akun '.$username.' tidak di temukan, silahkan cek kembali username anda ','warning'));
                redirect('login','refresh');
            }
        } else {
            $this->load->view('reset_pass');
        }
    }

    public function lokasi_driver()
    {
        $this->load->view('data_driver/lokasi_driver');
    }

    public function update_profil()
    {
        if ($this->session->userdata('level') == '') {
                redirect('login');
            }
        if ($_POST) {
            $data = array(
                'nama_lengkap' => $this->input->post('nama_lengkap',TRUE),
                'username' => $this->input->post('username',TRUE),
                'password' => $retVal = ($this->input->post('password') == '') ? $_POST['password_old'] :$this->input->post('password',TRUE),
                'email' => $this->input->post('email',TRUE),
                'no_telp' => $this->input->post('no_telp',TRUE),
                'foto' => $retVal = ($_FILES['foto']['name'] == '') ? $_POST['foto_old'] : upload_gambar_biasa('user', 'image/user/', 'jpeg|png|jpg|gif', 10000, 'foto'),
            );

            $this->db->where('id_user', $this->session->userdata('id_user'));
            $update = $this->db->update('users', $data);
            if ($update) {
                $this->session->set_flashdata('message', alert_biasa('Profil berhasil di update','success'));
                redirect('app/update_profil','refresh');
            }
        } else {

            $data = array(
                'konten' => 'edit_profil',
                'judul_page' => 'Update Profil',
            );
            $this->load->view('v_index', $data);
        }
    }
   
	
}
