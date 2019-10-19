<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Ci_sessions extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Ci_sessions_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $ci_sessions = $this->Ci_sessions_model->get_all();

        $data = array(
            'ci_sessions_data' => $ci_sessions
        );

        $this->load->view('ci_sessions_list', $data);
    }

    public function read($id) 
    {
        $row = $this->Ci_sessions_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id' => $row->id,
		'ip_address' => $row->ip_address,
		'timestamp' => $row->timestamp,
		'data' => $row->data,
	    );
            $this->load->view('ci_sessions_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('ci_sessions'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('ci_sessions/create_action'),
	    'id' => set_value('id'),
	    'ip_address' => set_value('ip_address'),
	    'timestamp' => set_value('timestamp'),
	    'data' => set_value('data'),
	);
        $this->load->view('ci_sessions_form', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'ip_address' => $this->input->post('ip_address',TRUE),
		'timestamp' => $this->input->post('timestamp',TRUE),
		'data' => $this->input->post('data',TRUE),
	    );

            $this->Ci_sessions_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('ci_sessions'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Ci_sessions_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('ci_sessions/update_action'),
		'id' => set_value('id', $row->id),
		'ip_address' => set_value('ip_address', $row->ip_address),
		'timestamp' => set_value('timestamp', $row->timestamp),
		'data' => set_value('data', $row->data),
	    );
            $this->load->view('ci_sessions_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('ci_sessions'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id', TRUE));
        } else {
            $data = array(
		'ip_address' => $this->input->post('ip_address',TRUE),
		'timestamp' => $this->input->post('timestamp',TRUE),
		'data' => $this->input->post('data',TRUE),
	    );

            $this->Ci_sessions_model->update($this->input->post('id', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('ci_sessions'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Ci_sessions_model->get_by_id($id);

        if ($row) {
            $this->Ci_sessions_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('ci_sessions'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('ci_sessions'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('ip_address', 'ip address', 'trim|required');
	$this->form_validation->set_rules('timestamp', 'timestamp', 'trim|required');
	$this->form_validation->set_rules('data', 'data', 'trim|required');

	$this->form_validation->set_rules('id', 'id', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Ci_sessions.php */
/* Location: ./application/controllers/Ci_sessions.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2019-10-19 08:45:15 */
/* http://harviacode.com */