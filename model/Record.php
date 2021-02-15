<?php

class Record {
    private $conn;

    public $id;
    public $artist;
    public $title;
    public $release_type;
    public $release_year;


    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function readAllRecords() {
        $query = /** @lang MySQL */
            "SELECT *
        FROM
            record";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }

    public function readOneRecord() {
        $query = /** @lang MySQL */
            "SELECT *
        FROM
            record r
        WHERE
            r.id = ?";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();

        return $stmt;
    }

    public function createRecord() {
        $query = /** @lang MySQL */
            "INSERT INTO
            record
        SET
            artist = :artist,
            title = :title,
            release_type = :release_type,
            release_year = :release_year";

        $stmt = $this->conn->prepare($query);
        $this->artist = htmlspecialchars(strip_tags($this->artist));
        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->release_type = htmlspecialchars(strip_tags($this->release_type));
        $this->release_year = htmlspecialchars(strip_tags($this->release_year));
        $stmt->bindParam(":artist", $this->artist);
        $stmt->bindParam(":title", $this->title);
        $stmt->bindParam(":release_type", $this->release_type);
        $stmt->bindParam(":release_year", $this->release_year);
        if ($stmt->execute()) {
            return true;
        }

        printf("Error: %s.\n", $stmt->error);
        return false;
    }

    public function updateRecord() {
        $query = /** @lang MySQL */
            "UPDATE 
            record r
        SET
            r.artist = :artist,
            r.title = :title,
            r.release_type = :release_type,
            r.release_year = :release_year
        WHERE 
            r.id = :id";

        $stmt = $this->conn->prepare($query);
        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->artist = htmlspecialchars(strip_tags($this->artist));
        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->release_type = htmlspecialchars(strip_tags($this->release_type));
        $this->release_year = htmlspecialchars(strip_tags($this->release_year));
        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":artist", $this->artist);
        $stmt->bindParam(":title", $this->title);
        $stmt->bindParam(":release_type", $this->release_type);
        $stmt->bindParam(":release_year", $this->release_year);
        if ($stmt->execute()) {
            return true;
        }

        printf("Error: %s.\n", $stmt->error);
        return false;
    }

    public function deleteRecord() {
        $query = /** @lang MySQL */
            "DELETE FROM 
            record
        WHERE 
            id = :id";

        $stmt = $this->conn->prepare($query);
        $this->id = htmlspecialchars(strip_tags($this->id));
        $stmt->bindParam(":id", $this->id);
        if ($stmt->execute()) {
            return true;
        }

        printf("Error: %s.\n", $stmt->error);
        return false;
    }

}

?>
