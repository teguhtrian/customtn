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
		// session_start();
		// print_r($this->session->userdata('fullname'));//die;
		$tglhariIni = date('Y-m-d');
		$kocab = $this->session->userdata('kocab');
		$data['bpbra'] = $this->home_model->rBpbraDayByKocab($kocab, $tglhariIni)->result();
		$data['content'] = 'dashboard.php';
		// $data['data']=$this->sdm_model->getSppd100();
		$this->load->view('template', $data);
	}

	public function formInputPelanggan()
	{
		// print_r($this->session->userdata('fullname'));die;
		$data['content'] = 'form_input_pelanggan.php';
		// $data['data']=$this->sdm_model->getSppd100();
		$data['biaya'] = $this->home_model->rBiayaByKocab($this->session->userdata('kocab'))->result();
		// print_r($data['biaya']);die;
		$this->load->view('template', $data);
	}

	public function inputPelanggan()
	{
		// print_r($this->session->userdata('fullname'));die;
		print_r($_POST);
		die;
		$data['content'] = 'form_input_pelanggan.php';
		// $data['data']=$this->sdm_model->getSppd100();
		$data['biaya'] = $this->home_model->rBiayaByKocab($this->session->userdata('kocab'))->result();
		// print_r($data['biaya']);die;
		$this->load->view('template', $data);
	}

	public function formInputBpbra()
	{
		// print_r($this->session->userdata('fullname'));die;
		$data['content'] = 'form_input_bpbra.php';
		// $data['data']=$this->sdm_model->getSppd100();
		$data['biaya'] = $this->home_model->rBiayaByKocab($this->session->userdata('kocab'))->result();
		// print_r($data['biaya']);die;
		$this->load->view('template', $data);
	}

	public function formInputBpbraNP()
	{
		// print_r($this->session->userdata('fullname'));die;
		$data['content'] = 'form_input_bpbra_np.php';
		// $data['data']=$this->sdm_model->getSppd100();
		$data['biaya'] = $this->home_model->rBiayaByKocab($this->session->userdata('kocab'))->result();
		// print_r($data['biaya']);die;
		$this->load->view('template', $data);
	}

	public function formInputBpbraPsb()
	{
		// print_r($this->session->all_userdata());die;
		// print_r($this->session->userdata('fullname'));die;
		$data['content'] = 'form_input_bpbra_psb.php';
		// $data['data']=$this->sdm_model->getSppd100();
		$data['biaya'] = $this->home_model->rBiayaPsbByKocab($this->session->userdata('kocab'))->result();
		// print_r($data['biaya']);die;
		$this->load->view('template', $data);
	}

	public function formCetakUlangBonBulan()
	{
		if ($this->session->userdata('grup_user') == '1') {
			$data['cabang'] = $this->home_model->rAllCabang()->result();
		} else {
			$data['cabang'] = $this->home_model->rDataKocabByKocab($this->session->userdata('kocab'))->result();
		}
		$data['content'] = 'form_cetak_ulang_bpbra.php';
		// $data['data']=$this->sdm_model->getSppd100();
		$data['biaya'] = $this->home_model->rBiayaPsbByKocab($this->session->userdata('kocab'))->result();
		// print_r($data['biaya']);die;
		$this->load->view('template', $data);
	}

	public function formInputBpbraPsbMan()
	{
		// print_r($this->session->all_userdata());die;
		// print_r($this->session->userdata('fullname'));die;
		$data['content'] = 'form_input_bpbra_psb_man.php';
		// $data['data']=$this->sdm_model->getSppd100();
		$data['biaya'] = $this->home_model->rBiayaPsbByKocab($this->session->userdata('kocab'))->result();
		// print_r($data['biaya']);die;
		$this->load->view('template', $data);
	}

	public function formInputBpbra2()
	{
		// print_r($this->session->set_userdata('fullname'));die;
		$data['content'] = 'form_input_bpbra2.php';
		// $data['data']=$this->sdm_model->getSppd100();
		$data['biaya'] = $this->home_model->rBiayaByKocab($this->session->userdata('kocab'))->result();
		// print_r($data['biaya']);die;
		$this->load->view('template', $data);
	}

	public function formCetakLpp()
	{
		if ($this->session->userdata('grup_user') == '1') {
			$data['cabang'] = $this->home_model->rAllCabang()->result();
		} else {
			$data['cabang'] = $this->home_model->rDataKocabByKocab($this->session->userdata('kocab'))->result();
		}
		$data['content'] = 'form_cetak_lpp.php';
		$this->load->view('template', $data);
	}

	public function formCetakSuPemPsb()
	{
		if ($this->session->userdata('grup_user') == '1') {
			$data['cabang'] = $this->home_model->rAllCabang()->result();
		} else {
			$data['cabang'] = $this->home_model->rDataKocabByKocab($this->session->userdata('kocab'))->result();
		}
		$data['content'] = 'form_cetak_sp_psb.php';
		$this->load->view('template', $data);
	}

	public function formCetakBpkb()
	{
		if ($this->session->userdata('grup_user') == '1') {
			$data['cabang'] = $this->home_model->rAllCabang()->result();
		} else {
			$data['cabang'] = $this->home_model->rDataKocabByKocab($this->session->userdata('kocab'))->result();
		}
		$data['content'] = 'form_cetak_bpkb.php';
		$this->load->view('template', $data);
	}

	public function formCetakBs()
	{
		if ($this->session->userdata('grup_user') == '1') {
			$data['cabang'] = $this->home_model->rAllCabang()->result();
		} else {
			$data['cabang'] = $this->home_model->rDataKocabByKocab($this->session->userdata('kocab'))->result();
		}
		$data['content'] = 'form_cetak_bs.php';
		$this->load->view('template', $data);
	}

	// public function npa(){
	// 	$query='0101';
	// 	$result=$this->home_model->getNpaCustom($query);
	// 	print_r($result);
	// }

	public function getNpa()
	{
		$query = $this->input->post('query');
		$result = $this->home_model->getNpaCustom($query);
		if ($result->num_rows() > 0) {
			echo json_encode($result->result());
		} else {
			echo '';
		}
	}

	public function getNoReg($kocab)
	{
		$query = $this->input->post('query');
		// $result=$this->home_model->getNpaCustom($query);
		if ($kocab == '00') {
			//pusat -> sementara diganti jadi 00
			$result = $this->home_model->getNoRegBrstg($query);
			// print_r($result->result());die;
			if ($result->num_rows() > 0) {
				echo json_encode($result->result());
			} else {
				echo '';
			}
		} elseif ($kocab == '14') {
			//tapsel
			$result = $this->home_model->getNoRegTapsel($query);
			if ($result->num_rows() > 0) {
				echo json_encode($result->result());
			} else {
				echo '';
			}
		} elseif ($kocab == '06') {
			//berastagi
			$result = $this->home_model->getNoRegBrstg($query);
			if ($result->num_rows() > 0) {
				echo json_encode($result->result());
			} else {
				echo '';
			}
		} elseif ($kocab == '17') {
			//tobasa
			$result = $this->home_model->getNoRegTobasa($query);
			if ($result->num_rows() > 0) {
				echo json_encode($result->result());
			} else {
				echo '';
			}
		} elseif ($kocab == '22') {
			//samosir
			$result = $this->home_model->getNoRegSamosir($query);
			if ($result->num_rows() > 0) {
				echo json_encode($result->result());
			} else {
				echo '';
			}
		} elseif ($kocab == '16') {
			//tapteng
			$result = $this->home_model->getNoRegTapteng($query);
			if ($result->num_rows() > 0) {
				echo json_encode($result->result());
			} else {
				echo '';
			}
		} elseif ($kocab == '05') {
			//sibolangit
			$result = $this->home_model->getNoRegSibolangit($query);
			if ($result->num_rows() > 0) {
				echo json_encode($result->result());
			} else {
				echo '';
			}
		} else {
			echo '';
		}
		// $result=$this->home_model->getNoReg($query,$);

	}

	public function inputBPBRA()
	{
		// session_start();
		// if ($_POST['my_token'] === $_SESSION['my_token']){
		$fmt = new NumberFormatter('en_US', NumberFormatter::CURRENCY);
		$count = 0;
		$kocab = $this->session->userdata('kocab');
		$abbrev = $this->home_model->rAbreByKocab($kocab)->row_array();
		// print_r($abbrev['Abbreviation']);
		$bulan = date("m");
		$tahun = date('Y');
		// print_r($bulan);die;
		$count = $this->home_model->rCountBon($kocab, $tahun, $bulan)->result();
		$count = $count[0]->hitung + 1;
		// print_r($count);die;
		$no_kwitansi = $abbrev['Abbreviation'] . "-" . date("Y") . "." . date("m") . "-" . $count . "";
		// print_r($no_kwitansi);
		$inputby_name = addslashes($this->session->userdata('fullname'));
		$inputby_nipp = $this->session->userdata('nipp');
		$tgl_input = date("Y-m-d H:i:s");
		$tgl_bayar = date("Y-m-d H:i:s");
		// print_r($_POST);die;
		$btotal = str_replace(",", "", str_replace(".00", "", $_POST['btotal']));
		// print_r($btotal);die;
		$npa = $_POST['npa_pel'];
		$nm_ctm = str_replace("'", "''", $_POST['na_ctm']);
		$alamat = $_POST['alamat'] . " " . $_POST['no_rmh'];
		$alamat = str_replace("'", "''", str_replace("<", " ", $alamat));
		// $npa='0102010222';
		// $nm_ctm='Fulan';
		// $alamat='Jl.Fulan';

		// print_r($_POST);die;
		// print_r($_POST);die;
		if (!empty($_POST['cicil'])) {
			//dp cicilan
			// echo 'dp cicilan'; die;
			$cicil = 1;
			$idBpbra = $this->home_model->iTblBpbraCicil($no_kwitansi, $kocab, $tgl_bayar, $npa, $nm_ctm, $alamat, $inputby_nipp, $inputby_name, $tgl_input, $cicil);
		} else {
			//bukan dp cicilan
			// echo 'bukan dp cicilan'; die;
			$idBpbra = $this->home_model->iTblBpbra($no_kwitansi, $kocab, $tgl_bayar, $npa, $nm_ctm, $alamat, $inputby_nipp, $inputby_name, $tgl_input);
		}


		$countItem = 0;
		foreach ($_POST['box'] as $cb) {
			// print_r($cb);
			// echo '<br>';
			// print_r($_POST['box']);
			// echo '<br>';
			// print_r($_POST['boxChecklist']);
			// die;
			$val = explode("-", $cb);
			$item = $this->home_model->rTbBiayaById($val[0])->row_array();
			$isNotPpn = $item['isNotPpn'];
			// print_r($item['isNotPpn']);
			// die
			$rubrik = $item['rubrik'] . $kocab;
			if ($item['biaya'] != $btotal) {
				//total tidak sama dengan biaya
				if (empty($_POST['cicil'])) {
					//bukan merupakan dp cicilan
					// echo "bukan cicilan";die;
					$bb = $btotal; //bb -> biaya baru
					$ppnBb = $bb * 0.1;
					$prefixItem = '';
					$prefixPpn = '';
					$idtb_biaya = $item['id'];
					$item = $item['itemnya'] . " " . $_POST['ket'];
					$callback[$countItem] = $this->home_model->iTblCicilan($no_kwitansi, $idBpbra, $kocab, $tgl_bayar, $rubrik, $item, $bb, $npa, $nm_ctm, $alamat, $idtb_biaya, $inputby_nipp, $inputby_name, $tgl_input, $ppnBb, $prefixItem, $prefixPpn, $isNotPpn);
				} else {
					// cicilan
					// echo "cicilan";die;
					$dp = $btotal;
					$ppn = $item['biaya'] * 0.1;
					$prefixItem = '(DP ' . $fmt->formatCurrency($btotal, "IDR") . ')';
					// $prefixPpn ='(Dari total Biaya: '.$fmt->formatCurrency($item['biaya'],"IDR").')';
					$prefixPpn = '';
					$rubrik = '13.02.70.' . $kocab;
					$isdp = 1;
					$idtb_biaya = $item['id'];
					$item = $item['itemnya'] . " " . $_POST['ket'];
					$callback[$countItem] = $this->home_model->iTblCicilanDp($no_kwitansi, $idBpbra, $kocab, $tgl_bayar, $rubrik, $item, $dp, $npa, $nm_ctm, $alamat, $idtb_biaya, $inputby_nipp, $inputby_name, $tgl_input, $ppn, $prefixItem, $prefixPpn, $isdp, $isNotPpn);
				}
			} else {
				//total sama dengan biaya
				$biaya = $item['biaya'];
				$ppn = $biaya * 0.1;
				$prefixItem = '';
				$prefixPpn = '';
				$idtb_biaya = $item['id'];
				$item = $item['itemnya'] . " " . $_POST['ket'];
				$callback[$countItem] = $this->home_model->iTblCicilan($no_kwitansi, $idBpbra, $kocab, $tgl_bayar, $rubrik, $item, $biaya, $npa, $nm_ctm, $alamat, $idtb_biaya, $inputby_nipp, $inputby_name, $tgl_input, $ppn, $prefixItem, $prefixPpn, $isNotPpn);
			}
			// $idtb_biaya=$item['id'];
			// $item=$item['itemnya'];
			// print_r($item);die;
			// $callback[$countItem]=$this->home_model->iTblCicilan($no_kwitansi,$idBpbra,$kocab,$tgl_bayar,$rubrik,$item,$biaya,$npa,$nm_ctm,$alamat,$idtb_biaya,$inputby_nipp,$inputby_name,$tgl_input,$ppn,$prefixItem,$prefixPpn,$isdp);
			$countItem++;
		}

		// session_destroy();
		$countItem = 0;
		foreach ($callback as $cb) {
			if ($cb <> 0) {
				// $this->konfirmasiInput($callback[$countItem]);
				$this->session->set_flashdata('konfirm', $callback[$countItem]);
			}
		}
		// print_r($no_kwitansi);

		// $this->konfirmasiInput('Berhasil',$no_kwitansi);
		// $this->session->set_flashdata('konfirm','Berhasil');
		// $this->session->set_flashdata('no_kwitansi',$no_kwitansi);
		$this->session->set_userdata(array(
			'no_kwitansi' => $no_kwitansi,
			'konfirm' => 'Berhasil'
		));
		redirect('home/konfirmasiInput/');

		// }else{
		// 	// was bad!!!
		//  	// echo "BEDA";
		// 	$data['content']='errorSession.php';
		// 	$this->load->view('template',$data);
		// }
	}

	public function inputBPBRANonNpa()
	{
		// session_start();
		// if ($_POST['my_token'] === $_SESSION['my_token']){
		$fmt = new NumberFormatter('en_US', NumberFormatter::CURRENCY);
		$count = 0;
		$kocab = $this->session->userdata('kocab');
		$abbrev = $this->home_model->rAbreByKocab($kocab)->row_array();
		// print_r($abbrev['Abbreviation']);
		$bulan = date("m");
		$tahun = date('Y');
		// print_r($bulan);die;
		$count = $this->home_model->rCountBon($kocab, $tahun, $bulan)->result();
		$count = $count[0]->hitung + 1;
		// print_r($count);die;
		$no_kwitansi = $abbrev['Abbreviation'] . "-" . date("Y") . "." . date("m") . "-" . $count . "";
		// print_r($no_kwitansi);
		$inputby_name = addslashes($this->session->userdata('fullname'));
		$inputby_nipp = $this->session->userdata('nipp');
		$tgl_input = date("Y-m-d H:i:s");
		$tgl_bayar = date("Y-m-d H:i:s");
		// print_r($_POST);die;
		$btotal = str_replace(",", "", str_replace(".00", "", $_POST['btotal']));
		// print_r($btotal);die;
		$npa = '-';
		$nm_ctm = $_POST['na_ctm'];
		$alamat = $_POST['alamat'];
		$alamat = addslashes(str_replace("<", " ", $alamat));
		// $npa='-';
		// $nm_ctm='Fulan';
		// $alamat='Jl.Fulan';

		// print_r($_POST);die;
		// print_r($_POST);die;
		if (!empty($_POST['cicil'])) {
			//dp cicilan
			// echo 'dp cicilan'; die;
			$cicil = 1;
			$idBpbra = $this->home_model->iTblBpbraCicil($no_kwitansi, $kocab, $tgl_bayar, $npa, $nm_ctm, $alamat, $inputby_nipp, $inputby_name, $tgl_input, $cicil);
		} else {
			//bukan dp cicilan
			// echo 'bukan dp cicilan'; die;
			$idBpbra = $this->home_model->iTblBpbra($no_kwitansi, $kocab, $tgl_bayar, $npa, $nm_ctm, $alamat, $inputby_nipp, $inputby_name, $tgl_input);
		}


		$countItem = 0;
		foreach ($_POST['box'] as $cb) {
			// print_r($val);
			$val = explode("-", $cb);
			$item = $this->home_model->rTbBiayaById($val[0])->row_array();
			// print_r($item);die;
			$isNotPpn = $item['isNotPpn'];
			$rubrik = $item['rubrik'] . $kocab;
			if ($item['biaya'] != $btotal) {
				//total tidak sama dengan biaya
				if (empty($_POST['cicil'])) {
					//bukan merupakan dp cicilan
					// echo "bukan cicilan";die;
					$bb = $btotal; //bb -> biaya baru
					$ppnBb = $bb * 0.1;
					$prefixItem = '';
					$prefixPpn = '';
					$idtb_biaya = $item['id'];
					$item = $item['itemnya'] . " " . $_POST['ket'];
					$callback[$countItem] = $this->home_model->iTblCicilan($no_kwitansi, $idBpbra, $kocab, $tgl_bayar, $rubrik, $item, $bb, $npa, $nm_ctm, $alamat, $idtb_biaya, $inputby_nipp, $inputby_name, $tgl_input, $ppnBb, $prefixItem, $prefixPpn, $isNotPpn);
				} else {
					// cicilan
					// echo "cicilan";die;
					$dp = $btotal;
					$ppn = $item['biaya'] * 0.1;
					$prefixItem = '(DP ' . $fmt->formatCurrency($btotal, "IDR") . ')';
					// $prefixPpn ='(Dari total Biaya: '.$fmt->formatCurrency($item['biaya'],"IDR").')';
					$prefixPpn = '';
					$isdp = 1;
					$idtb_biaya = $item['id'];
					$item = $item['itemnya'] . " " . $_POST['ket'];
					$callback[$countItem] = $this->home_model->iTblCicilanDp($no_kwitansi, $idBpbra, $kocab, $tgl_bayar, $rubrik, $item, $dp, $npa, $nm_ctm, $alamat, $idtb_biaya, $inputby_nipp, $inputby_name, $tgl_input, $ppn, $prefixItem, $prefixPpn, $isdp, $isNotPpn);
				}
			} else {
				//total sama dengan biaya
				$biaya = $item['biaya'];
				$ppn = $biaya * 0.1;
				$prefixItem = '';
				$prefixPpn = '';
				$idtb_biaya = $item['id'];
				$item = $item['itemnya'] . " " . $_POST['ket'];
				$callback[$countItem] = $this->home_model->iTblCicilan($no_kwitansi, $idBpbra, $kocab, $tgl_bayar, $rubrik, $item, $biaya, $npa, $nm_ctm, $alamat, $idtb_biaya, $inputby_nipp, $inputby_name, $tgl_input, $ppn, $prefixItem, $prefixPpn, $isNotPpn);
			}
			// $idtb_biaya=$item['id'];
			// $item=$item['itemnya'];
			// print_r($item);die;
			// $callback[$countItem]=$this->home_model->iTblCicilan($no_kwitansi,$idBpbra,$kocab,$tgl_bayar,$rubrik,$item,$biaya,$npa,$nm_ctm,$alamat,$idtb_biaya,$inputby_nipp,$inputby_name,$tgl_input,$ppn,$prefixItem,$prefixPpn,$isdp);
			$countItem++;
		}

		// session_destroy();
		$countItem = 0;
		foreach ($callback as $cb) {
			if ($cb <> 0) {
				// $this->konfirmasiInput($callback[$countItem]);
				$this->session->set_flashdata('konfirm', $callback[$countItem]);
			}
		}
		// print_r($no_kwitansi);

		// $this->konfirmasiInput('Berhasil',$no_kwitansi);
		// $this->session->set_flashdata('konfirm','Berhasil');
		// $this->session->set_flashdata('no_kwitansi',$no_kwitansi);
		$this->session->set_userdata(array(
			'no_kwitansi' => $no_kwitansi,
			'konfirm' => 'Berhasil'
		));
		redirect('home/konfirmasiInput/');

		// }else{
		// 	// was bad!!!
		//  	// echo "BEDA";
		// 	$data['content']='errorSession.php';
		// 	$this->load->view('template',$data);
		// }
	}

	public function inputBPBRAPsb()
	{
		// session_start();
		// if ($_POST['my_token'] === $_SESSION['my_token']){
		// print_r($_POST);die;
		$fmt = new NumberFormatter('en_US', NumberFormatter::CURRENCY);
		$count = 0;
		$kocab = $this->session->userdata('kocab');
		$abbrev = $this->home_model->rAbreByKocab($kocab)->row_array();
		// print_r($abbrev['Abbreviation']);
		$bulan = date("m");
		$tahun = date('Y');
		// print_r($bulan);die;
		$count = $this->home_model->rCountBon($kocab, $tahun, $bulan)->result();
		$count = $count[0]->hitung + 1;
		// print_r($count);die;
		$no_kwitansi = $abbrev['Abbreviation'] . "-" . date("Y") . "." . date("m") . "-" . $count . "";
		// print_r($no_kwitansi);
		$inputby_name = $this->session->userdata('fullname');
		$inputby_nipp = $this->session->userdata('nipp');
		$tgl_input = date("Y-m-d H:i:s");
		$tgl_bayar = date("Y-m-d H:i:s");
		// print_r($_POST);die;
		$btotal = str_replace(",", "", str_replace(".00", "", $_POST['btotal']));
		// print_r($btotal);die;
		$npa = $_POST['noreg_pel'];
		$nm_ctm = addslashes($_POST['na_ctm']);
		$alamat = $_POST['alamat'] . " " . $_POST['no_rmh'];
		$alamat = addslashes(str_replace("<", " ", $alamat));
		// $npa='0102010222';
		// $nm_ctm='Fulan';
		// $alamat='Jl.Fulan';

		// print_r($_POST);die;
		// print_r($_POST);die;
		if (!empty($_POST['cicil'])) {
			//dp cicilan
			// echo 'dp cicilan'; die;
			$cicil = 1;
			$idBpbra = $this->home_model->iTblBpbraCicilPsb($no_kwitansi, $kocab, $tgl_bayar, $npa, $nm_ctm, $alamat, $inputby_nipp, $inputby_name, $tgl_input, $cicil);
		} else {
			//bukan dp cicilan
			// echo 'bukan dp cicilan'; die;
			$idBpbra = $this->home_model->iTblBpbraPsb($no_kwitansi, $kocab, $tgl_bayar, $npa, $nm_ctm, $alamat, $inputby_nipp, $inputby_name, $tgl_input);
		}


		$countItem = 0;
		foreach ($_POST['box'] as $cb) {
			// print_r($val);
			$val = explode("-", $cb);
			$item = $this->home_model->rTbBiayaById($val[0])->row_array();
			// print_r($item);
			// die;
			$isNotPpn = $item['isNotPpn'];
			$rubrik = $item['rubrik'] . $kocab;
			if ($item['biaya'] != $btotal) {
				//total tidak sama dengan biaya
				if (empty($_POST['cicil'])) {
					//bukan merupakan dp cicilan
					// echo "bukan cicilan";die;
					$bb = $btotal; //bb -> biaya baru
					$ppnBb = $bb * 0.1;
					$prefixItem = '';
					$prefixPpn = '';
					$idtb_biaya = $item['id'];
					$item = $item['itemnya'] . " " . $_POST['ket'];
					// print_r($item);die;
					$callback[$countItem] = $this->home_model->iTblCicilanPsb($no_kwitansi, $idBpbra, $kocab, $tgl_bayar, $rubrik, $item, $bb, $npa, $nm_ctm, $alamat, $idtb_biaya, $inputby_nipp, $inputby_name, $tgl_input, $ppnBb, $prefixItem, $prefixPpn, $isNotPpn);
				} else {
					// cicilan
					// echo "cicilan";die;
					$dp = $btotal;
					$ppn = $item['biaya'] * 0.1;
					$prefixItem = '(DP ' . $fmt->formatCurrency($btotal, "IDR") . ')';
					// $prefixPpn ='(Dari total Biaya: '.$fmt->formatCurrency($item['biaya'],"IDR").')';
					$prefixPpn = '';
					$isdp = 1;
					$idtb_biaya = $item['id'];
					$item = $item['itemnya'] . " " . $_POST['ket'];
					// print_r($item);die;
					$callback[$countItem] = $this->home_model->iTblCicilanDpPsb($no_kwitansi, $idBpbra, $kocab, $tgl_bayar, $rubrik, $item, $dp, $npa, $nm_ctm, $alamat, $idtb_biaya, $inputby_nipp, $inputby_name, $tgl_input, $ppn, $prefixItem, $prefixPpn, $isdp, $isNotPpn);
				}
			} else {
				//total sama dengan biaya
				$biaya = $item['biaya'];
				$ppn = $biaya * 0.1;
				$prefixItem = '';
				$prefixPpn = '';
				$idtb_biaya = $item['id'];
				$item = $item['itemnya'] . " " . $_POST['ket'];
				// print_r($item);die;
				$callback[$countItem] = $this->home_model->iTblCicilanPsb($no_kwitansi, $idBpbra, $kocab, $tgl_bayar, $rubrik, $item, $biaya, $npa, $nm_ctm, $alamat, $idtb_biaya, $inputby_nipp, $inputby_name, $tgl_input, $ppn, $prefixItem, $prefixPpn, $isNotPpn);
			}
			// $idtb_biaya=$item['id'];
			// $item=$item['itemnya'];
			// print_r($item);die;
			// $callback[$countItem]=$this->home_model->iTblCicilan($no_kwitansi,$idBpbra,$kocab,$tgl_bayar,$rubrik,$item,$biaya,$npa,$nm_ctm,$alamat,$idtb_biaya,$inputby_nipp,$inputby_name,$tgl_input,$ppn,$prefixItem,$prefixPpn,$isdp);
			$countItem++;
		}

		// session_destroy();
		$countItem = 0;
		foreach ($callback as $cb) {
			if ($cb <> 0) {
				// $this->konfirmasiInput($callback[$countItem]);
				$this->session->set_flashdata('konfirm', $callback[$countItem]);
			}
		}
		// print_r($no_kwitansi);

		// $this->konfirmasiInput('Berhasil',$no_kwitansi);
		// $this->session->set_flashdata('konfirm','Berhasil');
		// $this->session->set_flashdata('no_kwitansi',$no_kwitansi);
		$this->session->set_userdata(array(
			'no_kwitansi' => $no_kwitansi,
			'konfirm' => 'Berhasil'
		));
		redirect('home/konfirmasiInput/');

		// }else{
		// 	// was bad!!!
		//  	// echo "BEDA";
		// 	$data['content']='errorSession.php';
		// 	$this->load->view('template',$data);
		// }
	}

	public function konfirmasiInput()
	{
		// print_r($this->session->flashdata('konfirm'));
		// $konfirm = $this->session->flashdata('konfirm');
		// $kwit = $this->session->flashdata('no_kwitansi');
		$konfirm = $this->session->userdata('konfirm');
		$kwit = $this->session->userdata('no_kwitansi');
		$data['content'] = 'form_konf_input.php';
		$data['data'] = $konfirm;
		$data['no_kwitansi'] = $kwit;
		$this->load->view('template', $data);
	}

	public function menuBiaya()
	{
		$data['content'] = 'menu_rubrik.php';
		$data['biaya'] = $this->home_model->rBiayaByKocab($this->session->userdata('kocab'))->result();
		if ($this->session->userdata('grup_user') == 1) {
			$data['cabang'] = $this->home_model->rAllCabang()->result();
		} else {
			$data['cabang'] = $this->home_model->rDataKocabByKocab($this->session->userdata('kocab'))->result();
		}
		// print_r($data['biaya']);die;
		$this->load->view('template', $data);
	}

	public function inputDataBiaya()
	{
		$kocab = $_POST['kocab'];
		$rubrik = $_POST['rubrik'];
		$jenis = $_POST['jenis'];
		$item = $_POST['item'];
		$biaya = str_replace(".00", "", str_replace(",", "", $_POST['biaya']));
		$ppn = str_replace("%", "", $_POST['ppn']);
		// print_r($_POST);die;
		$result = $this->home_model->iTblBiaya($kocab, $rubrik, $jenis, $item, $biaya, $ppn);
		echo $result;
	}

	public function menuPejabat()
	{
		if ($this->session->userdata('grup_user') == '1') {
			// $data['pejabat']=$this->home_model->rPejabatAllCabang()->result();
			$data['cabang'] = $this->home_model->rAllCabang()->result();
			$data['pejabat'] = $this->home_model->rPejabatByCabang($this->session->userdata('kocab'))->result();
			$data['content'] = 'menu_pejabat_cabang.php';
		} else {
			$data['cabang'] = $this->home_model->rDataKocabByKocab($this->session->userdata('kocab'))->result();
			$data['pejabat'] = $this->home_model->rPejabatByCabang($this->session->userdata('kocab'))->result();
			$data['content'] = 'menu_pejabat_cabang.php';
		}
		// var_dump($data['pejabat'][0]);die;
		$this->load->view('template', $data);
	}

	public function inputDataPejabat()
	{
		// print_r($_POST);die;
		$kocab = $_POST['kocab'];
		$nm_kacab = $_POST['nm_kacab'];
		$jb_kacab = $_POST['jb_kacab'];
		$nipp_kacab = $_POST['nipp_kacab'];
		$nm_kabag = $_POST['nm_kabag'];
		$jb_kabag = $_POST['jb_kabag'];
		$nipp_kabag = $_POST['nipp_kabag'];
		$nm_ast = $_POST['nm_ast'];
		$jb_ast = $_POST['jb_ast'];
		$nipp_ast = $_POST['nipp_ast'];
		$pejabat = $this->home_model->rPejabatByCabang($this->session->userdata('kocab'))->result();
		// print_r($pejabat);die;
		if ($pejabat == NULL) {
			$result = $this->home_model->iTblPejabat($kocab, $nm_kacab, $jb_kacab, $nipp_kacab, $nm_kabag, $jb_kabag, $nipp_kabag, $nm_ast, $jb_ast, $nipp_ast);
		} else {
			$result = $this->home_model->uTblPejabat($kocab, $nm_kacab, $jb_kacab, $nipp_kacab, $nm_kabag, $jb_kabag, $nipp_kabag, $nm_ast, $jb_ast, $nipp_ast);
		}
		echo $result;
	}

	public function menuPengguna()
	{
		$data['content'] = 'menu_pengguna.php';
		if ($this->session->userdata('grup_user') == 1) {
			$data['pengguna'] = $this->home_model->rAllPengguna()->result();
			$data['cabang'] = $this->home_model->rAllCabang()->result();
		} else {
			$data['pengguna'] = $this->home_model->rPenggunaByKocab($this->session->userdata('kocab'))->result();
			$data['cabang'] = $this->home_model->rDataKocabByKocab($this->session->userdata('kocab'))->result();
		}
		// print_r($data['pengguna']);die;
		$this->load->view('template', $data);
	}

	public function inputDataPengguna()
	{
		// print_r($_POST);die;
		$kocab = $_POST['kocab'];
		$nipp = $_POST['nippUsr'];
		$pass = $_POST['pass'];
		$gu = $_POST['grup_user'];
		$result = $this->home_model->iTblUser($kocab, $nipp, $pass, $gu);
		echo $result;
	}

	public function editBiayaBybId($id)
	{
		$idBiaya = $id;
		$data['rubrik'] = $this->home_model->rDataBiayaById($idBiaya)->result();
		// print_r($data['rubrik']);die;
		$data['cabang'] = $this->home_model->rDataKocabByKocab($data['rubrik'][0]->kocab)->result();
		// print_r($data['cabang']);die;
		$data['content'] = 'form_edit_rubrik.php';
		$this->load->view('template', $data);
	}

	public function updateBiayaById($id)
	{
		// print_r($id);die;
		$kocab = $_POST['kocab'];
		$rubrik = $_POST['rubrik'];
		$jenis = $_POST['jenis'];
		$item = $_POST['item'];
		$ppn = str_replace("%", "", $_POST['ppn']);
		$biaya = str_replace(",", "", str_replace(".00", "", str_replace("Rp", "", $_POST['biaya'])));
		// print_r($biaya);
		$result = $this->home_model->uTblBiaya($id, $kocab, $rubrik, $jenis, $item, $ppn, $biaya);
		echo $result;
	}

	public function hapusBiayaBybId($id)
	{
		$result = $this->home_model->dBiayaBybId($id);
		redirect(base_url() . 'home/menuBiaya', 'refresh');
	}

	public function getNipp()
	{
		$query = $this->input->post('query');
		if ($this->session->userdata('grup_user') == 1) {
			$qKocab = "";
		} else {
			$kocab = $this->session->userdata('kocab');
			$qKocab = "AND KOCAB='" . $kocab . "'";
		}
		$result = $this->home_model->getNipp($query, $qKocab);
		if ($result->num_rows() > 0) {
			echo json_encode($result->result());
		} else {
			echo '';
		}
	}

	public function editUserById($id)
	{
		$idUser = $id;
		$data['user'] = $this->home_model->rDataUserById($idUser)->result();
		// print_r($data['rubrik']);die;
		$data['cabang'] = $this->home_model->rDataKocabByKocab($data['user'][0]->kocab)->result();
		// print_r($data['cabang']);die;
		$data['content'] = 'form_edit_user.php';
		// print_r($data);die;
		$this->load->view('template', $data);
	}

	public function updatePenggunaById($id)
	{
		// print_r($id);die;
		$kocab = $_POST['kocab'];
		$pass = $_POST['pass'];
		$grup_user = $_POST['grup_user'];
		$result = $this->home_model->uTblPengguna($id, $kocab, $pass, $grup_user);
		echo $result;
	}

	public function hapusUserBybId($id)
	{
		$result = $this->home_model->dUserBybId($id);
		redirect(base_url() . 'home/menuPengguna', 'refresh');
	}

	public function formCetakRekBulan()
	{
		if ($this->session->userdata('grup_user') == '1') {
			$data['cabang'] = $this->home_model->rAllCabang()->result();
		} else {
			$data['cabang'] = $this->home_model->rDataKocabByKocab($this->session->userdata('kocab'))->result();
		}
		$data['content'] = 'form_cetak_tran_bulan.php';
		$this->load->view('template', $data);
	}

	public function getBpbraPeriod()
	{
		// print_r($_POST);die;
		$kocab = $_POST['kocab'];
		$bulan = $_POST['bulan'];
		$tahun = $_POST['tahun'];
		$data['period'] = $tahun . '-' . $bulan . '-01';
		$data['period'] = explode(' ', $this->tgl_indo(date("Y-m-d", strtotime($data['period']))));
		$data['period'] = $data['period'][1] . ' ' . $data['period'][2];
		$data['bpbra'] = $this->home_model->rBpbraMonthByKocab($kocab, $bulan, $tahun)->result();
		// print_r($data);die;
		$this->load->view('listBpbraPeriod', $data);
	}

	public function tgl_indo($tanggal)
	{
		$bulan = array(
			1 =>   'Januari',
			'Februari',
			'Maret',
			'April',
			'Mei',
			'Juni',
			'Juli',
			'Agustus',
			'September',
			'Oktober',
			'November',
			'Desember'
		);
		$pecahkan = explode('-', $tanggal);

		// variabel pecahkan 0 = tanggal
		// variabel pecahkan 1 = bulan
		// variabel pecahkan 2 = tahun

		return $pecahkan[2] . ' ' . $bulan[(int)$pecahkan[1]] . ' ' . $pecahkan[0];
	}


	public function tesCR1()
	{
		echo "tes";
		die;
		$nokwit = 'PST-2020.01-1';
		$kocab = '01';
		$allData = $this->home_model->rItemByNoKwit($nokwit, $kocab)->result();

		$my_report = "C:\\xampp\\htdocs\\bpbra\\report\\tes2.rpt"; // 
		$my_pdf = "C:\\xampp\\htdocs\\bpbra\\report\\tes2.pdf"; // RPT export to pdf file

		//-Create new COM object-depends on your Crystal Report version
		// 7   --> Crystal.CRPE.Application
		// 8.0 --> CrystalRuntime.Application  or CrystalRuntime.Application.8
		// 8.5 --> CrystalRuntime.Application 
		// 9 (RDC) --> CrystalRuntime.Application.9
		// 9 (RAS) -->	 CrystalReports.ObjectFactory.2
		// 10 (RDC) -->	 CrystalRuntime.Application.10
		// 10  (CEE) --> CrystalReports10.ObjectFactory.1
		// XI (RDC)	-->  CrystalRuntime.Application.11
		// XI (RAS)	-->  CrystalReports11.ObjectFactory.1
		// XI R2 (RDC) -->	CrystalRuntime.Application.115

		$ObjectFactory = new COM("CrystalRuntime.Application") or die("Error on load"); // call COM port
		$creport = $ObjectFactory->OpenReport($my_report, 1); // call rpt report



		//$creport->RecordSelectionFormula= "{QTertagihKelompokBank.jumlah}>0";
		// $creport->FormulaFields->Item(7)->Text = ("'DARI TANGGAL : '+ '$tgl1' + ' S/D '+ '$tgl2'");



		//$creport->RecordSelectionFormula="{tra_bill_rpt.npa}='$inpa '"; 

		//$creport->RecordSelectionFormula="{test.no}='ANY_VALUE'";
		//$creport->FormulaFields->Item(1)->Text = ("'My Report Title'");
		//$creport->ParameterFields(1)->AddCurrentValue ("FirstParameter");
		//$creport->ParameterFields(2)->AddCurrentValue (2000);


		// to refresh data before
		//- Set database logon info - must have
		// $creport->Database->Tables(1)->SetLogOnInfo("10.61.0.205\mssqlserver206", "LOKETPROD", "sa", "PDAMtn99!@");
		$creport->Database->Tables(1)->SetLogOnInfo("10.61.0.201", "bpbra", "sa", "PDAMtn99!@");

		//- field prompt or else report will hang - to get through
		$creport->EnableParameterPrompting = 0;

		//- DiscardSavedData - to refresh then read records
		$creport->DiscardSavedData;
		var_dump($creport);
		die;
		$creport->ReadRecords();


		//export to PDF process
		$creport->ExportOptions->DiskFileName = $my_pdf; //export to pdf
		$creport->ExportOptions->PDFExportAllPages = true;
		$creport->ExportOptions->DestinationType = 1; // export to file
		$creport->ExportOptions->FormatType = 31; // PDF type
		$creport->Export(false);

		/* Format Types:
		4 - RTF
		31 - PDF
		30 - xls
		36 - xls
		14 - doc
		*/

		//------ Release the variables ------
		$creport = null;
		$crapp = null;
		$ObjectFactory = null;

		$filename = "C:\\xampp\\htdocs\\bpbra\\report\\tes2.pdf";

		// Header content type 
		header("Content-type: application/pdf");

		header("Content-Length: " . filesize($filename));

		// Send the file to the browser. 
		readfile($filename);
	}
}
