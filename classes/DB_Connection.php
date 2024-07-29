<?php

class DB_Connection {
    private $host = 'localhost';
    private $user = 'root';
    private $pass = 'reformedtech';
    private $db_name = 'php_projects';
    protected $db_connect;

    public function __construct() {
        $this->db_connect = new mysqli($this->host, $this->user, $this->pass, $this->db_name);

        // Check connection
        if ($this->db_connect->connect_error) {
            die('Database connection failed: ' . $this->db_connect->connect_error);
        }
    }

    public function getDbConnect() {
        return $this->db_connect;
    }
}

