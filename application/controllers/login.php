<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		// $this->load->model('gudang_model','gudang');
		$this->load->model('login_model');
	}

	public function index()
	{
		//$data['content'] = "kelompok";
		//$this->load->view('template', $data);
		$this->load->view('form_login');
	}

	public function auth()
	{
		$nipp = strip_tags(addslashes(trim($_POST['nipp'])));
		$pass = strip_tags(addslashes(trim($_POST['password'])));
		$cek = $this->login_model->get_user($nipp, $pass)->result_array();

		if (count($cek) == 1) {
			// print_r($cek);
			foreach ($cek as $cek) {
				$nipp = $cek['nipp'];
				$kocab = $cek['kocab'];
				$grup_user = $cek['grup_user'];
			}

			$userInfo = $this->login_model->getUserFullInfo($nipp)->result_array();
			// print_r($userInfo[0]['Fullname']);die;
			if ($userInfo == NULL) {
				$fullname = $nipp;
			} else {
				foreach ($userInfo as $userInfo) {
					$fullname = ucwords((strtolower($userInfo['Fullname'])));
				}
			}
			// print_r($fullname);
			// die;

			$this->session->set_userdata(array(
				'isLogin' => TRUE,
				'nipp' => $nipp,
				'kocab' => $kocab,
				'grup_user' => $grup_user,
				'fullname' => $fullname,
			));

			// print_r($this->session->all_userdata());
			// print_r($_SESSION);
			// die;

			session_start();
			// print_r($this->session->all_userdata());die();
			if ($this->session->userdata('isLogin') == TRUE) {
				redirect('home', 'refresh');
			}
		} else {
			//jika data tidak cocok
			//alihkan ke home
			echo "<script>alert('Gagal Login')</script>";
			redirect('login', 'refresh');
		}
	}

	function logout()
	{
		// $this->actionLog($this->session->userdata('NAMALENGKAP')." (".$this->session->userdata('NIP').") Logout dari sistem","logout()",current_url());
		$this->session->sess_destroy();
		redirect("login");
	}

	function changePass()
	{
		$data['content'] = 'form_ganti_pass.php';
		$this->load->view('template', $data);
	}

	function updatePass()
	{
		// print_r($_POST);die;
		$nipp = $_POST['nipp'];
		$passnew = $_POST['pass'];
		$result = $this->login_model->uPassByNipp($nipp, $passnew);
		echo $result;
	}
}
