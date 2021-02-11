<?php


function setup(): Track {
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json");

    require_once "../config/Database.php";
    require_once "../model/Track.php";

    $database = new Database();
    $conn = $database->connect();
    $track = new Track($conn);
    return $track;
}


function readAll() {
    $track = setup();
    $all = $track->readAll();
    $row_counter = $all->rowCount();

    if ($row_counter > 0) {
        $tracks_arr = [];

        while ($row = $all->fetch(PDO::FETCH_ASSOC)) {
            extract($row);

            /** @var int $id */
            /** @var int $record_id */
            /** @var string $artist */
            /** @var string $title */
            $track_item = [
                "id" => $id,
                "record_id" => $record_id,
                "artist" => $artist,
                "title" => $title,
            ];

            array_push($tracks_arr, $track_item);
        }

        return $tracks_arr;

    } else {
        return ["message" => "No tracks found."];
    }
}


function readOne($id) {
    $track = setup();
    $track->id = $id;

    $one = $track->readOne();
    $row = $one->fetch(PDO::FETCH_ASSOC);

    $track->record_id = $row["record_id"];
    $track->artist = $row["artist"];
    $track->title = $row["title"];

    $track_item = [
        "id" => $track->id,
        "record_id" => $track->record_id,
        "artist" => $track->artist,
        "title" => $track->title
    ];

    return $track_item;
}


function create() {
    $track = setup();
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Allow-Headers: Access-Control-Allow-Headers, Access-Control-Allow-Methods, Content-Type");

    $data = json_decode(file_get_contents("php://input"));

    $track->record_id = $data->record_id;
    $track->title = $data->title;

    return $track->create() ?
        ["message:" => "Track created."] :
        ["message:" => "Track not created."];
}


function update() {
    $track = setup();
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Allow-Headers: Access-Control-Allow-Headers, Access-Control-Allow-Methods, Content-Type");

    $data = json_decode(file_get_contents("php://input"));

    $track->id = $data->id;
    $track->record_id = $data->record_id;
    $track->title = $data->title;

    return $track->update() ?
        ["message:" => "Track updated."] :
        ["message:" => "Track not updated."];
}


function delete() {
    $track = setup();
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Allow-Headers: Access-Control-Allow-Headers, Access-Control-Allow-Methods, Content-Type");

    $data = json_decode(file_get_contents("php://input"));

    $track->id = $data->id;

    return $track->delete() ?
        ["message:" => "Track deleted."] :
        ["message:" => "Track not deleted."];
}

?>
