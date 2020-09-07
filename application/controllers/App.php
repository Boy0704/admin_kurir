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

    public function lokasi_driver()
    {
        $this->load->view('data_driver/lokasi_driver');
    }
   
	
}
