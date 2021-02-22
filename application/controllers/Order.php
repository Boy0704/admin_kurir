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

    public function log_order_driver($id_user)
    {
        $data = array(
            'judul_page' => 'Log Order',
            'konten' => 'data_driver/order_belum_selesai',
        );
        $this->load->view('v_index', $data);
    }

    public function rekap_excel()
    {
        $this->load->view('cetak/rekap_order_kirim_paket');
    }

    public function cancel_order($id_order,$driver)
    {
        $this->db->where('id_order', $id_order);
        $update = $this->db->update('order', array('status'=>'3'));
        $this->db->where('id_user', $driver);
        $this->db->update('data_driver', array('status_order'=>'0'));
        if ($update) {
            $driver = get_data('order','id_order',$id_order,'driver');
            $server_key = get_setting('server_fcm_driver');
            $token = get_data('users','id_user',$driver,'token_fcm');
            $title = "Order dibatalkan";
            $body = "Hai Driver, order telah dibatalkan pelanggan";
            $screen ="list_trx";
            $this->send_notif($server_key,$token,$title, $body, $screen);

            echo "Order kamu telah di batalkan";
        } else {
            echo "ada kesalahan server";
        }

        redirect('order/log_order_driver/'.$driver,'refresh');
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

    private function send_notif($server_key,$token,$title, $body, $screen)
    {
        # agar diparse sebagai JSON di browser
        header('Content-Type:application/json');

        # atur zona waktu sender server ke Jakarta (WIB / GMT+7)
        date_default_timezone_set("Asia/Jakarta");


        $headers = [
        'Content-Type:application/json',
        'Accept:application/json',
        'Authorization: key='.$server_key.''
        ];


        // echo $post_raw_json;
        // exit();
        

        # Inisiasi CURL request
        $ch = curl_init();

        # atur CURL Options
        curl_setopt_array($ch, array(
        CURLOPT_URL => 'https://fcm.googleapis.com/fcm/send', # URL endpoint
        CURLOPT_HTTPHEADER => $headers, # HTTP Headers
        CURLOPT_RETURNTRANSFER => 1, # return hasil curl_exec ke variabel, tidak langsung dicetak
        CURLOPT_FOLLOWLOCATION => 1, # atur flag followlocation untuk mengikuti bila ada url redirect di server penerima tetap difollow
        CURLOPT_CONNECTTIMEOUT => 60, # set connection timeout ke 60 detik, untuk mencegah request gantung saat server mati
        CURLOPT_TIMEOUT => 60, # set timeout ke 120 detik, untuk mencegah request gantung saat server hang
        CURLOPT_POST => 1, # set method request menjadi POST
        CURLOPT_POSTFIELDS => '{"notification": {"body": "'.$body.'","title": "'.$title.'","sound": "default","badge":"1"}, "priority": "high", "data": {"click_action": "FLUTTER_NOTIFICATION_CLICK", "screen": "'.$screen.'", "status": "done"}, "to": "'.$token.'"}', # attached post data dalam bentuk JSON String,
        // CURLOPT_VERBOSE => 1, # mode debug
        // CURLOPT_HEADER => 1, # cetak header
        CURLOPT_SSL_VERIFYPEER => true  
        ));

        # eksekusi CURL request dan tampung hasil responsenya ke variabel $resp
        $resp = curl_exec($ch);

        # validasi curl request tidak error
        if (curl_errno($ch) == false) {
        # jika curl berhasil
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if ($http_code == 200) {
          # http code === 200 berarti request sukses (harap pastikan server penerima mengirimkan http_code 200 jika berhasil)
        //   return $resp;
            $send = '{"notification": {"body": "'.$body.'","title": "'.$title.'","sound": "default","badge":"1"}, "priority": "high", "data": {"click_action": "FLUTTER_NOTIFICATION_CLICK", "screen": "'.$screen.'", "status": "done"}, "to": "'.$token.'"}';
            $this->db->insert('log_notif', array('log'=>$send,'resp'=>$resp));
            return $resp;
        } else {
          # selain itu request gagal (contoh: error 404 page not found)
          // echo 'Error HTTP Code : '.$http_code."\n";
          
            $send = '{"notification": {"body": "'.$body.'","title": "'.$title.'","sound": "default","badge":"1"}, "priority": "high", "data": {"click_action": "FLUTTER_NOTIFICATION_CLICK", "screen": "'.$screen.'", "status": "done"}, "to": "'.$token.'"}';
            $this->db->insert('log_notif', array('log'=>$send,'resp'=>$resp));
            return $resp;
        }
        } else {
        # jika curl error (contoh: request timeout)
        # Daftar kode error : https://curl.haxx.se/libcurl/c/libcurl-errors.html
        // echo "Error while sending request, reason:".curl_error($ch);
        }

        # tutup CURL
        curl_close($ch);
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