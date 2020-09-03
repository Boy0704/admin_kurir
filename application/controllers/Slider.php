<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Slider extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Slider_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . 'slider/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'slider/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'slider/index.html';
            $config['first_url'] = base_url() . 'slider/index.html';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Slider_model->total_rows($q);
        $slider = $this->Slider_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'slider_data' => $slider,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
            'judul_page' => 'slider/slider_list',
            'konten' => 'slider/slider_list',
        );
        $this->load->view('v_index', $data);
    }

    public function read($id) 
    {
        $row = $this->Slider_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id_slide' => $row->id_slide,
		'image' => $row->image,
	    );
            $this->load->view('slider/slider_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('slider'));
        }
    }

    public function create() 
    {
        $data = array(
            'judul_page' => 'slider/slider_form',
            'konten' => 'slider/slider_form',
            'button' => 'Create',
            'action' => site_url('slider/create_action'),
	    'id_slide' => set_value('id_slide'),
	    'image' => set_value('image'),
	);
        $this->load->view('v_index', $data);
    }


    
    public function create_action() 
    {
        $this->load->library('upload');
            $nmfile = $_FILES['image']['name'];
            $config['upload_path']   = './image/slider';
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
                   
                );

                $this->Slider_model->insert($data);
                $this->session->set_flashdata('message', 'Create Record Success');
                redirect(site_url('slider'));
            }
        }
    }
    
    
    public function update($id) 
    {
        $row = $this->Slider_model->get_by_id($id);

        if ($row) {
            $data = array(
                'judul_page' => 'slider/slider_form',
                'konten' => 'slider/slider_form',
                'button' => 'Update',
                'action' => site_url('slider/update_action'),
		'id_slide' => set_value('id_slide', $row->id_slide),
		'image' => set_value('image', $row->image),
	    );
            $this->load->view('v_index', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('slider'));
        }
    }
    
    public function update_action() 
    {
        $this->load->library('upload');
        $nmfile = $_FILES['image']['name'];
        $config['upload_path']   = './image/slider';
        $config['overwrite']     = true;
        $config['allowed_types'] = 'gif|jpeg|png|jpg|bmp|PNG|JPEG|JPG';
        $config['file_name'] = $nmfile;

        $this->upload->initialize($config);
        
                if(!empty($_FILES['image']['name']))
                {  
                        if($_FILES['image']['name']==$this->input->post('image')){
                            unlink("image/slider/".$this->input->post('image'));
                        }

                    if($_FILES['image']['name'])
                    {
                        if($this->upload->do_upload('image'))
                        {
                            $gbr = $this->upload->data();
                            $data = array(
                                'image' => $gbr['file_name'],
                            );
                        }
                    }
                  
                    $this->Slider_model->update($this->input->post('id_slide', TRUE), $data);
                    $this->session->set_flashdata('message', 'Update Record Success');
                    redirect(site_url('slider'));
                }
                    else
                        {
                            $data = array(
                                'image' => $gbr['file_name'],
                            );
                        }
                    
                        $this->Slider_model->update($this->input->post('id_slide', TRUE), $data);
                        $this->session->set_flashdata('message', 'Update Record Success');
                        redirect(site_url('slider'));
    }
    
    public function delete($id) 
    {
        $row = $this->Slider_model->get_by_id($id);

        if ($row) {
            $this->Slider_model->delete($id);
            unlink('./image/slider/'.$row->image);
            
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('slider'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('slider'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('image', 'image', 'trim|required');

	$this->form_validation->set_rules('id_slide', 'id_slide', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Slider.php */
/* Location: ./application/controllers/Slider.php */
/* Please DO NOT modify this information : */
/* Generated by Boy Kurniawan 2020-09-02 11:33:42 */
/* https://jualkoding.com */