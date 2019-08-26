<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Ms_bank extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Ms_bank_model');
        $this->load->library('form_validation');        
        $this->load->library('datatables');
        date_default_timezone_set("Asia/Bangkok");
    }

    public function index()
    {
        $this->template->load('template','master/ms_bank/ms_bank_list');
    } 
    
    public function json() {
        header('Content-Type: application/json');
        echo $this->Ms_bank_model->json();
    }

    public function read($id) 
    {
        $row = $this->Ms_bank_model->get_by_id($id);
        if ($row) {
            $data = array(
              'id_bank' => $row->id_bank,
              'kd_bank' => $row->kd_bank,
              'nm_bank' => $row->nm_bank,
              'namacabang_bank' => $row->namacabang_bank,
              'norek_bank' => $row->norek_bank,
              'atasnama_bank' => $row->atasnama_bank,
              'ket_bank' => $row->ket_bank,
              'is_del_bank' => $row->is_del_bank,
              'isaktif_bank' => $row->isaktif_bank,
              'crdate_bank' => $row->crdate_bank,
              'id_cr_bank' => $row->id_cr_bank,
              'update_bank' => $row->update_bank,
              'id_up_bank' => $row->id_up_bank,
          );
            $this->load->view('ms_bank/ms_bank_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('ms_bank'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'title'  => 'Input',
            'action' => site_url('ms_bank/create_action'),
            'id_bank' => set_value('id_bank'),
            'kd_bank' => set_value('kd_bank'),
            'nm_bank' => set_value('nm_bank'),
            'namacabang_bank' => set_value('namacabang_bank'),
            'norek_bank' => set_value('norek_bank'),
            'atasnama_bank' => set_value('atasnama_bank'),
            'ket_bank' => set_value('ket_bank'),
        );
        $this->template->load('template','master/ms_bank/ms_bank_form', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
              'kd_bank' => $this->input->post('kd_bank',TRUE),
              'nm_bank' => $this->input->post('nm_bank',TRUE),
              'namacabang_bank' => $this->input->post('namacabang_bank',TRUE),
              'norek_bank' => $this->input->post('norek_bank',TRUE),
              'atasnama_bank' => $this->input->post('atasnama_bank',TRUE),
              'ket_bank' => $this->input->post('ket_bank',TRUE),
              'id_cr_bank' => $this->session->userdata("id_users"),
          );

            $this->Ms_bank_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('ms_bank'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Ms_bank_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'title' => 'Edit',
                'action' => site_url('ms_bank/update_action'),
                'id_bank' => set_value('id_bank', $row->id_bank),
                'kd_bank' => set_value('kd_bank', $row->kd_bank),
                'nm_bank' => set_value('nm_bank', $row->nm_bank),
                'namacabang_bank' => set_value('namacabang_bank', $row->namacabang_bank),
                'norek_bank' => set_value('norek_bank', $row->norek_bank),
                'atasnama_bank' => set_value('atasnama_bank', $row->atasnama_bank),
                'ket_bank' => set_value('ket_bank', $row->ket_bank),
                'update_bank' => set_value('update_bank', $row->update_bank),
            );
            $this->template->load('template','master/ms_bank/ms_bank_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('ms_bank'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_bank', TRUE));
        } else {
            $updatez     = date('Y-m-d H:i:s');
            $data = array(
              'kd_bank' => $this->input->post('kd_bank',TRUE),
              'nm_bank' => $this->input->post('nm_bank',TRUE),
              'namacabang_bank' => $this->input->post('namacabang_bank',TRUE),
              'norek_bank' => $this->input->post('norek_bank',TRUE),
              'atasnama_bank' => $this->input->post('atasnama_bank',TRUE),
              'ket_bank' => $this->input->post('ket_bank',TRUE),
              'is_del_bank' => $this->input->post('is_del_bank',TRUE),
              'isaktif_bank' => $this->input->post('isaktif_bank',TRUE),
              'crdate_bank' => $this->input->post('crdate_bank',TRUE),
              'id_cr_bank' => $this->input->post('id_cr_bank',TRUE),
              'update_bank' => $updatez,
              'id_up_bank' => $this->session->userdata("id_users"),
          );

            $this->Ms_bank_model->update($this->input->post('id_bank', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('ms_bank'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Ms_bank_model->get_by_id($id);

        if ($row) {
            $this->Ms_bank_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('ms_bank'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('ms_bank'));
        }
    }

    public function _rules() 
    {
       $this->form_validation->set_rules('kd_bank', 'kd bank', 'trim|required');
       $this->form_validation->set_rules('nm_bank', 'nm bank', 'trim|required');
       $this->form_validation->set_rules('namacabang_bank', 'namacabang bank', 'trim|required');
       $this->form_validation->set_rules('norek_bank', 'norek bank', 'trim|required');
       $this->form_validation->set_rules('atasnama_bank', 'atasnama bank', 'trim|required');
       $this->form_validation->set_rules('ket_bank', 'ket bank', 'trim|required');
       $this->form_validation->set_rules('is_del_bank', 'is del bank', 'trim');
       $this->form_validation->set_rules('isaktif_bank', 'isaktif bank', 'trim');
       $this->form_validation->set_rules('crdate_bank', 'crdate bank', 'trim');
       $this->form_validation->set_rules('id_cr_bank', 'id cr bank', 'trim');
       $this->form_validation->set_rules('update_bank', 'update bank', 'trim');
       $this->form_validation->set_rules('id_up_bank', 'id up bank', 'trim');

       $this->form_validation->set_rules('id_bank', 'id_bank', 'trim');
       $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
   }

}
