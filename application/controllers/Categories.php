<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Categories extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Categories_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $categories = $this->Categories_model->get_all();

        $data = array(
            'categories_data' => $categories
        );

        $this->load->view('categories_list', $data);
    }

    public function read($id) 
    {
        $row = $this->Categories_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id' => $row->id,
		'name' => $row->name,
	    );
            $this->load->view('categories_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('categories'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('categories/create_action'),
	    'id' => set_value('id'),
	    'name' => set_value('name'),
	);
        $this->load->view('categories_form', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'name' => $this->input->post('name',TRUE),
	    );

            $this->Categories_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('categories'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Categories_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('categories/update_action'),
		'id' => set_value('id', $row->id),
		'name' => set_value('name', $row->name),
	    );
            $this->load->view('categories_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('categories'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id', TRUE));
        } else {
            $data = array(
		'name' => $this->input->post('name',TRUE),
	    );

            $this->Categories_model->update($this->input->post('id', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('categories'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Categories_model->get_by_id($id);

        if ($row) {
            $this->Categories_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('categories'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('categories'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('name', 'name', 'trim|required');

	$this->form_validation->set_rules('id', 'id', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Categories.php */
/* Location: ./application/controllers/Categories.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2019-10-19 08:45:15 */
/* http://harviacode.com */