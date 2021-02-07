<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Access-Control-Allow-Headers, Access-Control-Allow-Methods, Content-Type");

require_once "../../config/Database.php";
require_once "../../model/Track.php";

$database = new Database();
$conn = $database->connect();
$track = new Track($conn);

$data = json_decode(file_get_contents("php://input"));

$track->record_id = $data->record_id;
$track->title = $data->title;

echo json_encode($track->create() ?
    ["message:" => "Track created"] :
    ["message:" => "Track not created"]
);

?>
