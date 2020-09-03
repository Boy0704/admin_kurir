<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Order extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Order_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . 'order/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'order/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'order/index.html';
            $config['first_url'] = base_url() . 'order/index.html';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Order_model->total_rows($q);
        $order = $this->Order_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'order_data' => $order,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
            'judul_page' => 'order/order_list',
            'konten' => 'order/order_list',
        );
        $this->load->view('v_index', $data);
    }

    public function read($id) 
    {
        $row = $this->Order_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id_order' => $row->id_order,
		'customer' => $row->customer,
		'driver' => $row->driver,
		'origin' => $row->origin,
		'destination' => $row->destination,
		'alamat_origin' => $row->alamat_origin,
		'alamat_destination' => $row->alamat_destination,
		'jarak' => $row->jarak,
		'harga' => $row->harga,
		'catatan' => $row->catatan,
		'telp_penerima' => $row->telp_penerima,
		'telp_pengirim' => $row->telp_pengirim,
		'nama_penerima' => $row->nama_penerima,
		'nama_pengirim' => $row->nama_pengirim,
		'status' => $row->status,
		'id_jenis' => $row->id_jenis,
		'date_at' => $row->date_at,
	    );
            $this->load->view('order/order_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('order'));
        }
    }

    public function create() 
    {
        $data = array(
            'judul_page' => 'order/order_form',
            'konten' => 'order/order_form',
            'button' => 'Create',
            'action' => site_url('order/create_action'),
	    'id_order' => set_value('id_order'),
	    'customer' => set_value('customer'),
	    'driver' => set_value('driver'),
	    'origin' => set_value('origin'),
	    'destination' => set_value('destination'),
	    'alamat_origin' => set_value('alamat_origin'),
	    'alamat_destination' => set_value('alamat_destination'),
	    'jarak' => set_value('jarak'),
	    'harga' => set_value('harga'),
	    'catatan' => set_value('catatan'),
	    'telp_penerima' => set_value('telp_penerima'),
	    'telp_pengirim' => set_value('telp_pengirim'),
	    'nama_penerima' => set_value('nama_penerima'),
	    'nama_pengirim' => set_value('nama_pengirim'),
	    'status' => set_value('status'),
	    'id_jenis' => set_value('id_jenis'),
	    'date_at' => set_value('date_at'),
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
		'customer' => $this->input->post('customer',TRUE),
		'driver' => $this->input->post('driver',TRUE),
		'origin' => $this->input->post('origin',TRUE),
		'destination' => $this->input->post('destination',TRUE),
		'alamat_origin' => $this->input->post('alamat_origin',TRUE),
		'alamat_destination' => $this->input->post('alamat_destination',TRUE),
		'jarak' => $this->input->post('jarak',TRUE),
		'harga' => $this->input->post('harga',TRUE),
		'catatan' => $this->input->post('catatan',TRUE),
		'telp_penerima' => $this->input->post('telp_penerima',TRUE),
		'telp_pengirim' => $this->input->post('telp_pengirim',TRUE),
		'nama_penerima' => $this->input->post('nama_penerima',TRUE),
		'nama_pengirim' => $this->input->post('nama_pengirim',TRUE),
		'status' => $this->input->post('status',TRUE),
		'id_jenis' => $this->input->post('id_jenis',TRUE),
		'date_at' => $this->input->post('date_at',TRUE),
	    );

            $this->Order_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('order'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Order_model->get_by_id($id);

        if ($row) {
            $data = array(
                'judul_page' => 'order/order_form',
                'konten' => 'order/order_form',
                'button' => 'Update',
                'action' => site_url('order/update_action'),
		'id_order' => set_value('id_order', $row->id_order),
		'customer' => set_value('customer', $row->customer),
		'driver' => set_value('driver', $row->driver),
		'origin' => set_value('origin', $row->origin),
		'destination' => set_value('destination', $row->destination),
		'alamat_origin' => set_value('alamat_origin', $row->alamat_origin),
		'alamat_destination' => set_value('alamat_destination', $row->alamat_destination),
		'jarak' => set_value('jarak', $row->jarak),
		'harga' => set_value('harga', $row->harga),
		'catatan' => set_value('catatan', $row->catatan),
		'telp_penerima' => set_value('telp_penerima', $row->telp_penerima),
		'telp_pengirim' => set_value('telp_pengirim', $row->telp_pengirim),
		'nama_penerima' => set_value('nama_penerima', $row->nama_penerima),
		'nama_pengirim' => set_value('nama_pengirim', $row->nama_pengirim),
		'status' => set_value('status', $row->status),
		'id_jenis' => set_value('id_jenis', $row->id_jenis),
		'date_at' => set_value('date_at', $row->date_at),
	    );
            $this->load->view('v_index', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('order'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_order', TRUE));
        } else {
            $data = array(
		'customer' => $this->input->post('customer',TRUE),
		'driver' => $this->input->post('driver',TRUE),
		'origin' => $this->input->post('origin',TRUE),
		'destination' => $this->input->post('destination',TRUE),
		'alamat_origin' => $this->input->post('alamat_origin',TRUE),
		'alamat_destination' => $this->input->post('alamat_destination',TRUE),
		'jarak' => $this->input->post('jarak',TRUE),
		'harga' => $this->input->post('harga',TRUE),
		'catatan' => $this->input->post('catatan',TRUE),
		'telp_penerima' => $this->input->post('telp_penerima',TRUE),
		'telp_pengirim' => $this->input->post('telp_pengirim',TRUE),
		'nama_penerima' => $this->input->post('nama_penerima',TRUE),
		'nama_pengirim' => $this->input->post('nama_pengirim',TRUE),
		'status' => $this->input->post('status',TRUE),
		'id_jenis' => $this->input->post('id_jenis',TRUE),
		'date_at' => $this->input->post('date_at',TRUE),
	    );

            $this->Order_model->update($this->input->post('id_order', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('order'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Order_model->get_by_id($id);

        if ($row) {
            $this->Order_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('order'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('order'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('customer', 'customer', 'trim|required');
	$this->form_validation->set_rules('driver', 'driver', 'trim|required');
	$this->form_validation->set_rules('origin', 'origin', 'trim|required');
	$this->form_validation->set_rules('destination', 'destination', 'trim|required');
	$this->form_validation->set_rules('alamat_origin', 'alamat origin', 'trim|required');
	$this->form_validation->set_rules('alamat_destination', 'alamat destination', 'trim|required');
	$this->form_validation->set_rules('jarak', 'jarak', 'trim|required');
	$this->form_validation->set_rules('harga', 'harga', 'trim|required');
	$this->form_validation->set_rules('catatan', 'catatan', 'trim|required');
	$this->form_validation->set_rules('telp_penerima', 'telp penerima', 'trim|required');
	$this->form_validation->set_rules('telp_pengirim', 'telp pengirim', 'trim|required');
	$this->form_validation->set_rules('nama_penerima', 'nama penerima', 'trim|required');
	$this->form_validation->set_rules('nama_pengirim', 'nama pengirim', 'trim|required');
	$this->form_validation->set_rules('status', 'status', 'trim|required');
	$this->form_validation->set_rules('id_jenis', 'id jenis', 'trim|required');
	$this->form_validation->set_rules('date_at', 'date at', 'trim|required');

	$this->form_validation->set_rules('id_order', 'id_order', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Order.php */
/* Location: ./application/controllers/Order.php */
/* Please DO NOT modify this information : */
/* Generated by Boy Kurniawan 2020-09-03 08:58:44 */
/* https://jualkoding.com */