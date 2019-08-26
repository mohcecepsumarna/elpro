<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Ms_cabang extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Ms_cabang_model');
        $this->load->library('form_validation');        
        $this->load->library('datatables');
        date_default_timezone_set("Asia/Bangkok");
    }

    public function index()
    {
        $this->template->load('template','master/ms_cabang/ms_cabang_list');
    } 
    
    public function json() {
        header('Content-Type: application/json');
        echo $this->Ms_cabang_model->json();
    }

    public function read($id) 
    {
        $row = $this->Ms_cabang_model->get_by_id($id);
        if ($row) {
            $data = array(
              'id_cb' => $row->id_cb,
              'kd_cb' => $row->kd_cb,
              'nm_cb' => $row->nm_cb,
              'ket_cb' => $row->ket_cb,
              'is_del_cb' => $row->is_del_cb,
              'crdate_cb' => $row->crdate_cb,
              'id_cr_cb' => $row->id_cr_cb,
              'update_cb' => $row->update_cb,
              'id_up_cb' => $row->id_up_cb,
          );
            $this->template->load('template','master/ms_cabang/ms_cabang_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('ms_cabang'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'title'  => 'Input',
            'action' => site_url('ms_cabang/create_action'),
            'id_cb' => set_value('id_cb'),
            'kd_cb' => set_value('kd_cb'),
            'nm_cb' => set_value('nm_cb'),
            'ket_cb' => set_value('ket_cb'),
            // 'is_del_cb' => set_value('is_del_cb'),
            // 'crdate_cb' => set_value('crdate_cb'),
            // 'id_cr_cb' => set_value('id_cr_cb'),
            // 'update_cb' => set_value('update_cb'),
            // 'id_up_cb' => set_value('id_up_cb'),
        );
        $this->template->load('template','master/ms_cabang/ms_cabang_form', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
              'kd_cb' => $this->input->post('kd_cb',TRUE),
              'nm_cb' => $this->input->post('nm_cb',TRUE),
              'ket_cb' => $this->input->post('ket_cb',TRUE),
              'id_cr_cb' => $this->session->userdata("id_users"),
              // 'is_del_cb' => $this->input->post('is_del_cb',TRUE),
              // 'crdate_cb' => $this->input->post('crdate_cb',TRUE),
              // 'id_cr_cb' => $this->input->post('id_cr_cb',TRUE),
              // 'update_cb' => $this->input->post('update_cb',TRUE),
              // 'id_up_cb' => $this->input->post('id_up_cb',TRUE),
          );

            $this->Ms_cabang_model->insert($data);
            $this->session->set_flashdata('message', '<div class="alert alert-success">Insert Success </div>');
            redirect(site_url('ms_cabang'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Ms_cabang_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'title'  => 'Edit',
                'action' => site_url('ms_cabang/update_action'),
                'id_cb' => set_value('id_cb', $row->id_cb),
                'kd_cb' => set_value('kd_cb', $row->kd_cb),
                'nm_cb' => set_value('nm_cb', $row->nm_cb),
                'ket_cb' => set_value('ket_cb', $row->ket_cb),
                'update_cb' => set_value('update_cb', $row->update_cb),
                'id_up_cb' => set_value('id_up_cb', $row->id_up_cb),
            );
            $this->template->load('template','master/ms_cabang/ms_cabang_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('ms_cabang'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_cb', TRUE));
        } else {
           $updatez     = date('Y-m-d H:i:s');
            $data = array(
              'kd_cb' => $this->input->post('kd_cb',TRUE),
              'nm_cb' => $this->input->post('nm_cb',TRUE),
              'ket_cb' => $this->input->post('ket_cb',TRUE),
              'update_cb' => $updatez,
              'id_up_cb' => $this->session->userdata("id_users"),
          );

            $this->Ms_cabang_model->update($this->input->post('id_cb', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('ms_cabang'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Ms_cabang_model->get_by_id($id);

        if ($row) {
            $this->Ms_cabang_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('ms_cabang'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('ms_cabang'));
        }
    }

    public function _rules() 
    {
       $this->form_validation->set_rules('kd_cb', 'kode cara pembayaran', 'trim|required');
       $this->form_validation->set_rules('nm_cb', 'nama cara pembayaran', 'trim|required');
       $this->form_validation->set_rules('ket_cb', 'keterangan cara pembayaran', 'trim|required');
       $this->form_validation->set_rules('is_del_cb', 'is del cb', 'trim');
       $this->form_validation->set_rules('crdate_cb', 'crdate cb', 'trim');
       $this->form_validation->set_rules('id_cr_cb', 'id cr cb', 'trim');
       $this->form_validation->set_rules('update_cb', 'update cb', 'trim');
       $this->form_validation->set_rules('id_up_cb', 'id up cb', 'trim');

       $this->form_validation->set_rules('id_cb', 'id_cb', 'trim');
       $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
   }

}
