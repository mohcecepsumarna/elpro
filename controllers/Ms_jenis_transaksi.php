<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Ms_jenis_transaksi extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Ms_jenis_transaksi_model');
        $this->load->library('form_validation');        
        $this->load->library('datatables');
        date_default_timezone_set("Asia/Bangkok");
    }

    public function index()
    {
        $this->template->load('template','master/ms_jenis_transaksi/ms_jenis_transaksi_list');
    } 
    
    public function json() {
        header('Content-Type: application/json');
        echo $this->Ms_jenis_transaksi_model->json();
    }

    public function read($id) 
    {
        $row = $this->Ms_jenis_transaksi_model->get_by_id($id);
        if ($row) {
            $data = array(
              'id_jt' => $row->id_jt,
              'kd_jt' => $row->kd_jt,
              'nm_jt' => $row->nm_jt,
              'ket_jt' => $row->ket_jt,
              'is_del_jt' => $row->is_del_jt,
              'crdate_jt' => $row->crdate_jt,
              'id_cr_jt' => $row->id_cr_jt,
              'update_jt' => $row->update_jt,
              'id_up_jt' => $row->id_up_jt,
          );
            $this->load->view('ms_jenis_transaksi/master/ms_jenis_transaksi_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('ms_jenis_transaksi'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'title' => 'Input',
            'action' => site_url('ms_jenis_transaksi/create_action'),
            'id_jt' => set_value('id_jt'),
            'kd_jt' => set_value('kd_jt'),
            'nm_jt' => set_value('nm_jt'),
            'ket_jt' => set_value('ket_jt'),
        );
        $this->template->load('template','master/ms_jenis_transaksi/ms_jenis_transaksi_form', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
              'kd_jt' => $this->input->post('kd_jt',TRUE),
              'nm_jt' => $this->input->post('nm_jt',TRUE),
              'ket_jt' => $this->input->post('ket_jt',TRUE),
              'id_cr_jt' => $this->session->userdata("id_users"),
          );

            $this->Ms_jenis_transaksi_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('ms_jenis_transaksi'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Ms_jenis_transaksi_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'title' => 'Edit',
                'action' => site_url('ms_jenis_transaksi/update_action'),
                'id_jt' => set_value('id_jt', $row->id_jt),
                'kd_jt' => set_value('kd_jt', $row->kd_jt),
                'nm_jt' => set_value('nm_jt', $row->nm_jt),
                'ket_jt' => set_value('ket_jt', $row->ket_jt),
                'update_jt' => set_value('update_jt', $row->update_jt),
            );
            $this->template->load('template','master/ms_jenis_transaksi/ms_jenis_transaksi_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('ms_jenis_transaksi'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_jt', TRUE));
        } else {
            $updatez     = date('Y-m-d H:i:s');
            $data = array(
              'kd_jt' => $this->input->post('kd_jt',TRUE),
              'nm_jt' => $this->input->post('nm_jt',TRUE),
              'ket_jt' => $this->input->post('ket_jt',TRUE),
              'update_jt' => $updatez,
              'id_up_jt' => $this->session->userdata("id_users"),
          );

            $this->Ms_jenis_transaksi_model->update($this->input->post('id_jt', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('ms_jenis_transaksi'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Ms_jenis_transaksi_model->get_by_id($id);

        if ($row) {
            $this->Ms_jenis_transaksi_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('ms_jenis_transaksi'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('ms_jenis_transaksi'));
        }
    }

    public function _rules() 
    {
       $this->form_validation->set_rules('kd_jt', 'Kode', 'trim|required');
       $this->form_validation->set_rules('nm_jt', 'Nama', 'trim|required');
       $this->form_validation->set_rules('ket_jt', 'Keterangan', 'trim|required');
       $this->form_validation->set_rules('is_del_jt', 'is del jt', 'trim');
       $this->form_validation->set_rules('crdate_jt', 'crdate jt', 'trim');
       $this->form_validation->set_rules('id_cr_jt', 'id cr jt', 'trim');
       $this->form_validation->set_rules('update_jt', 'update jt', 'trim');
       $this->form_validation->set_rules('id_up_jt', 'id up jt', 'trim');

       $this->form_validation->set_rules('id_jt', 'id_jt', 'trim');
       $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
   }

}
