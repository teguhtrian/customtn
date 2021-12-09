<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Login_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		// $result = mssql_query("SET ANSI_NULLS ON;");
		// $result = mssql_query("SET ANSI_WARNINGS ON;");
		// $result = sqlsrv_query("SET ANSI_NULLS ON;");
		// $result = sqlsrv_query("SET ANSI_WARNINGS ON;");
	}

	function get_user($nipp, $password)
	{
		$query = $this->db->query("SELECT * FROM tb_user WHERE nipp='$nipp' AND password='$password'");
		return $query;
	}

	function getUserFullInfo($nipp)
	{
		// $query = $this->db->query("SELECT Fullname FROM view_employeeActive WHERE [NIPP]='$nipp'");
		$query = $this->db->query("SELECT Fullname FROM temp_employeeActive WHERE [NIPP]='$nipp'");
		return $query;
	}

	function uPassByNipp($nipp, $pass)
	{
		try {
			$result = $this->db->query("UPDATE [dbo].[tb_user] SET [password] = '$pass' WHERE [nipp] = '$nipp'");
			return "Berhasil Diupdate";
		} catch (Exception $e) {
			return $this->db->error();
		}
	}
}
