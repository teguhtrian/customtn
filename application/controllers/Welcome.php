<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	function __construct(){
		parent::__construct();
		$this->load->model('sdm_model');
	}	

	public function index()
	{
		// $this->load->view('welcome_message');
		// $query=$this->sdm_model->getSppd100();
		// print_r($query->result());
		$data['content']='index.php';
		$data['data']=$this->sdm_model->getSppd100();
		$this->load->view('template',$data);
	}

	public function menuBatValid(){
		$data['content']='formEditSPPD.php';
		$this->load->view('template',$data);
	}

	public function getEditSPPDData(){
		$query=$this->input->post('query');
		$result=$this->sdm_model->getEditSPPDData($query);
		if ($result->num_rows()>0) {
			echo json_encode($result->result());
		} else {
			echo '';
		}
	}

	public function bukaEditSPPD(){
		session_start();
		// print_r($_POST);
		// print_r($_SESSION);
		if ($_POST['my_token'] === $_SESSION['my_token']){
        	// was ok
			// echo "SAMA";
			$kodeSPPD=$_POST['code'];
			$result=$this->sdm_model->editBukaSPPD($kodeSPPD);
			session_destroy();
			$this->berhasilBukaEditSPPD();
		}else{
			// was bad!!!
			// echo "BEDA";
			$data['content']='errorSession.php';
			$this->load->view('template',$data);
		}
	}

	public function berhasilBukaEditSPPD(){
		$data['content']='berhasilProses.php';
		$this->load->view('template',$data);
	}

	public function menuCtkUsulanSPPD(){
		$data['content']='formCtkSPPD.php';
		$this->load->view('template',$data);	
	}

	public function menuCtkRincianBiayaSPPD(){
		$data['content']='formCtkRincianBiayaSPPD.php';
		$this->load->view('template',$data);	
	}

	public function cetakSPPD(){
		session_start();
		if ($_POST['my_token'] === $_SESSION['my_token']){
        	// was ok
			// echo "SAMA";
			$kodeSPPD=$_POST['code'];
			$tipeCtk=$_POST['tipe'];
			print_r($_POST);die;

			if ($tipeCtk==1) {
				$this->cetakUsulanDanaSPPD($kodeSPPD);
			}else{
				$this->cetakUsulanPenginapanSPPD($kodeSPPD);
			}
			session_destroy();
			$this->menuCtkUsulanSPPD();
		}else{
			// was bad!!!
			// echo "BEDA";
			$data['content']='errorSession.php';
			$this->load->view('template',$data);
		}
	}

	public function penyebut($nilai){
		$nilai = abs($nilai);
		$huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
		$temp = "";
		if ($nilai < 12) {
			$temp = " ". $huruf[$nilai];
		} else if ($nilai <20) {
			$temp = $this->penyebut($nilai - 10). " belas";
		} else if ($nilai < 100) {
			$temp = $this->penyebut($nilai/10)." puluh". $this->penyebut($nilai % 10);
		} else if ($nilai < 200) {
			$temp = " seratus" . $this->penyebut($nilai - 100);
		} else if ($nilai < 1000) {
			$temp = $this->penyebut($nilai/100) . " ratus" . $this->penyebut($nilai % 100);
		} else if ($nilai < 2000) {
			$temp = " seribu" . $this->penyebut($nilai - 1000);
		} else if ($nilai < 1000000) {
			$temp = $this->penyebut($nilai/1000) . " ribu" . $this->penyebut($nilai % 1000);
		} else if ($nilai < 1000000000) {
			$temp = $this->penyebut($nilai/1000000) . " juta" . $this->penyebut($nilai % 1000000);
		} else if ($nilai < 1000000000000) {
			$temp = $this->penyebut($nilai/1000000000) . " milyar" . $this->penyebut(fmod($nilai,1000000000));
		} else if ($nilai < 1000000000000000) {
			$temp = $this->penyebut($nilai/1000000000000) . " trilyun" . $this->penyebut(fmod($nilai,1000000000000));
		}     
		return $temp;
	}

	public 	function terbilang($nilai) {
		if($nilai<0) {
			$hasil = "minus ". trim($this->penyebut($nilai));
		} else {
			$hasil = trim($this->penyebut($nilai));
		}     		
		return $hasil;
	}

	public function cetakUsulanDanaSPPD(){
		// session_start();
		// print_r($_POST['code']);die;
		$atasNama=$this->sdm_model->getAtasNamaByCode($_POST['code']);
		$SPPDInfo=$this->sdm_model->getSPPDByCode($_POST['code']);
		$SPPDCost=$this->sdm_model->getSPPDCostByCode($_POST['code']);
		$SPPDCostInn=$this->sdm_model->getSPPDCostInnByCode($_POST['code']);
		// print_r($SPPDCostInn->result());die;
		// print_r($_POST['kodeSPPD']);
		// die;
		// print_r($kodeSPPD);die;
		// print_r($atasNama->result());die;
		// print_r($SPPDInfo->Reason);die;
		$this->load->library('mpdf/mPdf');		
		$mpdf = new mPDF('c','A4-L', 0, '', 10, 10, 10, 10, 1, 1,'arial');	
		// $mpdf->setWatermarkImage('./images/logo.png', 1, '', array(10,2));
		$mpdf->showWatermarkImage = true;
		$html = '<div style="font-size:20px; font-weight:bold"></div>
		<div style="font-weight:bold;"></div>
		<div style="font-size:12pt; font-weight:bold; text-align:center">USULAN PEMBAYARAN</div><br/>';
		$html .= '<table width="100%" border="0" cellspacing="0">
		  <tr>
			<td width="4%" align="left" style="font-size:13pt;"></td>
			<td width="12%" align="left" style="font-size:13pt;"></td>
			<td width="45%" align="left" style="font-size:13pt;"></td>
			<td width="12%" align="left" style="font-size:13pt;"></td>
			<td width="12%" align="left" style="font-size:13pt;"></td>
			<td width="12%" align="left" style="font-size:13pt;"></td>
			<td width="14%" align="left" style="font-size:13pt;">FORMULIR A-1</td>
			<td width="5%" align="left" style="font-size:13pt;">:</td>
			<td width="14%" align="left" style="font-size:13pt;"></td>
		  </tr><tr>
			<td width="4%" align="left" style="font-size:13pt;"></td>
			<td width="12%" align="left" style="font-size:13pt;"></td>
			<td width="45%" align="left" style="font-size:13pt;"></td>
			<td width="12%" align="left" style="font-size:13pt;"></td>
			<td width="12%" align="left" style="font-size:13pt;"></td>
			<td width="12%" align="left" style="font-size:13pt;"></td>
			<td width="20%" align="left" style="font-size:13pt;">NO. BIDANG/CABANG</td>
			<td width="5%" align="left" style="font-size:13pt;">:</td>
			<td width="5%" align="left" style="font-size:13pt;">/P-SDM/2019</td>
		  </tr><tr>
			<td width="4%" align="left" style="font-size:13pt;"></td>
			<td width="12%" align="left" style="font-size:13pt;"></td>
			<td width="45%" align="left" style="font-size:13pt;"></td>
			<td width="12%" align="left" style="font-size:13pt;"></td>
			<td width="12%" align="left" style="font-size:13pt;"></td>
			<td width="12%" align="left" style="font-size:13pt;"></td>
			<td width="14%" align="left" style="font-size:13pt;">NO. ANGGARAN</td>
			<td width="5%" align="left" style="font-size:13pt;">:</td>
			<td width="14%" align="left" style="font-size:13pt;"></td>
		  </tr>
		</table><br/>';

		// AWAL TABEL
		$html .='<table width="100%" border="0" cellspacing="0" cellpadding="0">
		  <tr>
			<td height="32" width="11%" align="center" style="font-size:13pt;font-weight:bold;border-top:1pt solid black;border-left:1pt solid black;border-bottom:1pt solid black;border-right:1pt solid black;">NO.</td>
			<td width="14%" align="center" style="font-size:13pt;font-weight:bold;border-top:1pt solid black;border-left:1pt solid black;border-bottom:1pt solid black;border-right:1pt solid black;">KODE PERKIRAAN</td>
			<td width="45%" align="center" style="font-size:13pt;font-weight:bold;border-top:1pt solid black;border-left:1pt solid black;border-bottom:1pt solid black;border-right:1pt solid black;">JENIS PEMBAYARAN</td>
			<td width="12%" align="center" style="font-size:13pt;font-weight:bold;border-top:1pt solid black;border-left:1pt solid black;border-bottom:1pt solid black;border-right:1pt solid black;">BANYAKNYA</td>
			<td width="14%" align="center" style="font-size:13pt;font-weight:bold;border-top:1pt solid black;border-left:1pt solid black;border-bottom:1pt solid black;border-right:1pt solid black;">HARGA SATUAN</td>
			<td width="14%" align="center" style="font-size:13pt;font-weight:bold;border-top:1pt solid black;border-left:1pt solid black;border-bottom:1pt solid black;border-right:1pt solid black;">HARGA KESELURUHAN</td>
			<td width="17%" align="center" style="font-size:13pt;font-weight:bold;border-top:1pt solid black;border-left:1pt solid black;border-bottom:1pt solid black;border-right:1pt solid black;">DASAR PEMBAYARAN</td>
			<td width="10%" align="center" style="font-size:13pt;font-weight:bold;border-top:1pt solid black;border-left:1pt solid black;border-bottom:1pt solid black;border-right:1pt solid black;">LOKASI</td>
			<td width="14%" align="center" style="font-size:13pt;font-weight:bold;border-top:1pt solid black;border-left:1pt solid black;border-bottom:1pt solid black;border-right:1pt solid black;">KETERANGAN</td>
		  </tr>';
		$html .='<tr>
			<td height="32" align="center" style="font-size:13pt;font-weight:bold;border-top:1pt solid black;border-left:1pt solid black;border-bottom:1pt solid black;border-right:1pt solid black;">1</td>
			<td align="center" style="font-size:13pt;font-weight:bold;border-top:1pt solid black;border-left:1pt solid black;border-bottom:1pt solid black;border-right:1pt solid black;">2</td>
			<td align="center" style="font-size:13pt;font-weight:bold;border-top:1pt solid black;border-left:1pt solid black;border-bottom:1pt solid black;border-right:1pt solid black;">3</td>			
			<td align="center" style="font-size:13pt;font-weight:bold;border-top:1pt solid black;border-left:1pt solid black;border-bottom:1pt solid black;border-right:1pt solid black;">4</td>
			<td align="center" style="font-size:13pt;font-weight:bold;border-top:1pt solid black;border-left:1pt solid black;border-bottom:1pt solid black;border-right:1pt solid black;">5</td>
			<td align="center" style="font-size:13pt;font-weight:bold;border-top:1pt solid black;border-left:1pt solid black;border-bottom:1pt solid black;border-right:1pt solid black;">6</td>
			<td align="center" style="font-size:13pt;font-weight:bold;border-top:1pt solid black;border-left:1pt solid black;border-bottom:1pt solid black;border-right:1pt solid black;">7</td>
			<td align="center" style="font-size:13pt;font-weight:bold;border-top:1pt solid black;border-left:1pt solid black;border-bottom:1pt solid black;border-right:1pt solid black;">8</td>
			<td align="center" style="font-size:13pt;font-weight:bold;border-top:1pt solid black;border-left:1pt solid black;border-bottom:1pt solid black;border-right:1pt solid black;">9</td>		
		</tr>';
		// Atas Nama
		$html .='<tr>
			<td align="left" style="font-size:13pt;border-top:none;border-left:1pt solid black;border-bottom:none;border-right:1pt solid black;"></td>
			<td align="left" style="font-size:13pt;border-top:none;border-left:1pt solid black;border-bottom:none;border-right:1pt solid black;"></td>
			<td align="left" valign="top" style="font-size:12pt;padding:2pt;border-top:none;border-left:1pt solid black;border-bottom:none;border-right:1pt solid black;">';
		foreach ($SPPDInfo->result() as $b) {
				$html .= str_replace('RINCIAN ', '', ucwords(strtolower($b->SPPDGroupName)));
			};
		$html .= ' atas nama: <ul style="list-style-type:circle;">';
			foreach ($atasNama->result() as $a) {
				$html .= '<li><b>'.$a->FullName.' / '.$a->OccupationName.'</b></li>';
			};
		$html .= '</ul>';
		$html .='</td>
			<td align="center" style="font-size:13pt;border-top:none;border-left:1pt solid black;border-bottom:none;border-right:1pt solid black;"></td>
			<td align="left" style="font-size:13pt;border-top:none;border-left:1pt solid black;border-bottom:none;border-right:1pt solid black;"></td>
			<td align="left" style="font-size:13pt;border-top:none;border-left:1pt solid black;border-bottom:none;border-right:1pt solid black;"></td>
			<td align="left" valign="top" style="font-size:12pt;padding:2pt;border-top:none;border-left:1pt solid black;border-bottom:none;border-right:1pt solid black;">';
		foreach ($SPPDInfo->result() as $b) {
				$html .= $b->Reason;
			};
		$html .= '</td>
			<td align="center" valign="top" style="font-size:12pt;padding:2pt;border-top:none;border-left:1pt solid black;border-bottom:none;border-right:1pt solid black;">';
		foreach ($SPPDInfo->result() as $c) {
				$html .= $c->Location;
			};
		$html .= '</td>
			<td align="left" style="font-size:13pt;border-top:none;border-left:1pt solid black;border-bottom:none;border-right:1pt solid black;"></td>			
		</tr>';
		// Deskripsi
		$html .='<tr>
			<td align="left" style="border-top:none;border-left:1pt solid black;border-bottom:none;border-right:1pt solid black;font-size:13pt;"></td>
			<td align="left" style="border-top:none;border-left:1pt solid black;border-bottom:none;border-right:1pt solid black;font-size:13pt;"></td>
			<td align="left" style="border-top:none;border-left:1pt solid black;padding:2pt;border-bottom:none;border-right:1pt solid black;font-size:12pt;">';
		foreach ($SPPDInfo->result() as $b) {
				$html .= $b->Description;
			};	
		$html .= '</td>
			<td align="left" style="border-top:none;border-left:1pt solid black;border-bottom:none;border-right:1pt solid black;font-size:13pt;"></td>
			<td align="left" style="border-top:none;border-left:1pt solid black;border-bottom:none;border-right:1pt solid black;font-size:13pt;"></td>
			<td align="left" style="border-top:none;border-left:1pt solid black;border-bottom:none;border-right:1pt solid black;font-size:13pt;"></td>
			<td align="left" style="border-top:none;border-left:1pt solid black;border-bottom:none;border-right:1pt solid black;font-size:13pt;"></td>
			<td align="left" style="border-top:none;border-left:1pt solid black;border-bottom:none;border-right:1pt solid black;font-size:13pt;"></td>
			<td align="left" style="border-top:none;border-left:1pt solid black;border-bottom:none;border-right:1pt solid black;font-size:13pt;"></td>			
		</tr>';
		// Rincian Biaya
		$html .='<tr>
			<td align="left" style="border-top:none;border-left:1pt solid black;border-bottom:none;border-right:1pt solid black;font-size:13pt;"></td>
			<td align="left" style="border-top:none;border-left:1pt solid black;border-bottom:none;border-right:1pt solid black;font-size:13pt;"></td>
			<td align="left" style="border-top:none;border-left:1pt solid black;border-bottom:none;border-right:1pt solid black;font-size:12pt;"></td>
			<td align="left" style="border-top:none;border-left:1pt solid black;border-bottom:none;border-right:1pt solid black;font-size:13pt;"></td>
			<td align="left" style="border-top:none;border-left:1pt solid black;border-bottom:none;border-right:1pt solid black;font-size:13pt;"></td>
			<td align="left" style="border-top:none;border-left:1pt solid black;border-bottom:none;border-right:1pt solid black;font-size:13pt;"></td>
			<td align="left" style="border-top:none;border-left:1pt solid black;border-bottom:none;border-right:1pt solid black;font-size:13pt;"></td>
			<td align="left" style="border-top:none;border-left:1pt solid black;border-bottom:none;border-right:1pt solid black;font-size:13pt;"></td>
			<td align="left" style="border-top:none;border-left:1pt solid black;border-bottom:none;border-right:1pt solid black;font-size:13pt;"></td>			
		</tr>';
		// Rincian Biaya
		$html .='<tr>
			<td align="left" style="border-top:none;border-left:1pt solid black;border-bottom:none;border-right:1pt solid black;font-size:13pt;"></td>
			<td align="left" style="border-top:none;border-left:1pt solid black;border-bottom:none;border-right:1pt solid black;font-size:13pt;"></td>
			<td align="left" style="border-top:none;border-left:1pt solid black;border-bottom:none;padding:2pt;margin-bottom:0pt;border-right:1pt solid black;font-size:12pt;"><b>Rincian Biaya :</b></td>
			<td align="left" style="border-top:none;border-left:1pt solid black;border-bottom:none;border-right:1pt solid black;font-size:13pt;"></td>
			<td align="left" style="border-top:none;border-left:1pt solid black;border-bottom:none;border-right:1pt solid black;font-size:13pt;"></td>
			<td align="left" style="border-top:none;border-left:1pt solid black;border-bottom:none;border-right:1pt solid black;font-size:13pt;"></td>
			<td align="left" style="border-top:none;border-left:1pt solid black;border-bottom:none;border-right:1pt solid black;font-size:13pt;"></td>
			<td align="left" style="border-top:none;border-left:1pt solid black;border-bottom:none;border-right:1pt solid black;font-size:13pt;"></td>
			<td align="left" style="border-top:none;border-left:1pt solid black;border-bottom:none;border-right:1pt solid black;font-size:13pt;"></td>			
		</tr>';
		// Item Rincian Biaya
			$countInn=0;
			foreach ($SPPDCostInn->result() as $b) {
				$countInn=$b->bPenginapan+$countInn;
			};
		$html .='<tr>
			<td align="left" style="border-top:none;border-left:1pt solid black;border-bottom:none;border-right:1pt solid black;font-size:13pt;"></td>
			<td align="left" style="border-top:none;border-left:1pt solid black;border-bottom:none;border-right:1pt solid black;font-size:13pt;"></td>
			<td align="left" style="border-top:none;padding:2pt;margin-bottom:0pt;border-left:1pt solid black;border-bottom:none;border-right:1pt solid black;font-size:12pt;">';
			if ($countInn!=0) {
				$html .='- Biaya Penginapan';
			}
		$html .='</td>
			<td align="left" style="border-top:none;border-left:1pt solid black;border-bottom:none;border-right:1pt solid black;font-size:13pt;"></td>
			<td align="center" style="border-top:none;padding:2pt;margin-bottom:0pt;border-left:1pt solid black;border-bottom:none;border-right:1pt solid black;font-size:12pt;">';
			if ($countInn!=0) {
				$html .= 'Rp. '.number_format($countInn);
			}
		$html .= '</td>
			<td align="left" style="border-top:none;border-left:1pt solid black;border-bottom:none;border-right:1pt solid black;font-size:13pt;"></td>
			<td align="left" style="border-top:none;border-left:1pt solid black;border-bottom:none;border-right:1pt solid black;font-size:13pt;"></td>
			<td align="left" style="border-top:none;border-left:1pt solid black;border-bottom:none;border-right:1pt solid black;font-size:13pt;"></td>
			<td align="left" style="border-top:none;border-left:1pt solid black;border-bottom:none;border-right:1pt solid black;font-size:13pt;"></td>			
		</tr>';
			$countPlane=0;
			foreach ($SPPDCostInn->result() as $b) {
				$countPlane=$b->bPesawat+$countPlane;
			};
		$html .='<tr>
			<td align="left" style="border-top:none;border-left:1pt solid black;border-bottom:none;border-right:1pt solid black;font-size:13pt;"></td>
			<td align="left" style="border-top:none;border-left:1pt solid black;border-bottom:none;border-right:1pt solid black;font-size:13pt;"></td>
			<td align="left" style="border-top:none;padding:2pt;border-left:1pt solid black;border-bottom:none;border-right:1pt solid black;font-size:12pt;">';
			if ($countPlane!=0) {
				$html .='- Biaya Tiket Pesawat';
			}
		$html .='</td>
			<td align="left" style="border-top:none;border-left:1pt solid black;border-bottom:none;border-right:1pt solid black;font-size:13pt;"></td>
			<td align="center" style="border-top:none;padding:2pt;border-left:1pt solid black;border-bottom:none;border-right:1pt solid black;font-size:12pt;">';
			if ($countPlane!=0) {
				$html .= 'Rp. '.number_format($countPlane);
			}
		$html .= '</td>
			<td align="left" style="border-top:none;border-left:1pt solid black;border-bottom:none;border-right:1pt solid black;font-size:13pt;"></td>
			<td align="left" style="border-top:none;border-left:1pt solid black;border-bottom:none;border-right:1pt solid black;font-size:13pt;"></td>
			<td align="left" style="border-top:none;border-left:1pt solid black;border-bottom:none;border-right:1pt solid black;font-size:13pt;"></td>
			<td align="left" style="border-top:none;border-left:1pt solid black;border-bottom:none;border-right:1pt solid black;font-size:13pt;"></td>			
		</tr>';
		// Total
		$html .='<tr>
			<td align="left" style="border-top:none;border-left:1pt solid black;border-bottom:none;border-right:1pt solid black;font-size:13pt;"></td>
			<td align="left" style="border-top:none;border-left:1pt solid black;border-bottom:none;border-right:1pt solid black;font-size:13pt;"></td>
			<td align="left" style="border-top:none;padding:2pt;border-left:1pt solid black;border-bottom:none;border-right:1pt solid black;font-size:12pt;"><b>Total</b></td>
			<td align="left" style="border-top:none;border-left:1pt solid black;border-bottom:none;border-right:1pt solid black;font-size:13pt;"></td>
			<td align="left" style="border-top:none;border-left:1pt solid black;border-bottom:none;border-right:1pt solid black;font-size:13pt;"></td>
			<td align="center" style="border-top:none;padding:2pt;border-left:1pt solid black;border-bottom:none;border-right:1pt solid black;font-size:12pt;">';
			$countAll=$countPlane+$countInn;
			$html .= '<b>Rp. '.number_format($countAll).'</b>';
		$html .='</td>
			<td align="left" style="border-top:none;border-left:1pt solid black;border-bottom:none;border-right:1pt solid black;font-size:13pt;"></td>
			<td align="left" style="border-top:none;border-left:1pt solid black;border-bottom:none;border-right:1pt solid black;font-size:13pt;"></td>
			<td align="left" style="border-top:none;border-left:1pt solid black;border-bottom:none;border-right:1pt solid black;font-size:13pt;"></td>			
		</tr>';
		// Terbilang
		$html .='<tr>
			<td align="left" style="border-top:none;border-left:1pt solid black;border-bottom:none;border-right:1pt solid black;font-size:13pt;"></td>
			<td align="left" style="border-top:none;border-left:1pt solid black;border-bottom:none;border-right:1pt solid black;font-size:13pt;"></td>
			<td align="left" colspan="4" style="border-top:1px solid black;padding:2pt;border-left:solid black 1.0pt;border-bottom:none;font-size:13pt;font-style:italic">';
			$html .= 'Terbilang : '.$this->terbilang($countAll).' rupiah';
		$html .= '</td>
			<td align="left" style="border-top:none;border-left:1pt solid black;border-bottom:none;border-right:1pt solid black;font-size:13pt;"></td>
			<td align="left" style="border-top:none;border-left:1pt solid black;border-bottom:none;border-right:1pt solid black;font-size:13pt;"></td>
			<td align="left" style="border-top:none;border-left:1pt solid black;border-bottom:none;border-right:1pt solid black;font-size:13pt;"></td>		
		</tr>';
		$html .='<tr>
			<td align="center" colspan="2" style="border-top:1.0pt solid black;border-left:1pt solid black; border-right:1pt solid black;border-bottom:none;font-size:13pt;font-weight:bold;">YANG MEMINTA</td>
			<td align="center" colspan="4" style="border-top:1.0pt solid black;border-left:1pt solid black; border-right:1pt solid black;border-bottom:none;font-size:13pt;font-weight:bold;">R    E    K    O    M    E    N    D    A    S    I</td>
			<td align="center" rowspan="2" colspan="3" style="border-top:1.0pt solid black;border-left:1pt solid black;border-right:1pt solid black;border-bottom:none;font-size:13pt;font-weight:bold;">KEPUTUSAN KEPALA DIVISI</td>
		</tr>
		<tr>
			<td align="center" colspan="2" style="border-top:1.0pt solid black;border-left:1pt solid black; border-right:1pt solid black;border-bottom:none;font-size:12pt;font-weight:bold;">DIVISI SUMBER DAYA MANUSIA</td>
			<td align="center" colspan="4" style="border-top:1.0pt solid black;border-left:1pt solid black; border-right:1pt solid black;border-bottom:none;font-size:13pt;font-weight:bold;">DIVISI KEUANGAN</td>
		</tr>
		<tr>
			<td align="center" style="border-top:1.0pt solid black;border-left:1pt solid black; border-right:1pt solid black;border-bottom:none;font-size:13pt;font-weight:bold;">TANGGAL</td>
			<td align="center" style="border-top:1.0pt solid black;border-left:1pt solid black;border-right:1pt solid black;border-bottom:none;font-size:13pt;">'.date('d-m-Y').'</td>
			<td align="left" style="border-top:1.0pt solid black;border-left:1.0pt solid black; border-right:1pt solid black;border-bottom:none;font-size:13pt;font-weight:bold;">TGL. DITERIMA</td>
			<td align="center" style="border-top:1.0pt solid black;border-left:1.0pt solid black; border-right:1pt solid black;border-bottom:none;font-size:13pt;"></td>
			<td align="left" style="border-top:1.0pt solid black;border-left:1.0pt solid black; border-right:1pt solid black;border-bottom:none;font-size:13pt;font-weight:bold;">TERMIN I</td>
			<td align="center" style="border-top:1.0pt solid black;border-left:1.0pt solid black; border-right:1pt solid black;border-bottom:none;font-size:13pt;"></td>
			<td align="center" colspan="3" style="border-top:1.0pt solid black;border-left:1.0pt solid black; border-right:1pt solid black;border-bottom:none;font-size:13pt;"></td>
		</tr>
		<tr>
			<td align="center" colspan="2" style="border-top:1.0pt solid black;border-left:1.0pt solid black; border-right:1pt solid black;border-bottom:none;font-size:13pt;"></td>
			<td align="left" style="border-top:1.0pt solid black;border-left:1.0pt solid black; border-right:1pt solid black;border-bottom:none;font-size:13pt;font-weight:bold;">TGL. DIKIRIM</td>
			<td align="center" style="border-top:1.0pt solid black;border-left:1.0pt solid black; border-right:1pt solid black;border-bottom:none;font-size:13pt;"></td>
			<td align="left" style="border-top:1.0pt solid black;border-left:1.0pt solid black; border-right:1pt solid black;border-bottom:none;font-size:13pt;font-weight:bold;">TERMIN II</td>
			<td align="center" style="border-top:1.0pt solid black;border-left:1.0pt solid black; border-right:1pt solid black;border-bottom:none;font-size:13pt;"></td>
			<td align="center" colspan="3" style="border-top:none;border-left:1.0pt solid black; border-right:1pt solid black;border-bottom:none;font-size:13pt;"></td>
		</tr>
		<tr>
			<td align="center" colspan="2" style="border-top:none;border-left:1.0pt solid black; border-right:1pt solid black;border-bottom:none;font-size:13pt;"></td>
			<td align="left" rowspan="2" style="border-top:1.0pt solid black;border-left:1.0pt solid black; border-right:1pt solid black;border-bottom:none;font-size:13pt;font-weight:bold;">PLAPON</td>
			<td align="left" rowspan="2" style="border-top:1.0pt solid black;border-left:1.0pt solid black; border-right:1pt solid black;border-bottom:none;font-size:13pt;font-weight:bold;">Rp.</td>
			<td align="left" style="border-top:1.0pt solid black;border-left:1.0pt solid black; border-right:1pt solid black;border-bottom:none;font-size:13pt;font-weight:bold;">TERMIN III</td>
			<td align="center" style="border-top:1.0pt solid black;border-left:1.0pt solid black; border-right:1pt solid black;border-bottom:none;font-size:13pt;"></td>
			<td align="center" colspan="3" style="border-top:none;border-left:1.0pt solid black; border-right:1pt solid black;border-bottom:none;font-size:13pt;"></td>
		</tr>
		<tr>
			<td align="center" colspan="2" style="border-top:none;border-left:1.0pt solid black; border-right:1pt solid black;border-bottom:none;font-size:13pt;"></td>
			<td align="left" style="border-top:1.0pt solid black;border-left:1.0pt solid black; border-right:1pt solid black;border-bottom:none;font-size:13pt;font-weight:bold;">TERMIN IV</td>
			<td align="center" style="border-top:1.0pt solid black;border-left:1.0pt solid black; border-right:1pt solid black;border-bottom:none;font-size:13pt;"></td>
			<td align="center" colspan="3" style="border-top:none;border-left:1.0pt solid black; border-right:1pt solid black;border-bottom:none;font-size:13pt;"></td>
		</tr>
		<tr>
			<td align="center" colspan="2" style="border-top:none;border-left:1.0pt solid black; border-right:1pt solid black;border-bottom:none;font-size:13pt;"></td>
			<td align="left" style="border-top:1.0pt solid black;border-left:1.0pt solid black; border-right:1pt solid black;border-bottom:none;font-size:13pt;font-weight:bold;">NAMA PERKIRAAN</td>
			<td align="center" style="border-top:1.0pt solid black;border-left:1.0pt solid black; border-right:1pt solid black;border-bottom:none;font-size:13pt;"></td>
			<td align="left" style="border-top:1.0pt solid black;border-left:1.0pt solid black; border-right:1pt solid black;border-bottom:none;font-size:13pt;font-weight:bold;">TERMIN V</td>
			<td align="center" style="border-top:1.0pt solid black;border-left:1.0pt solid black; border-right:1pt solid black;border-bottom:none;font-size:13pt;"></td>
			<td align="center" colspan="3" style="border-top:none;border-left:1.0pt solid black; border-right:1pt solid black;border-bottom:none;font-size:13pt;"></td>
		</tr>
		<tr>
			<td align="center" colspan="2" style="border-top:none;border-left:1.0pt solid black; border-right:1pt solid black;border-bottom:none;font-size:13pt;"></td>
			<td align="left" style="border-top:1.0pt solid black;border-left:1.0pt solid black; border-right:1pt solid black;border-bottom:none;font-size:13pt;font-weight:bold;">NOMOR PERKIRAAN</td>
			<td align="center" style="border-top:1.0pt solid black;border-left:1.0pt solid black; border-right:1pt solid black;border-bottom:none;font-size:13pt;"></td>
			<td align="left" rowspan="2" style="border-top:1.0pt solid black;border-left:1.0pt solid black; border-right:1pt solid black;border-bottom:none;font-size:13pt;font-weight:bold;">LUNAS</td>
			<td align="center" style="border-top:1.0pt solid black;border-left:1.0pt solid black; border-right:1pt solid black;border-bottom:none;font-size:13pt;"></td>
			<td align="center" colspan="3" style="border-top:none;border-left:1.0pt solid black; border-right:1pt solid black;border-bottom:none;font-size:13pt;"></td>
		</tr>
		<tr>
			<td align="center" colspan="2" style="border-top:none;border-left:1.0pt solid black; border-right:1pt solid black;border-bottom:none;font-size:13pt;"></td>
			<td align="left" style="border-top:1.0pt solid black;border-left:1.0pt solid black; border-right:1pt solid black;border-bottom:none;font-size:13pt;font-weight:bold;">PARAF</td>
			<td align="center" style="border-top:1.0pt solid black;border-left:1.0pt solid black; border-right:1pt solid black;border-bottom:none;font-size:13pt;"></td>
			<td align="center" style="border-top:1.0pt solid black;border-left:1.0pt solid black; border-right:1pt solid black;border-bottom:none;font-size:13pt;"></td>
			<td align="center" colspan="3" style="border-top:none;border-left:1.0pt solid black; border-right:1pt solid black;border-bottom:none;font-size:13pt;"></td>
		</tr>
		<tr>
			<td align="center" colspan="2" style="border-top:none;border-left:1.0pt solid black; border-right:1pt solid black;border-bottom:none;font-size:13pt;"></td>
			<td align="center" colspan="2" style="border-top:1.0pt solid black;border-left:1.0pt solid black; border-right:1pt solid black;border-bottom:none;font-size:13pt;font-weight:bold;">DTO</td>
			<td align="center" colspan="2" style="border-top:1.0pt solid black;border-left:1.0pt solid black; border-right:1pt solid black;border-bottom:none;font-size:13pt;font-weight:bold;">DTO</td>
			<td align="center" colspan="3" style="border-top:none;border-left:1.0pt solid black; border-right:1pt solid black;border-bottom:none;font-size:13pt;"></td>
		</tr>
		<tr>
			<td height="30" align="center" colspan="2" style="border-top:none;border-left:1.0pt solid black; border-right:1pt solid black;border-bottom:none;font-size:13pt;"></td>
			<td align="center" colspan="2" style="border-top:none;border-left:1.0pt solid black; border-right:1pt solid black;border-bottom:none;font-size:13pt;"></td>
			<td align="center" colspan="2" style="border-top:none;border-left:1.0pt solid black; border-right:1pt solid black;border-bottom:none;font-size:13pt;"></td>
			<td align="center" colspan="3" style="border-top:none;border-left:1.0pt solid black; border-right:1pt solid black;border-bottom:none;font-size:13pt;"></td>
		</tr>
		<tr>
			<td align="center" colspan="2" style="border-top:none;border-left:1.0pt solid black; border-right:1pt solid black;border-bottom:none;font-size:12pt;">HAFNI GANA SIREGAR, SE</td>
			<td align="center" colspan="2" style="border-top:none;border-left:1.0pt solid black; border-right:1pt solid black;border-bottom:none;font-size:13pt;"></td>
			<td align="center" colspan="2" style="border-top:none;border-left:1.0pt solid black; border-right:1pt solid black;border-bottom:none;font-size:13pt;"></td>
			<td align="center" colspan="3" style="border-top:none;border-left:1.0pt solid black; border-right:1pt solid black;border-bottom:none;font-size:13pt;"></td>
		</tr>
		<tr>
			<td align="center" colspan="2" style="border-top:none;border-left:1.0pt solid black; border-right:1pt solid black;border-bottom:1pt solid black;font-size:12pt;font-weight:bold;">KABID PENGEMBANGAN SDM</td>
			<td align="center" colspan="2" style="border-top:none;border-left:1.0pt solid black; border-right:1pt solid black;border-bottom:1pt solid black;font-size:13pt;font-weight:bold;">KABID ANGGARAN</td>
			<td align="center" colspan="2" style="border-top:none;border-left:1.0pt solid black; border-right:1pt solid black;border-bottom:1pt solid black;font-size:13pt;font-weight:bold;">KABID PENDANAAN</td>
			<td align="center" colspan="3" style="border-top:none;border-left:1pt solid black;border-bottom:1pt solid black;border-right:1pt solid black;font-size:13pt;"></td>
		</tr>
		<tr>
			<td align="left" colspan="2" style="border-top:none;border-left:solid black 1.0pt;border-bottom:none;font-size:8pt;font-weight:bold">Keterangan:<br/>A. Kolom 1, 3, 4, 5, 6, 7 & 8 diisi oleh Divisi/Cabang.<br/>B. Kolom 2 diisi oleh Divisi Keuangan.<br/>C. Kolom 9 kalau perlu diisi yang memberi rekomendasi.</td>
			<td align="center" colspan="2" style="border-top:none;border-left:solid black 1.0pt;border-bottom:none;font-size:13pt;font-weight:bold;"></td>
			<td align="center" colspan="2" style="border-top:none;border-left:solid black 1.0pt;border-bottom:none;font-size:13pt;font-weight:bold;"></td>
			<td align="left" style="border-top:none;border-left:solid black 1.0pt;border-bottom:none;font-size:9pt;font-weight:bold">Putih<br/>Merah<br/>Biru</td>
			<td align="left" colspan="2" style="border-top:none;border-left:solid black 1.0pt;border-bottom:none;font-size:8pt;font-weight:bold">: Divisi Keuangan<br/>: Bidang Anggaran<br/>: Divisi / Cabang ybs</td>
		</tr>';
		$html .= '</table>';
		$mpdf->WriteHTML($html);
		$mpdf->Output();
		echo $html;
	}

	public function cetakUsulanPenginapanSPPD($kodeSPPD){

	}

	public function cetakRincianBiayaSPPD(){
$atasNama=$this->sdm_model->getAtasNamaByCode($_POST['code']);
		$SPPDInfo=$this->sdm_model->getSPPDByCode($_POST['code']);
		$SPPDCost=$this->sdm_model->getSPPDCostByCode($_POST['code']);
		$SPPDCostInn=$this->sdm_model->getSPPDCostInnByCode($_POST['code']);
		// print_r($SPPDCostInn->result());die;
		// print_r($_POST['kodeSPPD']);
		// die;
		// print_r($kodeSPPD);die;
		// print_r($atasNama->result());die;
		// print_r($SPPDInfo->Reason);die;
		$this->load->library('mpdf/mPdf');		
		$mpdf = new mPDF('c','A4', 0, '', 10, 10, 10, 10, 1, 1,'arial');	
		// $mpdf->setWatermarkImage('./images/logo.png', 1, '', array(10,2));
		$mpdf->showWatermarkImage = true;
		$html = '<div style="font-size:20px; font-weight:bold"></div>
		<div style="font-weight:bold;"></div>
		<div style="font-size:12pt; font-weight:bold; text-align:center">RINCIAN BIAYA PERJALANAN DINAS</div><br/>';
		$html .= '<table width="100%" border="0" cellspacing="0">
		  <tr>
			<td width="4%" align="left" style="font-size:13pt;"></td>
			<td width="12%" align="left" style="font-size:13pt;"></td>
			<td width="45%" align="left" style="font-size:13pt;"></td>
			<td width="12%" align="left" style="font-size:13pt;"></td>
			<td width="12%" align="left" style="font-size:13pt;"></td>
			<td width="12%" align="left" style="font-size:13pt;"></td>
			<td width="14%" align="left" style="font-size:13pt;">FORMULIR A-1</td>
			<td width="5%" align="left" style="font-size:13pt;">:</td>
			<td width="14%" align="left" style="font-size:13pt;"></td>
		  </tr><tr>
			<td width="4%" align="left" style="font-size:13pt;"></td>
			<td width="12%" align="left" style="font-size:13pt;"></td>
			<td width="45%" align="left" style="font-size:13pt;"></td>
			<td width="12%" align="left" style="font-size:13pt;"></td>
			<td width="12%" align="left" style="font-size:13pt;"></td>
			<td width="12%" align="left" style="font-size:13pt;"></td>
			<td width="20%" align="left" style="font-size:13pt;">NO. BIDANG/CABANG</td>
			<td width="5%" align="left" style="font-size:13pt;">:</td>
			<td width="5%" align="left" style="font-size:13pt;">/P-SDM/2019</td>
		  </tr><tr>
			<td width="4%" align="left" style="font-size:13pt;"></td>
			<td width="12%" align="left" style="font-size:13pt;"></td>
			<td width="45%" align="left" style="font-size:13pt;"></td>
			<td width="12%" align="left" style="font-size:13pt;"></td>
			<td width="12%" align="left" style="font-size:13pt;"></td>
			<td width="12%" align="left" style="font-size:13pt;"></td>
			<td width="14%" align="left" style="font-size:13pt;">NO. ANGGARAN</td>
			<td width="5%" align="left" style="font-size:13pt;">:</td>
			<td width="14%" align="left" style="font-size:13pt;"></td>
		  </tr>
		</table><br/>';

		// AWAL TABEL
		$html .='<table width="100%" border="0" cellspacing="0" cellpadding="0">
		  <tr>
			<td height="32" width="11%" align="center" style="font-size:13pt;font-weight:bold;border-top:1pt solid black;border-left:1pt solid black;border-bottom:1pt solid black;border-right:1pt solid black;">NO.</td>
			<td width="14%" align="center" style="font-size:13pt;font-weight:bold;border-top:1pt solid black;border-left:1pt solid black;border-bottom:1pt solid black;border-right:1pt solid black;">KODE PERKIRAAN</td>
			<td width="45%" align="center" style="font-size:13pt;font-weight:bold;border-top:1pt solid black;border-left:1pt solid black;border-bottom:1pt solid black;border-right:1pt solid black;">JENIS PEMBAYARAN</td>
			<td width="12%" align="center" style="font-size:13pt;font-weight:bold;border-top:1pt solid black;border-left:1pt solid black;border-bottom:1pt solid black;border-right:1pt solid black;">BANYAKNYA</td>
			<td width="14%" align="center" style="font-size:13pt;font-weight:bold;border-top:1pt solid black;border-left:1pt solid black;border-bottom:1pt solid black;border-right:1pt solid black;">HARGA SATUAN</td>
			<td width="14%" align="center" style="font-size:13pt;font-weight:bold;border-top:1pt solid black;border-left:1pt solid black;border-bottom:1pt solid black;border-right:1pt solid black;">HARGA KESELURUHAN</td>
			<td width="17%" align="center" style="font-size:13pt;font-weight:bold;border-top:1pt solid black;border-left:1pt solid black;border-bottom:1pt solid black;border-right:1pt solid black;">DASAR PEMBAYARAN</td>
			<td width="10%" align="center" style="font-size:13pt;font-weight:bold;border-top:1pt solid black;border-left:1pt solid black;border-bottom:1pt solid black;border-right:1pt solid black;">LOKASI</td>
			<td width="14%" align="center" style="font-size:13pt;font-weight:bold;border-top:1pt solid black;border-left:1pt solid black;border-bottom:1pt solid black;border-right:1pt solid black;">KETERANGAN</td>
		  </tr>';
		$html .='<tr>
			<td height="32" align="center" style="font-size:13pt;font-weight:bold;border-top:1pt solid black;border-left:1pt solid black;border-bottom:1pt solid black;border-right:1pt solid black;">1</td>
			<td align="center" style="font-size:13pt;font-weight:bold;border-top:1pt solid black;border-left:1pt solid black;border-bottom:1pt solid black;border-right:1pt solid black;">2</td>
			<td align="center" style="font-size:13pt;font-weight:bold;border-top:1pt solid black;border-left:1pt solid black;border-bottom:1pt solid black;border-right:1pt solid black;">3</td>			
			<td align="center" style="font-size:13pt;font-weight:bold;border-top:1pt solid black;border-left:1pt solid black;border-bottom:1pt solid black;border-right:1pt solid black;">4</td>
			<td align="center" style="font-size:13pt;font-weight:bold;border-top:1pt solid black;border-left:1pt solid black;border-bottom:1pt solid black;border-right:1pt solid black;">5</td>
			<td align="center" style="font-size:13pt;font-weight:bold;border-top:1pt solid black;border-left:1pt solid black;border-bottom:1pt solid black;border-right:1pt solid black;">6</td>
			<td align="center" style="font-size:13pt;font-weight:bold;border-top:1pt solid black;border-left:1pt solid black;border-bottom:1pt solid black;border-right:1pt solid black;">7</td>
			<td align="center" style="font-size:13pt;font-weight:bold;border-top:1pt solid black;border-left:1pt solid black;border-bottom:1pt solid black;border-right:1pt solid black;">8</td>
			<td align="center" style="font-size:13pt;font-weight:bold;border-top:1pt solid black;border-left:1pt solid black;border-bottom:1pt solid black;border-right:1pt solid black;">9</td>		
		</tr>';
		// Atas Nama
		$html .='<tr>
			<td align="left" style="font-size:13pt;border-top:none;border-left:1pt solid black;border-bottom:none;border-right:1pt solid black;"></td>
			<td align="left" style="font-size:13pt;border-top:none;border-left:1pt solid black;border-bottom:none;border-right:1pt solid black;"></td>
			<td align="left" valign="top" style="font-size:12pt;padding:2pt;border-top:none;border-left:1pt solid black;border-bottom:none;border-right:1pt solid black;">';
		foreach ($SPPDInfo->result() as $b) {
				$html .= str_replace('RINCIAN ', '', ucwords(strtolower($b->SPPDGroupName)));
			};
		$html .= ' atas nama: <ul style="list-style-type:circle;">';
			foreach ($atasNama->result() as $a) {
				$html .= '<li><b>'.$a->FullName.' / '.$a->OccupationName.'</b></li>';
			};
		$html .= '</ul>';
		$html .='</td>
			<td align="center" style="font-size:13pt;border-top:none;border-left:1pt solid black;border-bottom:none;border-right:1pt solid black;"></td>
			<td align="left" style="font-size:13pt;border-top:none;border-left:1pt solid black;border-bottom:none;border-right:1pt solid black;"></td>
			<td align="left" style="font-size:13pt;border-top:none;border-left:1pt solid black;border-bottom:none;border-right:1pt solid black;"></td>
			<td align="left" valign="top" style="font-size:12pt;padding:2pt;border-top:none;border-left:1pt solid black;border-bottom:none;border-right:1pt solid black;">';
		foreach ($SPPDInfo->result() as $b) {
				$html .= $b->Reason;
			};
		$html .= '</td>
			<td align="center" valign="top" style="font-size:12pt;padding:2pt;border-top:none;border-left:1pt solid black;border-bottom:none;border-right:1pt solid black;">';
		foreach ($SPPDInfo->result() as $c) {
				$html .= $c->Location;
			};
		$html .= '</td>
			<td align="left" style="font-size:13pt;border-top:none;border-left:1pt solid black;border-bottom:none;border-right:1pt solid black;"></td>			
		</tr>';
		// Deskripsi
		$html .='<tr>
			<td align="left" style="border-top:none;border-left:1pt solid black;border-bottom:none;border-right:1pt solid black;font-size:13pt;"></td>
			<td align="left" style="border-top:none;border-left:1pt solid black;border-bottom:none;border-right:1pt solid black;font-size:13pt;"></td>
			<td align="left" style="border-top:none;border-left:1pt solid black;padding:2pt;border-bottom:none;border-right:1pt solid black;font-size:12pt;">';
		foreach ($SPPDInfo->result() as $b) {
				$html .= $b->Description;
			};	
		$html .= '</td>
			<td align="left" style="border-top:none;border-left:1pt solid black;border-bottom:none;border-right:1pt solid black;font-size:13pt;"></td>
			<td align="left" style="border-top:none;border-left:1pt solid black;border-bottom:none;border-right:1pt solid black;font-size:13pt;"></td>
			<td align="left" style="border-top:none;border-left:1pt solid black;border-bottom:none;border-right:1pt solid black;font-size:13pt;"></td>
			<td align="left" style="border-top:none;border-left:1pt solid black;border-bottom:none;border-right:1pt solid black;font-size:13pt;"></td>
			<td align="left" style="border-top:none;border-left:1pt solid black;border-bottom:none;border-right:1pt solid black;font-size:13pt;"></td>
			<td align="left" style="border-top:none;border-left:1pt solid black;border-bottom:none;border-right:1pt solid black;font-size:13pt;"></td>			
		</tr>';
		// Rincian Biaya
		$html .='<tr>
			<td align="left" style="border-top:none;border-left:1pt solid black;border-bottom:none;border-right:1pt solid black;font-size:13pt;"></td>
			<td align="left" style="border-top:none;border-left:1pt solid black;border-bottom:none;border-right:1pt solid black;font-size:13pt;"></td>
			<td align="left" style="border-top:none;border-left:1pt solid black;border-bottom:none;border-right:1pt solid black;font-size:12pt;"></td>
			<td align="left" style="border-top:none;border-left:1pt solid black;border-bottom:none;border-right:1pt solid black;font-size:13pt;"></td>
			<td align="left" style="border-top:none;border-left:1pt solid black;border-bottom:none;border-right:1pt solid black;font-size:13pt;"></td>
			<td align="left" style="border-top:none;border-left:1pt solid black;border-bottom:none;border-right:1pt solid black;font-size:13pt;"></td>
			<td align="left" style="border-top:none;border-left:1pt solid black;border-bottom:none;border-right:1pt solid black;font-size:13pt;"></td>
			<td align="left" style="border-top:none;border-left:1pt solid black;border-bottom:none;border-right:1pt solid black;font-size:13pt;"></td>
			<td align="left" style="border-top:none;border-left:1pt solid black;border-bottom:none;border-right:1pt solid black;font-size:13pt;"></td>			
		</tr>';
		// Rincian Biaya
		$html .='<tr>
			<td align="left" style="border-top:none;border-left:1pt solid black;border-bottom:none;border-right:1pt solid black;font-size:13pt;"></td>
			<td align="left" style="border-top:none;border-left:1pt solid black;border-bottom:none;border-right:1pt solid black;font-size:13pt;"></td>
			<td align="left" style="border-top:none;border-left:1pt solid black;border-bottom:none;padding:2pt;margin-bottom:0pt;border-right:1pt solid black;font-size:12pt;"><b>Rincian Biaya :</b></td>
			<td align="left" style="border-top:none;border-left:1pt solid black;border-bottom:none;border-right:1pt solid black;font-size:13pt;"></td>
			<td align="left" style="border-top:none;border-left:1pt solid black;border-bottom:none;border-right:1pt solid black;font-size:13pt;"></td>
			<td align="left" style="border-top:none;border-left:1pt solid black;border-bottom:none;border-right:1pt solid black;font-size:13pt;"></td>
			<td align="left" style="border-top:none;border-left:1pt solid black;border-bottom:none;border-right:1pt solid black;font-size:13pt;"></td>
			<td align="left" style="border-top:none;border-left:1pt solid black;border-bottom:none;border-right:1pt solid black;font-size:13pt;"></td>
			<td align="left" style="border-top:none;border-left:1pt solid black;border-bottom:none;border-right:1pt solid black;font-size:13pt;"></td>			
		</tr>';
		// Item Rincian Biaya
			$countInn=0;
			foreach ($SPPDCostInn->result() as $b) {
				$countInn=$b->bPenginapan+$countInn;
			};
		$html .='<tr>
			<td align="left" style="border-top:none;border-left:1pt solid black;border-bottom:none;border-right:1pt solid black;font-size:13pt;"></td>
			<td align="left" style="border-top:none;border-left:1pt solid black;border-bottom:none;border-right:1pt solid black;font-size:13pt;"></td>
			<td align="left" style="border-top:none;padding:2pt;margin-bottom:0pt;border-left:1pt solid black;border-bottom:none;border-right:1pt solid black;font-size:12pt;">';
			if ($countInn!=0) {
				$html .='- Biaya Penginapan';
			}
		$html .='</td>
			<td align="left" style="border-top:none;border-left:1pt solid black;border-bottom:none;border-right:1pt solid black;font-size:13pt;"></td>
			<td align="center" style="border-top:none;padding:2pt;margin-bottom:0pt;border-left:1pt solid black;border-bottom:none;border-right:1pt solid black;font-size:12pt;">';
			if ($countInn!=0) {
				$html .= 'Rp. '.number_format($countInn);
			}
		$html .= '</td>
			<td align="left" style="border-top:none;border-left:1pt solid black;border-bottom:none;border-right:1pt solid black;font-size:13pt;"></td>
			<td align="left" style="border-top:none;border-left:1pt solid black;border-bottom:none;border-right:1pt solid black;font-size:13pt;"></td>
			<td align="left" style="border-top:none;border-left:1pt solid black;border-bottom:none;border-right:1pt solid black;font-size:13pt;"></td>
			<td align="left" style="border-top:none;border-left:1pt solid black;border-bottom:none;border-right:1pt solid black;font-size:13pt;"></td>			
		</tr>';
			$countPlane=0;
			foreach ($SPPDCostInn->result() as $b) {
				$countPlane=$b->bPesawat+$countPlane;
			};
		$html .='<tr>
			<td align="left" style="border-top:none;border-left:1pt solid black;border-bottom:none;border-right:1pt solid black;font-size:13pt;"></td>
			<td align="left" style="border-top:none;border-left:1pt solid black;border-bottom:none;border-right:1pt solid black;font-size:13pt;"></td>
			<td align="left" style="border-top:none;padding:2pt;border-left:1pt solid black;border-bottom:none;border-right:1pt solid black;font-size:12pt;">';
			if ($countPlane!=0) {
				$html .='- Biaya Tiket Pesawat';
			}
		$html .='</td>
			<td align="left" style="border-top:none;border-left:1pt solid black;border-bottom:none;border-right:1pt solid black;font-size:13pt;"></td>
			<td align="center" style="border-top:none;padding:2pt;border-left:1pt solid black;border-bottom:none;border-right:1pt solid black;font-size:12pt;">';
			if ($countPlane!=0) {
				$html .= 'Rp. '.number_format($countPlane);
			}
		$html .= '</td>
			<td align="left" style="border-top:none;border-left:1pt solid black;border-bottom:none;border-right:1pt solid black;font-size:13pt;"></td>
			<td align="left" style="border-top:none;border-left:1pt solid black;border-bottom:none;border-right:1pt solid black;font-size:13pt;"></td>
			<td align="left" style="border-top:none;border-left:1pt solid black;border-bottom:none;border-right:1pt solid black;font-size:13pt;"></td>
			<td align="left" style="border-top:none;border-left:1pt solid black;border-bottom:none;border-right:1pt solid black;font-size:13pt;"></td>			
		</tr>';
		// Total
		$html .='<tr>
			<td align="left" style="border-top:none;border-left:1pt solid black;border-bottom:none;border-right:1pt solid black;font-size:13pt;"></td>
			<td align="left" style="border-top:none;border-left:1pt solid black;border-bottom:none;border-right:1pt solid black;font-size:13pt;"></td>
			<td align="left" style="border-top:none;padding:2pt;border-left:1pt solid black;border-bottom:none;border-right:1pt solid black;font-size:12pt;"><b>Total</b></td>
			<td align="left" style="border-top:none;border-left:1pt solid black;border-bottom:none;border-right:1pt solid black;font-size:13pt;"></td>
			<td align="left" style="border-top:none;border-left:1pt solid black;border-bottom:none;border-right:1pt solid black;font-size:13pt;"></td>
			<td align="center" style="border-top:none;padding:2pt;border-left:1pt solid black;border-bottom:none;border-right:1pt solid black;font-size:12pt;">';
			$countAll=$countPlane+$countInn;
			$html .= '<b>Rp. '.number_format($countAll).'</b>';
		$html .='</td>
			<td align="left" style="border-top:none;border-left:1pt solid black;border-bottom:none;border-right:1pt solid black;font-size:13pt;"></td>
			<td align="left" style="border-top:none;border-left:1pt solid black;border-bottom:none;border-right:1pt solid black;font-size:13pt;"></td>
			<td align="left" style="border-top:none;border-left:1pt solid black;border-bottom:none;border-right:1pt solid black;font-size:13pt;"></td>			
		</tr>';
		// Terbilang
		$html .='<tr>
			<td align="left" style="border-top:none;border-left:1pt solid black;border-bottom:none;border-right:1pt solid black;font-size:13pt;"></td>
			<td align="left" style="border-top:none;border-left:1pt solid black;border-bottom:none;border-right:1pt solid black;font-size:13pt;"></td>
			<td align="left" colspan="4" style="border-top:1px solid black;padding:2pt;border-left:solid black 1.0pt;border-bottom:none;font-size:13pt;font-style:italic">';
			$html .= 'Terbilang : '.$this->terbilang($countAll).' rupiah';
		$html .= '</td>
			<td align="left" style="border-top:none;border-left:1pt solid black;border-bottom:none;border-right:1pt solid black;font-size:13pt;"></td>
			<td align="left" style="border-top:none;border-left:1pt solid black;border-bottom:none;border-right:1pt solid black;font-size:13pt;"></td>
			<td align="left" style="border-top:none;border-left:1pt solid black;border-bottom:none;border-right:1pt solid black;font-size:13pt;"></td>		
		</tr>';
		$html .='<tr>
			<td align="center" colspan="2" style="border-top:1.0pt solid black;border-left:1pt solid black; border-right:1pt solid black;border-bottom:none;font-size:13pt;font-weight:bold;">YANG MEMINTA</td>
			<td align="center" colspan="4" style="border-top:1.0pt solid black;border-left:1pt solid black; border-right:1pt solid black;border-bottom:none;font-size:13pt;font-weight:bold;">R    E    K    O    M    E    N    D    A    S    I</td>
			<td align="center" rowspan="2" colspan="3" style="border-top:1.0pt solid black;border-left:1pt solid black;border-right:1pt solid black;border-bottom:none;font-size:13pt;font-weight:bold;">KEPUTUSAN KEPALA DIVISI</td>
		</tr>
		<tr>
			<td align="center" colspan="2" style="border-top:1.0pt solid black;border-left:1pt solid black; border-right:1pt solid black;border-bottom:none;font-size:12pt;font-weight:bold;">DIVISI SUMBER DAYA MANUSIA</td>
			<td align="center" colspan="4" style="border-top:1.0pt solid black;border-left:1pt solid black; border-right:1pt solid black;border-bottom:none;font-size:13pt;font-weight:bold;">DIVISI KEUANGAN</td>
		</tr>
		<tr>
			<td align="center" style="border-top:1.0pt solid black;border-left:1pt solid black; border-right:1pt solid black;border-bottom:none;font-size:13pt;font-weight:bold;">TANGGAL</td>
			<td align="center" style="border-top:1.0pt solid black;border-left:1pt solid black;border-right:1pt solid black;border-bottom:none;font-size:13pt;">'.date('d-m-Y').'</td>
			<td align="left" style="border-top:1.0pt solid black;border-left:1.0pt solid black; border-right:1pt solid black;border-bottom:none;font-size:13pt;font-weight:bold;">TGL. DITERIMA</td>
			<td align="center" style="border-top:1.0pt solid black;border-left:1.0pt solid black; border-right:1pt solid black;border-bottom:none;font-size:13pt;"></td>
			<td align="left" style="border-top:1.0pt solid black;border-left:1.0pt solid black; border-right:1pt solid black;border-bottom:none;font-size:13pt;font-weight:bold;">TERMIN I</td>
			<td align="center" style="border-top:1.0pt solid black;border-left:1.0pt solid black; border-right:1pt solid black;border-bottom:none;font-size:13pt;"></td>
			<td align="center" colspan="3" style="border-top:1.0pt solid black;border-left:1.0pt solid black; border-right:1pt solid black;border-bottom:none;font-size:13pt;"></td>
		</tr>
		<tr>
			<td align="center" colspan="2" style="border-top:1.0pt solid black;border-left:1.0pt solid black; border-right:1pt solid black;border-bottom:none;font-size:13pt;"></td>
			<td align="left" style="border-top:1.0pt solid black;border-left:1.0pt solid black; border-right:1pt solid black;border-bottom:none;font-size:13pt;font-weight:bold;">TGL. DIKIRIM</td>
			<td align="center" style="border-top:1.0pt solid black;border-left:1.0pt solid black; border-right:1pt solid black;border-bottom:none;font-size:13pt;"></td>
			<td align="left" style="border-top:1.0pt solid black;border-left:1.0pt solid black; border-right:1pt solid black;border-bottom:none;font-size:13pt;font-weight:bold;">TERMIN II</td>
			<td align="center" style="border-top:1.0pt solid black;border-left:1.0pt solid black; border-right:1pt solid black;border-bottom:none;font-size:13pt;"></td>
			<td align="center" colspan="3" style="border-top:none;border-left:1.0pt solid black; border-right:1pt solid black;border-bottom:none;font-size:13pt;"></td>
		</tr>
		<tr>
			<td align="center" colspan="2" style="border-top:none;border-left:1.0pt solid black; border-right:1pt solid black;border-bottom:none;font-size:13pt;"></td>
			<td align="left" rowspan="2" style="border-top:1.0pt solid black;border-left:1.0pt solid black; border-right:1pt solid black;border-bottom:none;font-size:13pt;font-weight:bold;">PLAPON</td>
			<td align="left" rowspan="2" style="border-top:1.0pt solid black;border-left:1.0pt solid black; border-right:1pt solid black;border-bottom:none;font-size:13pt;font-weight:bold;">Rp.</td>
			<td align="left" style="border-top:1.0pt solid black;border-left:1.0pt solid black; border-right:1pt solid black;border-bottom:none;font-size:13pt;font-weight:bold;">TERMIN III</td>
			<td align="center" style="border-top:1.0pt solid black;border-left:1.0pt solid black; border-right:1pt solid black;border-bottom:none;font-size:13pt;"></td>
			<td align="center" colspan="3" style="border-top:none;border-left:1.0pt solid black; border-right:1pt solid black;border-bottom:none;font-size:13pt;"></td>
		</tr>
		<tr>
			<td align="center" colspan="2" style="border-top:none;border-left:1.0pt solid black; border-right:1pt solid black;border-bottom:none;font-size:13pt;"></td>
			<td align="left" style="border-top:1.0pt solid black;border-left:1.0pt solid black; border-right:1pt solid black;border-bottom:none;font-size:13pt;font-weight:bold;">TERMIN IV</td>
			<td align="center" style="border-top:1.0pt solid black;border-left:1.0pt solid black; border-right:1pt solid black;border-bottom:none;font-size:13pt;"></td>
			<td align="center" colspan="3" style="border-top:none;border-left:1.0pt solid black; border-right:1pt solid black;border-bottom:none;font-size:13pt;"></td>
		</tr>
		<tr>
			<td align="center" colspan="2" style="border-top:none;border-left:1.0pt solid black; border-right:1pt solid black;border-bottom:none;font-size:13pt;"></td>
			<td align="left" style="border-top:1.0pt solid black;border-left:1.0pt solid black; border-right:1pt solid black;border-bottom:none;font-size:13pt;font-weight:bold;">NAMA PERKIRAAN</td>
			<td align="center" style="border-top:1.0pt solid black;border-left:1.0pt solid black; border-right:1pt solid black;border-bottom:none;font-size:13pt;"></td>
			<td align="left" style="border-top:1.0pt solid black;border-left:1.0pt solid black; border-right:1pt solid black;border-bottom:none;font-size:13pt;font-weight:bold;">TERMIN V</td>
			<td align="center" style="border-top:1.0pt solid black;border-left:1.0pt solid black; border-right:1pt solid black;border-bottom:none;font-size:13pt;"></td>
			<td align="center" colspan="3" style="border-top:none;border-left:1.0pt solid black; border-right:1pt solid black;border-bottom:none;font-size:13pt;"></td>
		</tr>
		<tr>
			<td align="center" colspan="2" style="border-top:none;border-left:1.0pt solid black; border-right:1pt solid black;border-bottom:none;font-size:13pt;"></td>
			<td align="left" style="border-top:1.0pt solid black;border-left:1.0pt solid black; border-right:1pt solid black;border-bottom:none;font-size:13pt;font-weight:bold;">NOMOR PERKIRAAN</td>
			<td align="center" style="border-top:1.0pt solid black;border-left:1.0pt solid black; border-right:1pt solid black;border-bottom:none;font-size:13pt;"></td>
			<td align="left" rowspan="2" style="border-top:1.0pt solid black;border-left:1.0pt solid black; border-right:1pt solid black;border-bottom:none;font-size:13pt;font-weight:bold;">LUNAS</td>
			<td align="center" style="border-top:1.0pt solid black;border-left:1.0pt solid black; border-right:1pt solid black;border-bottom:none;font-size:13pt;"></td>
			<td align="center" colspan="3" style="border-top:none;border-left:1.0pt solid black; border-right:1pt solid black;border-bottom:none;font-size:13pt;"></td>
		</tr>
		<tr>
			<td align="center" colspan="2" style="border-top:none;border-left:1.0pt solid black; border-right:1pt solid black;border-bottom:none;font-size:13pt;"></td>
			<td align="left" style="border-top:1.0pt solid black;border-left:1.0pt solid black; border-right:1pt solid black;border-bottom:none;font-size:13pt;font-weight:bold;">PARAF</td>
			<td align="center" style="border-top:1.0pt solid black;border-left:1.0pt solid black; border-right:1pt solid black;border-bottom:none;font-size:13pt;"></td>
			<td align="center" style="border-top:1.0pt solid black;border-left:1.0pt solid black; border-right:1pt solid black;border-bottom:none;font-size:13pt;"></td>
			<td align="center" colspan="3" style="border-top:none;border-left:1.0pt solid black; border-right:1pt solid black;border-bottom:none;font-size:13pt;"></td>
		</tr>
		<tr>
			<td align="center" colspan="2" style="border-top:none;border-left:1.0pt solid black; border-right:1pt solid black;border-bottom:none;font-size:13pt;"></td>
			<td align="center" colspan="2" style="border-top:1.0pt solid black;border-left:1.0pt solid black; border-right:1pt solid black;border-bottom:none;font-size:13pt;font-weight:bold;">DTO</td>
			<td align="center" colspan="2" style="border-top:1.0pt solid black;border-left:1.0pt solid black; border-right:1pt solid black;border-bottom:none;font-size:13pt;font-weight:bold;">DTO</td>
			<td align="center" colspan="3" style="border-top:none;border-left:1.0pt solid black; border-right:1pt solid black;border-bottom:none;font-size:13pt;"></td>
		</tr>
		<tr>
			<td height="30" align="center" colspan="2" style="border-top:none;border-left:1.0pt solid black; border-right:1pt solid black;border-bottom:none;font-size:13pt;"></td>
			<td align="center" colspan="2" style="border-top:none;border-left:1.0pt solid black; border-right:1pt solid black;border-bottom:none;font-size:13pt;"></td>
			<td align="center" colspan="2" style="border-top:none;border-left:1.0pt solid black; border-right:1pt solid black;border-bottom:none;font-size:13pt;"></td>
			<td align="center" colspan="3" style="border-top:none;border-left:1.0pt solid black; border-right:1pt solid black;border-bottom:none;font-size:13pt;"></td>
		</tr>
		<tr>
			<td align="center" colspan="2" style="border-top:none;border-left:1.0pt solid black; border-right:1pt solid black;border-bottom:none;font-size:12pt;">HAFNI GANA SIREGAR, SE</td>
			<td align="center" colspan="2" style="border-top:none;border-left:1.0pt solid black; border-right:1pt solid black;border-bottom:none;font-size:13pt;"></td>
			<td align="center" colspan="2" style="border-top:none;border-left:1.0pt solid black; border-right:1pt solid black;border-bottom:none;font-size:13pt;"></td>
			<td align="center" colspan="3" style="border-top:none;border-left:1.0pt solid black; border-right:1pt solid black;border-bottom:none;font-size:13pt;"></td>
		</tr>
		<tr>
			<td align="center" colspan="2" style="border-top:none;border-left:1.0pt solid black; border-right:1pt solid black;border-bottom:1pt solid black;font-size:12pt;font-weight:bold;">KABID PENGEMBANGAN SDM</td>
			<td align="center" colspan="2" style="border-top:none;border-left:1.0pt solid black; border-right:1pt solid black;border-bottom:1pt solid black;font-size:13pt;font-weight:bold;">KABID ANGGARAN</td>
			<td align="center" colspan="2" style="border-top:none;border-left:1.0pt solid black; border-right:1pt solid black;border-bottom:1pt solid black;font-size:13pt;font-weight:bold;">KABID PENDANAAN</td>
			<td align="center" colspan="3" style="border-top:none;border-left:1pt solid black;border-bottom:1pt solid black;border-right:1pt solid black;font-size:13pt;"></td>
		</tr>
		<tr>
			<td align="left" colspan="2" style="border-top:none;border-left:solid black 1.0pt;border-bottom:none;font-size:8pt;font-weight:bold">Keterangan:<br/>A. Kolom 1, 3, 4, 5, 6, 7 & 8 diisi oleh Divisi/Cabang.<br/>B. Kolom 2 diisi oleh Divisi Keuangan.<br/>C. Kolom 9 kalau perlu diisi yang memberi rekomendasi.</td>
			<td align="center" colspan="2" style="border-top:none;border-left:solid black 1.0pt;border-bottom:none;font-size:13pt;font-weight:bold;"></td>
			<td align="center" colspan="2" style="border-top:none;border-left:solid black 1.0pt;border-bottom:none;font-size:13pt;font-weight:bold;"></td>
			<td align="left" style="border-top:none;border-left:solid black 1.0pt;border-bottom:none;font-size:9pt;font-weight:bold">Putih<br/>Merah<br/>Biru</td>
			<td align="left" colspan="2" style="border-top:none;border-left:solid black 1.0pt;border-bottom:none;font-size:8pt;font-weight:bold">: Divisi Keuangan<br/>: Bidang Anggaran<br/>: Divisi / Cabang ybs</td>
		</tr>';
		$html .= '</table>';
		$mpdf->WriteHTML($html);
		$mpdf->Output();
		echo $html;
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */