<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Ms_tim extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Ms_tim_model');
        $this->load->library('form_validation');        
        $this->load->library('datatables');
        date_default_timezone_set("Asia/Bangkok");
    }

    public function index()
    {
        $this->template->load('template','master/ms_tim/ms_tim_list');
    } 
    
    public function json() {
        header('Content-Type: application/json');
        echo $this->Ms_tim_model->json();
    }

    public function read($id) 
    {
        $row = $this->Ms_tim_model->get_by_id($id);
        if ($row) {
            $data = array(
              'id_tim' => $row->id_tim,
              'kd_tim' => $row->kd_tim,
              'nm_tim' => $row->nm_tim,
              'ket_tim' => $row->ket_tim,
              'is_del_tim' => $row->is_del_tim,
              'crdate_tim' => $row->crdate_tim,
              'id_cr_tim' => $row->id_cr_tim,
              'update_tim' => $row->update_tim,
              'id_up_tim' => $row->id_up_tim,
          );
            $this->load->view('ms_tim/ms_tim_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('ms_tim'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'title' => 'Input',
            'action' => site_url('ms_tim/create_action'),
            'id_tim' => set_value('id_tim'),
            'kd_tim' => set_value('kd_tim'),
            'nm_tim' => set_value('nm_tim'),
            'ket_tim' => set_value('ket_tim'),
            // 'is_del_tim' => set_value('is_del_tim'),
            // 'crdate_tim' => set_value('crdate_tim'),
            // 'id_cr_tim' => set_value('id_cr_tim'),
            // 'update_tim' => set_value('update_tim'),
            // 'id_up_tim' => set_value('id_up_tim'),
        );
        $this->template->load('template','master/ms_tim/ms_tim_form', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
              'kd_tim' => $this->input->post('kd_tim',TRUE),
              'nm_tim' => $this->input->post('nm_tim',TRUE),
              'ket_tim' => $this->input->post('ket_tim',TRUE),
              'id_cr_tim' => $this->session->userdata("id_users"),
          );

            $this->Ms_tim_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('ms_tim'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Ms_tim_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'title' => 'Edit',
                'action' => site_url('ms_tim/update_action'),
                'id_tim' => set_value('id_tim', $row->id_tim),
                'kd_tim' => set_value('kd_tim', $row->kd_tim),
                'nm_tim' => set_value('nm_tim', $row->nm_tim),
                'ket_tim' => set_value('ket_tim', $row->ket_tim),
                'update_tim' => set_value('update_tim', $row->update_tim),
            );
            $this->template->load('template','master/ms_tim/ms_tim_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('ms_tim'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_tim', TRUE));
        } else {
            $updatez     = date('Y-m-d H:i:s');
            $data = array(
              'kd_tim' => $this->input->post('kd_tim',TRUE),
              'nm_tim' => $this->input->post('nm_tim',TRUE),
              'ket_tim' => $this->input->post('ket_tim',TRUE),
              'update_tim' => $updatez,
              'id_up_tim' => $this->session->userdata("id_users"),
          );

            $this->Ms_tim_model->update($this->input->post('id_tim', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('ms_tim'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Ms_tim_model->get_by_id($id);

        if ($row) {
            $this->Ms_tim_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('ms_tim'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('ms_tim'));
        }
    }

    public function _rules() 
    {
       $this->form_validation->set_rules('kd_tim', 'kd tim', 'trim|required');
       $this->form_validation->set_rules('nm_tim', 'nm tim', 'trim|required');
       $this->form_validation->set_rules('ket_tim', 'ket tim', 'trim|required');
       $this->form_validation->set_rules('is_del_tim', 'is del tim', 'trim');
       $this->form_validation->set_rules('crdate_tim', 'crdate tim', 'trim');
       $this->form_validation->set_rules('id_cr_tim', 'id cr tim', 'trim');
       $this->form_validation->set_rules('update_tim', 'update tim', 'trim');
       $this->form_validation->set_rules('id_up_tim', 'id up tim', 'trim');

       $this->form_validation->set_rules('id_tim', 'id_tim', 'trim');
       $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
   }

}
