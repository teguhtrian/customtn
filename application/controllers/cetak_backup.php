<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Cetak extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model('home_model');
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

	public function penyebut($nilai)
	{
		$nilai = abs($nilai);
		$huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
		$temp = "";
		if ($nilai < 12) {
			$temp = " " . $huruf[$nilai];
		} else if ($nilai < 20) {
			$temp = $this->penyebut($nilai - 10) . " belas";
		} else if ($nilai < 100) {
			$temp = $this->penyebut($nilai / 10) . " puluh" . $this->penyebut($nilai % 10);
		} else if ($nilai < 200) {
			$temp = " seratus" . $this->penyebut($nilai - 100);
		} else if ($nilai < 1000) {
			$temp = $this->penyebut($nilai / 100) . " ratus" . $this->penyebut($nilai % 100);
		} else if ($nilai < 2000) {
			$temp = " seribu" . $this->penyebut($nilai - 1000);
		} else if ($nilai < 1000000) {
			$temp = $this->penyebut($nilai / 1000) . " ribu" . $this->penyebut($nilai % 1000);
		} else if ($nilai < 1000000000) {
			$temp = $this->penyebut($nilai / 1000000) . " juta" . $this->penyebut($nilai % 1000000);
		} else if ($nilai < 1000000000000) {
			$temp = $this->penyebut($nilai / 1000000000) . " milyar" . $this->penyebut(fmod($nilai, 1000000000));
		} else if ($nilai < 1000000000000000) {
			$temp = $this->penyebut($nilai / 1000000000000) . " trilyun" . $this->penyebut(fmod($nilai, 1000000000000));
		}
		return $temp;
	}

	public 	function terbilang($nilai)
	{
		if ($nilai < 0) {
			$hasil = "minus " . trim($this->penyebut($nilai));
		} else {
			$hasil = trim($this->penyebut($nilai));
		}
		return $hasil;
	}

	function cetakBon2($no_kwit)
	{
		// session_start();
		$fmt = new NumberFormatter('en_US', NumberFormatter::CURRENCY);
		$allData = $this->home_model->rItemByNoKwit($no_kwit)->result();
		$tb = 0;
		$kantor = $this->home_model->rDataKocabByKocab($this->session->userdata('kocab'))->result();
		// print_r($allData);die;
		// $pointer=0;
		$tbItem = 0;
		foreach ($allData as $d) {
			$tb = $tb + $d->biaya;
			if (!empty($d->idtb_biaya)) {
				// echo $d->idtb_biaya;
				$item = $this->home_model->rTbBiayaById($d->idtb_biaya)->result();
				$tbItem = $tbItem + $item[0]->biaya;
			}
		}
		$nm_ttd = $this->home_model->rTtdKabagByKocab($allData[0]->kocab)->result();
		// print_r($tbItem);die;
		$tbItemPpn = $tbItem + ($tbItem * 0.1);
		$this->load->library('mpdf/mPdf');
		$mpdf = new mPDF('c', 'A4-P', 0, '', 10, 10, 10, 10, 1, 1, 'arial');
		// $mpdf->setWatermarkImage('./images/logo.png', 1, '', array(10,2));
		$mpdf->showWatermarkImage = true;
		$html = '<div style="font-size:18pt; font-weight:bold; text-align:center; margin-bottom:0px">BPBRA</div>';
		$html .= '<div style="font-size:11pt; font-weight:bold; text-align:center; margin-top:0px">(BUKTI PEMBAYARAN BUKAN REKENING AIR)</div><hr style="width:75%; margin-bottom=0px">';
		$html .= '<p style="margin-top:0px" align="center">Nomor: ' . $no_kwit . '</p>';
		$html .= '<table width="100%" style="padding:20px" border="1" frame="box">
		  <tr>
			<td rowspan="3" width="5%" align="center" style="border-top:solid black 1.0pt;border-left:solid black 1.0pt;border-right:solid black 1.0pt;border-bottom:none;font-size:10pt;">
				<img width="10%" height="10%" src="./asset/images/logo.png" alt="Logo Tirtanadi"></td>
			<td align="left" colspan="2" style="border-top:solid black 1.0pt;border-left:none;border-right:solid black 1.0pt;border-bottom:none;font-size:11pt;">PDAM Tirtanadi ' . ucwords(strtolower($kantor[0]->nama)) . '</td>
		  </tr>
		  <tr>
			  <td align="left" style="border-top:solid black 1.0pt;border-left:none;border-right:solid black 1.0pt;border-bottom:none;font-size:11pt;">' . ucwords(strtolower($kantor[0]->alamat)) . '</td>
		  </tr>
		  <tr>
			  <td align="left" style="border-top:solid black 1.0pt;border-left:none;border-right:solid black 1.0pt;border-bottom:none;font-size:11pt;">NPWP : 01.128.068.2.123.000</td>
		  </tr>
		  <tr>
			  <td align="left" colspan="3" style="border-top:solid black 1.0pt;border-left:none;border-right:solid black 1.0pt;border-bottom:none;font-size:11pt;"></td><br>
		  </tr>
		  <tr>
			  <td colspan="3" align="left" style="border-top:solid black 1.0pt;border-left:none;border-right:solid black 1.0pt;border-bottom:none;font-size:11pt;">Telah diterima uang untuk pembayaran biaya ' . $allData[0]->item . ' dan biaya lainnya (sesuai dengan yang tercantum pada Jenis Pembayaran) yang telah ditetapkan perusahaan terhadap pelanggan sebesar:</td><br><br>
		  </tr>
		  <tr>
			  <!-- <td width="200px" align="left" style="border-top:solid black 1.0pt;border-left:none;border-right:solid black 1.0pt;border-bottom:none;font-size:11pt;"><dl><strong>' . $fmt->formatCurrency($tb, "IDR") . '</strong></td>
			  <td align="center" style="border-top:solid black 1.0pt;border-left:none;border-right:solid black 1.0pt;border-bottom:none;font-size:11pt;"><strong>Terbilang:  ' . ucwords($this->terbilang($tb)) . ' Rupiah</strong></td><br><br> -->
			  <td width="200px" colspan="3" align="left" style="border-top:solid black 1.0pt;border-left:none;border-right:solid black 1.0pt;border-bottom:none;font-size:11pt;"><table><tr><td style="border-top:solid black 1.0pt;border-left:none;border-right:solid black 1.0pt;border-bottom:none;font-size:11pt;"><strong>' . $fmt->formatCurrency($tb, "IDR") . '</strong></td><td style="margin:0px;padding-left:150px;border-top:solid black 1.0pt;border-left:none;border-right:solid black 1.0pt;border-bottom:none;font-size:11pt;"><strong>Terbilang:  ' . ucwords($this->terbilang($tb)) . ' Rupiah</strong></td></tr></table></td>
		  </tr>
		  <tr>
			  <td colspan="3" align="center" style="border-top:solid black 1.0pt;border-left:none;border-right:solid black 1.0pt;border-bottom:none;font-size:11pt;"></td><br>
		  </tr>
		  <tr>
			  <td colspan="3" align="center" style="border-top:solid black 1.0pt;border-left:none;border-right:solid black 1.0pt;border-bottom:none;font-size:11pt;">---------------------------------------------- dari ----------------------------------------------</td><br><br>
		  </tr>
		  <tr>
			  <td align="left" style="border-top:solid black 1.0pt;border-left:none;border-right:solid black 1.0pt;border-bottom:none;font-size:11pt;">Nama </td>
			  <td align="left" colspan="2" style="border-top:solid black 1.0pt;border-left:none;border-right:solid black 1.0pt;border-bottom:none;font-size:11pt;">: ' . $allData[0]->nm_ctm . '</td>
		  </tr>
		  <tr>
			  <td align="left" style="border-top:solid black 1.0pt;border-left:none;border-right:solid black 1.0pt;border-bottom:none;font-size:11pt;">Alamat </td>
			  <td align="left" style="border-top:solid black 1.0pt;border-left:none;border-right:solid black 1.0pt;border-bottom:none;font-size:11pt;">: ' . $allData[0]->alamat . '</td>
		  </tr>
		  <tr>
			  <td align="left" style="border-top:solid black 1.0pt;border-left:none;border-right:solid black 1.0pt;border-bottom:none;font-size:11pt;">NPA </td>
			  <td align="left" style="border-top:solid black 1.0pt;border-left:none;border-right:solid black 1.0pt;border-bottom:none;font-size:11pt;">: ' . $allData[0]->npa . '</td><br>
		  </tr>
		  <tr>
			  <td colspan="3" align="center" style="border-top:solid black 1.0pt;border-left:none;border-right:solid black 1.0pt;border-bottom:none;font-size:11pt;"></td><br>
		  </tr>		  
		  <tr>
			  <td colspan="2" align="left" style="border-top:solid black 1.0pt;border-left:none;border-right:solid black 1.0pt;border-bottom:none;font-size:11pt;">Dengan perincian sebagai berikut :</td><br><br>
		  </tr>		  
		  <tr>
			  <td align="left" style="border-top:solid black 1.0pt;border-left:none;border-right:solid black 1.0pt;border-bottom:none;font-size:11pt;"><strong>Rubrik</strong></td>
			  <td width="100px" align="left" style="border-top:solid black 1.0pt;border-left:none;border-right:solid black 1.0pt;border-bottom:none;font-size:11pt;"><strong>Jenis Pembayaran</strong></td>
			  <td width="100px" align="left" style="padding-left:80px;border-top:solid black 1.0pt;border-left:none;border-right:solid black 1.0pt;border-bottom:none;font-size:11pt;"><strong>Biaya</strong></td>
		  </tr>';
		// $tb=0;
		foreach ($allData as $d) {
			// $tb=$tb+$d->biaya;
			$html .= '<tr>';
			$html .= '<td align="left" style="border-top:solid black 1.0pt;border-left:none;border-right:solid black 1.0pt;border-bottom:none;font-size:11pt;">' . $d->rubrik . '</td>';
			$html .= '<td align="left" style="border-top:solid black 1.0pt;border-left:none;border-right:solid black 1.0pt;border-bottom:none;font-size:11pt;">' . $d->item . '</td>';
			if ($d->idtb_biaya == '') {
				$html .= '<td align="left" style="padding-left:80px;border-top:solid black 1.0pt;border-left:none;border-right:solid black 1.0pt;border-bottom:none;font-size:11pt;">&nbsp;&nbsp;' . $fmt->formatCurrency($d->biaya, "IDR") . '</td>';
			} else {
				$html .= '<td align="left" style="padding-left:80px;border-top:solid black 1.0pt;border-left:none;border-right:solid black 1.0pt;border-bottom:none;font-size:11pt;">' . $fmt->formatCurrency($d->biaya, "IDR") . '</td>';
			}
			$html .= '</tr>';
		}
		$html .= '<tr><td align="left" style="border-top:solid black 1.0pt;border-left:none;border-right:solid black 1.0pt;border-bottom:none;font-size:11pt;">-</td>
			  <td width="100px" align="left" style="border-top:solid black 1.0pt;border-left:none;border-right:solid black 1.0pt;border-bottom:none;font-size:11pt;">-</td>
			  <td width="100px" align="left" style="padding-left:80px;border-top:solid black 1.0pt;border-left:none;border-right:solid black 1.0pt;border-bottom:none;font-size:11pt;">-</td></tr>';
		$html .= '<tr><td align="left" style="border-top:solid black 1.0pt;border-left:none;border-right:solid black 1.0pt;border-bottom:none;font-size:11pt;">-</td>
			  <td width="100px" align="left" style="border-top:solid black 1.0pt;border-left:none;border-right:solid black 1.0pt;border-bottom:none;font-size:11pt;">-</td>
			  <td width="100px" align="left" style="padding-left:80px;border-top:solid black 1.0pt;border-left:none;border-right:solid black 1.0pt;border-bottom:none;font-size:11pt;">-</td></tr>';
		//jumlah biaya kebawah
		$html .= '<tr><td align="left" style="border-top:solid black 1.0pt;border-left:none;border-right:solid black 1.0pt;border-bottom:none;font-size:11pt;"></td>
			  <td width="100px" align="left" style="border-top:solid black 1.0pt;border-left:none;border-right:solid black 1.0pt;border-bottom:none;font-size:11pt;"></td>
			  <td width="100px" align="left" style=padding-left:80px;"border-top:solid black 1.0pt;border-left:none;border-right:solid black 1.0pt;font-size:11pt;">----------------  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; +</td></tr>';
		$html .= '<tr><td align="left" colspan="2" style="border-top:solid black 1.0pt;border-left:none;border-right:solid black 1.0pt;border-bottom:none;font-size:11pt;">Jumlah biaya</td>
			  <td align="left" style="padding-left:80px;border-top:solid black 1.0pt;border-left:none;border-right:solid black 1.0pt;border-bottom:none;font-size:11pt;"><strong>' . $fmt->formatCurrency($tb, "IDR") . '</strong></td></tr>';
		$html .= '<tr><td colspan="2" align="left" style="border-top:solid black 1.0pt;border-left:none;border-right:solid black 1.0pt;border-bottom:none;font-size:11pt;">Jumlah yang telah dibayar</td>
			  <td width="100px" align="left" style="padding-left:80px;border-top:solid black 1.0pt;border-left:none;border-right:solid black 1.0pt;font-size:11pt;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;0</td></tr>';
		$html .= '<tr><td align="left" style="border-top:solid black 1.0pt;border-left:none;border-right:solid black 1.0pt;border-bottom:none;font-size:11pt;"></td>
			  <td width="100px" align="left" style="border-top:solid black 1.0pt;border-left:none;border-right:solid black 1.0pt;border-bottom:none;font-size:11pt;"></td>
			  <td width="100px" align="left" style="padding-left:80px;border-top:solid black 1.0pt;border-left:none;border-right:solid black 1.0pt;font-size:11pt;">----------------  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -</td></tr>';
		$html .= '<tr><td colspan="2" align="left" style="border-top:solid black 1.0pt;border-left:none;border-right:solid black 1.0pt;border-bottom:none;font-size:11pt;">Pembayaran kontan</td>
			  <td width="100px" align="left" style="padding-left:80px;border-top:solid black 1.0pt;border-bottom:none;border-left:none;border-right:solid black 1.0pt;font-size:11pt;"><strong>' . $fmt->formatCurrency($tb, "IDR") . '</strong></td></tr>';
		$sisaBayar = $tbItemPpn - $tb;
		$html .= '<tr><td colspan="2" align="left" style="border-top:solid black 1.0pt;border-left:none;border-right:solid black 1.0pt;border-bottom:none;font-size:11pt;">Sisa yang masih harus dibayar</td>
			  <td align="left" style="padding-left:80px;border-top:solid black 1.0pt;border-left:none;border-right:solid black 1.0pt;font-size:11pt;">' . $fmt->formatCurrency($sisaBayar, "IDR") . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-</td></tr>';
		$html .= '<tr><td colspan="2" align="left" style="border-top:solid black 1.0pt;border-left:none;border-right:solid black 1.0pt;border-bottom:none;font-size:11pt;"></td>
			  <td align="right" style="border-top:solid black 1.0pt;border-bottom:none;border-left:none;border-right:solid black 1.0pt;font-size:11pt;"></td></tr><br><br>';
		$html .= '<tr><td colspan="2" align="left" style="border-top:solid black 1.0pt;border-left:none;border-right:solid black 1.0pt;border-bottom:none;font-size:11pt;"></td>
			  <td align="center" style="border-top:solid black 1.0pt;border-left:none;border-right:solid black 1.0pt;font-size:11pt;">' . ucwords(strtolower($kantor[0]->kota)) . ', ' . $this->tgl_indo(date('Y-m-d')) . '</td></tr>';
		$html .= '<tr><td colspan="2" align="left" style="border-top:solid black 1.0pt;border-left:none;border-right:solid black 1.0pt;border-bottom:none;font-size:11pt;"></td>
			  <td align="right" style="border-top:solid black 1.0pt;border-bottom:none;border-left:none;border-right:solid black 1.0pt;font-size:11pt;"></td></tr><br><br><br><br>';
		$html .= '<tr><td colspan="2" align="left" style="border-top:solid black 1.0pt;border-left:none;border-right:solid black 1.0pt;border-bottom:none;font-size:11pt;"></td>
			  <td align="center" style="text-decoration: underline;border-top:solid black 1.0pt;border-left:none;border-right:solid black 1.0pt;font-size:11pt;">' . $nm_ttd[0]->nm_ttd . '</td></tr>';
		$html .= '<tr><td colspan="2" align="left" style="border-top:solid black 1.0pt;border-left:none;border-right:solid black 1.0pt;border-bottom:none;font-size:11pt;"></td>
			  <td align="center" style="border-top:solid black 1.0pt;border-left:none;border-right:solid black 1.0pt;font-size:11pt;">' . $nm_ttd[0]->jb_ttd . '</td></tr>';
		$html .= '</table>';
		$mpdf->WriteHTML($html);
		$mpdf->Output();
		echo $html;
	}

	function cetakBon($no_kwit)
	{
		// session_start();
		$fmt = new NumberFormatter('en_US', NumberFormatter::CURRENCY);
		$kantor = $this->home_model->rDataKocabByKocab($this->session->userdata('kocab'))->result();
		$kocab = $kantor[0]->Code;
		$allData = $this->home_model->rItemByNoKwit($no_kwit, $kocab)->result();
		$isDp = $this->home_model->rIsDpByNoKwit($no_kwit, $kocab)->result();
		// print_r($kantor);die;
		$tb = 0;
		$tbItem = 0;
		foreach ($allData as $d) {
			if (!empty($d->idtb_biaya)) {
				//jika bukan pajak
				// echo $d->idtb_biaya;
				$item = $this->home_model->rTbBiayaById($d->idtb_biaya)->result();
				if ($item[0]->biaya != $d->biaya) {
					//biaya input tidak sama dengan tabel biaya
					if ($d->isDp != NULL) {
						//jika dp
						$tb = $tb + $item[0]->biaya;
						$tbItem = $tbItem + $d->biaya;
					} else {
						//bukan dp
						$tb = $tb + $d->biaya;
						$tbItem = $tbItem + $d->biaya;
					}
				} else {
					//biaya input sama dengan tabel biaya
					$tb = $tb + $item[0]->biaya;
					$tbItem = $tbItem + $item[0]->biaya;
				}
			} else {
				//jika pajak
				$tb = $tb + $d->biaya;
				$tbItem = $tbItem + $d->biaya;
			}
		}

		$sisaBayar = $tb - $tbItem;
		// var_dump($tb);
		// var_dump($tbItem);
		// var_dump($sisaBayar);die;
		// var_dump($isDp);die;
		$nm_ttd = $this->home_model->rTtdKabagByKocab($kocab)->result();
		// $totalBiaya=$item[0]->biaya+($item[0]->biaya*0.1);
		// print_r($totalBiaya);die;
		$this->load->library('mpdf/mPdf');
		$mpdf = new mPDF('c', 'A4-P', 0, '', 10, 10, 10, 10, 1, 1, 'arial');
		// $mpdf->setWatermarkImage('./images/logo.png', 1, '', array(10,2));
		$mpdf->showWatermarkImage = true;
		$html = '<div style="font-size:18pt; font-weight:bold; text-align:center; margin-bottom:0px">BPBRA</div>';
		$html .= '<div style="font-size:11pt; font-weight:bold; text-align:center; margin-top:0px">(BUKTI PEMBAYARAN BUKAN REKENING AIR)</div><hr style="width:75%; margin-bottom=0px">';
		$html .= '<p style="margin-top:0px" align="center">Nomor: ' . $no_kwit . '</p>';
		$html .= '<table width="100%" style="padding:20px" border="1" frame="box">
		  <tr>
			<td rowspan="3" width="5%" align="center" style="border-top:solid black 1.0pt;border-left:solid black 1.0pt;border-right:solid black 1.0pt;border-bottom:none;font-size:10pt;">
				<img width="10%" height="10%" src="./asset/images/logo.png" alt="Logo Tirtanadi"></td>
			<td align="left" colspan="2" style="border-top:solid black 1.0pt;border-left:none;border-right:solid black 1.0pt;border-bottom:none;font-size:11pt;">PDAM Tirtanadi ' . ucwords(strtolower($kantor[0]->nama)) . '</td>
		  </tr>
		  <tr>
			  <td align="left" style="border-top:solid black 1.0pt;border-left:none;border-right:solid black 1.0pt;border-bottom:none;font-size:11pt;">' . ucwords(strtolower($kantor[0]->alamat)) . '</td>
		  </tr>
		  <tr>
			  <td align="left" style="border-top:solid black 1.0pt;border-left:none;border-right:solid black 1.0pt;border-bottom:none;font-size:11pt;">NPWP : 01.128.068.2.123.000</td>
		  </tr>
		  <tr>
			  <td align="left" colspan="3" style="border-top:solid black 1.0pt;border-left:none;border-right:solid black 1.0pt;border-bottom:none;font-size:11pt;"></td><br>
		  </tr>
		  <tr>
			  <td colspan="3" align="left" style="border-top:solid black 1.0pt;border-left:none;border-right:solid black 1.0pt;border-bottom:none;font-size:11pt;">Telah diterima uang untuk pembayaran biaya <strong>' . $allData[0]->item . '</strong> dan biaya lainnya (sesuai dengan yang tercantum pada Jenis Pembayaran) yang telah ditetapkan perusahaan terhadap pelanggan sebesar:</td><br><br>
		  </tr>
		  <tr>
			  <!-- <td width="200px" align="left" style="border-top:solid black 1.0pt;border-left:none;border-right:solid black 1.0pt;border-bottom:none;font-size:11pt;"><dl><strong>' . $fmt->formatCurrency($tb, "IDR") . '</strong></td>
			  <td align="center" style="border-top:solid black 1.0pt;border-left:none;border-right:solid black 1.0pt;border-bottom:none;font-size:11pt;"><strong>Terbilang:  ' . ucwords($this->terbilang($tb)) . ' Rupiah</strong></td><br><br> -->
			  <td width="200px" colspan="3" align="left" style="border-top:solid black 1.0pt;border-left:none;border-right:solid black 1.0pt;border-bottom:none;font-size:11pt;"><table><tr><td style="border-top:solid black 1.0pt;border-left:none;border-right:solid black 1.0pt;border-bottom:none;font-size:11pt;"><strong>' . $fmt->formatCurrency($tbItem, "IDR") . '</strong></td><td align="left" style="margin:0px;padding-left:150px;border-top:solid black 1.0pt;border-left:none;border-right:solid black 1.0pt;border-bottom:none;font-size:11pt;"><strong>Terbilang:  ' . ucwords($this->terbilang($tbItem)) . ' Rupiah</strong></td></tr></table></td>
		  </tr>
		  <tr>
			  <td colspan="3" align="center" style="border-top:solid black 1.0pt;border-left:none;border-right:solid black 1.0pt;border-bottom:none;font-size:11pt;"></td><br>
		  </tr>
		  <tr>
			  <td colspan="3" align="center" style="border-top:solid black 1.0pt;border-left:none;border-right:solid black 1.0pt;border-bottom:none;font-size:11pt;">---------------------------------------------- dari ----------------------------------------------</td><br><br>
		  </tr>
		  <tr>
			  <td align="left" style="border-top:solid black 1.0pt;border-left:none;border-right:solid black 1.0pt;border-bottom:none;font-size:11pt;">Nama </td>
			  <td align="left" colspan="2" style="border-top:solid black 1.0pt;border-left:none;border-right:solid black 1.0pt;border-bottom:none;font-size:11pt;">: ' . $allData[0]->nm_ctm . '</td>
		  </tr>
		  <tr>
			  <td align="left" style="border-top:solid black 1.0pt;border-left:none;border-right:solid black 1.0pt;border-bottom:none;font-size:11pt;">Alamat </td>
			  <td align="left" style="border-top:solid black 1.0pt;border-left:none;border-right:solid black 1.0pt;border-bottom:none;font-size:11pt;">: ' . $allData[0]->alamat . '</td>
		  </tr>
		  <tr>
			  <td align="left" style="border-top:solid black 1.0pt;border-left:none;border-right:solid black 1.0pt;border-bottom:none;font-size:11pt;">NPA/No. Reg. </td>
			  <td align="left" style="border-top:solid black 1.0pt;border-left:none;border-right:solid black 1.0pt;border-bottom:none;font-size:11pt;">: ' . $allData[0]->npa . '</td><br>
		  </tr>
		  <tr>
			  <td colspan="3" align="center" style="border-top:solid black 1.0pt;border-left:none;border-right:solid black 1.0pt;border-bottom:none;font-size:11pt;"></td><br>
		  </tr>		  
		  <tr>
			  <td colspan="2" align="left" style="border-top:solid black 1.0pt;border-left:none;border-right:solid black 1.0pt;border-bottom:none;font-size:11pt;">Dengan perincian sebagai berikut :</td><br><br>
		  </tr>		  
		  <tr>
			  <td align="left" style="border-top:solid black 1.0pt;border-left:none;border-right:solid black 1.0pt;border-bottom:none;font-size:11pt;"><strong>Rubrik</strong></td>
			  <td width="100px" align="left" style="border-top:solid black 1.0pt;border-left:none;border-right:solid black 1.0pt;border-bottom:none;font-size:11pt;"><strong>Jenis Pembayaran</strong></td>
			  <td width="100px" align="right" style="padding-right:100px;border-top:solid black 1.0pt;border-left:none;border-right:solid black 1.0pt;border-bottom:none;font-size:11pt;"><strong>Biaya</strong></td>
		  </tr>';
		// $tb=0;
		$tbNonDp = 0;
		foreach ($allData as $d) {
			//data item all
			// $tb=$tb+$d->biaya;
			$html .= '<tr>';
			$html .= '<td align="left" style="border-top:solid black 1.0pt;border-left:none;border-right:solid black 1.0pt;border-bottom:none;font-size:11pt;">' . $d->rubrik . '</td>';
			$html .= '<td align="left" style="border-top:solid black 1.0pt;border-left:none;border-right:solid black 1.0pt;border-bottom:none;font-size:11pt;">' . $d->item . '</td>';
			if ($d->idtb_biaya == '') {
				//jika pajak
				$html .= '<td align="right" style="padding-right:75px;border-top:solid black 1.0pt;border-left:none;border-right:solid black 1.0pt;border-bottom:none;font-size:11pt;">&nbsp;&nbsp;' . $fmt->formatCurrency($d->biaya, "IDR") . '</td>';
			} else {
				//bukan pajak
				if ($d->isDp == '') {
					//bukan DP
					// $itemTotal=$this->home_model->rTbBiayaById($d->idtb_biaya)->result();
					$html .= '<td align="right" width="17px" style="padding-right:75px;border-top:solid black 1.0pt;border-left:none;border-right:solid black 1.0pt;border-bottom:none;font-size:11pt;">' . $fmt->formatCurrency($d->biaya, "IDR") . '</td>';
				} else {
					//DP
					$itemTotal = $this->home_model->rTbBiayaById($d->idtb_biaya)->result();
					$html .= '<td align="right" style="padding-right:75px;border-top:solid black 1.0pt;border-left:none;border-right:solid black 1.0pt;border-bottom:none;font-size:11pt;">' . $fmt->formatCurrency($itemTotal[0]->biaya, "IDR") . '</td>';
				}
			}
			$html .= '</tr>';
		}
		$html .= '<tr><td align="left" style="border-top:solid black 1.0pt;border-left:none;border-right:solid black 1.0pt;border-bottom:none;font-size:11pt;">-</td>
			  <td width="100px" align="left" style="border-top:solid black 1.0pt;border-left:none;border-right:solid black 1.0pt;border-bottom:none;font-size:11pt;">-</td>
			  <td width="100px" align="right" style="padding-right:75px;border-top:solid black 1.0pt;border-left:none;border-right:solid black 1.0pt;border-bottom:none;font-size:11pt;">-</td></tr>';
		$html .= '<tr><td align="left" style="border-top:solid black 1.0pt;border-left:none;border-right:solid black 1.0pt;border-bottom:none;font-size:11pt;">-</td>
			  <td width="100px" align="left" style="border-top:solid black 1.0pt;border-left:none;border-right:solid black 1.0pt;border-bottom:none;font-size:11pt;">-</td>
			  <td width="100px" align="right" style="padding-right:75px;border-top:solid black 1.0pt;border-left:none;border-right:solid black 1.0pt;border-bottom:none;font-size:11pt;">-</td></tr>';
		//jumlah biaya kebawah
		$html .= '<tr><td align="left" style="border-top:solid black 1.0pt;border-left:none;border-right:solid black 1.0pt;border-bottom:none;font-size:11pt;"></td>
			  <td width="100px" align="left" style="border-top:solid black 1.0pt;border-left:none;border-right:solid black 1.0pt;border-bottom:none;font-size:11pt;"></td>
			  <td width="100px" align="right" style=padding-right:40px;"border-top:solid black 1.0pt;border-left:none;border-right:solid black 1.0pt;font-size:11pt;">----------------  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; +</td></tr>';
		$html .= '<tr><td align="left" colspan="2" style="border-top:solid black 1.0pt;border-left:none;border-right:solid black 1.0pt;border-bottom:none;font-size:11pt;">Jumlah biaya</td>
			  <td align="right" style="padding-right:75px;border-top:solid black 1.0pt;border-left:none;border-right:solid black 1.0pt;border-bottom:none;font-size:11pt;"><strong>' . $fmt->formatCurrency($tb, "IDR") . '</strong></td></tr>';
		$html .= '<tr><td colspan="2" align="left" style="border-top:solid black 1.0pt;border-left:none;border-right:solid black 1.0pt;border-bottom:none;font-size:11pt;">Jumlah yang telah dibayar</td>
			  <td width="100px" align="right" style="padding-right:75px;border-top:solid black 1.0pt;border-left:none;border-right:solid black 1.0pt;font-size:11pt;">0</td></tr>';
		$html .= '<tr><td align="left" style="border-top:solid black 1.0pt;border-left:none;border-right:solid black 1.0pt;border-bottom:none;font-size:11pt;"></td>
			  <td width="100px" align="left" style="border-top:solid black 1.0pt;border-left:none;border-right:solid black 1.0pt;border-bottom:none;font-size:11pt;"></td>
			  <td width="100px" align="right" style="padding-right:40px;border-top:solid black 1.0pt;border-left:none;border-right:solid black 1.0pt;font-size:11pt;">----------------  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -</td></tr>';
		// print_r($isDp[0]->isDp);die;
		if ($isDp[0]->isDp == 1) {
			$html .= '<tr><td colspan="2" align="left" style="border-top:solid black 1.0pt;border-left:none;border-right:solid black 1.0pt;border-bottom:none;font-size:11pt;">Jumlah yang Dibayar (DP + PPN 10%)</td>
			  <td width="100px" align="right" style="padding-right:75px;border-top:solid black 1.0pt;border-bottom:none;border-left:none;border-right:solid black 1.0pt;font-size:11pt;"><strong>' . $fmt->formatCurrency($tbItem, "IDR") . '</strong></td></tr>';
		} else {
			$html .= '<tr><td colspan="2" align="left" style="border-top:solid black 1.0pt;border-left:none;border-right:solid black 1.0pt;border-bottom:none;font-size:11pt;">Pembayaran kontan</td>
			  <td width="100px" align="right" style="padding-right:75px;border-top:solid black 1.0pt;border-bottom:none;border-left:none;border-right:solid black 1.0pt;font-size:11pt;"><strong>' . $fmt->formatCurrency($tbItem, "IDR") . '</strong></td></tr>';
		}

		// $sisaBayar=$totalBiaya-$tb;
		if ($sisaBayar == 0) {
			// tidak ada sisa bayar
			$html .= '<tr><td colspan="2" align="left" style="border-top:solid black 1.0pt;border-left:none;border-right:solid black 1.0pt;border-bottom:none;font-size:11pt;">Sisa yang masih harus dibayar</td>
			  <td align="right" style="padding-right:40px;border-top:solid black 1.0pt;border-left:none;border-right:solid black 1.0pt;font-size:11pt;">0&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-</td></tr>';
		} else {
			// ada sisa bayar
			$html .= '<tr><td colspan="2" align="left" style="border-top:solid black 1.0pt;border-left:none;border-right:solid black 1.0pt;border-bottom:none;font-size:11pt;">Sisa yang masih harus dibayar</td>
			  <td align="right" style="padding-right:40px;border-top:solid black 1.0pt;border-left:none;border-right:solid black 1.0pt;font-size:11pt;">' . $fmt->formatCurrency($sisaBayar, "IDR") . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-</td></tr>';
		}
		$html .= '<tr><td colspan="2" align="left" style="border-top:solid black 1.0pt;border-left:none;border-right:solid black 1.0pt;border-bottom:none;font-size:11pt;"></td>
			  <td align="right" style="border-top:solid black 1.0pt;border-bottom:none;border-left:none;border-right:solid black 1.0pt;font-size:11pt;"></td></tr><br><br>';
		$html .= '<tr><td colspan="2" align="left" style="border-top:solid black 1.0pt;border-left:none;border-right:solid black 1.0pt;border-bottom:none;font-size:11pt;"></td>
			  <td align="center" style="border-top:solid black 1.0pt;border-left:none;border-right:solid black 1.0pt;font-size:11pt;">' . ucwords(strtolower($kantor[0]->kota)) . ', ' . $this->tgl_indo(date('Y-m-d')) . '</td></tr>';
		$html .= '<tr><td colspan="2" align="left" style="border-top:solid black 1.0pt;border-left:none;border-right:solid black 1.0pt;border-bottom:none;font-size:11pt;"></td>
			  <td align="right" style="border-top:solid black 1.0pt;border-bottom:none;border-left:none;border-right:solid black 1.0pt;font-size:11pt;"></td></tr><br><br><br><br>';
		$html .= '<tr><td colspan="2" align="left" style="border-top:solid black 1.0pt;border-left:none;border-right:solid black 1.0pt;border-bottom:none;font-size:11pt;"></td>
			  <td align="center" style="text-decoration: underline;border-top:solid black 1.0pt;border-left:none;border-right:solid black 1.0pt;font-size:11pt;">' . $nm_ttd[0]->nm_ttd . '</td></tr>';
		$html .= '<tr><td colspan="2" align="left" style="border-top:solid black 1.0pt;border-left:none;border-right:solid black 1.0pt;border-bottom:none;font-size:11pt;"></td>
			  <td align="center" style="border-top:solid black 1.0pt;border-left:none;border-right:solid black 1.0pt;font-size:11pt;">' . $nm_ttd[0]->jb_ttd . '</td></tr>';
		$html .= '</table>';
		// echo $html;die;
		$mpdf->WriteHTML($html);
		$mpdf->Output();
		echo $html;
	}


	function cetakBonUlang($no_kwit)
	{
		// session_start();
		$fmt = new NumberFormatter('en_US', NumberFormatter::CURRENCY);
		$kantor = $this->home_model->rDataKocabByKocab($this->session->userdata('kocab'))->result();
		$kocab = $kantor[0]->Code;
		// print_r($kantor[0]->Code);
		$allData = $this->home_model->rItemByNoKwit($no_kwit, $kocab)->result();
		$isDp = $this->home_model->rIsDpByNoKwit($no_kwit, $kocab)->result();
		// print_r(date("Y-m-d",strtotime($allData[0]->tgl_input)));die;
		// print_r(date('d-m-Y',$allData[0]->tgl_input));die;
		$tglbayar = date("Y-m-d", strtotime($allData[0]->tgl_bayar));
		// print_r($tglbayar);die;
		// print_r($allData);
		// die;
		$this->home_model->loginsert('Cetak ulang Bon : ' . $no_kwit . ' oleh: ' . $this->session->userdata('nipp') . ' ' . $this->session->userdata('fullname') . '', $this->session->userdata('nipp'), 'cetakBonUlang()', date('Y-m-d h:i:s'));
		$tb = 0;
		$tbItem = 0;
		foreach ($allData as $d) {
			if (!empty($d->idtb_biaya)) {
				//jika bukan pajak
				// echo $d->idtb_biaya;
				$item = $this->home_model->rTbBiayaById($d->idtb_biaya)->result();
				if ($item[0]->biaya != $d->biaya) {
					//biaya input tidak sama dengan tabel biaya
					if ($d->isDp != NULL) {
						//jika dp
						$tb = $tb + $item[0]->biaya;
						$tbItem = $tbItem + $d->biaya;
					} else {
						//bukan dp
						$tb = $tb + $d->biaya;
						$tbItem = $tbItem + $d->biaya;
					}
				} else {
					//biaya input sama dengan tabel biaya
					$tb = $tb + $item[0]->biaya;
					$tbItem = $tbItem + $item[0]->biaya;
				}
			} else {
				//jika pajak
				$tb = $tb + $d->biaya;
				$tbItem = $tbItem + $d->biaya;
			}
		}

		$sisaBayar = $tb - $tbItem;
		// var_dump($tb);
		// var_dump($tbItem);
		// var_dump($sisaBayar);die;
		// var_dump($isDp);die;
		$nm_ttd = $this->home_model->rTtdKabagByKocab($kocab)->result();
		// $totalBiaya=$item[0]->biaya+($item[0]->biaya*0.1);
		// print_r($totalBiaya);die;
		$this->load->library('mpdf/mPdf');
		$mpdf = new mPDF('c', 'A4-P', 0, '', 10, 10, 10, 10, 1, 1, 'arial');
		// $mpdf->setWatermarkImage('./images/logo.png', 1, '', array(10,2));
		$mpdf->showWatermarkImage = true;
		$html = '<div style="font-size:18pt; font-weight:bold; text-align:center; margin-bottom:0px">BPBRA</div>';
		$html .= '<div style="font-size:11pt; font-weight:bold; text-align:center; margin-top:0px">(BUKTI PEMBAYARAN BUKAN REKENING AIR)</div><hr style="width:75%; margin-bottom=0px">';
		$html .= '<p style="margin-top:0px" align="center">CU. Nomor: ' . $no_kwit . '</p>';
		$html .= '<table width="100%" style="padding:20px" border="1" frame="box">
		  <tr>
			<td rowspan="3" width="5%" align="center" style="border-top:solid black 1.0pt;border-left:solid black 1.0pt;border-right:solid black 1.0pt;border-bottom:none;font-size:10pt;">
				<img width="10%" height="10%" src="./asset/images/logo.png" alt="Logo Tirtanadi"></td>
			<td align="left" colspan="2" style="border-top:solid black 1.0pt;border-left:none;border-right:solid black 1.0pt;border-bottom:none;font-size:11pt;">PDAM Tirtanadi ' . ucwords(strtolower($kantor[0]->nama)) . '</td>
		  </tr>
		  <tr>
			  <td align="left" style="border-top:solid black 1.0pt;border-left:none;border-right:solid black 1.0pt;border-bottom:none;font-size:11pt;">' . ucwords(strtolower($kantor[0]->alamat)) . '</td>
		  </tr>
		  <tr>
			  <td align="left" style="border-top:solid black 1.0pt;border-left:none;border-right:solid black 1.0pt;border-bottom:none;font-size:11pt;">NPWP : 01.128.068.2.123.000</td>
		  </tr>
		  <tr>
			  <td align="left" colspan="3" style="border-top:solid black 1.0pt;border-left:none;border-right:solid black 1.0pt;border-bottom:none;font-size:11pt;"></td><br>
		  </tr>
		  <tr>
			  <td colspan="3" align="left" style="border-top:solid black 1.0pt;border-left:none;border-right:solid black 1.0pt;border-bottom:none;font-size:11pt;">Telah diterima uang untuk pembayaran biaya <strong>' . $allData[0]->item . '</strong> dan biaya lainnya (sesuai dengan yang tercantum pada Jenis Pembayaran) yang telah ditetapkan perusahaan terhadap pelanggan sebesar:</td><br><br>
		  </tr>
		  <tr>
			  <!-- <td width="200px" align="left" style="border-top:solid black 1.0pt;border-left:none;border-right:solid black 1.0pt;border-bottom:none;font-size:11pt;"><dl><strong>' . $fmt->formatCurrency($tb, "IDR") . '</strong></td>
			  <td align="center" style="border-top:solid black 1.0pt;border-left:none;border-right:solid black 1.0pt;border-bottom:none;font-size:11pt;"><strong>Terbilang:  ' . ucwords($this->terbilang($tb)) . ' Rupiah</strong></td><br><br> -->
			  <td width="200px" colspan="3" align="left" style="border-top:solid black 1.0pt;border-left:none;border-right:solid black 1.0pt;border-bottom:none;font-size:11pt;"><table><tr><td style="border-top:solid black 1.0pt;border-left:none;border-right:solid black 1.0pt;border-bottom:none;font-size:11pt;"><strong>' . $fmt->formatCurrency($tbItem, "IDR") . '</strong></td><td align="left" style="margin:0px;padding-left:150px;border-top:solid black 1.0pt;border-left:none;border-right:solid black 1.0pt;border-bottom:none;font-size:11pt;"><strong>Terbilang:  ' . ucwords($this->terbilang($tbItem)) . ' Rupiah</strong></td></tr></table></td>
		  </tr>
		  <tr>
			  <td colspan="3" align="center" style="border-top:solid black 1.0pt;border-left:none;border-right:solid black 1.0pt;border-bottom:none;font-size:11pt;"></td><br>
		  </tr>
		  <tr>
			  <td colspan="3" align="center" style="border-top:solid black 1.0pt;border-left:none;border-right:solid black 1.0pt;border-bottom:none;font-size:11pt;">---------------------------------------------- dari ----------------------------------------------</td><br><br>
		  </tr>
		  <tr>
			  <td align="left" style="border-top:solid black 1.0pt;border-left:none;border-right:solid black 1.0pt;border-bottom:none;font-size:11pt;">Nama </td>
			  <td align="left" colspan="2" style="border-top:solid black 1.0pt;border-left:none;border-right:solid black 1.0pt;border-bottom:none;font-size:11pt;">: ' . $allData[0]->nm_ctm . '</td>
		  </tr>
		  <tr>
			  <td align="left" style="border-top:solid black 1.0pt;border-left:none;border-right:solid black 1.0pt;border-bottom:none;font-size:11pt;">Alamat </td>
			  <td align="left" style="border-top:solid black 1.0pt;border-left:none;border-right:solid black 1.0pt;border-bottom:none;font-size:11pt;">: ' . $allData[0]->alamat . '</td>
		  </tr>
		  <tr>
			  <td align="left" style="border-top:solid black 1.0pt;border-left:none;border-right:solid black 1.0pt;border-bottom:none;font-size:11pt;">NPA/No. Reg. </td>
			  <td align="left" style="border-top:solid black 1.0pt;border-left:none;border-right:solid black 1.0pt;border-bottom:none;font-size:11pt;">: ' . $allData[0]->npa . '</td><br>
		  </tr>
		  <tr>
			  <td colspan="3" align="center" style="border-top:solid black 1.0pt;border-left:none;border-right:solid black 1.0pt;border-bottom:none;font-size:11pt;"></td><br>
		  </tr>		  
		  <tr>
			  <td colspan="2" align="left" style="border-top:solid black 1.0pt;border-left:none;border-right:solid black 1.0pt;border-bottom:none;font-size:11pt;">Dengan perincian sebagai berikut :</td><br><br>
		  </tr>		  
		  <tr>
			  <td align="left" style="border-top:solid black 1.0pt;border-left:none;border-right:solid black 1.0pt;border-bottom:none;font-size:11pt;"><strong>Rubrik</strong></td>
			  <td width="100px" align="left" style="border-top:solid black 1.0pt;border-left:none;border-right:solid black 1.0pt;border-bottom:none;font-size:11pt;"><strong>Jenis Pembayaran</strong></td>
			  <td width="100px" align="right" style="padding-right:100px;border-top:solid black 1.0pt;border-left:none;border-right:solid black 1.0pt;border-bottom:none;font-size:11pt;"><strong>Biaya</strong></td>
		  </tr>';
		// $tb=0;
		$tbNonDp = 0;
		foreach ($allData as $d) {
			//data item all
			// $tb=$tb+$d->biaya;
			$html .= '<tr>';
			$html .= '<td align="left" style="border-top:solid black 1.0pt;border-left:none;border-right:solid black 1.0pt;border-bottom:none;font-size:11pt;">' . $d->rubrik . '</td>';
			$html .= '<td align="left" style="border-top:solid black 1.0pt;border-left:none;border-right:solid black 1.0pt;border-bottom:none;font-size:11pt;">' . $d->item . '</td>';
			if ($d->idtb_biaya == '') {
				//jika pajak
				$html .= '<td align="right" style="padding-right:75px;border-top:solid black 1.0pt;border-left:none;border-right:solid black 1.0pt;border-bottom:none;font-size:11pt;">&nbsp;&nbsp;' . $fmt->formatCurrency($d->biaya, "IDR") . '</td>';
			} else {
				//bukan pajak
				if ($d->isDp == '') {
					//bukan DP
					// $itemTotal=$this->home_model->rTbBiayaById($d->idtb_biaya)->result();
					$html .= '<td align="right" width="17px" style="padding-right:75px;border-top:solid black 1.0pt;border-left:none;border-right:solid black 1.0pt;border-bottom:none;font-size:11pt;">' . $fmt->formatCurrency($d->biaya, "IDR") . '</td>';
				} else {
					//DP
					$itemTotal = $this->home_model->rTbBiayaById($d->idtb_biaya)->result();
					$html .= '<td align="right" style="padding-right:75px;border-top:solid black 1.0pt;border-left:none;border-right:solid black 1.0pt;border-bottom:none;font-size:11pt;">' . $fmt->formatCurrency($itemTotal[0]->biaya, "IDR") . '</td>';
				}
			}
			$html .= '</tr>';
		}
		$html .= '<tr><td align="left" style="border-top:solid black 1.0pt;border-left:none;border-right:solid black 1.0pt;border-bottom:none;font-size:11pt;">-</td>
			  <td width="100px" align="left" style="border-top:solid black 1.0pt;border-left:none;border-right:solid black 1.0pt;border-bottom:none;font-size:11pt;">-</td>
			  <td width="100px" align="right" style="padding-right:75px;border-top:solid black 1.0pt;border-left:none;border-right:solid black 1.0pt;border-bottom:none;font-size:11pt;">-</td></tr>';
		$html .= '<tr><td align="left" style="border-top:solid black 1.0pt;border-left:none;border-right:solid black 1.0pt;border-bottom:none;font-size:11pt;">-</td>
			  <td width="100px" align="left" style="border-top:solid black 1.0pt;border-left:none;border-right:solid black 1.0pt;border-bottom:none;font-size:11pt;">-</td>
			  <td width="100px" align="right" style="padding-right:75px;border-top:solid black 1.0pt;border-left:none;border-right:solid black 1.0pt;border-bottom:none;font-size:11pt;">-</td></tr>';
		//jumlah biaya kebawah
		$html .= '<tr><td align="left" style="border-top:solid black 1.0pt;border-left:none;border-right:solid black 1.0pt;border-bottom:none;font-size:11pt;"></td>
			  <td width="100px" align="left" style="border-top:solid black 1.0pt;border-left:none;border-right:solid black 1.0pt;border-bottom:none;font-size:11pt;"></td>
			  <td width="100px" align="right" style=padding-right:40px;"border-top:solid black 1.0pt;border-left:none;border-right:solid black 1.0pt;font-size:11pt;">----------------  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; +</td></tr>';
		$html .= '<tr><td align="left" colspan="2" style="border-top:solid black 1.0pt;border-left:none;border-right:solid black 1.0pt;border-bottom:none;font-size:11pt;">Jumlah biaya</td>
			  <td align="right" style="padding-right:75px;border-top:solid black 1.0pt;border-left:none;border-right:solid black 1.0pt;border-bottom:none;font-size:11pt;"><strong>' . $fmt->formatCurrency($tb, "IDR") . '</strong></td></tr>';
		$html .= '<tr><td colspan="2" align="left" style="border-top:solid black 1.0pt;border-left:none;border-right:solid black 1.0pt;border-bottom:none;font-size:11pt;">Jumlah yang telah dibayar</td>
			  <td width="100px" align="right" style="padding-right:75px;border-top:solid black 1.0pt;border-left:none;border-right:solid black 1.0pt;font-size:11pt;">0</td></tr>';
		$html .= '<tr><td align="left" style="border-top:solid black 1.0pt;border-left:none;border-right:solid black 1.0pt;border-bottom:none;font-size:11pt;"></td>
			  <td width="100px" align="left" style="border-top:solid black 1.0pt;border-left:none;border-right:solid black 1.0pt;border-bottom:none;font-size:11pt;"></td>
			  <td width="100px" align="right" style="padding-right:40px;border-top:solid black 1.0pt;border-left:none;border-right:solid black 1.0pt;font-size:11pt;">----------------  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -</td></tr>';
		// print_r($isDp[0]->isDp);die;
		if ($isDp[0]->isDp == 1) {
			$html .= '<tr><td colspan="2" align="left" style="border-top:solid black 1.0pt;border-left:none;border-right:solid black 1.0pt;border-bottom:none;font-size:11pt;">Jumlah yang Dibayar (DP + PPN 10%)</td>
			  <td width="100px" align="right" style="padding-right:75px;border-top:solid black 1.0pt;border-bottom:none;border-left:none;border-right:solid black 1.0pt;font-size:11pt;"><strong>' . $fmt->formatCurrency($tbItem, "IDR") . '</strong></td></tr>';
		} else {
			$html .= '<tr><td colspan="2" align="left" style="border-top:solid black 1.0pt;border-left:none;border-right:solid black 1.0pt;border-bottom:none;font-size:11pt;">Pembayaran kontan</td>
			  <td width="100px" align="right" style="padding-right:75px;border-top:solid black 1.0pt;border-bottom:none;border-left:none;border-right:solid black 1.0pt;font-size:11pt;"><strong>' . $fmt->formatCurrency($tbItem, "IDR") . '</strong></td></tr>';
		}

		// $sisaBayar=$totalBiaya-$tb;
		if ($sisaBayar == 0) {
			// tidak ada sisa bayar
			$html .= '<tr><td colspan="2" align="left" style="border-top:solid black 1.0pt;border-left:none;border-right:solid black 1.0pt;border-bottom:none;font-size:11pt;">Sisa yang masih harus dibayar</td>
			  <td align="right" style="padding-right:40px;border-top:solid black 1.0pt;border-left:none;border-right:solid black 1.0pt;font-size:11pt;">0&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-</td></tr>';
		} else {
			// ada sisa bayar
			$html .= '<tr><td colspan="2" align="left" style="border-top:solid black 1.0pt;border-left:none;border-right:solid black 1.0pt;border-bottom:none;font-size:11pt;">Sisa yang masih harus dibayar</td>
			  <td align="right" style="padding-right:40px;border-top:solid black 1.0pt;border-left:none;border-right:solid black 1.0pt;font-size:11pt;">' . $fmt->formatCurrency($sisaBayar, "IDR") . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-</td></tr>';
		}
		$html .= '<tr><td colspan="2" align="left" style="border-top:solid black 1.0pt;border-left:none;border-right:solid black 1.0pt;border-bottom:none;font-size:11pt;"></td>
			  <td align="right" style="border-top:solid black 1.0pt;border-bottom:none;border-left:none;border-right:solid black 1.0pt;font-size:11pt;"></td></tr><br><br>';
		$html .= '<tr><td colspan="2" align="left" style="border-top:solid black 1.0pt;border-left:none;border-right:solid black 1.0pt;border-bottom:none;font-size:11pt;"></td>
			  <td align="center" style="border-top:solid black 1.0pt;border-left:none;border-right:solid black 1.0pt;font-size:11pt;"> Tanggal Bayar:<br/>' . ucwords(strtolower($kantor[0]->kota)) . ', ' . $this->tgl_indo($tglbayar) . '</td></tr>';
		$html .= '<tr><td colspan="2" align="left" style="border-top:solid black 1.0pt;border-left:none;border-right:solid black 1.0pt;border-bottom:none;font-size:11pt;"></td>
			  <td align="right" style="border-top:solid black 1.0pt;border-bottom:none;border-left:none;border-right:solid black 1.0pt;font-size:11pt;"></td></tr><br><br><br><br>';
		$html .= '<tr><td colspan="2" align="left" style="border-top:solid black 1.0pt;border-left:none;border-right:solid black 1.0pt;border-bottom:none;font-size:11pt;"></td>
			  <td align="center" style="text-decoration: underline;border-top:solid black 1.0pt;border-left:none;border-right:solid black 1.0pt;font-size:11pt;">' . $nm_ttd[0]->nm_ttd . '</td></tr>';
		$html .= '<tr><td colspan="2" align="left" style="border-top:solid black 1.0pt;border-left:none;border-right:solid black 1.0pt;border-bottom:none;font-size:11pt;"></td>
			  <td align="center" style="border-top:solid black 1.0pt;border-left:none;border-right:solid black 1.0pt;font-size:11pt;">' . $nm_ttd[0]->jb_ttd . '</td></tr>';
		$html .= '</table>';
		// echo $html;die;
		$mpdf->WriteHTML($html);
		$mpdf->Output();
		echo $html;
	}


	public function cetakLppPeriode()
	{
		$fmt = new NumberFormatter('en_US', NumberFormatter::CURRENCY);
		// print_r($_POST['tglAwal']);print_r($_POST['tglAkhir']);die;
		// $kocab=$this->session->userdata('kocab');
		$kocab = $_POST['kocab'];
		$dataKocab = $this->home_model->rDataKocabByKocab($kocab)->result();
		// print_r($dataKocab);die;
		// YYYY-mm-dd dari halaman depan dan dari db
		// var_dump($_POST['tglAwal']);
		// date('format',variabel dalam format date*)
		// *kalo mau aman ganti semua variabel formatnya dengan strtotime(time)
		// $_POST['tglAwalBaru']=date('d-Y-m',strtotime($_POST['tglAwal']));
		// print_r($_POST);die;
		$tglAwal = $_POST['tglAwal'];
		$tglAkhir = $_POST['tglAkhir'];
		$dataBpbra = $this->home_model->rBpbraItemByPeriod($tglAwal, $tglAkhir, $kocab)->result();
		// print_r($kocab);die;	
		// $nm_ttd=$this->home_model->rTtdByKocab($this->session->userdata('kocab'))->result();
		$nm_ttd = $this->home_model->rTtdByKocab($kocab)->result();
		// print_r($nm_ttd);die;
		$this->load->library('mpdf/mPdf');
		$mpdf = new mPDF('c', 'A4-P', 0, '', 10, 10, 10, 10, 1, 1, 'arial');
		// $mpdf->setWatermarkImage('./images/logo.png', 1, '', array(10,2));
		$mpdf->showWatermarkImage = true;
		$html .= '<table width="100%" style="padding:0px" border="0" >
				<tr>
					<td align="center" rowspan="3" style="border-top:solid black 1.0pt;border-left:solid black 1.0pt;border-right:solid black 1.0pt;border-bottom:none;font-size:10pt;">
				<img width="50px" height="50px" src="./asset/images/logo.png" alt="Logo Tirtanadi"></td>
					<td style="font-size:14pt; font-weight:bold; text-align:center; margin-bottom:0px">Data Laporan Penerimaan Pembayaran</td>
				</tr>
				<tr>
					<td style="font-size:11pt; font-weight:bold; text-align:center; padding-top:0px; margin-top:0px">Periode: ' . date("d-m-Y", strtotime($tglAwal)) . ' s/d ' . date("d-m-Y", strtotime($tglAkhir)) . '
					</td>
				</tr>
				<tr>
					<td style="font-size:8pt; text-align:center; padding-top:0px; margin-top:0px">' . $dataKocab[0]->nama . ' ' . $dataKocab[0]->alamat . '<hr style="width:75%; margin-bottom=0px">
					</td>
				</tr>
				</table><br>';
		$html .= '<table width="100%" style="padding:0px" border="1" frame="box">
					<tr>
						<td width="5%" style="border-top:solid black 1.0pt;border-left:solid black 1.0pt;border-right:none;border-bottom:solid black 1.0pt;font-size:10pt;">No.</td>
						<td width="10%" style="border-top:solid black 1.0pt;border-left:solid black 1.0pt;border-right:none;border-bottom:solid black 1.0pt;font-size:10pt;">NPA</td>
						<td width="25%" style="border-top:solid black 1.0pt;border-left:solid black 1.0pt;border-right:none;border-bottom:solid black 1.0pt;font-size:10pt;">Nama</td>
						<td width="25%" style="border-top:solid black 1.0pt;border-left:solid black 1.0pt;border-right:none;border-bottom:solid black 1.0pt;font-size:10pt;">Alamat</td>
						<td width="10%" style="border-top:solid black 1.0pt;border-left:solid black 1.0pt;border-right:none;border-bottom:solid black 1.0pt;font-size:10pt;">Tanggal Cetak</td>
						<td width="15%" align="center" style="border-top:solid black 1.0pt;border-left:solid black 1.0pt;border-right:none;border-bottom:solid black 1.0pt;font-size:10pt;">Jumlah</td>
						<td width="20%" style="border-top:solid black 1.0pt;border-left:solid black 1.0pt;border-right:none;border-bottom:solid black 1.0pt;font-size:10pt;">Keterangan</td>
					</tr>';
		$html .=	'</table>
					<table width="100%" border="0">';
		$no = 0;
		$bt = 0;
		foreach ($dataBpbra as $db) {
			$no++;
			$bt = $bt + $db->biaya;
			$html .= '<tr>';
			$html .= '<td width="5%" style="border-top:solid black 1.0pt;border-left:solid black 1.0pt;border-right:none;border-bottom:solid black 1.0pt;font-size:10pt;">' . $no . '.</td>';
			$html .= '<td width="10%" style="border-top:solid black 1.0pt;border-left:solid black 1.0pt;border-right:none;border-bottom:solid black 1.0pt;font-size:10pt;">' . $db->npa . '</td>';
			$html .= '<td width="25%" style="border-top:solid black 1.0pt;border-left:solid black 1.0pt;border-right:none;border-bottom:solid black 1.0pt;font-size:10pt;">' . $db->nm_ctm . '</td>';
			$html .= '<td width="25%" style="border-top:solid black 1.0pt;border-left:solid black 1.0pt;border-right:none;border-bottom:solid black 1.0pt;font-size:10pt;">' . $db->alamat . '</td>';
			$html .= '<td width="10%" style="border-top:solid black 1.0pt;border-left:solid black 1.0pt;border-right:none;border-bottom:solid black 1.0pt;font-size:10pt;">' . date("d-m-Y", strtotime($db->tgl_bayar)) . '</td>';
			$html .= '<td width="15%" align="right" style="border-top:solid black 1.0pt;border-left:solid black 1.0pt;border-right:none;border-bottom:solid black 1.0pt;font-size:10pt;">' . $fmt->formatCurrency($db->biaya, "IDR") . '</td>';
			$html .= '<td width="20%" style="border-top:solid black 1.0pt;border-left:solid black 1.0pt;border-right:none;border-bottom:solid black 1.0pt;font-size:10pt;">' . $db->item . '</td>';
			$html .= '</tr>';
		}
		$html .= '<tr><td colspan="5" style="font-size:12pt;font-weight:bold;">Jumlah Total Penerimaan</td><td align="right" colspan="0" style="font-size:10pt;font-weight:bold;">' . $fmt->formatCurrency($bt, "IDR") . '</td><td align="right"style="font-size:10pt;font-weight:bold;"></td></tr>';
		$html .= '</table><br/><br/>';
		$html .= '<table width="100%" border="0">';
		$html .= '<tr>
					<td align="center">Diketahui oleh,</td>
					<td align="center">Diperiksa oleh,</td>
				</tr>
				<tr>
					<td align="center">&nbsp;</td>
					<td align="center">&nbsp;</td>
				</tr>
				<tr>
					<td align="center">&nbsp;</td>
					<td align="center">&nbsp;</td>
				</tr>
				<tr>
					<td align="center">&nbsp;</td>
					<td align="center">&nbsp;</td>
				</tr>
				<tr>
					<td align="center" style="text-decoration: underline;font-size:11pt">' . $nm_ttd[0]->nm_ttd_kacab . '</td>
					<td align="center" style="text-decoration: underline;font-size:11pt">' . $nm_ttd[0]->nm_ttd_kabag . '</td>
				</tr>
				<tr>
					<td align="center" style="margin-top:0px;font-size:11pt">' . $nm_ttd[0]->jb_ttd_kacab . '</td>
					<td align="center" style="margin-top:0px;font-size:11pt">' . $nm_ttd[0]->jb_ttd_kabag . '</td>
				</tr>';
		$html .= '</table>';
		// $html .= '<p style="margin-top:0px" align="center">Nomor: '.$no_kwit.'</p>';
		// $html .= '</table>';
		$mpdf->WriteHTML($html);
		$mpdf->Output();
		echo $html;
	}

	public function cetakBpkbPeriode()
	{
		$fmt = new NumberFormatter('en_US', NumberFormatter::CURRENCY);
		// print_r($_POST['tglAwal']);print_r($_POST['tglAkhir']);die;
		// $kocab=$this->session->userdata('kocab');
		$kocab = $_POST['kocab'];
		$kantor = $this->home_model->rDataKocabByKocab($kocab)->result();
		// print_r($kantor);die;
		$tglAwal = $_POST['tglAwal'];
		$tglAkhir = $_POST['tglAkhir'];
		$dataBpbra = $this->home_model->rBpbraItemByPeriod($tglAwal, $tglAkhir, $kocab)->result();
		// $nm_ttd=$this->home_model->rTtdByKocab($this->session->userdata('kocab'))->result();
		$nm_ttd = $this->home_model->rTtdByKocab($kocab)->result();
		$pKas = $this->home_model->rPKasByPeriod($tglAwal, $tglAkhir, $kocab)->result();
		// print_r($pKas);die;
		$this->load->library('mpdf/mPdf');
		$mpdf = new mPDF('c', 'A4-P', 0, '', 10, 10, 10, 10, 1, 1, 'arial');
		// $mpdf->setWatermarkImage('./images/logo.png', 1, '', array(10,2));
		$mpdf->showWatermarkImage = true;
		$html .= '<table width="100%" border="0">
			   <tr>
				<td rowspan="3" align="left" width="35px" style="padding:0px;margin:0px;font-size:9pt">
					<img width="35px" src="./asset/images/logo.png" alt="Logo Tirtanadi">
				</td>
				<td align="left" width="240px" style="padding:0px;margin:0px;font-size:8pt">&nbsp;PDAM Tirtanadi ' . ucwords(strtolower($kantor[0]->nama)) . '</td>
				<td rowspan="3" width="300px" align="center" style="font-size:13pt">BUKTI PENERIMAAN KAS / BANK<br/>PK Tgl: ' . date("d-m-Y", strtotime($tglAwal)) . ' s/d ' . date("d-m-Y", strtotime($tglAkhir)) . '</td>
				<td align="left" style="padding:0px;margin:0px;font-size:8pt">1. Putih</td>
				<td align="left" style="padding:0px;margin:0px;font-size:8pt">: Akuntansi</td>
			  </tr>
			  <tr>
				  <td align="left" style="padding:0px;margin:0px;font-size:8pt">&nbsp;' . ucwords(strtolower($kantor[0]->alamat)) . '</td>
				<td align="left" style="padding:0px;margin:0px;font-size:8pt">2. Merah</td>
				<td align="left" style="padding:0px;margin:0px;font-size:8pt">: Pendanaan</td>
			  </tr>
			  <tr>
				  <td align="left" style="padding:0px;margin:0px;font-size:8pt">&nbsp;NPWP : 01.128.068.2.123.000</td>
				<td align="left" style="padding:0px;margin:0px;font-size:8pt">3. Biru</td>
				<td align="left" style="padding:0px;margin:0px;font-size:8pt">: Bag/Sie/Cab Ybs</td>
			  </tr>
			</table>
			<br>
			<p style="margin-bottom:0px;font-size:11pt">Diterima dari PDAM Tirtanadi Medan</p>
			<table width="100%" border="1" style="border-collapse: collapse">
				<tr>
					<th width="90px" style="font-size:11pt">No. Perkiraan</th>
					<th width="450px" style="font-size:11pt">U R A I A N</th>
					<th width="100px" style="font-size:11pt">JUMLAH</th>
				</tr>';
		$btotal = 0;
		foreach ($pKas as $k) {
			$btotal = $btotal + $k->biaya;
			$html .= '<tr>';
			$html .= '<td>' . $k->rubrik . '</td>';
			if ($k->uraian == '') {
				$html .= '<td>' . $k->uraianlain . '</td>';
			} else {
				$html .= '<td>' . $k->uraian . '</td>';
			}
			$html .= '<td align="right">' . str_replace("Rp", "", $fmt->formatCurrency($k->biaya, "IDR")) . '</td>';
			$html .= '</tr>';
		}
		$html .= '<tr><td colspan="2"><strong>Jumlah Penerimaan Kas</strong></td><td align="right"><strong>' . str_replace("Rp", "", $fmt->formatCurrency($btotal, "IDR")) . '</strong></td></tr>';
		$html .= '</table>';
		$html .= '<strong>Terbilang: ' . ucwords($this->terbilang($btotal)) . ' Rupiah</strong><br/><br/>';
		$html .= '<table table width="100%" border="0">
				<tr><td align="center">Disetujui Oleh,</td><td align="center">Diperiksa Oleh,</td><td align="center">Dibuat Oleh,</td><td align="center">Diterima Oleh,</td></tr>
				<tr><td align="center">&nbsp;</td><td align="center">&nbsp;</td><td align="center">&nbsp;</td><td align="center">&nbsp;</td></tr>
				<tr><td align="center">&nbsp;</td><td align="center">&nbsp;</td><td align="center">&nbsp;</td><td align="center">&nbsp;</td></tr>
				<tr><td align="center" style="text-decoration: underline;font-size:9pt">' . $nm_ttd[0]->nm_ttd_kacab . '</td><td align="center" style="text-decoration: underline;font-size:9pt">' . $nm_ttd[0]->nm_ttd_kabag . '</td><td align="center" style="text-decoration: underline;font-size:9pt">' . $nm_ttd[0]->nm_ttd_ast . '</td><td align="center" style="text-decoration: underline;font-size:11pt">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td></tr>
				<tr><td align="center" style="font-size:9pt;margin-top:0px">' . $nm_ttd[0]->jb_ttd_kacab . '</td><td align="center" style="font-size:9pt;margin-top:0px">' . $nm_ttd[0]->jb_ttd_kabag . '</td><td align="center" style="font-size:9pt;margin-top:0px">' . $nm_ttd[0]->jb_ttd_ast . '</td><td align="center" style="font-size:9pt">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td></tr>
				</table>';
		// echo $html;die;
		$mpdf->WriteHTML($html);
		$mpdf->Output();
		echo $html;
	}

	public function cetakBsPeriode()
	{
		$fmt = new NumberFormatter('en_US', NumberFormatter::CURRENCY);
		// print_r($_POST['tglAwal']);print_r($_POST['tglAkhir']);die;
		// $kocab=$this->session->userdata('kocab');
		$kocab = $_POST['kocab'];
		$kantor = $this->home_model->rDataKocabByKocab($kocab)->result();
		// print_r($kantor);die;
		$tglHari = $_POST['tglHari'];
		$bank = $_POST['tujbank'];
		$noac = $_POST['noac'];
		$dataBpbra = $this->home_model->rBpbraItemByPeriod($tglAwal, $tglAkhir, $kocab)->result();
		// $nm_ttd=$this->home_model->rTtdByKocab($this->session->userdata('kocab'))->result();
		$nm_ttd = $this->home_model->rTtdByKocab($kocab)->result();
		$pKas = $this->home_model->rPKasByPeriod($tglHari, $tglHari, $kocab)->result();
		// print_r($pKas);die;
		$this->load->library('mpdf/mPdf');
		$mpdf = new mPDF('c', 'A4-P', 0, '', 10, 10, 10, 10, 1, 1, 'arial');
		// $mpdf->setWatermarkImage('./images/logo.png', 1, '', array(10,2));
		$mpdf->showWatermarkImage = true;
		$html .= '<table width="100%" border="0">
			   <tr>
				<td rowspan="3" align="left" width="35px" style="padding:0px;margin:0px;font-size:9pt">
					<img width="35px" src="./asset/images/logo.png" alt="Logo Tirtanadi">
				</td>
				<td align="left" width="250px" style="padding:0px;margin:0px;font-size:8pt">&nbsp;PDAM Tirtanadi ' . ucwords(strtolower($kantor[0]->nama)) . '</td>
				<td rowspan="3" width="250px" align="center" style="font-size:13pt">&nbsp;</td>
				<td align="left" style="padding:0px;margin:0px;font-size:8pt">1. Putih</td>
				<td align="left" style="padding:0px;margin:0px;font-size:8pt">: Akuntansi</td>
			  </tr>
			  <tr>
				  <td align="left" style="padding:0px;margin:0px;font-size:8pt">&nbsp;' . ucwords(strtolower($kantor[0]->alamat)) . '</td>
				<td align="left" style="padding:0px;margin:0px;font-size:8pt">2. Merah</td>
				<td align="left" style="padding:0px;margin:0px;font-size:8pt">: Pendanaan</td>
			  </tr>
			  <tr>
				  <td align="left" style="padding:0px;margin:0px;font-size:8pt">&nbsp;NPWP : 01.128.068.2.123.000</td>
				<td align="left" style="padding:0px;margin:0px;font-size:8pt">3. Biru</td>
				<td align="left" style="padding:0px;margin:0px;font-size:8pt">: Bag/Sie/Cab Ybs</td>
			  </tr>
			</table>
			<br>
			<p style="margin-bottom:0px;font-size:11pt">BUKTI SETORAN KE ' . $bank . '<br>AC NOMOR : ' . $noac . '</p>
			<p align="right" style="margin-up:0px;font-size:11pt">' . ucwords(strtolower($kantor[0]->kota)) . ', ' . $this->tgl_indo($tglHari) . '</p>
			<table width="100%" border="1" style="border-collapse: collapse">
				<tr>
					<th width="90px" style="font-size:11pt">No. Perkiraan</th>
					<th width="450px" style="font-size:11pt">&nbsp;</th>
					<th width="100px" style="font-size:11pt">JUMLAH</th>
				</tr>';
		$btotal = 0;
		$bSubAll = 0;
		$bSubPpn = 0;
		foreach ($pKas as $k) {
			if ($k->uraian == '') {
				$bSubPpn = $bSubPpn + $k->biaya;
			} else {
				$bSubAll = $bSubAll + $k->biaya;
			}
		}
		$btotal = $bSubAll + $bSubPpn;
		$html .= '<tr><td>11.01.00.' . $kocab . '</td><td align="center" style="padding:10px">S E T O R A N<br/>PENERIMAAN KAS ' . $kantor[0]->nama . '<br/>Tanggal ' . date("d-m-Y", strtotime($tglHari)) . ' TUNAI .....</td><td align="right">' . str_replace("Rp", "", $fmt->formatCurrency($btotal, "IDR")) . '</td></tr>';
		// $html .= '<tr><td>50.06.50.'.$kocab.'</td><td align="left">PPN 10 %</td><td align="right">'.str_replace("Rp", "", $fmt->formatCurrency($bSubPpn,"IDR")).'</td></tr>';
		$html .= '<tr></tr>';
		$html .= '<tr><td colspan="2"><strong>T O T A L</strong></td><td align="right"><strong>' . str_replace("Rp", "", $fmt->formatCurrency($btotal, "IDR")) . '</strong></td></tr>';
		$html .= '</table>';
		$html .= '<strong>Terbilang: ' . ucwords($this->terbilang($btotal)) . ' Rupiah</strong><br/><br/><br/>';
		$html .= '<table table width="100%" border="0">
				<tr><td align="center">Disetujui Oleh,</td><td align="center">Diperiksa Oleh,</td><td align="center">Dibuat Oleh,</td><td align="center">Diterima Oleh,</td></tr>
				<tr><td align="center">&nbsp;</td><td align="center">&nbsp;</td><td align="center">&nbsp;</td><td align="center">&nbsp;</td></tr>
				<tr><td align="center">&nbsp;</td><td align="center">&nbsp;</td><td align="center">&nbsp;</td><td align="center">&nbsp;</td></tr>
				<tr><td align="center" style="text-decoration: underline;font-size:9pt">' . $nm_ttd[0]->nm_ttd_kacab . '</td><td align="center" style="text-decoration: underline;font-size:9pt">' . $nm_ttd[0]->nm_ttd_kabag . '</td><td align="center" style="text-decoration: underline;font-size:9pt">' . $nm_ttd[0]->nm_ttd_ast . '</td><td align="center" style="text-decoration: underline;font-size:9pt">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td></tr>
				<tr><td align="center" style="font-size:9pt;margin-top:0px">' . $nm_ttd[0]->jb_ttd_kacab . '</td><td align="center" style="font-size:9pt;margin-top:0px">' . $nm_ttd[0]->jb_ttd_kabag . '</td><td align="center" style="font-size:9pt;margin-top:0px">' . $nm_ttd[0]->jb_ttd_ast . '</td><td align="center" style="font-size:9pt">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td></tr>
				</table>';
		// echo $html;die;
		$mpdf->WriteHTML($html);
		$mpdf->Output();
		echo $html;
	}

	public function cetakTranPerbulan()
	{
		$fmt = new NumberFormatter('en_US', NumberFormatter::CURRENCY);
		// print_r($_POST['tglAwal']);print_r($_POST['tglAkhir']);die;
		// $kocab=$this->session->userdata('kocab');
		$kocab = $_POST['kocab'];
		$kantor = $this->home_model->rDataKocabByKocab($kocab)->result();
		// print_r($kantor);die;
		// print_r($pKas);die;
		$tahun = $_POST['tahun'];
		$bulan = $_POST['bulan'];
		$dataRubrik = $this->home_model->rDataKdPerkiraan($kocab)->result();
		$dataTrans = $this->home_model->rDataTransPerbulanByKocab($kocab, $tahun, $bulan)->result();
		$dataTglTrans = $this->home_model->rDataTglTransByKocab($kocab, $tahun, $bulan)->result();
		$nm_ttd = $this->home_model->rTtdByKocab($kocab)->result();
		// print_r($dataRubrik);
		// print_r($dataTrans);
		// print_r($dataTglTrans);
		// die;
		$this->load->library('mpdf/mPdf');
		$mpdf = new mPDF('c', 'A4-L', 0, '', 10, 10, 10, 10, 1, 1, 'arial');
		// $mpdf->setWatermarkImage('./images/logo.png', 1, '', array(10,2));
		$mpdf->showWatermarkImage = true;
		$html .= '<table width="100%" border="0">
			   <tr>
				<td rowspan="3" align="left" width="35px" style="padding:0px;margin:0px;font-size:9pt">
					<img width="35px" src="./asset/images/logo.png" alt="Logo Tirtanadi">
				</td>
				<td align="left" width="250px" style="padding:0px;margin:0px;font-size:8pt">&nbsp;PDAM Tirtanadi ' . ucwords(strtolower($kantor[0]->nama)) . '</td>
				<td rowspan="3" width="800px" align="center" style="font-size:12pt">REKAP HARIAN TAGIHAN REKENING NON AIR<br/>BULAN ' . strtoupper($this->tgl_indo(date('' . $tahun . '-' . $bulan . ''))) . '</td>
			  </tr>
			  <tr>
				  <td align="left" style="padding:0px;margin:0px;font-size:8pt">&nbsp;' . ucwords(strtolower($kantor[0]->alamat)) . '</td>
			  </tr>
			  <tr>
				  <td align="left" style="padding:0px;margin:0px;font-size:8pt">&nbsp;NPWP : 01.128.068.2.123.000</td>
			  </tr>
			</table><br><br>';
		$html .= '<table width="100%" style="border-collapse:collapse">
			   <tr style="border: 1px solid black">
			   		<th width="20px" style="font-size:7pt" >No.</th>
			   		<th width="20px" style="font-size:7pt" >Tanggal</th>';
		foreach ($dataRubrik as $dr) {
			$html .= '<th width="40px" align="right" style="font-size:7pt" >' . $dr->abreviasi . '</th>';
		}
		$html .= '<th width="30px" align="right" style="font-size:7pt">Jumlah (Rupiah)</th>	
				</tr>';
		// </table>';
		// $html .= '<table width="100%" border="1">';
		$no = 1;
		foreach ($dataTglTrans as $tgl) {
			$totalSum = 0;
			$html .= '<tr>
			<td align="center" style="font-size:8pt">' . $no . '.</td>
			<td align="center" style="font-size:8pt">' . date("d-m-Y", strtotime($tgl->tgl_bayar)) . '</td>';
			foreach ($dataRubrik as $dr) {
				$sumKoPer = $this->home_model->rSumKoperByDate($kocab, $tgl->tgl_bayar, $dr->koPer)->result();
				// print_r($sumKoPer);//die;
				if ($sumKoPer == NULL) {
					$html .= '<td align="right" style="font-size:8pt">0</td>';
				} else {
					$totalSum = $totalSum + $sumKoPer[0]->sum;
					$html .= '<td align="right" style="font-size:8pt">' . str_replace("Rp", "", $fmt->formatCurrency($sumKoPer[0]->sum, "IDR")) . '</td>';
				}
			}
			$html .= '<td align="right" style="font-size:8pt">' . str_replace("Rp", "", $fmt->formatCurrency($totalSum, "IDR")) . '</td>';
			$html .= '</tr>';
			$no++;
		}
		$html .= '<tr style="border-top: 1px solid black;border-left: 1px solid black;border-right: 1px solid black;border-bottom: none;">
					<td colspan="2" style="font-size:8pt;font-weight: bold;border-right: 1px solid black;">Total Jumlah</td>';
		$totalSum = 0;
		foreach ($dataRubrik as $dr) {
			$sumKoPer = $this->home_model->rSumKoperByMonthYear($kocab, $bulan, $tahun, $dr->koPer)->result();
			if ($sumKoPer == NULL) {
				$html .= '<td align="right" style="font-size:8pt;font-weight: bold;">0</td>';
			} else {
				$totalSum = $totalSum + $sumKoPer[0]->sum;
				$html .= '<td align="right" style="font-size:8pt;font-weight: bold;">' . str_replace("Rp", "", $fmt->formatCurrency($sumKoPer[0]->sum, "IDR")) . '</td>';
			}
		}
		$html .= '<td align="right" style="font-size:8pt;font-weight: bold;">' . str_replace("Rp", "", $fmt->formatCurrency($totalSum, "IDR")) . '</td></tr>';
		$html .= '<tr style="border-top:none;border-left: 1px solid black;border-right: 1px solid black;border-bottom: 1px solid black;">
					<td colspan="2" style="font-size:8pt;font-weight: bold;border-right: 1px solid black;">Total Jumlah Item</td>';
		$totalSum = 0;
		foreach ($dataRubrik as $dr) {
			$countKoPer = $this->home_model->rCountKoperByMonthYear($kocab, $bulan, $tahun, $dr->koPer)->result();
			if ($countKoPer == NULL) {
				$html .= '<td align="right" style="font-size:8pt;font-weight: bold;">0</td>';
			} else {
				$totalSum = $totalSum + $countKoPer[0]->sum;
				$html .= '<td align="right" style="font-size:8pt;font-weight: bold;">' . $countKoPer[0]->sum . '</td>';
			}
		}
		$html .= '<td align="right" style="font-size:8pt;font-weight: bold;">' . $totalSum . '</td></tr>';
		$html .= '</table>'; // echo $html;die;
		$html .= '<br/><br/><table width="100%" border="0">';
		$html .= '<tr>
					<td align="center">&nbsp;</td>
					<td align="center">Tanggal Cetak: ' . date('d-m-Y H:i:s') . '</td>
				</tr>
				<tr>
					<td align="center">Diketahui oleh,</td>
					<td align="center">Diperiksa oleh,</td>
				</tr>
				<tr>
					<td align="center">&nbsp;</td>
					<td align="center">&nbsp;</td>
				</tr>
				<tr>
					<td align="center">&nbsp;</td>
					<td align="center">&nbsp;</td>
				</tr>
				<tr>
					<td align="center">&nbsp;</td>
					<td align="center">&nbsp;</td>
				</tr>
				<tr>
					<td align="center" style="text-decoration: underline;font-size:11pt">' . $nm_ttd[0]->nm_ttd_kacab . '</td>
					<td align="center" style="text-decoration: underline;font-size:11pt">' . $nm_ttd[0]->nm_ttd_kabag . '</td>
				</tr>
				<tr>
					<td align="center" style="margin-top:0px;font-size:11pt">' . $nm_ttd[0]->jb_ttd_kacab . '</td>
					<td align="center" style="margin-top:0px;font-size:11pt">' . $nm_ttd[0]->jb_ttd_kabag . '</td>
				</tr>';
		$html .= '</table>';
		$mpdf->WriteHTML($html);
		$mpdf->Output();
		echo $html;
	}

	public function cetakFormPerBuku()
	{
	}
}
