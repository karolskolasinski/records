<?php


class Database {
    private $db_host = 'localhost';
    private $db_user = 'root';
    private $db_pass = '';
    private $db_name = 'itpendent';
    private $db_conn;

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
