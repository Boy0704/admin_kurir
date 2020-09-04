<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Setting_layanan extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Setting_layanan_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . 'setting_layanan/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'setting_layanan/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'setting_layanan/index.html';
            $config['first_url'] = base_url() . 'setting_layanan/index.html';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Setting_layanan_model->total_rows($q);
        $setting_layanan = $this->Setting_layanan_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'setting_layanan_data' => $setting_layanan,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
            'judul_page' => 'setting_layanan/setting_layanan_list',
            'konten' => 'setting_layanan/setting_layanan_list',
        );
        $this->load->view('v_index', $data);
    }

    public function read($id) 
    {
        $row = $this->Setting_layanan_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id_setting_layanan' => $row->id_setting_layanan,
		'id_jenis' => $row->id_jenis,
		'max_km' => $row->max_km,
		'standar_km' => $row->standar_km,
		'standar_harga' => $row->standar_harga,
		'per_km' => $row->per_km,
		'jarak_driver' => $row->jarak_driver,
	    );
            $this->load->view('setting_layanan/setting_layanan_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('setting_layanan'));
        }
    }

    public function create() 
    {
        $data = array(
            'judul_page' => 'setting_layanan/setting_layanan_form',
            'konten' => 'setting_layanan/setting_layanan_form',
            'button' => 'Create',
            'action' => site_url('setting_layanan/create_action'),
	    'id_setting_layanan' => set_value('id_setting_layanan'),
	    'id_jenis' => set_value('id_jenis'),
	    'max_km' => set_value('max_km'),
	    'standar_km' => set_value('standar_km'),
	    'standar_harga' => set_value('standar_harga'),
	    'per_km' => set_value('per_km'),
	    'jarak_driver' => set_value('jarak_driver'),
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
		'id_jenis' => $this->input->post('id_jenis',TRUE),
		'max_km' => $this->input->post('max_km',TRUE),
		'standar_km' => $this->input->post('standar_km',TRUE),
		'standar_harga' => $this->input->post('standar_harga',TRUE),
		'per_km' => $this->input->post('per_km',TRUE),
		'jarak_driver' => $this->input->post('jarak_driver',TRUE),
	    );

            $this->Setting_layanan_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('setting_layanan'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Setting_layanan_model->get_by_id($id);

        if ($row) {
            $data = array(
                'judul_page' => 'setting_layanan/setting_layanan_form',
                'konten' => 'setting_layanan/setting_layanan_form',
                'button' => 'Update',
                'action' => site_url('setting_layanan/update_action'),
		'id_setting_layanan' => set_value('id_setting_layanan', $row->id_setting_layanan),
		'id_jenis' => set_value('id_jenis', $row->id_jenis),
		'max_km' => set_value('max_km', $row->max_km),
		'standar_km' => set_value('standar_km', $row->standar_km),
		'standar_harga' => set_value('standar_harga', $row->standar_harga),
        'per_km' => set_value('per_km', $row->per_km),
        'jarak_driver' => set_value('jarak_driver', $row->jarak_driver),
	    );
            $this->load->view('v_index', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('setting_layanan'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_setting_layanan', TRUE));
        } else {
            $data = array(
		'id_jenis' => $this->input->post('id_jenis',TRUE),
		'max_km' => $this->input->post('max_km',TRUE),
		'standar_km' => $this->input->post('standar_km',TRUE),
		'standar_harga' => $this->input->post('standar_harga',TRUE),
		'per_km' => $this->input->post('per_km',TRUE),
		'jarak_driver' => $this->input->post('jarak_driver',TRUE),
	    );

            $this->Setting_layanan_model->update($this->input->post('id_setting_layanan', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('setting_layanan'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Setting_layanan_model->get_by_id($id);

        if ($row) {
            $this->Setting_layanan_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('setting_layanan'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('setting_layanan'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('id_jenis', 'id jenis', 'trim|required');
	$this->form_validation->set_rules('max_km', 'max km', 'trim|required');
	$this->form_validation->set_rules('standar_km', 'standar km', 'trim|required');
	$this->form_validation->set_rules('standar_harga', 'standar harga', 'trim|required');
	$this->form_validation->set_rules('per_km', 'per km', 'trim|required');
	$this->form_validation->set_rules('jarak_driver', 'jarak driver', 'trim|required');

	$this->form_validation->set_rules('id_setting_layanan', 'id_setting_layanan', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Setting_layanan.php */
/* Location: ./application/controllers/Setting_layanan.php */
/* Please DO NOT modify this information : */
/* Generated by Boy Kurniawan 2020-09-03 05:31:42 */
/* https://jualkoding.com */