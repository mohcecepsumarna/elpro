<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Ms_type_marketing extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Ms_type_marketing_model');
        $this->load->library('form_validation');        
        $this->load->library('datatables');
        date_default_timezone_set("Asia/Bangkok");
    }

    public function index()
    {
        $this->template->load('template','master/ms_type_marketing/ms_type_marketing_list');
    } 
    
    public function json() {
        header('Content-Type: application/json');
        echo $this->Ms_type_marketing_model->json();
    }

    public function read($id) 
    {
        $row = $this->Ms_type_marketing_model->get_by_id($id);
        if ($row) {
            $data = array(
              'id_type_mr' => $row->id_type_mr,
              'kd_type_mr' => $row->kd_type_mr,
              'nm_type_mr' => $row->nm_type_mr,
              'ket_type_mr' => $row->ket_type_mr,
              'is_del_type_mr' => $row->is_del_type_mr,
              'crdate_type_mr' => $row->crdate_type_mr,
              'id_cr_type_mr' => $row->id_cr_type_mr,
              'update_type_mr' => $row->update_type_mr,
              'id_up_type_mr' => $row->id_up_type_mr,
          );
            $this->load->view('ms_type_marketing/ms_type_marketing_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('ms_type_marketing'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'title' => 'Input',
            'action' => site_url('ms_type_marketing/create_action'),
            'id_type_mr' => set_value('id_type_mr'),
            'kd_type_mr' => set_value('kd_type_mr'),
            'nm_type_mr' => set_value('nm_type_mr'),
            'ket_type_mr' => set_value('ket_type_mr'),
        );
        $this->template->load('template','master/ms_type_marketing/ms_type_marketing_form', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
              'kd_type_mr' => $this->input->post('kd_type_mr',TRUE),
              'nm_type_mr' => $this->input->post('nm_type_mr',TRUE),
              'ket_type_mr' => $this->input->post('ket_type_mr',TRUE),
              'id_cr_type_mr' => $this->session->userdata("id_users"),
          );

            $this->Ms_type_marketing_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('ms_type_marketing'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Ms_type_marketing_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'title' => 'Edit',
                'action' => site_url('ms_type_marketing/update_action'),
                'id_type_mr' => set_value('id_type_mr', $row->id_type_mr),
                'kd_type_mr' => set_value('kd_type_mr', $row->kd_type_mr),
                'nm_type_mr' => set_value('nm_type_mr', $row->nm_type_mr),
                'ket_type_mr' => set_value('ket_type_mr', $row->ket_type_mr),
                'update_type_mr' => set_value('update_type_mr', $row->update_type_mr),
            );
            $this->template->load('template','master/ms_type_marketing/ms_type_marketing_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('ms_type_marketing'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_type_mr', TRUE));
        } else {
            $updatez     = date('Y-m-d H:i:s');
            $data = array(
              'kd_type_mr' => $this->input->post('kd_type_mr',TRUE),
              'nm_type_mr' => $this->input->post('nm_type_mr',TRUE),
              'ket_type_mr' => $this->input->post('ket_type_mr',TRUE),
              'update_type_mr' => $updatez,
              'id_up_type_mr' => $this->session->userdata("id_users"),
          );

            $this->Ms_type_marketing_model->update($this->input->post('id_type_mr', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('ms_type_marketing'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Ms_type_marketing_model->get_by_id($id);

        if ($row) {
            $this->Ms_type_marketing_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('ms_type_marketing'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('ms_type_marketing'));
        }
    }

    public function _rules() 
    {
       $this->form_validation->set_rules('kd_type_mr', 'kd type mr', 'trim|required');
       $this->form_validation->set_rules('nm_type_mr', 'nm type mr', 'trim|required');
       $this->form_validation->set_rules('ket_type_mr', 'ket type mr', 'trim|required');
       $this->form_validation->set_rules('is_del_type_mr', 'is del type mr', 'trim');
       $this->form_validation->set_rules('crdate_type_mr', 'crdate type mr', 'trim');
       $this->form_validation->set_rules('id_cr_type_mr', 'id cr type mr', 'trim');
       $this->form_validation->set_rules('update_type_mr', 'update type mr', 'trim');
       $this->form_validation->set_rules('id_up_type_mr', 'id up type mr', 'trim');

       $this->form_validation->set_rules('id_type_mr', 'id_type_mr', 'trim');
       $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
   }

}
