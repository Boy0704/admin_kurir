<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	
	public function index() 
	{
		$this->load->view('login');
	}

	public function aksi_login()
	{
			$username = $this->input->post('username');
			$password = $this->input->post('password');

			// $hashed = '$2y$10$LO9IzV0KAbocIBLQdgy.oeNDFSpRidTCjXSQPK45ZLI9890g242SG';
			$cek_user = $this->db->query("SELECT * FROM users WHERE username='$username' and password='$password' ");
			// if (password_verify($password, $hashed)) {
			if ($cek_user->num_rows() > 0) {
				foreach ($cek_user->result() as $row) {
					
                    $sess_data['id_user'] = $row->id_user;
					$sess_data['nama'] = $row->nama_lengkap;
					$sess_data['username'] = $row->username;
					$sess_data['foto'] = $row->foto;
					$sess_data['level'] = $row->level;
					$this->session->set_userdata($sess_data);
				}

				//simpan log
				// $this->db->insert('log_user', array(
				// 	'id_user' => $this->session->userdata('id_user'),
				// 	'nama' => $this->session->userdata('nama'),
				// 	'level' => $this->session->userdata('level'),
				// 	'date_at' => get_waktu(),
				// 	'status' => 'login',
				// ));

				// $this->db->where('id_user', $this->session->userdata('id_user'));
				// $this->db->update('a_user', array('status_login'=>'1'));

				// define('FOTO', $this->session->userdata('foto'), TRUE);
				

				// print_r($this->session->userdata());
				// exit;
				// $sess_data['username'] = $username;
				// $this->session->set_userdata($sess_data);
				if ($this->session->userdata('level') == 'admin') {
					redirect('app','refresh');
				// 	echo 'Server TimeOut';
				} 
				elseif ($this->session->userdata('level') == 'operator') {
					redirect('app','refresh');
				}

				// redirect('app/index');
			} else {
				$this->session->set_flashdata('message', alert_biasa('Gagal Login!\n username atau password kamu salah','warning'));
				// $this->session->set_flashdata('message', alert_tunggu('Gagal Login!\n username atau password kamu salah','warning'));
				redirect('login','refresh');
			}
	}

	

	function logout()
	{

		//simpan log
		// $this->db->insert('log_user', array(
		// 	'id_user' => $this->session->userdata('id_user'),
		// 	'nama' => $this->session->userdata('nama'),
		// 	'level' => $this->session->userdata('level'),
		// 	'date_at' => get_waktu(),
		// 	'status' => 'logout',
		// ));

		// $this->db->where('id_user', $this->session->userdata('id_user'));
		// $this->db->update('a_user', array('status_login'=>'0'));


		$this->session->unset_userdata('id_user');
		$this->session->unset_userdata('nama');
		$this->session->unset_userdata('username');
		$this->session->unset_userdata('level');
		session_destroy();
		redirect('login','refresh');
	}
}
