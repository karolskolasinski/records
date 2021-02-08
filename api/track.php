<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

require_once "../config/Database.php";
require_once "../model/Track.php";

$database = new Database();
$conn = $database->connect();
$track = new Track($conn);


switch ($_SERVER['REQUEST_METHOD']) {
    case "DELETE":
        delete($track);
        break;
    case "PUT":
        update($track);
        break;
    case "POST":
        create($track);
        break;
    case "GET":
        !empty($_GET["id"]) ? create($track) : readAll($track);
}


function readAll(Track $track) {
    $all = $track->readAll();
    $row_counter = $all->rowCount();

    if ($row_counter > 0) {
        $tracks_arr = [];
        $tracks_arr["data"] = [];

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

            array_push($tracks_arr["data"], $track_item);
        }

        echo json_encode($tracks_arr);

    } else {
        echo json_encode(["message" => "No tracks found."]);
    }
}


function readOne(Track $track) {
    $track->id = isset($_GET["id"]) ? $_GET["id"] : die();

    $one = $track->readOne();
    $row = $one->fetch(PDO::FETCH_ASSOC);

    $track->record_id = $row["record_id"];
    $track->artist = $row["artist"];
    $track->title = $row["title"];

    $track_arr = [
        "id" => $track->id,
        "record_id" => $track->record_id,
        "artist" => $track->artist,
        "title" => $track->title
    ];

    print_r(json_encode($track_arr));
}


function create(Track $track) {
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Allow-Headers: Access-Control-Allow-Headers, Access-Control-Allow-Methods, Content-Type");

    $data = json_decode(file_get_contents("php://input"));

    $track->record_id = $data->record_id;
    $track->title = $data->title;

    echo json_encode($track->create() ?
        ["message:" => "Track created."] :
        ["message:" => "Track not created."]
    );
}


function update(Track $track) {
    header("Access-Control-Allow-Methods: PUT");
    header("Access-Control-Allow-Headers: Access-Control-Allow-Headers, Access-Control-Allow-Methods, Content-Type");

    $data = json_decode(file_get_contents("php://input"));

    $track->id = $data->id;
    $track->record_id = $data->record_id;
    $track->title = $data->title;

    echo json_encode($track->update() ?
        ["message:" => "Track updated."] :
        ["message:" => "Track not updated."]
    );
}


function delete(Track $track) {
    header("Access-Control-Allow-Methods: DELETE");
    header("Access-Control-Allow-Headers: Access-Control-Allow-Headers, Access-Control-Allow-Methods, Content-Type");

    $data = json_decode(file_get_contents("php://input"));

    $track->id = $data->id;

    echo json_encode($track->delete() ?
        ["message:" => "Track deleted."] :
        ["message:" => "Track not deleted."]
    );
}

?>
