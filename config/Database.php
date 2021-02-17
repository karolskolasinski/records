<?php

class Database {
    private $db_host;
    private $db_user;
    private $db_pass;
    private $db_name;
    private $db_conn;

    public function __construct() {
        $this->db_host = getenv('DB_CONFIG_HOST');
        $this->db_user = getenv('DB_CONFIG_USER');
        $this->db_pass = getenv('DB_CONFIG_PASS');
        $this->db_name = getenv('DB_CONFIG_NAME');
    }

    public function connect() {
        $this->db_conn = null;
        $dsn = "mysql:host=" . $this->db_host . ";dbname=" . $this->db_name;

        try {
            $this->db_conn = new PDO($dsn, $this->db_user, $this->db_pass);
            $this->db_conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection Error: " . $e->getMessage();
        }

        return $this->db_conn;
    }

}
