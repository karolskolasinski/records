<?php


switch ($_SERVER["REQUEST_METHOD"]) {
    case "DELETE":
        delete();
        break;
    case "PUT":
        update();
        break;
    case "POST":
        create();
        break;
    case "GET":
        !empty($_GET["id"]) ? readOne() : readAll();
}


function setup(): Record {
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json");

    require_once "../config/Database.php";
    require_once "../model/Record.php";

    $database = new Database();
    $conn = $database->connect();
    $record = new Record($conn);
    return $record;
}


function readAll() {
    $record = setup();
    $all = $record->readAllRecords();
    $row_counter = $all->rowCount();

    if ($row_counter > 0) {
        $records_arr = [];
        $records_arr["data"] = [];

        while ($row = $all->fetch(PDO::FETCH_ASSOC)) {
            extract($row);

            /** @var int $id */
            /** @var string $artist */
            /** @var string $title */
            /** @var string $release_type */
            /** @var string $release_year */
            $record_item = [
                "id" => $id,
                "artist" => $artist,
                "title" => $title,
                "release_type" => $release_type,
                "release_year" => $release_year,
            ];

            array_push($records_arr["data"], $record_item);
        }

        echo json_encode($records_arr);

    } else {
        echo json_encode(["message" => "No tracks found."]);
    }
}


function readOne() {
    $record = setup();
    $record->id = isset($_GET["id"]) ? $_GET["id"] : die();

    $one = $record->readOneRecord();
    $row = $one->fetch(PDO::FETCH_ASSOC);

    $record->artist = $row["artist"];
    $record->title = $row["title"];
    $record->release_type = $row["release_type"];
    $record->release_year = $row["release_year"];

    $record_item = [
        "id" => $record->id,
        "artist" => $record->artist,
        "title" => $record->title,
        "release_type" => $record->release_type,
        "release_year" => $record->release_year,
    ];

    print_r(json_encode($record_item));
}


function create() {
    $record = setup();
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Allow-Headers: Access-Control-Allow-Headers, Access-Control-Allow-Methods, Content-Type");

    $data = json_decode(file_get_contents("php://input"));

    $record->artist = $data->artist;
    $record->title = $data->title;
    $record->release_type = $data->release_type;
    $record->release_year = $data->release_year;

    echo json_encode($record->createRecord() ?
        ["message" => "Record created."] :
        ["message" => "Record not created."]
    );
}


function update() {
    $record = setup();
    header("Access-Control-Allow-Methods: PUT");
    header("Access-Control-Allow-Headers: Access-Control-Allow-Headers, Access-Control-Allow-Methods, Content-Type");

    $data = json_decode(file_get_contents("php://input"));

    $record->id = $data->id;
    $record->artist = $data->artist;
    $record->title = $data->title;
    $record->release_type = $data->release_type;
    $record->release_year = $data->release_year;

    echo json_encode($record->updateRecord() ?
        ["message" => "Record updated."] :
        ["message" => "Record not updated."]
    );
}


function delete() {
    $record = setup();
    header("Access-Control-Allow-Methods: DELETE");
    header("Access-Control-Allow-Headers: Access-Control-Allow-Headers, Access-Control-Allow-Methods, Content-Type");

    $data = json_decode(file_get_contents("php://input"));

    $record->id = $data->id;

    echo json_encode($record->deleteRecord() ?
        ["message" => "Record deleted."] :
        ["message" => "Record not deleted."]
    );
}

?>
