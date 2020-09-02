<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api_kurir extends CI_Controller {

	
	public function index()
	{
		$this->load->view('welcome_message');
	}

	public function daftar()
	{
		if ($_POST) {
			$nama = $this->input->post('nama');
			$no_telp = $this->input->post('no_telp');
			$password = $this->input->post('password');
			$email = $this->input->post('email');

			$cek = $this->db->get_where('users', array('no_telp'=>$no_telp));
			if ($cek->num_rows() > 0) {
				$result = array(
					'status' => "0",
					'pesan' => 'No Telp Sudah terdaftar, silahkan login !'
				);
				echo json_encode($result);
			} else {
				$simpan = $this->db->insert('users', array(
					'nama_lengkap' => $nama,
					'username' => $no_telp,
					'password' => $password,
					'no_telp' => $no_telp,
					'email' => $email,
					'level' => 'user'
				));

				if ($simpan) {
					$result = array(
						'status' => "1",
						'pesan' => 'Pendaftaran berhasil, silahkan login'
					);
					echo json_encode($result);
				} else {
					$result = array(
						'status' => "0",
						'pesan' => 'Gagal'
					);
					echo json_encode($result);
				}
			}

			
		}
	}

	public function login()
	{
		if ($_POST) {
			$username = $this->input->post('username');
			$password = $this->input->post('password');

			$cek = $this->db->get_where('users', array('username' => $username, 'password' => $password));

			if ($cek->num_rows() == 1) {
				$data = $cek->row();
				$result = array(
					'status' => "1",
					'id_user' => $data->id_user,
					'nama' => $data->nama_lengkap,
					'no_telp' => $data->no_telp,
					'password' => $data->password,
					'email' => $data->email,
					'level' => $data->level,
					'pesan' => "Selamat datang dan selamat beraktifitas $data->nama_lengkap"
				);
				echo json_encode($result);
			} else {
				$result = array(
					'status' => "0",
					'pesan' => 'Gagal'
				);
				echo json_encode($result);
			}
		}
	}





}
