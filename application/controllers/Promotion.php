<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Promotion extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Promotion_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . 'promotion/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'promotion/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'promotion/index.html';
            $config['first_url'] = base_url() . 'promotion/index.html';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Promotion_model->total_rows($q);
        $promotion = $this->Promotion_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'promotion_data' => $promotion,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
            'judul_page' => 'promotion/promotion_list',
            'konten' => 'promotion/promotion_list',
        );
        $this->load->view('v_index', $data);
    }

    public function read($id) 
    {
        $row = $this->Promotion_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id_promotion' => $row->id_promotion,
		'image' => $row->image,
		'status' => $row->status,
	    );
            $this->load->view('promotion/promotion_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('promotion'));
        }
    }

    public function create() 
    {
        $data = array(
            'judul_page' => 'promotion/promotion_form',
            'konten' => 'promotion/promotion_form',
            'button' => 'Create',
            'action' => site_url('promotion/create_action'),
	    'id_promotion' => set_value('id_promotion'),
	    'image' => set_value('image'),
	    'status' => set_value('status'),
	);
        $this->load->view('v_index', $data);
    }
    
   
    public function create_action() 
    {
        $this->load->library('upload');
            $nmfile = $_FILES['image']['name'];
            $config['upload_path']   = './image';
            $config['overwrite']     = true;
            $config['allowed_types'] = 'gif|jpeg|png|jpg|bmp|PNG|JPEG|JPG';
            $config['file_name'] = $nmfile;

            $this->upload->initialize($config);

            if($_FILES['image']['name'])
            {
                if($this->upload->do_upload('image'))
                {
                $gbr = $this->upload->data();
                $data = array(
                    'image' =>  $gbr['file_name'],
                    'status'=>$this->input->post('status')
                   
                );

                $this->Promotion_model->insert($data);
                $this->session->set_flashdata('message', 'Create Record Success');
                redirect(site_url('promotion'));
            }
        }
    }
   
    
    public function update($id) 
    {
        $row = $this->Promotion_model->get_by_id($id);

        if ($row) {
            $data = array(
                'judul_page' => 'promotion/promotion_form',
                'konten' => 'promotion/promotion_form',
                'button' => 'Update',
                'action' => site_url('promotion/update_action'),
		'id_promotion' => set_value('id_promotion', $row->id_promotion),
		'image' => set_value('image', $row->image),
		'status' => set_value('status', $row->status),
	    );
            $this->load->view('v_index', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('promotion'));
        }
    }


    public function update_action() 
    {
        $this->load->library('upload');
        $nmfile = $_FILES['image']['name'];
        $config['upload_path']   = './image';
        $config['overwrite']     = true;
        $config['allowed_types'] = 'gif|jpeg|png|jpg|bmp|PNG|JPEG|JPG';
        $config['file_name'] = $nmfile;

        $this->upload->initialize($config);
        
                if(!empty($_FILES['image']['name']))
                {
                        unlink("image/".$this->input->post('image'));

                    if($_FILES['image']['name'])
                    {
                        if($this->upload->do_upload('image'))
                        {
                            $gbr = $this->upload->data();
                            $data = array(
                                'image' => $gbr['file_name'],
                                'status'=>$this->input->post('status')
                            );
                        }
                    }
                  
                    $this->Promotion_model->update($this->input->post('id_promotion', TRUE), $data);
                    $this->session->set_flashdata('message', 'Update Record Success');
                    redirect(site_url('promotion'));
                }
                    else
                        {
                            $data = array(
                                'status'=>$this->input->post('status')
                            );
                        }
                    
                        $this->Promotion_model->update($this->input->post('id_promotion', TRUE), $data);
                        $this->session->set_flashdata('message', 'Update Record Success');
                        redirect(site_url('promotion'));
    }

    
    public function delete($id) 
    {
        $row = $this->Promotion_model->get_by_id($id);

        if ($row) {
            $this->Promotion_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('promotion'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('promotion'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('image', 'image', 'trim|required');
	$this->form_validation->set_rules('status', 'status', 'trim|required');

	$this->form_validation->set_rules('id_promotion', 'id_promotion', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Promotion.php */
/* Location: ./application/controllers/Promotion.php */
/* Please DO NOT modify this information : */
/* Generated by Boy Kurniawan 2020-09-06 06:22:18 */
/* https://jualkoding.com */