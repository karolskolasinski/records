<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

include_once "../../config/Database.php";
include_once "../../model/Track.php";

$database = new Database();
$conn = $database->connect();

$track = new Track($conn);

$all = $track->readAll();
$row_counter = $all->rowCount();

if ($row_counter > 0) {
    $tracks_arr = array();
    $tracks_arr["data"] = array();

    while ($row = $all->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        /** @var int $id */
        /** @var int $record_id */
        /** @var string $artist */
        /** @var string $title */
        $track_item = array(
            "id" => $id,
            "record_id" => $record_id,
            "artist" => $artist,
            "title" => $title,
        );

        array_push($tracks_arr["data"], $track_item);
    }

    echo json_encode($tracks_arr);

} else {
    echo json_encode(array("message" => "No tracks found"));
}
