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

	public function cetakFormPerBuku()
	{
		$fmt = new NumberFormatter('en_US', NumberFormatter::CURRENCY);
		$kocab = $_POST['kocab'];
		$nobuku = $_POST['nobuku'];
		$ctm = $this->home_model->getActvCtmByNoBuku($kocab, $nobuku)->result();
		$kantor = $this->home_model->rDataKocabByKocab($kocab)->result();
		$count = 0;
		$size = count($ctm);
		// print_r(count($ctm));
		// die;

		$this->load->library('mpdf/mPdf');
		$mpdf = new mPDF('c', 'A4-P', 0, '', 10, 10, 10, 10, 1, 1, 'arial');
		$mpdf->showWatermarkImage = true;
		foreach ($ctm as $c) {
			$count++;
			$html = '<table width="100%" border="0">
			   <tr>
				<td rowspan="3" align="left" width="35px" style="padding:0px;margin:0px;font-size:9pt">
					<img width="45px" src="./asset/images/logo.png" alt="Logo Tirtanadi">
				</td>
				<td align="center" style="padding:0px;margin:0px;font-size:14pt">FORM DATA PELANGGAN</td>
			  </tr>
			</table>
			<br>
			<table border="1" width="100%" style="border-collapse: collapse;border: 1px solid black;">
				<tr>
					<th align="center" width="1%" style="font-size:12pt">A.</th>
					<th colspan="4" align="left" width="99%" style="font-size:12pt">DATA PELANGGAN</th>
				</tr>
				<tr>
					<td align="center" width="1%" style="font-size:12pt">1.</td>
					<td align="left" width="29%" style="font-size:12pt"><strong>NPA</strong></td>
					<td colspan="3" align="left" width="70%" style="font-size:12pt">&nbsp; ' . $c->npa . '</td>
				</tr>
				<tr>
					<td rowspan="2" align="center" width="1%" style="font-size:12pt">2.</td>
					<td rowspan="2" align="left" width="29%" style="font-size:12pt"><strong>Nama</strong></td>
					<td align="center" width="1%" style="font-size:12pt"><strong>Pelanggan</strong></td>
					<td align="center" width="1%" style="font-size:12pt"><strong>Pemilik</strong></td>
					<td align="center" width="1%" style="font-size:12pt"><strong>Penghuni</strong></td>
				</tr>
				<tr>
					<td align="left" width="1%" style="font-size:12pt">&nbsp; ' . $c->na_ctm . '</td>
					<td align="left" width="1%" style="font-size:12pt">&nbsp;</td>
					<td align="left" width="1%" style="font-size:12pt">&nbsp;</td>
				</tr>
				<tr>
					<td align="center" width="1%" style="font-size:12pt">3.</td>
					<td align="left" width="1%" style="font-size:12pt"><strong>No.Telpon</strong></td>
					<td align="center" width="1%" style="font-size:12pt">&nbsp;</td>
					<td align="center" width="1%" style="font-size:12pt">&nbsp;</td>
					<td align="center" width="1%" style="font-size:12pt">&nbsp;</td>
				</tr>
				<tr>
					<td align="center" width="1%" style="font-size:12pt">4.</td>
					<td align="left" width="1%" style="font-size:12pt"><strong>HP/WA</strong></td>
					<td align="center" width="1%" style="font-size:12pt">&nbsp;</td>
					<td align="center" width="1%" style="font-size:12pt">&nbsp;</td>
					<td align="center" width="1%" style="font-size:12pt">&nbsp;</td>
				</tr>
				<tr>
					<td align="center" width="1%" style="font-size:12pt">5.</td>
					<td align="left" width="1%" style="font-size:12pt"><strong>Email</strong></td>
					<td align="center" width="1%" style="font-size:12pt">&nbsp;</td>
					<td align="center" width="1%" style="font-size:12pt">&nbsp;</td>
					<td align="center" width="1%" style="font-size:12pt">&nbsp;</td>
				</tr>
				<tr>
					<td align="center" width="1%" style="font-size:12pt">6.</td>
					<td align="left" width="1%" style="font-size:12pt"><strong>No.KTP</strong></td>
					<td align="center" width="1%" style="font-size:12pt">&nbsp;</td>
					<td align="center" width="1%" style="font-size:12pt">&nbsp;</td>
					<td align="center" width="1%" style="font-size:12pt">&nbsp;</td>
				</tr>
				<tr>
					<td align="center" width="1%" style="font-size:12pt">7.</td>
					<td colspan="4" align="left" width="1%" style="font-size:12pt"><strong>Alamat Sesuai NPA</strong></td>
				</tr>
				<tr>
					<td align="left" width="1%" style="font-size:12pt">&nbsp;</td>
					<td align="left" width="1%" style="font-size:12pt"><strong>Jalan</strong></td>
					<td colspan="3" align="left" width="1%" style="font-size:12pt">&nbsp; ' . $c->alamat . ' ' . $c->no_rmh . '</td>
				</tr>
				<tr>
					<td align="left" width="1%" style="font-size:12pt">&nbsp;</td>
					<td align="left" width="1%" style="font-size:12pt"><strong>Kelurahan</strong></td>
					<td colspan="3" align="left" width="1%" style="font-size:12pt">&nbsp; ' . $c->kelurahan . '</td>
				</tr>
				<tr>
					<td align="left" width="1%" style="font-size:12pt">&nbsp;</td>
					<td align="left" width="1%" style="font-size:12pt"><strong>Kecamatan</strong></td>
					<td colspan="3" align="left" width="1%" style="font-size:12pt">&nbsp; ' . $c->kecamatan . '</td>
				</tr>
				<tr>
					<td align="left" width="1%" style="font-size:12pt">&nbsp;</td>
					<td align="left" width="1%" style="font-size:12pt"><strong>Kabupaten/Kota</strong></td>
					<td colspan="3" align="left" width="1%" style="font-size:12pt">&nbsp; ' . $c->kabupaten . '</td>
				</tr>
				<tr>
					<th align="center" width="1%" style="font-size:12pt">B.</th>
					<th colspan="4" align="left" width="90%" style="font-size:12pt">KONDISI TARIF</th>
				</tr>
				<tr>
					<td align="center" width="1%" style="font-size:12pt">1.</td>
					<td align="left" width="1%" style="font-size:12pt"><strong>Tarif Saat Ini</strong></td>
					<td colspan="3" align="left" width="90%" style="font-size:12pt">&nbsp; ' . $c->tarif . '</td>
				</tr>
				<tr>
					<td align="center" width="1%" style="font-size:12pt">2.</td>
					<td align="left" width="1%" style="font-size:12pt"><strong>Luas Bangunan</strong></td>
					<td colspan="3" align="left" width="90%" style="font-size:12pt">&nbsp; ' . $c->luas . '</td>
				</tr>
				<tr>
					<td align="center" width="1%" style="font-size:12pt">3.</td>
					<td align="left" width="1%" style="font-size:12pt"><strong>Kegiatan Usaha Pada Persil</strong></td>
					<td align="left" width="1%" style="font-size:12pt"><input type="checkbox">Ada</input></td>
					<td colspan="2" align="left" width="1%" style="font-size:12pt"><input type="checkbox">Tidak Ada</input></td>
				</tr>
				<tr>
					<td height="100px" align="left" width="1%" style="font-size:12pt">&nbsp;</td>
					<td height="100px" align="left" width="1%" style="font-size:12pt"><strong>Jika Ada, Sebutkan</strong></td>
					<td height="100px" colspan="3" align="left" width="1%" style="font-size:12pt">&nbsp;</td>
				</tr>
				<tr>
					<td align="left" width="1%" style="font-size:12pt">&nbsp;</td>
					<td align="left" width="1%" style="font-size:12pt"><strong>Skala Usaha</strong></td>
					<td align="left" width="1%" style="font-size:12pt"><input type="checkbox">Kecil</input></td>
					<td align="left" width="1%" style="font-size:12pt"><input type="checkbox">Sedang</input></td>
					<td align="left" width="1%" style="font-size:12pt"><input type="checkbox">Besar</input></td>
				</tr>
			</table>
			<br>
			<table width="100%">
			<tr>
			<td width="50%">&nbsp;</td>
			<td width="50%" align="center" style="font-size:12pt">Medan,&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . date('Y') . '</td>
			</tr>
			<tr>
			<td width="50%">&nbsp;</td>
			<td width="50%" align="center" style="font-size:12pt">Pemberi Data</td>
			</tr>
			<tr>
			<td width="50%">&nbsp;</td>
			<td width="50%" align="center">&nbsp;</td>
			</tr>
			<tr>
			<td width="50%">&nbsp;</td>
			<td width="50%" align="center">&nbsp;</td>
			</tr>
			<tr>
			<td width="50%">&nbsp;</td>
			<td width="50%" align="center">&nbsp;</td>
			</tr>
			<tr>
			<td width="50%">&nbsp;</td>
			<td width="50%" align="center">&nbsp;</td>
			</tr>
			<tr>
			<td width="50%">&nbsp;</td>
			<td width="50%" align="center" style="font-size:12pt">(.......................................)</td>
			</tr>
			</table>
			<br>
			<br><br>
			<table border="1" width="100%" style="border-collapse: collapse;border: 1px solid black;">
				<tr>
					<th align="left" width="25%" style="font-size:12pt"><strong>Uraian</strong></th>
					<th align="center" width="25%" style="font-size:12pt">Pendataan</th>
					<th align="center" width="25%" style="font-size:12pt">Verifikasi</th>
					<th align="center" width="25%" style="font-size:12pt">Input</th>
				</tr>
				<tr>
					<td align="left" width="25%" style="font-size:12pt"><strong>Nama Petugas</strong></td>
					<td align="center" width="25%" style="font-size:12pt">&nbsp;</td>
					<td align="center" width="25%" style="font-size:12pt">&nbsp;</td>
					<td align="center" width="25%" style="font-size:12pt">&nbsp;</td>
				</tr>
				<tr>
					<td align="left" width="25%" style="font-size:12pt"><strong>NIP/NIK</strong></td>
					<td align="center" width="25%" style="font-size:12pt">&nbsp;</td>
					<td align="center" width="25%" style="font-size:12pt">&nbsp;</td>
					<td align="center" width="25%" style="font-size:12pt">&nbsp;</td>
				</tr>
				<tr>
					<td align="left" width="25%" style="font-size:12pt"><strong>Tanggal</strong></td>
					<td align="center" width="25%" style="font-size:12pt">&nbsp;</td>
					<td align="center" width="25%" style="font-size:12pt">&nbsp;</td>
					<td align="center" width="25%" style="font-size:12pt">&nbsp;</td>
				</tr>
				<tr>
					<td align="left" width="25%" style="font-size:12pt"><strong>Tanda Tangan</strong></td>
					<td align="center" width="25%" style="font-size:12pt">&nbsp;</td>
					<td align="center" width="25%" style="font-size:12pt">&nbsp;</td>
					<td align="center" width="25%" style="font-size:12pt">&nbsp;</td>
				</tr>
			</table>';
			// echo $html;die;
			$mpdf->WriteHTML($html);
			if ($count < $size) {
				# code...
				$mpdf->AddPage();
			}
		}
		// $mpdf->WriteHTML($html);
		$mpdf->Output();
		echo $html;
	}
}
