<?php

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable("./");
$dotenv->load();


class Database {
    private $db_host;
    private $db_user;
    private $db_pass;
    private $db_name;
    private $db_conn;

    public function __construct() {
        $this->db_host = $_ENV['DB_CONFIG_HOST'];
        $this->db_user = $_ENV['DB_CONFIG_USER'];
        $this->db_pass = $_ENV['DB_CONFIG_PASS'];
        $this->db_name = $_ENV['DB_CONFIG_NAME'];
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
