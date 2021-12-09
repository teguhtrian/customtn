<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Home_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		// $result = mssql_query("SET ANSI_NULLS ON;");
		// $result = mssql_query("SET ANSI_WARNINGS ON;");
	}

	public function getNpaCustomIsm($query)
	{
		$result = $this->db->query("SELECT TOP 10 npa, na_ctm, status, ket_status, tarif, alamat, no_rmh, ketstatus, kabu, kabupaten, keca, kecamatan, kelu, kelurahan, longitude, latitude, luas FROM view_custom WHERE npa like '" . $query . "%'");
		return $result;
	}

	public function getCtmTodayAll()
	{
		$result = $this->db->query("SELECT id, npa, pelanggan, jalan, nm_tarif FROM view_custom_data_full WHERE insert_tgl BETWEEN CONCAT(CONVERT(date, GETDATE()),' 00:00:00') AND CONCAT(CONVERT(date, GETDATE()),' 23:59:59')");
		return $result;
	}

	public function getCtmTodayByKocab($kocab)
	{
		$result = $this->db->query("SELECT id, npa, pelanggan, jalan, nm_tarif FROM view_custom_data_full WHERE kocab='" . $kocab . "' insert_tgl BETWEEN CONCAT(CONVERT(date, GETDATE()),' 00:00:00') AND CONCAT(CONVERT(date, GETDATE()),' 23:59:59')");
		return $result;
	}

	public function getNpaCustomDb($query)
	{
		$result = $this->db->query("SELECT TOP 10 [form_token] 
		,[npa] 
		,[na_pel] na_ctm 
		,[notelp] notelp_ctm
		,[nohp] nohp_ctm 
		,[email] email_ctm
		,[noktp] noktp_ctm 
		,(SELECT na_pem FROM pemilik WHERE pemilik.npa=pelanggan.npa) na_pem 
		,(SELECT notelp FROM pemilik WHERE pemilik.npa=pelanggan.npa) notelp_pem 
		,(SELECT nohp FROM pemilik WHERE pemilik.npa=pelanggan.npa) nohp_pem 
		,(SELECT email FROM pemilik WHERE pemilik.npa=pelanggan.npa) email_pem 
		,(SELECT noktp FROM pemilik WHERE pemilik.npa=pelanggan.npa) noktp_pem 
		,(SELECT na_penghuni FROM penghuni WHERE penghuni.npa=pelanggan.npa) na_pen 
		,(SELECT notelp FROM penghuni WHERE penghuni.npa=pelanggan.npa) notelp_pen 
		,(SELECT nohp FROM penghuni WHERE penghuni.npa=pelanggan.npa) nohp_pen 
		,(SELECT email FROM penghuni WHERE penghuni.npa=pelanggan.npa) email_pen 
		,(SELECT noktp FROM penghuni WHERE penghuni.npa=pelanggan.npa) noktp_pen 
		,[jalan] alamat
		,[no_rmh]
		,[kd_kab] kabu
		,(SELECT kabupaten FROM rkabupaten WHERE rkabupaten.kd_prop='12' AND rkabupaten.kd_kab=pelanggan.kd_kab) kabupaten
		,[kd_kec] keca
		,(SELECT kecamatan FROM rkecamatan WHERE rkecamatan.kd_prop='12' AND rkecamatan.kd_kab=pelanggan.kd_kab AND rkecamatan.kd_kec=pelanggan.kd_kec) kecamatan
		,[kd_kel] kelu
		,(SELECT kelurahan FROM rkelurahan WHERE rkelurahan.kd_prop='12' AND rkelurahan.kd_kab=pelanggan.kd_kab AND rkelurahan.kd_kec=pelanggan.kd_kec AND rkelurahan.kd_kel=pelanggan.kd_kel) kelurahan
		,[nm_tarif] tarif
		,[luas] 
		,[usaha_persil] 
		,[usaha_ket] 
		,[usaha_skala] 
		,[longitude] 
		,[latitude] 
		,[insert_tgl] 
		,[insert_usr] 
		FROM pelanggan WHERE pelanggan.npa like '" . $query . "%'");
		// var_dump($result->result());
		// die;
		return $result;
	}

	public function getKabuKota()
	{
		$this->db->where('kd_prop', 12);
		$this->db->order_by("kd_kab", "asc");
		return $this->db->get('rkabupaten')->result();
	}

	public function getKeca($idKabu)
	{
		$this->db->where('kd_prop', 12);
		$this->db->where('kd_kab', $idKabu);
		$this->db->order_by("kd_kec", "asc");
		return $this->db->get('rkecamatan')->result();
	}

	public function getKecaAll()
	{
		$this->db->where('kd_prop', 12);
		$this->db->order_by("kd_kec", "asc");
		return $this->db->get('rkecamatan')->result();
	}

	public function getKelu($idKabu, $idKeca)
	{
		$this->db->where('kd_prop', 12);
		$this->db->where('kd_kab', $idKabu);
		$this->db->where('kd_kec', $idKeca);
		$this->db->order_by("kd_kel", "asc");
		return $this->db->get('rkelurahan')->result();
	}

	public function getKeluAll()
	{
		$this->db->where('kd_prop', 12);
		$this->db->order_by("kd_kel", "asc");
		return $this->db->get('rkelurahan')->result();
	}

	public function rAllCabang()
	{
		$result = $this->db->query("SELECT CAST(name AS TEXT) nama, Code, CAST(InitialOffice AS TEXT) io,CAST(Address AS TEXT) alamat FROM view_office");
		return $result;
	}

	public function getActvCtmByNoBuku($kocab, $no_buku)
	{
		$result = $this->db->query("SELECT TOP (1000) [customidinc]
		,[npa]
		,[npal]
		,[noreg]
		,[no_buku]
		,[hal_buku]
		,[na_ctm]
		,[no_rmh]
		,[luas]
		,[status]
		,[ket_status]
		,[tarif]
		,[alamat]
		,[ketstatus]
		,[kabu]
		,[kabupaten]
		,[keca]
		,[kecamatan]
		,[kelu]
		,[kelurahan]
		,[latitude]
		,[longitude]
	FROM [customer].[dbo].[view_custom]
	WHERE LEFT(npa,2)='$kocab' and no_buku='$no_buku' and  status='1'
	ORDER BY hal_buku ASC");
		return $result;
	}

	public function rDataKocabByKocab($kocab)
	{
		$result = $this->db->query("SELECT CAST(name AS TEXT) nama, Code, CAST(InitialOffice AS TEXT) io,CAST(Address AS TEXT) alamat, CAST(City AS TEXT) kota FROM view_office WHERE Code='$kocab'");
		return $result;
	}

	public function iDataPelanggan($data)
	{
		// $data = $_POST;
		// print_r($this->session->all_userdata());
		// die;
		if ($data['kegush_ctm'] === 'tidak_ada') {
			$data['ketush_ctm'] = NULL;
			$data['sklaush_ctm'] = NULL;
		}

		$pelanggan = array(
			'form_token' => $data['my_token'],
			'npa' => $data['npa'],
			// 'npal' => $data[''],
			'kocab' => substr($data['npa'], 0, 2),
			'na_pel' => $data['na_ctm'],
			'notelp' => $data['notlp_ctm'],
			'nohp' => $data['nohp_ctm'],
			'email' => $data['email_ctm'],
			'noktp' => $data['noktp_ctm'],
			'jalan' => $data['almt_ctm'],
			'no_rmh' => $data['normh_ctm'],
			'kd_kab' => $data['kbptn'],
			'kd_kec' => $data['kcmtn'],
			'kd_kel' => $data['klrhn'],
			'nm_tarif' => $data['trf_ctm'],
			'luas' => $data['lbang_ctm'],
			'latitude' => $data['lat'],
			'longitude' => $data['long'],
			'usaha_persil' => $data['kegush_ctm'],
			'usaha_ket' => $data['ketush_ctm'],
			'usaha_skala' => $data['sklaush_ctm'],
			'insert_tgl' => date('Y-m-d h:i:s'),
			'insert_usr' => $this->session->userdata('nipp')
		);
		$this->db->insert('pelanggan', $pelanggan);

		$pemilik = array(
			'form_token' => $data['my_token'],
			'npa' => $data['npa'],
			// 'npal' => $data[''],
			'kocab' => substr($data['npa'], 0, 2),
			'na_pem' => $data['na_pmlk'],
			'notelp' => $data['notlp_pmlk'],
			'nohp' => $data['nohp_pmlk'],
			'email' => $data['email_pmlk'],
			'noktp' => $data['noktp_pmlk'],
			'jalan' => $data['almt_ctm'],
			'kd_kab' => $data['kbptn'],
			'kd_kec' => $data['kcmtn'],
			'kd_kel' => $data['klrhn'],
			'nm_tarif' => $data['trf_ctm'],
			'luas' => $data['lbang_ctm'],
			// 'latitude' => $data['lat'],
			// 'longitude' => $data['long'],
			'usaha_persil' => $data['kegush_ctm'],
			'usaha_ket' => $data['ketush_ctm'],
			'usaha_skala' => $data['sklaush_ctm'],
			'insert_tgl' => date('Y-m-d h:i:s'),
			'insert_usr' => $this->session->userdata('nipp')
		);
		$this->db->insert('pemilik', $pemilik);

		$penghuni = array(
			'form_token' => $data['my_token'],
			'npa' => $data['npa'],
			// 'npal' => $data[''],
			'kocab' => substr($data['npa'], 0, 2),
			'na_penghuni' => $data['na_pghn'],
			'notelp' => $data['notlp_pghn'],
			'nohp' => $data['nohp_pghn'],
			'email' => $data['email_pghn'],
			'noktp' => $data['noktp_pghn'],
			'jalan' => $data['almt_ctm'],
			'kd_kab' => $data['kbptn'],
			'kd_kec' => $data['kcmtn'],
			'kd_kel' => $data['klrhn'],
			'nm_tarif' => $data['trf_ctm'],
			'luas' => $data['lbang_ctm'],
			// 'latitude' => $data['lat'],
			// 'longitude' => $data['long'],
			'usaha_persil' => $data['kegush_ctm'],
			'usaha_ket' => $data['ketush_ctm'],
			'usaha_skala' => $data['sklaush_ctm'],
			'insert_tgl' => date('Y-m-d h:i:s'),
			'insert_usr' => $this->session->userdata('nipp')
		);
		// $this->db->insert('penghuni', $penghuni);
		// print_r(sqlsrv_rows_affected($this->db->insert('penghuni', $penghuni)));
		return sqlsrv_rows_affected($this->db->insert('penghuni', $penghuni));
		// print_r($this->db->affected_rows());
		// die;
	}

	public function uDataPelanggan($data)
	{
		// $data = $_POST;
		// print_r($this->session->all_userdata());
		// die;
		if ($data['kegush_ctm'] === 'tidak_ada') {
			$data['ketush_ctm'] = NULL;
			$data['sklaush_ctm'] = NULL;
		}

		$pelanggan = array(
			'form_token' => $data['my_token'],
			'npa' => $data['npa'],
			// 'npal' => $data[''],
			'kocab' => substr($data['npa'], 0, 2),
			'na_pel' => $data['na_ctm'],
			'notelp' => $data['notlp_ctm'],
			'nohp' => $data['nohp_ctm'],
			'email' => $data['email_ctm'],
			'noktp' => $data['noktp_ctm'],
			'jalan' => $data['almt_ctm'],
			'no_rmh' => $data['normh_ctm'],
			'kd_kab' => $data['kbptn'],
			'kd_kec' => $data['kcmtn'],
			'kd_kel' => $data['klrhn'],
			'nm_tarif' => $data['trf_ctm'],
			'luas' => $data['lbang_ctm'],
			'latitude' => $data['lat'],
			'longitude' => $data['long'],
			'usaha_persil' => $data['kegush_ctm'],
			'usaha_ket' => $data['ketush_ctm'],
			'usaha_skala' => $data['sklaush_ctm'],
			'last_update_tgl' => date('Y-m-d h:i:s'),
			'last_update_usr' => $this->session->userdata('nipp')
		);
		$this->db->where('npa', $data['npa']);
		$this->db->update('pelanggan', $pelanggan);

		$pemilik = array(
			'form_token' => $data['my_token'],
			'npa' => $data['npa'],
			// 'npal' => $data[''],
			'kocab' => substr($data['npa'], 0, 2),
			'na_pem' => $data['na_pmlk'],
			'notelp' => $data['notlp_pmlk'],
			'nohp' => $data['nohp_pmlk'],
			'email' => $data['email_pmlk'],
			'noktp' => $data['noktp_pmlk'],
			'jalan' => $data['almt_ctm'],
			'kd_kab' => $data['kbptn'],
			'kd_kec' => $data['kcmtn'],
			'kd_kel' => $data['klrhn'],
			'nm_tarif' => $data['trf_ctm'],
			'luas' => $data['lbang_ctm'],
			// 'latitude' => $data['lat'],
			// 'longitude' => $data['long'],
			'usaha_persil' => $data['kegush_ctm'],
			'usaha_ket' => $data['ketush_ctm'],
			'usaha_skala' => $data['sklaush_ctm'],
			'last_update_tgl' => date('Y-m-d h:i:s'),
			'last_update_usr' => $this->session->userdata('nipp')
		);
		$this->db->where('npa', $data['npa']);
		$this->db->update('pemilik', $pemilik);

		$penghuni = array(
			'form_token' => $data['my_token'],
			'npa' => $data['npa'],
			// 'npal' => $data[''],
			'kocab' => substr($data['npa'], 0, 2),
			'na_penghuni' => $data['na_pghn'],
			'notelp' => $data['notlp_pghn'],
			'nohp' => $data['nohp_pghn'],
			'email' => $data['email_pghn'],
			'noktp' => $data['noktp_pghn'],
			'jalan' => $data['almt_ctm'],
			'kd_kab' => $data['kbptn'],
			'kd_kec' => $data['kcmtn'],
			'kd_kel' => $data['klrhn'],
			'nm_tarif' => $data['trf_ctm'],
			'luas' => $data['lbang_ctm'],
			// 'latitude' => $data['lat'],
			// 'longitude' => $data['long'],
			'usaha_persil' => $data['kegush_ctm'],
			'usaha_ket' => $data['ketush_ctm'],
			'usaha_skala' => $data['sklaush_ctm'],
			'last_update_tgl' => date('Y-m-d h:i:s'),
			'last_update_usr' => $this->session->userdata('nipp')
		);
		$this->db->where('npa', $data['npa']);
		return $this->db->update('penghuni', $penghuni);
		// die;
		// echo sqlsrv_rows_affected($this->db->update('penghuni', $penghuni));
		// die;
		// return;
		// print_r($this->db->affected_rows());
		// die;
	}
}
