<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sdm_model extends CI_Model {
	function __construct(){
		parent::__construct();
	}

	public function getSppd100(){
		$query = $this->db->query("SELECT TOP 100 Code FROM SPPDInternalExternalAbroad");
		return $query;
		
	}

	public function getEditSPPDData($query){
		// $kodeUnit=$this->session->userdata('kodeUnit');
		$result = $this->db->query("SELECT TOP 10 Code, CAST(SPPDGroupName AS TEXT) SPPDGroupName, CAST(Destination AS TEXT) Destination, CAST(Reason AS TEXT) Reason, Description, StartDate, EndDate FROM SPPDInternalExternalAbroad WHERE Code like '%".$query."%'");
        return $result;
	}

	public function editBukaSPPD($kodeSPPD){
		$result = $this->db->query("UPDATE SPPDInternalExternalAbroad SET IsProcess=NULL WHERE Code='$kodeSPPD'");
        return $result;
	}
}