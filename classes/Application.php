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

		if (empty(array_filter($params))) {
			return ['status' => 'error', 'message' => 'Please select at least one item.'];
		}

		$sql = "SELECT * FROM buyers";

		if(isset($params['start_date']) && isset($params['end_date'])){
			$sql  .= " WHERE entry_at BETWEEN '$params[start_date]' AND '$params[end_date]'";
		}else{
			if(isset($params['start_date'])){
				$sql  .= " WHERE entry_at >= '$params[start_date]'";
			}
			if(isset($params['end_date'])){
				$sql  .= " WHERE entry_at <= '$params[end_date]'";
			}
		}

		$sql .= " ORDER BY id DESC";

		if (mysqli_query($this->db_connect, $sql)) {
			$result = mysqli_query($this->db_connect, $sql);
			return ['data' =>  $result, 'params' => $params];
		}else{
			return ['status' => 'error', 'message' =>  $this->db_connect->error];
		}
		
	}
}
