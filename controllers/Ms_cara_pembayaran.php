<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Ms_cara_pembayaran extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Ms_cara_pembayaran_model');
        $this->load->library('form_validation');        
        $this->load->library('datatables');
        date_default_timezone_set("Asia/Bangkok");
    }

    public function index()
    {
        $this->template->load('template','master/ms_cara_pembayaran/ms_cara_pembayaran_list');
    } 
    
    public function json() {
        header('Content-Type: application/json');
        echo $this->Ms_cara_pembayaran_model->json();
    }

    public function read($id) 
    {
        $row = $this->Ms_cara_pembayaran_model->get_by_id($id);
        if ($row) {
            $data = array(
              'id_cp' => $row->id_cp,
              'kd_cp' => $row->kd_cp,
              'nm_cp' => $row->nm_cp,
              'ket_cp' => $row->ket_cp,
              'is_del_cp' => $row->is_del_cp,
              'crdate_cp' => $row->crdate_cp,
              'id_cr_cp' => $row->id_cr_cp,
              'update_cp' => $row->update_cp,
              'id_up_cp' => $row->id_up_cp,
          );
            $this->template->load('template','master/ms_cara_pembayaran/ms_cara_pembayaran_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('ms_cara_pembayaran'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'title' => 'Input',
            'action' => site_url('ms_cara_pembayaran/create_action'),
            'id_cp' => set_value('id_cp'),
            'kd_cp' => set_value('kd_cp'),
            'nm_cp' => set_value('nm_cp'),
            'ket_cp' => set_value('ket_cp'),
        );
        $this->template->load('template','master/ms_cara_pembayaran/ms_cara_pembayaran_form', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
              'kd_cp' => $this->input->post('kd_cp',TRUE),
              'nm_cp' => $this->input->post('nm_cp',TRUE),
              'ket_cp' => $this->input->post('ket_cp',TRUE),
              'id_cr_cp' => $this->session->userdata("id_users"),
          );

            $this->Ms_cara_pembayaran_model->insert($data);
            // $this->session->set_flashdata('message', 'Create Record Success');
            $this->session->set_flashdata('message', '<div class="alert alert-success"> <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><i class="icon fa fa-check"></i>&nbsp;Insert Success </div>');
            redirect(site_url('ms_cara_pembayaran'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Ms_cara_pembayaran_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'title' => 'Edit',
                'action' => site_url('ms_cara_pembayaran/update_action'),
                'id_cp' => set_value('id_cp', $row->id_cp),
                'kd_cp' => set_value('kd_cp', $row->kd_cp),
                'nm_cp' => set_value('nm_cp', $row->nm_cp),
                'ket_cp' => set_value('ket_cp', $row->ket_cp),
                'update_cp' => set_value('update_cp', $row->update_cp),
                // 'id_up_cp' => set_value('id_up_cp', $row->id_up_cp),
            );
            $this->template->load('template','master/ms_cara_pembayaran/ms_cara_pembayaran_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('ms_cara_pembayaran'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_cp', TRUE));
        } else {
            $updatez     = date('Y-m-d H:i:s');
            $data = array(
              'kd_cp' => $this->input->post('kd_cp',TRUE),
              'nm_cp' => $this->input->post('nm_cp',TRUE),
              'ket_cp' => $this->input->post('ket_cp',TRUE),
              'update_cp' => $updatez,
              'id_up_cp' => $this->session->userdata("id_users"),
          );

            $this->Ms_cara_pembayaran_model->update($this->input->post('id_cp', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('ms_cara_pembayaran'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Ms_cara_pembayaran_model->get_by_id($id);

        if ($row) {
            $this->Ms_cara_pembayaran_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('ms_cara_pembayaran'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('ms_cara_pembayaran'));
        }
    }

    public function _rules() 
    {
       $this->form_validation->set_rules('kd_cp', 'kd cp', 'trim|required');
       $this->form_validation->set_rules('nm_cp', 'nm cp', 'trim|required');
       $this->form_validation->set_rules('ket_cp', 'ket cp', 'trim|required');
       $this->form_validation->set_rules('is_del_cp', 'is del cp', 'trim');
       $this->form_validation->set_rules('crdate_cp', 'crdate cp', 'trim');
       $this->form_validation->set_rules('id_cr_cp', 'id cr cp', 'trim');
       $this->form_validation->set_rules('update_cp', 'update cp', 'trim');
       $this->form_validation->set_rules('id_up_cp', 'id up cp', 'trim');

       $this->form_validation->set_rules('id_cp', 'id_cp', 'trim');
       $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
   }

}

