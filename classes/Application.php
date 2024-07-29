<?php

require_once('DB_Connection.php');

class Application extends DB_Connection
{
	protected $startDate;
    protected $endDate;
	protected $userId;

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
		print_r($params);
		exit();
		
	}
}
