<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */

	public function tes_maps($value='')
	{
		$this->load->view('data_driver/tes_maps');
	}
	public function index()
	{
		$this->load->view('welcome_message');
	}

	public function tes()
	{
		$this->db->select('a.id_user,a.nama_lengkap,a.level');
		$this->db->from('users a');
		$this->db->join('data_driver b', 'a.id_user = b.id_user', 'join');
		$this->db->where('a.level', 'driver');
		$data = $this->db->get();

		// $sql = "SELECT * FROM data_driver WHERE id_user NOT IN (SELECT id_user FROM users)";
		// foreach ($this->db->query($sql)->result() as $rw) {
			
		// }
	}
}
