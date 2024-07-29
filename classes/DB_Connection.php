<?php

class DB_Connection {
    private $host = 'localhost';
    private $username = 'root';
    private $password = 'babu';
    private $database = 'assignments';
    protected $db_connect;

    public function __construct() {
        $this->db_connect = new mysqli($this->host, $this->username, $this->password, $this->database);

        // Check connection
        if ($this->db_connect->connect_error) {
            echo ('Database connection failed: ' . $this->db_connect->connect_error);
            exit();
        }
    }

    public function getDbConnect() {
        return $this->db_connect;
    }
}

