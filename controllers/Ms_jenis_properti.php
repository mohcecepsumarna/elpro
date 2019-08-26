<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Ms_jenis_properti extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Ms_jenis_properti_model');
        $this->load->library('form_validation');        
        $this->load->library('datatables');
        date_default_timezone_set("Asia/Bangkok");
    }

    public function index()
    {
        $this->template->load('template','master/ms_jenis_properti/ms_jenis_properti_list');
    } 
    
    public function json() {
        header('Content-Type: application/json');
        echo $this->Ms_jenis_properti_model->json();
    }

    public function read($id) 
    {
        $row = $this->Ms_jenis_properti_model->get_by_id($id);
        if ($row) {
            $data = array(
              'id_jp' => $row->id_jp,
              'kd_jp' => $row->kd_jp,
              'nm_jp' => $row->nm_jp,
              'ket_jp' => $row->ket_jp,
              'is_del_jp' => $row->is_del_jp,
              'crdate_jp' => $row->crdate_jp,
              'id_cr_jp' => $row->id_cr_jp,
              'update_jp' => $row->update_jp,
              'id_up_jp' => $row->id_up_jp,
          );
            $this->load->view('ms_jenis_properti/ms_jenis_properti_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('ms_jenis_properti'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'title' => 'Input',
            'action' => site_url('ms_jenis_properti/create_action'),
            'id_jp' => set_value('id_jp'),
            'kd_jp' => set_value('kd_jp'),
            'nm_jp' => set_value('nm_jp'),
            'ket_jp' => set_value('ket_jp'),
            // 'is_del_jp' => set_value('is_del_jp'),
            // 'crdate_jp' => set_value('crdate_jp'),
            // 'id_cr_jp' => set_value('id_cr_jp'),
            // 'update_jp' => set_value('update_jp'),
            // 'id_up_jp' => set_value('id_up_jp'),
        );
        $this->template->load('template','master/ms_jenis_properti/ms_jenis_properti_form', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
              'kd_jp' => $this->input->post('kd_jp',TRUE),
              'nm_jp' => $this->input->post('nm_jp',TRUE),
              'ket_jp' => $this->input->post('ket_jp',TRUE),
              // 'is_del_jp' => $this->input->post('is_del_jp',TRUE),
              // 'crdate_jp' => $this->input->post('crdate_jp',TRUE),
              'id_cr_jp' => $this->session->userdata("id_users"),
              // 'update_jp' => $this->input->post('update_jp',TRUE),
              // 'id_up_jp' => $this->input->post('id_up_jp',TRUE),
          );

            $this->Ms_jenis_properti_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('ms_jenis_properti'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Ms_jenis_properti_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'title' => 'Edit',
                'action' => site_url('ms_jenis_properti/update_action'),
                'id_jp' => set_value('id_jp', $row->id_jp),
                'kd_jp' => set_value('kd_jp', $row->kd_jp),
                'nm_jp' => set_value('nm_jp', $row->nm_jp),
                'ket_jp' => set_value('ket_jp', $row->ket_jp),
                // 'is_del_jp' => set_value('is_del_jp', $row->is_del_jp),
                // 'crdate_jp' => set_value('crdate_jp', $row->crdate_jp),
                // 'id_cr_jp' => set_value('id_cr_jp', $row->id_cr_jp),
                'update_jp' => set_value('update_jp', $row->update_jp),
                // 'id_up_jp' => set_value('id_up_jp', $row->id_up_jp),
            );
            $this->template->load('template','master/ms_jenis_properti/ms_jenis_properti_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('ms_jenis_properti'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_jp', TRUE));
        } else {
            $updatez     = date('Y-m-d H:i:s');
            $data = array(
              'kd_jp' => $this->input->post('kd_jp',TRUE),
              'nm_jp' => $this->input->post('nm_jp',TRUE),
              'ket_jp' => $this->input->post('ket_jp',TRUE),
              // 'is_del_jp' => $this->input->post('is_del_jp',TRUE),
              // 'crdate_jp' => $this->input->post('crdate_jp',TRUE),
              // 'id_cr_jp' => $this->input->post('id_cr_jp',TRUE),
              'update_jp' => $updatez,
              'id_up_jp' => $this->session->userdata("id_users"),
          );

            $this->Ms_jenis_properti_model->update($this->input->post('id_jp', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('ms_jenis_properti'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Ms_jenis_properti_model->get_by_id($id);

        if ($row) {
            $this->Ms_jenis_properti_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('ms_jenis_properti'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('ms_jenis_properti'));
        }
    }

    public function _rules() 
    {
       $this->form_validation->set_rules('kd_jp', 'kd jp', 'trim|required');
       $this->form_validation->set_rules('nm_jp', 'nm jp', 'trim|required');
       $this->form_validation->set_rules('ket_jp', 'ket jp', 'trim|required');
       $this->form_validation->set_rules('is_del_jp', 'is del jp', 'trim');
       $this->form_validation->set_rules('crdate_jp', 'crdate jp', 'trim');
       $this->form_validation->set_rules('id_cr_jp', 'id cr jp', 'trim');
       $this->form_validation->set_rules('update_jp', 'update jp', 'trim');
       $this->form_validation->set_rules('id_up_jp', 'id up jp', 'trim');

       $this->form_validation->set_rules('id_jp', 'id_jp', 'trim');
       $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
   }

}
