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

    public function readAllTracks() {
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

    public function readAllTracksForSpecificRecord() {
        $query = /** @lang MySQL */
            "SELECT
            t.id,
            t.record_id,            
            r.artist,
            t.title
        FROM
            track t         
        LEFT JOIN 
            record r ON t.record_id = r.id
        WHERE 
             t.record_id = ?";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->record_id);
        $stmt->execute();

        return $stmt;
    }

    public function readOneTrack() {
        $query = /** @lang MySQL */
            "SELECT
            t.id,
            t.record_id,            
            r.artist,
            t.title
        FROM
            track t
        LEFT JOIN 
            record r ON t.record_id = r.id
        WHERE
            t.id = ?";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();

        return $stmt;
    }

    public function createTrack() {
        $query = /** @lang MySQL */
            "INSERT INTO 
            track
        SET
            record_id = :record_id,
            title = :title";

        $stmt = $this->conn->prepare($query);
        $this->record_id = htmlspecialchars(strip_tags($this->record_id));
        $this->title = htmlspecialchars(strip_tags($this->title));
        $stmt->bindParam(":record_id", $this->record_id);
        $stmt->bindParam(":title", $this->title);
        if ($stmt->execute()) {
            return true;
        }

        printf("Error: %s.\n", $stmt->error);
        return false;
    }

    public function updateTrack() {
        $query = /** @lang MySQL */
            "UPDATE 
            track
        SET
            record_id = :record_id,
            title = :title
        WHERE 
            id = :id";

        $stmt = $this->conn->prepare($query);
        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->record_id = htmlspecialchars(strip_tags($this->record_id));
        $this->title = htmlspecialchars(strip_tags($this->title));
        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":record_id", $this->record_id);
        $stmt->bindParam(":title", $this->title);
        if ($stmt->execute()) {
            return true;
        }

        printf("Error: %s.\n", $stmt->error);
        return false;
    }

    public function deleteTrack() {
        $query = /** @lang MySQL */
            "DELETE FROM 
            track
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
