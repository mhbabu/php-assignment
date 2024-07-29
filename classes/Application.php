<?php

require_once('DB_Connection.php');

class Application extends DB_Connection
{

	public function __construct(){
		parent::__construct();
	}

	public function getAllBuyers(){
		$sql = "SELECT * FROM buyers ORDER BY id DESC";
		if (mysqli_query($this->db_connect, $sql)) {
			return mysqli_query($this->db_connect, $sql);
		}
	}

	public function getBuyersByFiltering($params){

	}
}
