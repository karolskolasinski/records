<?php

function setupRecord(): Record {
    require_once "./config/Database.php";
    require_once "./model/Record.php";

    $database = new Database();
    $conn = $database->connect();
    $record = new Record($conn);
    return $record;
}


function readAllRecords() {
    $record = setupRecord();
    $all = $record->readAllRecords();
    $row_counter = $all->rowCount();

    if ($row_counter > 0) {
        $records_arr = [];

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

            array_push($records_arr, $record_item);
        }

        return $records_arr;

    } else {
        return ["message" => "No records found"];
    }
}


function readOneRecord($record_id) {
    $record = setupRecord();
    $record->id = $record_id;

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

    return $record_item;
}


function createRecord($artist, $title, $release_type, $release_year) {
    $record = setupRecord();

    $record->artist = $artist;
    $record->title = $title;
    $record->release_type = $release_type;
    $record->release_year = $release_year;

    return $record->createRecord() ?
        ["message" => "Record created"] :
        ["message" => "Record not created"];
}


function updateRecord($record_id, $artist, $title, $release_type, $release_year) {
    $record = setupRecord();

    $record->id = $record_id;
    $record->artist = $artist;
    $record->title = $title;
    $record->release_type = $release_type;
    $record->release_year = $release_year;

    return $record->updateRecord() ?
        ["message" => "Record updated"] :
        ["message" => "Record not updated"];
}


function deleteRecord($record_id) {
    $record = setupRecord();
    $record->id = $record_id;

    return $record->deleteRecord() ?
        ["message" => "Record deleted"] :
        ["message" => "Record not deleted"];
}

?>
