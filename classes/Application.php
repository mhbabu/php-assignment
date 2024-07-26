<?php

require_once('DB_Connection.php');

class Application extends DB_Connection{
	public function __construct(){
		parent::__construct();
	}

	public function getAllBuyers(){
		$sql = "SELECT * FROM buyers";
		if(mysqli_query($this->db_connect,$sql)){
			return mysqli_query($this->db_connect, $sql);
		}
	}

}



?>