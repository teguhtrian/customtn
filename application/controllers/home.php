<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Home extends MY_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model('home_model');
	}

	public function index()
	{
		// $data['content'] = 'dashboard.php';
		// print_r($this->session->userdata('kocab'));
		if ($this->session->userdata('kocab') == '00') {
			$data['ctmInputToday'] = $this->home_model->getCtmTodayAll();
		} else {
			$data['ctmInputToday'] = $this->home_model->getCtmTodayByKocab($this->session->userdata('kocab'));
		}
		$data['content'] = 'dashboard';
		$this->load->view('template', $data);
	}

	public function formInputPelanggan()
	{
		$data['kotakabu'] = $this->home_model->getKabuKota();
		$data['keca'] = $this->home_model->getKecaAll();
		$data['kelu'] = $this->home_model->getKeluAll();
		$data['content'] = 'form_input_pelanggan.php';
		$this->load->view('template', $data);
	}

	public function getNpa()
	{
		$query = $this->input->post('query');
		$result = $this->home_model->getNpaCustomDb($query);
		if ($result->num_rows() > 0) {
			echo json_encode($result->result());
		} else {
			$result = $this->home_model->getNpaCustomIsm($query);
			echo json_encode($result->result());
		}
		echo '';
	}

	public function inputPelanggan()
	{
		$data = $_POST;
		if ($this->home_model->iDataPelanggan($data) > 0) {
			# code...
			echo "Berhasil Diinput.";
		} else {
			# code...
			echo "Gagal Diinput. Terjadi Kesalahan Mohon Coba Kembali.";
		}
	}

	public function updatePelanggan()
	{
		$data = $_POST;
		// print_r($data);
		// die;
		if ($this->home_model->uDataPelanggan($data)) {
			# code...
			echo "Berhasil Diperbahrui.";
		} else {
			# code...
			echo "Gagal Diperbahrui.";
		}
	}

	public function inputPelanggan_backup()
	{
		// print_r($_POST);
		// die;
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->form_validation->set_rules('npa', 'npa', 'required');
		$this->form_validation->set_rules('na_ctm', 'nama customer', 'required');
		$this->form_validation->set_rules('notlp_ctm', 'notlp_ctm', 'required');
		$this->form_validation->set_rules('nohp_ctm', 'nohp_ctm', 'required');
		$this->form_validation->set_rules('email_ctm', 'email_ctm', 'required');
		$this->form_validation->set_rules('noktp_ctm', 'noktp_ctm', 'required');
		$this->form_validation->set_rules('almt_ctm', 'almt_ctm', 'required');
		$this->form_validation->set_rules('normh_ctm', 'normh_ctm', 'required');


		if ($this->form_validation->run() == FALSE) {
			// $this->load->view('myform');
			// echo "FALSE";
			// die;
			// $data['content'] = 'form_input_pelanggan.php';
			// $this->load->view('template', $data);
			$list['data'] = $this->input->post('kbptn');
			$data['kotakabu'] = $this->home_model->getKabuKota();
			$data['keca'] = $this->home_model->getKecaAll();
			$data['kelu'] = $this->home_model->getKeluAll();
			$data['content'] = 'form_input_pelanggan.php';
			$this->load->view('template', $data);
		} else {
			// $this->load->view('formsuccess');
			// echo "TRUE";
			// die;
			// $data['content'] = 'form_input_pelanggan.php';
			// $this->load->view('template', $data);
			redirect('/home/formInputPelanggan', 'refresh');
		}

		// $data['content'] = 'form_input_pelanggan.php';
		// $this->load->view('template', $data);
	}

	//List Kecamatan
	public function listKeca()
	{
		$idKabu = $this->input->post('kbptn');
		$keca = $this->home_model->getKeca($idKabu);

		$lists = "<option value=''>-- Pilih --</option>";
		foreach ($keca as $kc) {
			$lists .= "<option value='" . $kc->kd_kec . "'>" . $kc->kecamatan . "</option>";
		}

		$callback = array('list_keca' => $lists);
		echo json_encode($callback);
	}

	//List Kelurahan
	public function listKelu()
	{
		$idKabu = $this->input->post('kbptn');
		$idKeca = $this->input->post('kcmtn');
		$kelu = $this->home_model->getKelu($idKabu, $idKeca);

		$lists = "<option value=''>-- Pilih --</option>";
		foreach ($kelu as $kl) {
			$lists .= "<option value='" . $kl->kd_kel . "'>" . $kl->kelurahan . "</option>";
		}

		$callback = array('list_kelu' => $lists);
		echo json_encode($callback);
	}


	//Reporting
	public function ctkFormDaPel()
	{
		$data['cabang'] = $this->home_model->rAllCabang()->result();
		$data['content'] = 'form_cetak_buku.php';
		$this->load->view('template', $data);
	}

	public function ctkProgressInput()
	{
	}
}
