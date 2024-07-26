<?php
 
class DB_Connection{
	private $host = 'localhost';
	private $user = 'root';
	private $pass = '';
	private $db_name = 'e_shopper';
	protected $db_connect;

	public function __construct(){
		$this->db_connect = mysqli_connect($this->host,$this->user,$this->pass,$this->db_name);
		if(!$this->db_connect){
			die('Database Connection faild'.mysqli_error($this->db_connect));
		}
	}
}

?>