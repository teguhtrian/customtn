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

	public function getAtasNamaByCode($kodeSPPD){
		$result = $this->db->query("SELECT FullName, (SELECT OccupationName FROM EmployeeWithCompleteAttributes WHERE NIPP=SPPDInternalExternalAbroadDetail.NIPP) as OccupationName
			FROM SPPDInternalExternalAbroadDetail
			WHERE SPPDInternalExAbroadId IN (SELECT Id FROM SPPDInternalExternalAbroad WHERE Code='".$kodeSPPD."')");
        return $result;		
	}

	public function getSPPDByCode($kodeSPPD){
		$result = $this->db->query("SELECT CAST(Reason AS TEXT) AS Reason, CAST(Description AS TEXT) AS Description, CAST(SPPDGroupName AS TEXT) AS SPPDGroupName, CAST(Location AS TEXT) AS Location FROM SPPDInternalExternalAbroad WHERE Code='".$kodeSPPD."'");
        return $result;		
	}

	public function getSPPDCostByCode($kodeSPPD){
		$result = $this->db->query("SELECT Amount FROM SPPDPlaneCost WHERE SPPDId=(SELECT Id FROM SPPDInternalExternalAbroad WHERE Code='".$kodeSPPD."')");
        return $result;		
	}

	public function getSPPDCostInnByCode($kodeSPPD){
		$result = $this->db->query("SELECT (SELECT TOP 1 Amount FROM SPPDPlaneCost WHERE SPPDPlaneCost.SPPDId = SPPDInternalExternalAbroadDetail.SPPDInternalExAbroadId) bPesawat, (SELECT Price FROM SPPDInternalExternalAbroadCost WHERE SPPDInternalExternalAbroadCost.DetailId = SPPDInternalExternalAbroadDetail.DetailId and Name='Penginapan') bPenginapan,Fullname FROM SPPDInternalExternalAbroadDetail WHERE SPPDInternalExAbroadId=(SELECT Id FROM SPPDInternalExternalAbroad WHERE Code='".$kodeSPPD."')");
        return $result;				
	}
}