<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Ms_marketing extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Ms_marketing_model');
        $this->load->library('form_validation');        
        $this->load->library('datatables');
        date_default_timezone_set("Asia/Bangkok");
    }

    public function index()
    {
        $this->template->load('template','master/ms_marketing/ms_marketing_list');
    } 
    
    public function json() {
        header('Content-Type: application/json');
        echo $this->Ms_marketing_model->json();
    }

    public function read($id) 
    {
        $row = $this->Ms_marketing_model->get_by_id($id);
        if ($row) {
            $data = array(
              'id_mr' => $row->id_mr,
              'kd_mr' => $row->kd_mr,
              'nm_mr' => $row->nm_mr,
              'alamat_mr' => $row->alamat_mr,
              'ket_mr' => $row->ket_mr,
              'is_del_mr' => $row->is_del_mr,
              'jk_mr' => $row->jk_mr,
              'is_active_mr' => $row->is_active_mr,
              'crdate_mr' => $row->crdate_mr,
              'id_cr_mr' => $row->id_cr_mr,
              'update_mr' => $row->update_mr,
              'id_up_mr' => $row->id_up_mr,
          );
            $this->load->view('ms_marketing/ms_marketing_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('ms_marketing'));
        }
    }

    public function create() 
    {
        $markQuery = $this->db->query("
          SELECT * FROM ms_type_marketing
          where is_del_type_mr = 0");

        $mark_select_values = $markQuery->result();

        $mtrQuery = $this->db->query("
          SELECT * FROM ms_cabang
          where is_del_cb = 0");

        $mtr_select_values = $mtrQuery->result();

        $timQuery = $this->db->query("
              SELECT * FROM ms_tim
              where is_del_tim = 0");

            $tim_select_values = $timQuery->result();

        $data = array(
            'button' => 'Create',
            'title' => 'Input',
            'action' => site_url('ms_marketing/create_action'),
            'id_mr' => set_value('id_mr'),
            'id_type_mrk' => set_value('id_type_mrk'),
            'id_cb_mrk' => set_value('id_cb_mrk'),
            'id_tim_mr' => set_value('id_tim_mr'),
            'kd_mr' => set_value('kd_mr'),
            'nm_mr' => set_value('nm_mr'),
            'alamat_mr' => set_value('alamat_mr'),
            'ket_mr' => set_value('ket_mr'),
            'mark_select_values'     => $mark_select_values,
            'mtr_select_values'     => $mtr_select_values,
            'tim_select_values'     => $tim_select_values,
        );

        //   echo '<pre>';
        // var_dump($mark_select_values);
        // echo '</pre>';

        // echo '<pre>';
        // print_r($mark_select_values);
        // exit();

        $this->template->load('template','master/ms_marketing/ms_marketing_form', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
              'kd_mr' => $this->input->post('kd_mr',TRUE),
              'nm_mr' => $this->input->post('nm_mr',TRUE),
              'alamat_mr' => $this->input->post('alamat_mr',TRUE),
              'ket_mr' => $this->input->post('ket_mr',TRUE),
              'id_type_mrk' => $this->input->post('id_type_mrk',TRUE),
              'id_cb_mrk' => $this->input->post('id_cb_mrk',TRUE),
              'id_tim_mr' => $this->input->post('id_tim_mr',TRUE),
              'id_cr_mr' => $this->session->userdata("id_users"),
          );

            $this->Ms_marketing_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('ms_marketing'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Ms_marketing_model->get_by_id($id);

        if ($row) {
            $markQuery = $this->db->query("
              SELECT * FROM ms_type_marketing
              where is_del_type_mr = 0");

            $mark_select_values = $markQuery->result();

            $mtrQuery = $this->db->query("
              SELECT * FROM ms_cabang
              where is_del_cb = 0");

            $mtr_select_values = $mtrQuery->result();

            $timQuery = $this->db->query("
              SELECT * FROM ms_tim
              where is_del_tim = 0");

            $tim_select_values = $timQuery->result();

            $data = array(
                'button' => 'Update',
                'title' => 'Edit',
                'action' => site_url('ms_marketing/update_action'),
                'id_mr' => set_value('id_mr', $row->id_mr),
                'kd_mr' => set_value('kd_mr', $row->kd_mr),
                'nm_mr' => set_value('nm_mr', $row->nm_mr),
                'id_type_mrk' => set_value('id_type_mrk', $row->id_type_mrk),
                'id_cb_mrk' => set_value('id_cb_mrk', $row->id_cb_mrk),
                'id_tim_mr' => set_value('id_tim_mr', $row->id_tim_mr),
                'alamat_mr' => set_value('alamat_mr', $row->alamat_mr),
                'ket_mr' => set_value('ket_mr', $row->ket_mr),
                'ket_mr' => set_value('ket_mr', $row->ket_mr),
                'mark_select_values'     => $mark_select_values,
                'mtr_select_values'     => $mtr_select_values,
                'tim_select_values'     => $tim_select_values,
            );
           $this->template->load('template','master/ms_marketing/ms_marketing_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('ms_marketing'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_mr', TRUE));
        } else {
            $updatez     = date('Y-m-d H:i:s');
            $data = array(
              'kd_mr' => $this->input->post('kd_mr',TRUE),
              'nm_mr' => $this->input->post('nm_mr',TRUE),
              'alamat_mr' => $this->input->post('alamat_mr',TRUE),
              'ket_mr' => $this->input->post('ket_mr',TRUE),
              'id_type_mrk' => $this->input->post('id_type_mrk',TRUE),
              'id_cb_mrk' => $this->input->post('id_cb_mrk',TRUE),
              'id_tim_mr' => $this->input->post('id_tim_mr',TRUE),
              'update_mr' => $updatez,
              'id_up_mr' => $this->session->userdata("id_users"),
          );

            $this->Ms_marketing_model->update($this->input->post('id_mr', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('ms_marketing'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Ms_marketing_model->get_by_id($id);

        if ($row) {
            $this->Ms_marketing_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('ms_marketing'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('ms_marketing'));
        }
    }

    public function _rules() 
    {
       $this->form_validation->set_rules('kd_mr', 'kd mr', 'trim|required');
       $this->form_validation->set_rules('nm_mr', 'nm mr', 'trim|required');
       $this->form_validation->set_rules('alamat_mr', 'alamat mr', 'trim|required');
       $this->form_validation->set_rules('ket_mr', 'ket mr', 'trim|required');
       $this->form_validation->set_rules('is_del_mr', 'is del mr', 'trim');
       $this->form_validation->set_rules('jk_mr', 'jk mr', 'trim');
       $this->form_validation->set_rules('is_active_mr', 'is active mr', 'trim');
       $this->form_validation->set_rules('crdate_mr', 'crdate mr', 'trim');
       $this->form_validation->set_rules('id_cr_mr', 'id cr mr', 'trim');
       $this->form_validation->set_rules('update_mr', 'update mr', 'trim');
       $this->form_validation->set_rules('id_up_mr', 'id up mr', 'trim');

       $this->form_validation->set_rules('id_mr', 'id_mr', 'trim');
       $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
   }

}
