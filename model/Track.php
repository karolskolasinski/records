<?php


class Track {
    private $conn;

    public $id;
    public $record_id;
    public $artist;
    public $title;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function readAll() {
        $query = /** @lang MySQL */
            "SELECT
            t.id,
            t.record_id,            
            r.artist,
            t.title
        FROM
            track t
        LEFT JOIN 
            record r ON t.record_id = r.id";


        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }

}
