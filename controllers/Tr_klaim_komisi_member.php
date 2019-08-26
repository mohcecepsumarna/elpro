<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Tr_klaim_komisi_member extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Tr_klaim_komisi_member_model');
		$this->load->library('form_validation');        
		$this->load->library('datatables');
		date_default_timezone_set("Asia/Bangkok");
	}

	public function index()
	{
		$this->template->load('template','tr_klaim_komisi_member/tr_klaim_komisi_member_list');
	} 

	public function json() {
		header('Content-Type: application/json');
		echo $this->Tr_klaim_komisi_member_model->json();
	}

	public function read($id) 
	{
		$row = $this->Tr_klaim_komisi_member_model->get_by_id($id);
		if ($row) {
			$data = array(
				'id_kk_member' => $row->id_kk_member,
				'kd_kk_member' => $row->kd_kk_member,
				'nm_properti_member' => $row->nm_properti_member,
				'nm_mr_sel' => $row->nm_mr_sel,
				'nm_mr_pelisting' => $row->nm_mr_pelisting,
				'nm_mr_coselling' => $row->nm_mr_coselling,
				'nm_mr_colisting' => $row->nm_mr_colisting,
				'nm_cust_member' => $row->nm_cust_member,
				'harga_jual_member' => $row->harga_jual_member,
				'komisi_awal_member' => $row->komisi_awal_member,
				'komisi_member' => $row->komisi_member,
				'sisa_komisi_member' => $row->sisa_komisi_member,
				'nama_member' => $row->nama_member,
				'no_group_member' => $row->no_group_member,
				'no_rek_bca' => $row->no_rek_bca,
				'nama_rek_bca' => $row->nama_rek_bca,
				'is_del_member' => $row->is_del_member,
				'crdate_member' => $row->crdate_member,
				'id_cr_member' => $row->id_cr_member,
				'update_member' => $row->update_member,
				'id_up_member' => $row->id_up_member,
			);
			$this->template->load('template','tr_klaim_komisi_member/tr_klaim_komisi_member_read', $data);
		} else {
			$this->session->set_flashdata('message', 'Record Not Found');
			redirect(site_url('tr_klaim_komisi_member'));
		}
	}

	public function create() 
	{
		$data = array(
			'button' => 'Create',
			'title' => 'Input',
			'action' => site_url('tr_klaim_komisi_member/create_action'),
			'id_kk_member' => set_value('id_kk_member'),
			'kd_kk_member' => set_value('kd_kk_member'),
			'nm_properti_member' => set_value('nm_properti_member'),
			'nm_mr_sel' => set_value('nm_mr_sel'),
			'nm_mr_pelisting' => set_value('nm_mr_pelisting'),
			'nm_mr_coselling' => set_value('nm_mr_coselling'),
			'nm_mr_colisting' => set_value('nm_mr_colisting'),
			'nm_cust_member' => set_value('nm_cust_member'),
			'harga_jual_member' => set_value('harga_jual_member'),
			'komisi_awal_member' => set_value('komisi_awal_member'),
			'komisi_member' => set_value('komisi_member'),
			'sisa_komisi_member' => set_value('sisa_komisi_member'),
			'nama_member' => set_value('nama_member'),
			'no_group_member' => set_value('no_group_member'),
			'no_rek_bca' => set_value('no_rek_bca'),
			'nama_rek_bca' => set_value('nama_rek_bca'),
		);
		$this->template->load('template','tr_klaim_komisi_member/tr_klaim_komisi_member_form', $data);
	}

	public function create_action() 
	{
		$this->_rules();

		if ($this->form_validation->run() == FALSE) {
			$this->create();
		} else {
			$data = array(
				'kd_kk_member' => $this->input->post('kd_kk_member',TRUE),
				'nm_properti_member' => $this->input->post('nm_properti_member',TRUE),
				'nm_mr_sel' => $this->input->post('nm_mr_sel',TRUE),
				'nm_mr_pelisting' => $this->input->post('nm_mr_pelisting',TRUE),
				'nm_mr_coselling' => $this->input->post('nm_mr_coselling',TRUE),
				'nm_mr_colisting' => $this->input->post('nm_mr_colisting',TRUE),
				'nm_cust_member' => $this->input->post('nm_cust_member',TRUE),
				'harga_jual_member' => $this->input->post('harga_jual_member',TRUE),
				'komisi_awal_member' => $this->input->post('komisi_awal_member',TRUE),
				'komisi_member' => $this->input->post('komisi_member',TRUE),
				'sisa_komisi_member' => $this->input->post('sisa_komisi_member',TRUE),
				'nama_member' => $this->input->post('nama_member',TRUE),
				'no_group_member' => $this->input->post('no_group_member',TRUE),
				'no_rek_bca' => $this->input->post('no_rek_bca',TRUE),
				'nama_rek_bca' => $this->input->post('nama_rek_bca',TRUE),
				'id_cr_member' => $this->session->userdata("id_users"),
			
			);

			$this->Tr_klaim_komisi_member_model->insert($data);
			$this->session->set_flashdata('message', 'Create Record Success');
			redirect(site_url('tr_klaim_komisi_member'));
		}
	}

	public function update($id) 
	{
		$row = $this->Tr_klaim_komisi_member_model->get_by_id($id);

		if ($row) {
			$data = array(
				'button' => 'Update',
				'title' => 'Edit',
				'action' => site_url('tr_klaim_komisi_member/update_action'),
				'id_kk_member' => set_value('id_kk_member', $row->id_kk_member),
				'kd_kk_member' => set_value('kd_kk_member', $row->kd_kk_member),
				'nm_properti_member' => set_value('nm_properti_member', $row->nm_properti_member),
				'nm_mr_sel' => set_value('nm_mr_sel', $row->nm_mr_sel),
				'nm_mr_pelisting' => set_value('nm_mr_pelisting', $row->nm_mr_pelisting),
				'nm_mr_coselling' => set_value('nm_mr_coselling', $row->nm_mr_coselling),
				'nm_mr_colisting' => set_value('nm_mr_colisting', $row->nm_mr_colisting),
				'nm_cust_member' => set_value('nm_cust_member', $row->nm_cust_member),
				'harga_jual_member' => set_value('harga_jual_member', $row->harga_jual_member),
				'komisi_awal_member' => set_value('komisi_awal_member', $row->komisi_awal_member),
				'komisi_member' => set_value('komisi_member', $row->komisi_member),
				'sisa_komisi_member' => set_value('sisa_komisi_member', $row->sisa_komisi_member),
				'nama_member' => set_value('nama_member', $row->nama_member),
				'no_group_member' => set_value('no_group_member', $row->no_group_member),
				'no_rek_bca' => set_value('no_rek_bca', $row->no_rek_bca),
				'nama_rek_bca' => set_value('nama_rek_bca', $row->nama_rek_bca),
				'is_del_member' => set_value('is_del_member', $row->is_del_member),
				'crdate_member' => set_value('crdate_member', $row->crdate_member),
				'id_cr_member' => set_value('id_cr_member', $row->id_cr_member),
				'update_member' => set_value('update_member', $row->update_member),
				'id_up_member' => set_value('id_up_member', $row->id_up_member),
			);
			$this->template->load('template','tr_klaim_komisi_member/tr_klaim_komisi_member_form', $data);
		} else {
			$this->session->set_flashdata('message', 'Record Not Found');
			redirect(site_url('tr_klaim_komisi_member'));
		}
	}

	public function update_action() 
	{
		$this->_rules();

		if ($this->form_validation->run() == FALSE) {
			$this->update($this->input->post('id_kk_member', TRUE));
		} else {
		    $updatez     = date('Y-m-d H:i:s');
			$data = array(
				'kd_kk_member' => $this->input->post('kd_kk_member',TRUE),
				'nm_properti_member' => $this->input->post('nm_properti_member',TRUE),
				'nm_mr_sel' => $this->input->post('nm_mr_sel',TRUE),
				'nm_mr_pelisting' => $this->input->post('nm_mr_pelisting',TRUE),
				'nm_mr_coselling' => $this->input->post('nm_mr_coselling',TRUE),
				'nm_mr_colisting' => $this->input->post('nm_mr_colisting',TRUE),
				'nm_cust_member' => $this->input->post('nm_cust_member',TRUE),
				'harga_jual_member' => $this->input->post('harga_jual_member',TRUE),
				'komisi_awal_member' => $this->input->post('komisi_awal_member',TRUE),
				'komisi_member' => $this->input->post('komisi_member',TRUE),
				'sisa_komisi_member' => $this->input->post('sisa_komisi_member',TRUE),
				'nama_member' => $this->input->post('nama_member',TRUE),
				'no_group_member' => $this->input->post('no_group_member',TRUE),
				'no_rek_bca' => $this->input->post('no_rek_bca',TRUE),
				'nama_rek_bca' => $this->input->post('nama_rek_bca',TRUE),
				'update_member' => $updatez,
				'id_up_member' => $this->session->userdata("id_users"),
			);

			$this->Tr_klaim_komisi_member_model->update($this->input->post('id_kk_member', TRUE), $data);
			$this->session->set_flashdata('message', 'Update Record Success');
			redirect(site_url('tr_klaim_komisi_member'));
		}
	}

	public function delete($id) 
	{
		$row = $this->Tr_klaim_komisi_member_model->get_by_id($id);

		if ($row) {
			$this->Tr_klaim_komisi_member_model->delete($id);
			$this->session->set_flashdata('message', 'Delete Record Success');
			redirect(site_url('tr_klaim_komisi_member'));
		} else {
			$this->session->set_flashdata('message', 'Record Not Found');
			redirect(site_url('tr_klaim_komisi_member'));
		}
	}

	public function _rules() 
	{
		$this->form_validation->set_rules('kd_kk_member', 'kd kk member', 'trim|required');
		$this->form_validation->set_rules('nm_properti_member', 'nm properti member', 'trim|required');
		$this->form_validation->set_rules('nm_mr_sel', 'nm mr sel', 'trim|required');
		$this->form_validation->set_rules('nm_mr_pelisting', 'nm mr pelisting', 'trim|required');
		$this->form_validation->set_rules('nm_mr_coselling', 'nm mr coselling', 'trim|required');
		$this->form_validation->set_rules('nm_mr_colisting', 'nm mr colisting', 'trim|required');
		$this->form_validation->set_rules('nm_cust_member', 'nm cust member', 'trim|required');
		$this->form_validation->set_rules('harga_jual_member', 'harga jual member', 'trim|required');
		$this->form_validation->set_rules('komisi_awal_member', 'komisi awal member', 'trim|required');
		$this->form_validation->set_rules('komisi_member', 'komisi member', 'trim|required');
		$this->form_validation->set_rules('sisa_komisi_member', 'sisa komisi member', 'trim|required');
		$this->form_validation->set_rules('nama_member', 'nama member', 'trim|required');
		$this->form_validation->set_rules('no_group_member', 'no group member', 'trim');
		$this->form_validation->set_rules('no_rek_bca', 'no rek bca', 'trim');
		$this->form_validation->set_rules('nama_rek_bca', 'nama rek bca', 'trim');
		$this->form_validation->set_rules('is_del_member', 'is del member', 'trim');
		$this->form_validation->set_rules('crdate_member', 'crdate member', 'trim');
		$this->form_validation->set_rules('id_cr_member', 'id cr member', 'trim');
		$this->form_validation->set_rules('update_member', 'update member', 'trim');
		$this->form_validation->set_rules('id_up_member', 'id up member', 'trim');

		$this->form_validation->set_rules('id_kk_member', 'id_kk_member', 'trim');
		$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
	}

}
