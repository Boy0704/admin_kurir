<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Setting extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Setting_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . 'setting/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'setting/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'setting/index.html';
            $config['first_url'] = base_url() . 'setting/index.html';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Setting_model->total_rows($q);
        $setting = $this->Setting_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'setting_data' => $setting,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
            'judul_page' => 'setting/setting_list',
            'konten' => 'setting/setting_list',
        );
        $this->load->view('v_index', $data);
    }

    public function read($id) 
    {
        $row = $this->Setting_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id_setting' => $row->id_setting,
		'judul' => $row->judul,
		'value' => $row->value,
	    );
            $this->load->view('setting/setting_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('setting'));
        }
    }

    public function create() 
    {
        $data = array(
            'judul_page' => 'setting/setting_form',
            'konten' => 'setting/setting_form',
            'button' => 'Create',
            'action' => site_url('setting/create_action'),
	    'id_setting' => set_value('id_setting'),
	    'judul' => set_value('judul'),
	    'value' => set_value('value'),
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
		'judul' => $this->input->post('judul',TRUE),
		'value' => $this->input->post('value',TRUE),
	    );

            $this->Setting_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('setting'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Setting_model->get_by_id($id);

        if ($row) {
            $data = array(
                'judul_page' => 'setting/setting_form',
                'konten' => 'setting/setting_form',
                'button' => 'Update',
                'action' => site_url('setting/update_action'),
		'id_setting' => set_value('id_setting', $row->id_setting),
		'judul' => set_value('judul', $row->judul),
		'value' => set_value('value', $row->value),
	    );
            $this->load->view('v_index', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('setting'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_setting', TRUE));
        } else {
            $data = array(
		'judul' => $this->input->post('judul',TRUE),
		'value' => $this->input->post('value',TRUE),
	    );

            $this->Setting_model->update($this->input->post('id_setting', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('setting'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Setting_model->get_by_id($id);

        if ($row) {
            $this->Setting_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('setting'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('setting'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('judul', 'judul', 'trim|required');
	$this->form_validation->set_rules('value', 'value', 'trim|required');

	$this->form_validation->set_rules('id_setting', 'id_setting', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Setting.php */
/* Location: ./application/controllers/Setting.php */
/* Please DO NOT modify this information : */
/* Generated by Boy Kurniawan 2020-09-03 05:35:53 */
/* https://jualkoding.com */