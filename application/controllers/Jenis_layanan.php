<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Jenis_layanan extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Jenis_layanan_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . 'jenis_layanan/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'jenis_layanan/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'jenis_layanan/index.html';
            $config['first_url'] = base_url() . 'jenis_layanan/index.html';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Jenis_layanan_model->total_rows($q);
        $jenis_layanan = $this->Jenis_layanan_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'jenis_layanan_data' => $jenis_layanan,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
            'judul_page' => 'jenis_layanan/jenis_layanan_list',
            'konten' => 'jenis_layanan/jenis_layanan_list',
        );
        $this->load->view('v_index', $data);
    }

    public function read($id) 
    {
        $row = $this->Jenis_layanan_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id_jenis' => $row->id_jenis,
		'jenis_layanan' => $row->jenis_layanan,
	    );
            $this->load->view('jenis_layanan/jenis_layanan_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('jenis_layanan'));
        }
    }

    public function create() 
    {
        $data = array(
            'judul_page' => 'jenis_layanan/jenis_layanan_form',
            'konten' => 'jenis_layanan/jenis_layanan_form',
            'button' => 'Create',
            'action' => site_url('jenis_layanan/create_action'),
	    'id_jenis' => set_value('id_jenis'),
	    'jenis_layanan' => set_value('jenis_layanan'),
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
		'jenis_layanan' => $this->input->post('jenis_layanan',TRUE),
	    );

            $this->Jenis_layanan_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('jenis_layanan'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Jenis_layanan_model->get_by_id($id);

        if ($row) {
            $data = array(
                'judul_page' => 'jenis_layanan/jenis_layanan_form',
                'konten' => 'jenis_layanan/jenis_layanan_form',
                'button' => 'Update',
                'action' => site_url('jenis_layanan/update_action'),
		'id_jenis' => set_value('id_jenis', $row->id_jenis),
		'jenis_layanan' => set_value('jenis_layanan', $row->jenis_layanan),
	    );
            $this->load->view('v_index', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('jenis_layanan'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_jenis', TRUE));
        } else {
            $data = array(
		'jenis_layanan' => $this->input->post('jenis_layanan',TRUE),
	    );

            $this->Jenis_layanan_model->update($this->input->post('id_jenis', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('jenis_layanan'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Jenis_layanan_model->get_by_id($id);

        if ($row) {
            $this->Jenis_layanan_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('jenis_layanan'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('jenis_layanan'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('jenis_layanan', 'jenis layanan', 'trim|required');

	$this->form_validation->set_rules('id_jenis', 'id_jenis', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Jenis_layanan.php */
/* Location: ./application/controllers/Jenis_layanan.php */
/* Please DO NOT modify this information : */
/* Generated by Boy Kurniawan 2020-09-02 11:33:48 */
/* https://jualkoding.com */