<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Home_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		// $result = mssql_query("SET ANSI_NULLS ON;");
		// $result = mssql_query("SET ANSI_WARNINGS ON;");
	}

	public function getNpaCustom($query)
	{
		$result = $this->db->query("SELECT TOP 10 npa, na_ctm, status, ket_status, tarif, alamat, no_rmh, ketstatus, kabu, kabupaten, keca, kecamatan, kelu, kelurahan FROM view_custom WHERE npa like '" . $query . "%'");
		return $result;
	}

	//koneksi ke cabang tapsel
	public function getNoRegTapsel($query)
	{
		$dbPsb = $this->load->database('db14', TRUE);
		$result = $dbPsb->query("SELECT TOP 10 no_reg, nama, alamat, tarip as tarif FROM register WHERE no_reg like '" . $query . "%'");
		return $result;
	}

	//koneksi ke cabang berastagi
	public function getNoRegBrstg($query)
	{
		$dbPsb = $this->load->database('db06', TRUE);
		$result = $dbPsb->query("SELECT TOP 10 no_reg, nama, alamat, tarip as tarif FROM register WHERE no_reg like '" . $query . "%'");
		return $result;
	}

	//koneksi ke cabang samosir
	public function getNoRegSamosir($query)
	{
		$dbPsb = $this->load->database('db22', TRUE);
		$result = $dbPsb->query("SELECT TOP 10 no_reg, nama, alamat, tarip as tarif FROM register WHERE no_reg like '" . $query . "%'");
		return $result;
	}

	//koneksi ke cabang tobasa
	public function getNoRegTobasa($query)
	{
		$dbPsb = $this->load->database('db17', TRUE);
		$result = $dbPsb->query("SELECT TOP 10 no_reg, nama, alamat, tarip as tarif FROM register WHERE no_reg like '" . $query . "%'");
		return $result;
	}

	//koneksi ke cabang tapteng
	public function getNoRegTapteng($query)
	{
		$dbPsb = $this->load->database('db16', TRUE);
		$result = $dbPsb->query("SELECT TOP 10 no_reg, nama, alamat, tarip as tarif FROM register WHERE no_reg like '" . $query . "%'");
		return $result;
	}

	//koneksi ke cabang sibolangit
	public function getNoRegSibolangit($query)
	{
		$dbPsb = $this->load->database('db05', TRUE);
		$result = $dbPsb->query("SELECT TOP 10 no_reg, nama, alamat, tarip as tarif FROM register WHERE no_reg like '" . $query . "%'");
		return $result;
	}

	public function rBpbraDayByKocab($kocab, $tglhariIni)
	{
		$result = $this->db->query("SELECT no_kwitansi, npa, nm_ctm, alamat, (select top 1 item from tb_bpbra_item where tb_bpbra_item.no_kwitansi=tb_bpbra.no_kwitansi) item FROM tb_bpbra WHERE tgl_bayar BETWEEN '$tglhariIni 00:00:00' AND '$tglhariIni 23:59:59' AND kocab='$kocab' AND isDelete IS NULL");
		return $result;
	}

	public function rBpbraMonthByKocab($kocab, $bulan, $tahun)
	{
		$result = $this->db->query("SELECT tgl_bayar, no_kwitansi, npa, nm_ctm, alamat, (select top 1 item from tb_bpbra_item where tb_bpbra_item.no_kwitansi=tb_bpbra.no_kwitansi and tb_bpbra_item.kocab=tb_bpbra.kocab) item FROM tb_bpbra WHERE kocab='$kocab' AND MONTH(tgl_bayar)='$bulan' AND YEAR(tgl_bayar)='$tahun' AND isDelete IS NULL ORDER BY tgl_bayar ASC");
		return $result;
	}

	public function getNipp($query, $qKocab)
	{
		$result = $this->db->query("SELECT TOP 10 NIPP, fullname, FixFullWorkUnitName FROM view_employeeActiveUnit WHERE NIPP like '%" . $query . "%' " . $qKocab . "");
		return $result;
	}


	public function rBiayaByKocab($kocab)
	{
		$result = $this->db->query("SELECT * FROM tb_biaya WHERE kocab='$kocab' AND isDelete IS NULL");
		return $result;
	}

	public function rBiayaPsbByKocab($kocab)
	{
		$result = $this->db->query("SELECT * FROM tb_biaya WHERE kocab='$kocab' AND isPsb='1' AND isDelete IS NULL");
		return $result;
	}

	public function rTbBiayaById($id)
	{
		$result = $this->db->query("SELECT *, convert(varchar,cast(biaya*(CAST(ppn AS decimal(5,2))/100) as money)) as pajak FROM tb_biaya WHERE id='$id'");
		return $result;
	}

	public function iTblBpbra($no_kwitansi, $kocab, $tgl_bayar, $npa, $nm_ctm, $alamat, $inputby_nipp, $inputby_name, $tgl_input)
	{
		try {
			$result = $this->db->query("INSERT INTO [dbo].[tb_bpbra] ([no_kwitansi], [kocab], [tgl_bayar], [npa], [nm_ctm], [alamat], [inputby_nipp], [inputby_name], [tgl_input]) VALUES('$no_kwitansi','$kocab','$tgl_bayar', '$npa', '$nm_ctm', '$alamat', '$inputby_nipp','$inputby_name','$tgl_input')");
			return $this->db->insert_id();
		} catch (Exception $e) {
			return $this->db->error();
		}
	}

	public function iTblBpbraPsb($no_kwitansi, $kocab, $tgl_bayar, $npa, $nm_ctm, $alamat, $inputby_nipp, $inputby_name, $tgl_input)
	{
		try {
			$result = $this->db->query("INSERT INTO [dbo].[tb_bpbra] ([no_kwitansi], [kocab], [tgl_bayar], [npa], [nm_ctm], [alamat], [inputby_nipp], [inputby_name], [tgl_input], [isPsb]) VALUES('$no_kwitansi','$kocab','$tgl_bayar', '$npa', '$nm_ctm', '$alamat', '$inputby_nipp','$inputby_name','$tgl_input','1')");
			return $this->db->insert_id();
		} catch (Exception $e) {
			return $this->db->error();
		}
	}

	public function iTblBpbraCicil($no_kwitansi, $kocab, $tgl_bayar, $npa, $nm_ctm, $alamat, $inputby_nipp, $inputby_name, $tgl_input, $cicil)
	{
		try {
			$result = $this->db->query("INSERT INTO [dbo].[tb_bpbra] ([no_kwitansi], [kocab], [tgl_bayar], [npa], [nm_ctm], [alamat], [inputby_nipp], [inputby_name], [tgl_input], [isDp]) VALUES('$no_kwitansi','$kocab','$tgl_bayar', '$npa', '$nm_ctm', '$alamat', '$inputby_nipp','$inputby_name','$tgl_input','$cicil')");
			return $this->db->insert_id();
		} catch (Exception $e) {
			return $this->db->error();
		}
	}

	public function iTblBpbraCicilPsb($no_kwitansi, $kocab, $tgl_bayar, $npa, $nm_ctm, $alamat, $inputby_nipp, $inputby_name, $tgl_input, $cicil)
	{
		try {
			$result = $this->db->query("INSERT INTO [dbo].[tb_bpbra] ([no_kwitansi], [kocab], [tgl_bayar], [npa], [nm_ctm], [alamat], [inputby_nipp], [inputby_name], [tgl_input], [isDp]) VALUES('$no_kwitansi','$kocab','$tgl_bayar', '$npa', '$nm_ctm', '$alamat', '$inputby_nipp','$inputby_name','$tgl_input','$cicil')");
			return $this->db->insert_id();
		} catch (Exception $e) {
			return $this->db->error();
		}
	}

	public function iTblCicilan($no_kwitansi, $idBpbra, $kocab, $tgl_bayar, $rubrik, $item, $biaya, $npa, $nm_ctm, $alamat, $idtb_biaya, $inputby_nipp, $inputby_name, $tgl_input, $ppn, $prefixItem, $prefixPpn, $isNotPpn)
	{
		try {
			$result = $this->db->query("INSERT INTO [dbo].[tb_bpbra_item] ([no_kwitansi], [idBpbra], [kocab], [tgl_bayar], [rubrik], [item], [biaya], [npa], [nm_ctm], [alamat], [idtb_biaya], [inputby_nipp], [inputby_name], [tgl_input]) VALUES('$no_kwitansi','$idBpbra','$kocab','$tgl_bayar','$rubrik','$item $prefixItem',$biaya, '$npa', '$nm_ctm', '$alamat', $idtb_biaya, '$inputby_nipp','$inputby_name','$tgl_input')");
			// pajak
			// insert pajak jika bukan:
			// 1. Sambungan Baru
			// 2. Sambungan Kembali Baru PSKB
			// 3. Sambungan Kembali
			// 4. Sambungan Kembali Baru
			if ($isNotPpn === 1) {
				// bebas PPN
				// echo 'bebas ppn';
				// die;
				$result = $this->db->query("INSERT INTO [dbo].[tb_bpbra_item] ([no_kwitansi], [idBpbra], [kocab], [tgl_bayar], [rubrik], [item], [biaya], [npa], [nm_ctm], [alamat], [inputby_nipp], [inputby_name], [tgl_input]) VALUES('$no_kwitansi','$idBpbra','$kocab','$tgl_bayar','50.06.50.00','PPN 10 % $prefixPpn','0', '$npa', '$nm_ctm', '$alamat', '$inputby_nipp','$inputby_name','$tgl_input')");
				return 0;
			} else {
				// kena PPN
				// echo 'kena ppn';
				// die;
				$result = $this->db->query("INSERT INTO [dbo].[tb_bpbra_item] ([no_kwitansi], [idBpbra], [kocab], [tgl_bayar], [rubrik], [item], [biaya], [npa], [nm_ctm], [alamat], [inputby_nipp], [inputby_name], [tgl_input]) VALUES('$no_kwitansi','$idBpbra','$kocab','$tgl_bayar','50.06.50.00','PPN 10 % $prefixPpn','$ppn', '$npa', '$nm_ctm', '$alamat', '$inputby_nipp','$inputby_name','$tgl_input')");
				return 0;
			}
		} catch (Exception $e) {
			return $this->db->error();
		}
	}

	public function iTblCicilanPsb($no_kwitansi, $idBpbra, $kocab, $tgl_bayar, $rubrik, $item, $biaya, $npa, $nm_ctm, $alamat, $idtb_biaya, $inputby_nipp, $inputby_name, $tgl_input, $ppn, $prefixItem, $prefixPpn, $isNotPpn)
	{
		try {
			$result = $this->db->query("INSERT INTO [dbo].[tb_bpbra_item] ([no_kwitansi], [idBpbra], [kocab], [tgl_bayar], [rubrik], [item], [biaya], [npa], [nm_ctm], [alamat], [idtb_biaya], [inputby_nipp], [inputby_name], [tgl_input], [isPsb]) VALUES('$no_kwitansi','$idBpbra','$kocab','$tgl_bayar','$rubrik','$item $prefixItem',$biaya, '$npa', '$nm_ctm', '$alamat', $idtb_biaya, '$inputby_nipp','$inputby_name','$tgl_input','1')");
			// pajak
			// insert pajak jika bukan:
			// 1. Sambungan Baru
			// 2. Sambungan Kembali Baru PSKB
			// 3. Sambungan Kembali
			// 4. Sambungan Kembali Baru
			// echo 'tblcicilanpsb';
			// die;
			if ($isNotPpn === 1) {
				// bebas PPN
				$result = $this->db->query("INSERT INTO [dbo].[tb_bpbra_item] ([no_kwitansi], [idBpbra], [kocab], [tgl_bayar], [rubrik], [item], [biaya], [npa], [nm_ctm], [alamat], [inputby_nipp], [inputby_name], [tgl_input]) VALUES('$no_kwitansi','$idBpbra','$kocab','$tgl_bayar','50.06.50.00','PPN 10 % $prefixPpn','0', '$npa', '$nm_ctm', '$alamat', '$inputby_nipp','$inputby_name','$tgl_input')");
				return 0;
			} else {
				// kena PPN
				$result = $this->db->query("INSERT INTO [dbo].[tb_bpbra_item] ([no_kwitansi], [idBpbra], [kocab], [tgl_bayar], [rubrik], [item], [biaya], [npa], [nm_ctm], [alamat], [inputby_nipp], [inputby_name], [tgl_input], [isPsb]) VALUES('$no_kwitansi','$idBpbra','$kocab','$tgl_bayar','50.06.50.00','PPN 10 % $prefixPpn','$ppn', '$npa', '$nm_ctm', '$alamat', '$inputby_nipp','$inputby_name','$tgl_input','1')");
				return 0;
			}
		} catch (Exception $e) {
			return $this->db->error();
		}
	}

	public function iTblCicilanDp($no_kwitansi, $idBpbra, $kocab, $tgl_bayar, $rubrik, $item, $biaya, $npa, $nm_ctm, $alamat, $idtb_biaya, $inputby_nipp, $inputby_name, $tgl_input, $ppn, $prefixItem, $prefixPpn, $isDp, $isNotPpn)
	{
		try {
			$result = $this->db->query("INSERT INTO [dbo].[tb_bpbra_item] ([no_kwitansi], [idBpbra], [kocab], [tgl_bayar], [rubrik], [item], [biaya], [npa], [nm_ctm], [alamat], [idtb_biaya], [inputby_nipp], [inputby_name], [tgl_input], [isDp]) VALUES('$no_kwitansi','$idBpbra','$kocab','$tgl_bayar','$rubrik','$item $prefixItem',$biaya, '$npa', '$nm_ctm', '$alamat', $idtb_biaya, '$inputby_nipp','$inputby_name','$tgl_input', '$isDp')");
			// pajak
			// insert pajak jika bukan:
			// 1. Sambungan Baru
			// 2. Sambungan Kembali Baru PSKB
			// 3. Sambungan Kembali
			// 4. Sambungan Kembali Baru
			if ($isNotPpn === 1) {
				// bebas PPN
				$result = $this->db->query("INSERT INTO [dbo].[tb_bpbra_item] ([no_kwitansi], [idBpbra], [kocab], [tgl_bayar], [rubrik], [item], [biaya], [npa], [nm_ctm], [alamat], [inputby_nipp], [inputby_name], [tgl_input], [isDp]) VALUES('$no_kwitansi','$idBpbra','$kocab','$tgl_bayar','50.06.50.00','PPN 10 % $prefixPpn','0', '$npa', '$nm_ctm', '$alamat', '$inputby_nipp','$inputby_name','$tgl_input', '$isDp')");
				return 0;
			} else {
				// kena PPN
				$result = $this->db->query("INSERT INTO [dbo].[tb_bpbra_item] ([no_kwitansi], [idBpbra], [kocab], [tgl_bayar], [rubrik], [item], [biaya], [npa], [nm_ctm], [alamat], [inputby_nipp], [inputby_name], [tgl_input], [isDp]) VALUES('$no_kwitansi','$idBpbra','$kocab','$tgl_bayar','50.06.50.00','PPN 10 % $prefixPpn','$ppn', '$npa', '$nm_ctm', '$alamat', '$inputby_nipp','$inputby_name','$tgl_input', '$isDp')");
				return 0;
			}
		} catch (Exception $e) {
			return $this->db->error();
		}
	}

	public function iTblCicilanDpPsb($no_kwitansi, $idBpbra, $kocab, $tgl_bayar, $rubrik, $item, $biaya, $npa, $nm_ctm, $alamat, $idtb_biaya, $inputby_nipp, $inputby_name, $tgl_input, $ppn, $prefixItem, $prefixPpn, $isDp, $isNotPpn)
	{
		try {
			$result = $this->db->query("INSERT INTO [dbo].[tb_bpbra_item] ([no_kwitansi], [idBpbra], [kocab], [tgl_bayar], [rubrik], [item], [biaya], [npa], [nm_ctm], [alamat], [idtb_biaya], [inputby_nipp], [inputby_name], [tgl_input], [isDp], [isPsb]) VALUES('$no_kwitansi','$idBpbra','$kocab','$tgl_bayar','$rubrik','$item $prefixItem',$biaya, '$npa', '$nm_ctm', '$alamat', $idtb_biaya, '$inputby_nipp','$inputby_name','$tgl_input', '$isDp', '1')");
			// pajak
			// insert pajak jika bukan:
			// 1. Sambungan Baru
			// 2. Sambungan Kembali Baru PSKB
			// 3. Sambungan Kembali
			// 4. Sambungan Kembali Baru
			if ($isNotPpn === 1) {
				// bebas PPN
				$result = $this->db->query("INSERT INTO [dbo].[tb_bpbra_item] ([no_kwitansi], [idBpbra], [kocab], [tgl_bayar], [rubrik], [item], [biaya], [npa], [nm_ctm], [alamat], [inputby_nipp], [inputby_name], [tgl_input], [isDp], [isPsb]) VALUES('$no_kwitansi','$idBpbra','$kocab','$tgl_bayar','50.06.50.00','PPN 10 % $prefixPpn','0', '$npa', '$nm_ctm', '$alamat', '$inputby_nipp','$inputby_name','$tgl_input', '$isDp', '1')");
				return 0;
			} else {
				// kena PPN
				$result = $this->db->query("INSERT INTO [dbo].[tb_bpbra_item] ([no_kwitansi], [idBpbra], [kocab], [tgl_bayar], [rubrik], [item], [biaya], [npa], [nm_ctm], [alamat], [inputby_nipp], [inputby_name], [tgl_input], [isDp], [isPsb]) VALUES('$no_kwitansi','$idBpbra','$kocab','$tgl_bayar','50.06.50.00','PPN 10 % $prefixPpn','$ppn', '$npa', '$nm_ctm', '$alamat', '$inputby_nipp','$inputby_name','$tgl_input', '$isDp', '1')");
				return 0;
			}
		} catch (Exception $e) {
			return $this->db->error();
		}
	}

	public function rAbreByKocab($kocab)
	{
		$result = $this->db->query("SELECT Abbreviation FROM temp_office WHERE Code=$kocab");
		return $result;
	}

	public function rCountBon($kocab, $tahun, $bulan)
	{
		$result = $this->db->query("SELECT COUNT(*) hitung FROM tb_bpbra WHERE kocab='$kocab' AND YEAR(tgl_input)='$tahun' AND MONTH(tgl_input)='$bulan'");
		return $result;
	}

	public function rItemByNoKwit($no_kwit, $kocab)
	{
		$result = $this->db->query("SELECT *,(SELECT itemnya FROM tb_biaya WHERE tb_biaya.id=tb_bpbra_item.idtb_biaya) as itemnya FROM tb_bpbra_item WHERE no_kwitansi='$no_kwit' AND kocab='$kocab'");
		return $result;
	}

	public function rTtdKabagByKocab($kocab)
	{
		$result = $this->db->query("SELECT nipp_kabag, nm_ttd_kabag AS nm_ttd, jb_ttd_kabag as jb_ttd FROM tb_ttd WHERE kocab=$kocab");
		return $result;
	}

	public function rTtdByKocab($kocab)
	{
		$result = $this->db->query("SELECT * FROM tb_ttd WHERE kocab=$kocab");
		return $result;
	}

	public function rBpbraItemByPeriod($tglAwal, $tglAkhir, $kocab)
	{
		$result = $this->db->query("SELECT * FROM tb_bpbra_item WHERE kocab='$kocab' AND isDelete IS NULL AND tgl_bayar BETWEEN CONVERT(datetime,'$tglAwal 00:00:00:000') AND CONVERT(datetime,'$tglAkhir 23:59:59:999') ORDER BY tgl_bayar ASC, no_kwitansi ASC");
		return $result;
	}

	public function rDataKocabByKocab($kocab)
	{
		$result = $this->db->query("SELECT CAST(name AS TEXT) nama, Code, CAST(InitialOffice AS TEXT) io,CAST(Address AS TEXT) alamat, CAST(City AS TEXT) kota FROM view_office WHERE Code='$kocab'");
		return $result;
	}

	public function rDataKocabByKocab_old($kocab)
	{
		$result = $this->db->query("SELECT CAST(name AS TEXT) nama, Code, CAST(InitialOffice AS TEXT) io,CAST(Address AS TEXT) alamat, CAST(City AS TEXT) kota FROM view_office WHERE Code='$kocab'");
		return $result;
	}

	public function rAllCabang()
	{
		$result = $this->db->query("SELECT CAST(name AS TEXT) nama, Code, CAST(InitialOffice AS TEXT) io,CAST(Address AS TEXT) alamat FROM view_office");
		return $result;
	}

	public function iTblBiaya($kocab, $rubrik, $jenis, $item, $biaya, $ppn)
	{
		try {
			$result = $this->db->query("INSERT INTO [dbo].[tb_biaya] ([kocab],[rubrik],[jenis],[biaya],[itemnya],[ppn]) VALUES('$kocab','$rubrik','$jenis','$biaya','$item','$ppn')");
			return "Berhasil Input";
		} catch (Exception $e) {
			return $this->db->error();
		}
	}

	public function iTblUser($kocab, $nipp, $pass, $gu)
	{
		try {
			$result = $this->db->query("INSERT INTO [dbo].[tb_user]([nipp],[password],[kocab],[grup_user])VALUES('$nipp','$pass','$kocab','$gu')");
			return "Berhasil Input";
		} catch (Exception $e) {
			return $this->db->error();
		}
	}

	public function rPejabatByCabang($kocab)
	{
		$result = $this->db->query("SELECT * FROM tb_ttd WHERE kocab='$kocab'");
		return $result;
	}

	public function rAllPengguna()
	{
		// $result=$this->db->query("SELECT *, (CASE WHEN grup_user='1' THEN 'Super Admin' WHEN grup_user='2' THEN 'Admin Cabang' ELSE 'User' END) as grup_user, (SELECT fullname FROM view_employeeActive WHERE view_employeeActive.nipp=tb_user.nipp) fullname, (SELECT Name FROM view_office WHERE view_office.Code=tb_user.kocab) cabang FROM tb_user WHERE isDelete IS NULL");
		$result = $this->db->query("SELECT *, (CASE WHEN grup_user='1' THEN 'Super Admin' WHEN grup_user='2' THEN 'Admin Cabang' ELSE 'User' END) as grup_user, (SELECT fullname FROM temp_employeeActive WHERE temp_employeeActive.nipp=tb_user.nipp) fullname, (SELECT Name FROM view_office WHERE view_office.Code=tb_user.kocab) cabang FROM tb_user WHERE isDelete IS NULL");
		return $result;
	}

	public function rPenggunaByKocab($kocab)
	{
		// $result=$this->db->query("SELECT *, (CASE WHEN grup_user='1' THEN 'Super Admin' WHEN grup_user='2' THEN 'Admin Cabang' ELSE 'User' END) as grup_user, (SELECT fullname FROM view_employeeActive WHERE view_employeeActive.nipp=tb_user.nipp) fullname, (SELECT Name FROM view_office WHERE view_office.Code=tb_user.kocab) cabang FROM tb_user WHERE tb_user.kocab='$kocab' AND isDelete IS NULL");
		$result = $this->db->query("SELECT *, (CASE WHEN grup_user='1' THEN 'Super Admin' WHEN grup_user='2' THEN 'Admin Cabang' ELSE 'User' END) as grup_user, (SELECT fullname FROM temp_employeeActive WHERE temp_employeeActive.nipp=tb_user.nipp) fullname, (SELECT Name FROM view_office WHERE view_office.Code=tb_user.kocab) cabang FROM tb_user WHERE tb_user.kocab='$kocab' AND isDelete IS NULL");
		return $result;
	}

	public function iTblPejabat($kocab, $nm_kacab, $jb_kacab, $nipp_kacab, $nm_kabag, $jb_kabag, $nipp_kabag, $nm_ast, $jb_ast, $nipp_ast)
	{
		try {
			$result = $this->db->query("INSERT INTO [dbo].[tb_ttd]([kocab],[nipp_kacab],[nm_ttd_kacab],[jb_ttd_kacab],[nipp_kabag],[nm_ttd_kabag],[jb_ttd_kabag],[nipp_ast],[nm_ttd_ast],[jb_ttd_ast]) VALUES('$kocab','$nipp_kacab','$nm_kacab','$jb_kacab','$nipp_kabag','$nm_kabag','$jb_kabag','$nipp_ast','$nm_ast','$jb_ast')");
			return "Berhasil Input";
		} catch (Exception $e) {
			return $this->db->error();
		}
	}

	public function uTblPejabat($kocab, $nm_kacab, $jb_kacab, $nipp_kacab, $nm_kabag, $jb_kabag, $nipp_kabag, $nm_ast, $jb_ast, $nipp_ast)
	{
		try {
			$result = $this->db->query("UPDATE [dbo].[tb_ttd] SET [nipp_kacab] = '$nipp_kacab' ,[nm_ttd_kacab] = '$nm_kacab' ,[jb_ttd_kacab] = '$jb_kacab',[nipp_kabag] = '$nipp_kacab' ,[nm_ttd_kabag] = '$nm_kabag' ,[jb_ttd_kabag] = '$jb_kabag' ,[nipp_ast] = '$nipp_kabag' ,[nm_ttd_ast] = '$nm_ast' ,[jb_ttd_ast] = '$jb_ast' WHERE [kocab] = '$kocab'");
			return "Berhasil Diupdate";
		} catch (Exception $e) {
			return $this->db->error();
		}
	}

	public function rDataBiayaById($id)
	{
		$result = $this->db->query("SELECT * FROM tb_biaya WHERE id='$id'");
		return $result;
	}

	public function uTblBiaya($id, $kocab, $rubrik, $jenis, $item, $ppn, $biaya)
	{
		try {
			$result = $this->db->query("UPDATE [dbo].[tb_biaya] SET [kocab] = '$kocab' ,[rubrik] = '$rubrik' ,[jenis] = '$jenis' ,[biaya] = '$biaya'  ,[itemnya] = '$item' ,[ppn] = '$ppn'  WHERE [id] = '$id'");
			return "Berhasil Diupdate";
		} catch (Exception $e) {
			return $this->db->error();
		}
	}

	public function uTblPengguna($id, $kocab, $pass, $grup_user)
	{
		try {
			$result = $this->db->query("UPDATE [dbo].[tb_user] SET [kocab] = '$kocab' ,[password] = '$pass' ,[grup_user] = '$grup_user' WHERE [id] = '$id'");
			return "Berhasil Diupdate";
		} catch (Exception $e) {
			return $this->db->error();
		}
	}


	public function dBiayaBybId($id)
	{
		try {
			$result = $this->db->query("UPDATE [dbo].[tb_biaya] SET [isDelete] = '1' WHERE [id] = '$id'");
			return "Berhasil Hapus";
		} catch (Exception $e) {
			return $this->db->error();
		}
	}

	public function rDataUserById($id)
	{
		$result = $this->db->query("SELECT *, (SELECT Fullname FROM view_employeeActiveUnit WHERE view_employeeActiveUnit.NIPP=tb_user.nipp) fullname, (SELECT FixFullWorkUnitName FROM view_employeeActiveUnit WHERE view_employeeActiveUnit.NIPP=tb_user.nipp) FixFullWorkUnitName FROM tb_user WHERE id='$id'");
		return $result;
	}

	public function dUserBybId($id)
	{
		try {
			$result = $this->db->query("UPDATE [dbo].[tb_user] SET [isDelete] = '1' WHERE [id] = '$id'");
			return "Berhasil Hapus";
		} catch (Exception $e) {
			return $this->db->error();
		}
	}

	public function rPKasByPeriod($tglAwal, $tglAkhir, $kocab)
	{
		$result = $this->db->query("SELECT rubrik, (select top 1 jenis from tb_biaya where tb_biaya.rubrik+tb_biaya.kocab=tb_bpbra_item.rubrik) uraian, (select top 1 uraian from tb_kode_perkiraan where tb_kode_perkiraan.koPer=LEFT(tb_bpbra_item.rubrik,8)) uraianlain, COUNT(*) jumlah, SUM(biaya) biaya, (SELECT ordinat FROM tb_kode_perkiraan where tb_kode_perkiraan.koPer=LEFT(tb_bpbra_item.rubrik,8)) ordinat
			  FROM [bpbra].[dbo].[tb_bpbra_item]
			  WHERE kocab='$kocab' AND isDelete IS NULL AND tgl_bayar BETWEEN '$tglAwal 00:00:00' AND '$tglAkhir 23:59:59'
			  GROUP BY rubrik
			  ORDER BY ordinat ASC");
		return $result;
	}

	public function rDataKdPerkiraan()
	{
		$result = $this->db->query("SELECT koPer, abreviasi FROM tb_kode_perkiraan WHERE isNotActive IS NULL ORDER BY ordinat ASC");
		return $result;
	}

	public function rDataTransPerbulanByKocab($kocab, $tahun, $bulan)
	{
		$result = $this->db->query("SELECT bi.kocab, CAST(bi.tgl_bayar as date) tgl_bayar, kp.koPer, kp.uraian, bi.biaya FROM tb_kode_perkiraan kp, tb_bpbra_item bi WHERE kp.koPer=LEFT(bi.rubrik,8) AND bi.kocab='$kocab' AND YEAR(bi.tgl_bayar)='$tahun' AND MONTH(bi.tgl_bayar)='$bulan' AND bi.isDelete IS NULL ORDER BY bi.tgl_bayar ASC");
		return $result;
	}

	public function rDataTglTransByKocab($kocab, $tahun, $bulan)
	{
		$result = $this->db->query("SELECT CAST(tgl_bayar AS DATE) tgl_bayar FROM tb_bpbra_item WHERE kocab='$kocab' and YEAR(tgl_bayar)='$tahun' AND MONTH(tgl_bayar)='$bulan' AND isDelete IS NULL GROUP BY CAST(tgl_bayar AS DATE) ORDER BY tgl_bayar ASC");
		return $result;
	}

	public function rSumKoperByDate($kocab, $tgl, $koPer)
	{
		$result = $this->db->query("SELECT kocab, rubrik, sum(biaya) sum FROM tb_bpbra_item where kocab='$kocab' and CAST(tgl_bayar AS DATE)='$tgl' and LEFT(rubrik,8)='$koPer' and isDelete IS NULL group by kocab, rubrik");
		return $result;
	}

	public function rSumKoperByMonthYear($kocab, $bulan, $tahun, $koPer)
	{
		$result = $this->db->query("SELECT kocab, rubrik, sum(biaya) sum FROM tb_bpbra_item where kocab='$kocab' and YEAR(tgl_bayar)='$tahun' AND MONTH(tgl_bayar)='$bulan' and LEFT(rubrik,8)='$koPer' and isDelete IS NULL group by kocab, rubrik");
		return $result;
	}

	public function rCountKoperByMonthYear($kocab, $bulan, $tahun, $koPer)
	{
		$result = $this->db->query("SELECT kocab, rubrik, COUNT(biaya) sum FROM tb_bpbra_item where kocab='$kocab' and YEAR(tgl_bayar)='$tahun' AND MONTH(tgl_bayar)='$bulan' and LEFT(rubrik,8)='$koPer' AND isDelete IS NULL group by kocab, rubrik");
		return $result;
	}

	public function rIsDpByNoKwit($nokwit, $kocab)
	{
		$result = $this->db->query("SELECT isDp FROM tb_bpbra where no_kwitansi='$nokwit' and kocab='$kocab'");
		return $result;
	}

	public function loginsert($action, $actby, $modul, $timestamp)
	{
		$this->load->library('user_agent');
		if ($this->agent->is_browser()) {
			$browser = $this->agent->browser() . ' ' . $this->agent->version();
		} elseif ($this->agent->is_mobile()) {
			$browser = $this->agent->mobile();
		} else {
			$browser = 'Data user gagal di dapatkan';
		}
		$kocab = $this->session->userdata('kocab');
		$os = $this->agent->platform();
		$ip = $this->input->ip_address();
		$url = current_url();
		$this->db->query("INSERT INTO [dbo].[tb_log_sys] ([kocab],[action],[actBy],[modul],[timestamp],[browser],[os],[ip],[urlAccess]) VALUES('$kocab','$action','$actby','$modul','$timestamp','$browser','$os','$ip','$url')");
	}
}
