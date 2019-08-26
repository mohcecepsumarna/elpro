<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Tr_klaim_komisi_marketing extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Tr_klaim_komisi_marketing_model');
		$this->load->library('form_validation');        
		$this->load->library('datatables');
		date_default_timezone_set("Asia/Bangkok");
	}

	public function index()
	{
		$this->template->load('template','tr_klaim_komisi_marketing/tr_klaim_komisi_marketing_list');
	} 

	public function json() {
		header('Content-Type: application/json');
		echo $this->Tr_klaim_komisi_marketing_model->json();
	}

	public function read($id) 
	{
		$row = $this->Tr_klaim_komisi_marketing_model->get_by_id($id);
		// $idkkm = $row->id_kkm;
		// echo '<pre>';
		// 	print_r($idkkm);
		// 	exit();
		foreach ($row as $key => $value) {
			  $detsQuery = $this->db->query("SELECT * FROM tr_detail_kkm a where a.id_kkm_detail = '$id' 
                ");

            $details = $detsQuery->result();	
		}

		foreach ($row as $key => $value) {
			  $detsQuery = $this->db->query("SELECT * FROM tr_klaim_komisi_marketing a
				LEFT JOIN ms_marketing b ON a.id_mr_sel = b.id_mr
				LEFT JOIN ms_cabang c ON c.id_cb = b.id_cb_mrk
				WHERE a.id_kkm = '$id'
                ");

            // $ms_mark = $detsQuery->result()->row();	
             $ms_mark = $ms_mark = $detsQuery->row();
              // $this->db->get($this->table)->row();
		}

		if ($row) {
			// $datas = array(
			// 	'id_kkm' => $row->id_kkm,
			// 	'kd_kkm' => $row->kd_kkm,
			// 	// 'id_jp_dkkm' => $row->id_jp_dkkm,
			// 	// 'id_jt_dkkm' => $row->id_jt_dkkm,
			// 	// 'id_cp_dkkm' => $row->id_cp_dkkm,
			// 	// 'id_mr_kkm' => $row->id_mr_kkm,
			// 	'nm_kkm' => $row->nm_kkm,
			// 	'nm_dev' => $row->nm_dev,
			// 	'nm_properti' => $row->nm_properti,
			// 	'nm_cust' => $row->nm_cust,
			// 	'tgl_terjual' => $row->tgl_terjual,
			// 	'harga_jual' => $row->harga_jual,
			// 	'komisi' => $row->komisi,
			// 	'ket_kkm' => $row->ket_kkm,
			// 	'is_del_kkm' => $row->is_del_kkm,
			// 	'crdate_kkm' => $row->crdate_kkm,
			// 	'id_cr_kkm' => $row->id_cr_kkm,
			// 	'update_kkm' => $row->update_kkm,
			// 	'id_up_kkm' => $row->id_up_kkm,
			// );

			$data = array(
				'details' => $details,
				'datas' => $row,
				'ms_mark' => $ms_mark,
				// 'nm_properti' => $nm_properti,
			);	

			$this->template->load('template','tr_klaim_komisi_marketing/tr_klaim_komisi_marketing_read', $data);

			// echo '<pre>';
			// print_r($ms_mark);
			// exit();
		} else {
			$this->session->set_flashdata('message', 'Record Not Found');
			redirect(site_url('tr_klaim_komisi_marketing'));
		}
	}

	public function create() 
	{	
		$markQuery = $this->db->query("
			SELECT * FROM ms_marketing
			where is_del_mr = 0");

		$mark_select_values = $markQuery->result();

		$data = array(
			'button' => 'Create',
			'title' => 'Input',
			'action' => site_url('tr_klaim_komisi_marketing/create_action'),
			'id_kkm' => set_value('id_kkm'),
			'kd_kkm' => set_value('kd_kkm'),
			// 'id_jp_kkm' => set_value('id_jp_kkm'),
			// 'id_jt_kkm' => set_value('id_jt_kkm'),
			// 'id_cp_kkm' => set_value('id_cp_kkm'),
			'dll_kkm' => set_value('dll_kkm'),
			// 'id_mr_kkm' => set_value('id_mr_kkm'),
			// 'nm_kkm' => set_value('nm_kkm'),
			'nm_dev' => set_value('nm_dev'),
			'nm_properti' => set_value('nm_properti'),
			'ket_kkm' => set_value('ket_kkm'),
			'nm_cust' => set_value('nm_cust'),
			'tgl_terjual' => set_value('tgl_terjual'),
			'harga_jual' => set_value('harga_jual'),
			'komisi' => set_value('komisi'),
			'id_mr_sel' => set_value('id_mr_sel'),
			'id_mr_lis' => set_value('id_mr_lis'),
			'id_mr_cosel' => set_value('id_mr_cosel'),
			'id_mr_colis' => set_value('id_mr_colis'),
			// 'is_del_kkm' => set_value('is_del_kkm'),
			// 'crdate_kkm' => set_value('crdate_kkm'),
			// 'id_cr_kkm' => set_value('id_cr_kkm'),
			// 'update_kkm' => set_value('update_kkm'),
			// 'id_up_kkm' => set_value('id_up_kkm'),
			'mark_select_values'     => $mark_select_values,
		);
		$this->template->load('template','tr_klaim_komisi_marketing/tr_klaim_komisi_marketing_form', $data);
	}

	public function create_action() 
	{
		$this->_rules();

		if ($this->form_validation->run() == FALSE) {
			$this->create();
		} else {
			$data = array(
				'kd_kkm' => $this->input->post('kd_kkm',TRUE),
				// 'id_jp_kkm' => $this->input->post('id_jp_kkm',TRUE),
				// 'dll_kkm' => $this->input->post('dll_kkm',TRUE),
				// 'id_jt_kkm' => $this->input->post('id_jt_kkm',TRUE),
				// 'id_cp_kkm' => $this->input->post('id_cp_kkm',TRUE),
				'nm_dev' => $this->input->post('nm_dev',TRUE),
				'nm_properti' => $this->input->post('nm_properti',TRUE),
				'ket_kkm' => $this->input->post('ket_kkm',TRUE),
				'nm_cust' => $this->input->post('nm_cust',TRUE),
				'tgl_terjual' => $this->input->post('tgl_terjual',TRUE),
				'harga_jual' => $this->input->post('harga_jual',TRUE),
				'komisi' => $this->input->post('komisi',TRUE),
				'id_mr_sel' => $this->input->post('id_mr_sel',TRUE),
				'id_mr_lis' => $this->input->post('id_mr_lis',TRUE),
				'id_mr_colis' => $this->input->post('id_mr_colis',TRUE),
				'id_mr_cosel' => $this->input->post('id_mr_cosel',TRUE),
				'id_cr_kkm' => $this->session->userdata("id_users"),
			);

			$this->Tr_klaim_komisi_marketing_model->insert($data);

			$id_kkm = $this->db->insert_id();

			$id_jp_kkm = $this->input->post('id_jp_kkm');
			$id_jt_kkm = $this->input->post('id_jt_kkm');
			$id_cp_kkm = $this->input->post('id_cp_kkm');
			$dll_kkm = $this->input->post('dll_kkm');

			for ($i = 0; $i < count($id_jp_kkm) || $i < count($id_jt_kkm) || $i < count($id_cp_kkm); $i++) {

				$ins_db = array(
					'id_kkm_detail'         => $id_kkm,
					'dll_kkm'         => $dll_kkm,
					'id_jp_dkkm'   => $id_jp_kkm[$i],
					'id_jt_dkkm'   => $id_jt_kkm[$i],
					'id_cp_dkkm'   => $id_cp_kkm[$i],
				);

				$this->Tr_klaim_komisi_marketing_model->insert1($ins_db);
			}

			$this->session->set_flashdata('message', 'Create Record Success');
			redirect(site_url('tr_klaim_komisi_marketing'));
		}
	}

	// public function proses_kelas(){

	// 	$id_siswa = $this->input->post('id_siswa');
	// 	$kelas = $this->input->post('kelas[]');	

	// 	$jml_siswa = count($id_siswa);
	// 	for ($i=0;$i<$jml_siswa;$i++){ 
	// 		$data = array(
	// 			'id_siswa' => $id_siswa[$i],
	// 			 'kelas' => $kelas[$i]
	// 			  );
	// 		$this->db->insert('kelas_siswa',$data);
	// 	}
	// 	echo "sukses";

	// 	   // echo '<pre>';
 //            //     print_r($dataItems);
 //            //     exit();

	// }

	public function update($id) 
	{
		$row = $this->Tr_klaim_komisi_marketing_model->get_by_id($id);

		if ($row) {
			$data = array(
				'button' => 'Update',
				'action' => site_url('tr_klaim_komisi_marketing/update_action'),
				'id_kkm' => set_value('id_kkm', $row->id_kkm),
				'kd_kkm' => set_value('kd_kkm', $row->kd_kkm),
				'id_jp_kkm' => set_value('id_jp_kkm', $row->id_jp_kkm),
				'id_jt_kkm' => set_value('id_jt_kkm', $row->id_jt_kkm),
				'id_cp_kkm' => set_value('id_cp_kkm', $row->id_cp_kkm),
				'id_mr_kkm' => set_value('id_mr_kkm', $row->id_mr_kkm),
				'nm_kkm' => set_value('nm_kkm', $row->nm_kkm),
				'nm_dev' => set_value('nm_dev', $row->nm_dev),
				'nm_properti' => set_value('nm_properti', $row->nm_properti),
				'nm_cust' => set_value('nm_cust', $row->nm_cust),
				'tgl_terjual' => set_value('tgl_terjual', $row->tgl_terjual),
				'harga_jual' => set_value('harga_jual', $row->harga_jual),
				'komisi' => set_value('komisi', $row->komisi),
				'ket_kkm' => set_value('ket_kkm', $row->ket_kkm),
				'is_del_kkm' => set_value('is_del_kkm', $row->is_del_kkm),
				'crdate_kkm' => set_value('crdate_kkm', $row->crdate_kkm),
				'id_cr_kkm' => set_value('id_cr_kkm', $row->id_cr_kkm),
				'update_kkm' => set_value('update_kkm', $row->update_kkm),
				'id_up_kkm' => set_value('id_up_kkm', $row->id_up_kkm),
			);
			$this->template->load('template','tr_klaim_komisi_marketing/tr_klaim_komisi_marketing_form', $data);
		} else {
			$this->session->set_flashdata('message', 'Record Not Found');
			redirect(site_url('tr_klaim_komisi_marketing'));
		}
	}

	public function update_action() 
	{
		$this->_rules();

		if ($this->form_validation->run() == FALSE) {
			$this->update($this->input->post('id_kkm', TRUE));
		} else {
			$updatez     = date('Y-m-d H:i:s');
			$data = array(
				'kd_kkm' => $this->input->post('kd_kkm',TRUE),
				'id_jp_kkm' => $this->input->post('id_jp_kkm',TRUE),
				'id_jt_kkm' => $this->input->post('id_jt_kkm',TRUE),
				'id_cp_kkm' => $this->input->post('id_cp_kkm',TRUE),
				'id_mr_kkm' => $this->input->post('id_mr_kkm',TRUE),
				'nm_kkm' => $this->input->post('nm_kkm',TRUE),
				'nm_dev' => $this->input->post('nm_dev',TRUE),
				'nm_properti' => $this->input->post('nm_properti',TRUE),
				'nm_cust' => $this->input->post('nm_cust',TRUE),
				'tgl_terjual' => $this->input->post('tgl_terjual',TRUE),
				'harga_jual' => $this->input->post('harga_jual',TRUE),
				'komisi' => $this->input->post('komisi',TRUE),
				'ket_kkm' => $this->input->post('ket_kkm',TRUE),
				'update_kkm' => $updatez,
				'id_up_kkm' => $this->session->userdata("id_users"),
			);

			$this->Tr_klaim_komisi_marketing_model->update($this->input->post('id_kkm', TRUE), $data);
			$this->session->set_flashdata('message', 'Update Record Success');
			redirect(site_url('tr_klaim_komisi_marketing'));
		}
	}

	public function delete($id) 
	{
		$row = $this->Tr_klaim_komisi_marketing_model->get_by_id($id);

		if ($row) {
			$this->Tr_klaim_komisi_marketing_model->delete($id);
			$this->session->set_flashdata('message', 'Delete Record Success');
			redirect(site_url('tr_klaim_komisi_marketing'));
		} else {
			$this->session->set_flashdata('message', 'Record Not Found');
			redirect(site_url('tr_klaim_komisi_marketing'));
		}
	}

	public function _rules() 
	{
		$this->form_validation->set_rules('kd_kkm', 'kd kkm', 'trim|required');
		// $this->form_validation->set_rules('id_jp_kkm', 'id jp kkm', 'trim');
		// $this->form_validation->set_rules('id_jt_kkm', 'id jt kkm', 'trim');
		// $this->form_validation->set_rules('id_cp_kkm', 'id cp kkm', 'trim');
		$this->form_validation->set_rules('id_mr_sel', 'id cp kkm', 'trim|required');
		$this->form_validation->set_rules('id_mr_cosel', 'id cp kkm', 'trim|required');
		$this->form_validation->set_rules('id_mr_lis', 'id cp kkm', 'trim|required');
		$this->form_validation->set_rules('id_mr_colis', 'id cp kkm', 'trim|required');
		// $this->form_validation->set_rules('id_mr_kkm', 'id mr kkm', 'trim');
		// $this->form_validation->set_rules('nm_kkm', 'nm kkm', 'trim|required');
		$this->form_validation->set_rules('nm_dev', 'nm dev', 'trim|required');
		$this->form_validation->set_rules('nm_properti', 'nm properti', 'trim|required');
		$this->form_validation->set_rules('ket_kkm', 'ket kkm', 'trim');
		$this->form_validation->set_rules('nm_cust', 'nm cust', 'trim|required');
		$this->form_validation->set_rules('tgl_terjual', 'tgl terjual', 'trim|required');
		$this->form_validation->set_rules('harga_jual', 'harga jual', 'trim|required');
		$this->form_validation->set_rules('komisi', 'komisi', 'trim|required');
		// $this->form_validation->set_rules('is_del_kkm', 'is del kkm', 'trim');
		// $this->form_validation->set_rules('crdate_kkm', 'crdate kkm', 'trim');
		// $this->form_validation->set_rules('id_cr_kkm', 'id cr kkm', 'trim');
		// $this->form_validation->set_rules('update_kkm', 'update kkm', 'trim');
		// $this->form_validation->set_rules('id_up_kkm', 'id up kkm', 'trim');

		$this->form_validation->set_rules('id_kkm', 'id_kkm', 'trim');
		$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
	}

}
