<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Laporan extends CI_Controller {

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

	public function cetakSPPD(){
		session_start();
		if ($_POST['my_token'] === $_SESSION['my_token']){
        	// was ok
			// echo "SAMA";
			$kodeSPPD=$_POST['code'];
			$tipeCtk=$_POST['tipe'];
			// print_r($_POST);

			if ($tipeCtk==1) {
				$this->cetakUsulanDanaSPPD($kodeSPPD);
			}else{
				$this->cetakUsulanPenginapanSPPD($kodeSPPD);
			}
			session_destroy();
			// $this->menuCtkUsulanSPPD();
			redirect('/welcome');
		}else{
			// was bad!!!
			// echo "BEDA";
			$data['content']='errorSession.php';
			$this->load->view('template',$data);
		}
	}

	public function cetakUsulanDanaSPPD($kodeSPPD){
		$this->load->library('mpdf/mPdf');		
		$mpdf = new mPDF('c','F4-L', 0, '', 10, 20, 20, 5, 1, 1,'arial');		
		$mpdf->setWatermarkImage('./images/logo.png', 1, '', array(10,2));
		$mpdf->showWatermarkImage = true;
		$html = '
		<htmlpagefooter name="MyFooter1">
			<table width="100%" style="vertical-align: bottom; font-family: serif; font-size: 8pt; color: #000000; font-weight: bold; font-style: italic;">
				<tr>
					<td width="33%" align="center" style="font-weight: bold; font-style: italic;">Tanggal Cetak '.date("d/m/Y H:i:s").',  Halaman {PAGENO} dari {nbpg}</td>
				</tr>
			</table>
		</htmlpagefooter>
		<sethtmlpagefooter name="MyFooter1" value="off" />
		<div style="font-size:20px; font-weight:bold"></div>
		<div style="font-weight:bold;"></div>
		<div style="font-size:12pt; font-weight:bold; text-align:center">BARANG MASUK</div>
		<div style="font-weight:bold; text-align:center">NOMOR : </div>';
		$total=0;
		$html .='
		<table width="100%" border="1" cellspacing="0" cellpadding="2">
		  <tr>
			<td height="32" width="4%" align="center" style="font-size:10pt;"><strong>NO</strong></td>
			<td width="10%" align="center" style="font-size:10pt;"><strong>KODE</strong></td>
			<td width="45%" align="center" style="font-size:10pt;"><strong>NAMA BARANG</strong></td>
			<td width="10%" align="center" style="font-size:10pt;"><strong>JLH</strong></td>
			<td width="10%" align="center" style="font-size:10pt;"><strong>SATUAN</strong></td>
			<td width="12%" align="center" style="font-size:10pt;"><strong>HARGA</strong></td>
			<td width="14%" align="center" style="font-size:10pt;"><strong>TOTAL</strong></td>
			
		  </tr>';
		$no= 1;
		$html .='  
		  <tr>
			<td height="20" align="center" style="border-top:none;border-left:solid black 1.0pt;border-bottom:none;font-size:8pt;"></td>
			<td align="center" style="border-top:none;border-left:solid black 1.0pt;border-bottom:none;font-size:8pt;"></td>
			<td align="left" style="border-top:none;border-left:solid black 1.0pt;border-bottom:none;font-size:8pt;"></td>
			<td align="right" style="border-top:none;border-left:solid black 1.0pt;border-bottom:none;font-size:8pt;"></td>
			<td align="center" style="border-top:none;border-left:solid black 1.0pt;border-bottom:none;font-size:8pt;"></td>
			<td align="right" style="border-top:none;border-left:solid black 1.0pt;border-bottom:none;font-size:8pt;"></td>
			<td align="right" style="border-top:none;border-left:solid black 1.0pt;border-bottom:none;font-size:8pt;"></td>
			
		</tr>';			
		$html .='			
					  <tr>						
						<td height="32" align="center" colspan="6" style="font-size:10pt;"><strong>TOTAL</strong></td>						
						<td align="right" style="font-size:8pt;"><strong></strong></td>			
					  </tr>';
		$html .= '</table>';
		$html .= '<br>
		<table width="100%">
			<tr>
				<td width="40%" align="center"></td>
				<td width="20%"></td>
				<td width="40%" align="left">Tanggal Cetak '.date("d - m - Y H:i").'</td>
			</tr>
			<tr>
				<td width="40%" align="center" style="font-size:10pt;">Kadiv Umum</td>
				<td width="40%" align="center" style="font-size:10pt;">Kabid Logistik</td>
				<td width="20%" align="center" style="font-size:10pt;">Petugas</td>
			</tr>
			<tr>
				<td width="20%" align="center" style="font-size:10pt;"><br><br><br><br></td>
				<td width="60%"	align="center" style="font-size:10pt;"><br><br><br><br></td>
				<td width="20%" align="center" style="font-size:10pt;"><br><br><br><br></td>
			</tr>
		</table>';
		$mpdf->WriteHTML($html);
		$mpdf->Output('cetakUsulanDanaSPPD.pdf');
		echo $html;
	}

	public function cetakUsulanPenginapanSPPD($kodeSPPD){

	}
}