<?php

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

require_once "./vendor/autoload.php";
require_once "./service/recordService.php";
require_once "./service/trackService.php";

$loader = new FilesystemLoader("./views");
$twig = new Environment($loader);

$page = "home";
if (isset($_GET["p"])) {
    $page = $_GET["p"];
}

switch ($page) {
    case "home":
        echo $twig->render("index.twig");
        break;
    case "records":
        echo $twig->render("records.twig", [
            "records" => readAllRecords(),
        ]);
        break;
    case "record":
        $record_id = $_GET["record-id"];

        echo $twig->render("record.twig", [
            "record" => readOneRecord($record_id),
            "details" => readAllTracksForSpecificRecord($record_id),
        ]);
        break;
    case "add-record":
        if ($_SERVER["REQUEST_METHOD"] === "GET") {
            echo $twig->render("record-form.twig");
        }

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $artist = htmlspecialchars($_POST["artist"]);
            $title = htmlspecialchars($_POST["title"]);
            $release_type = htmlspecialchars($_POST["release-type"]);
            $release_year = htmlspecialchars($_POST["release-year"]);
            $result = createRecord($artist, $title, $release_type, $release_year);
            $record_id = $result["record_id"];

            echo $twig->render("record.twig", [
                "message" => $result,
                "record" => readOneRecord($record_id),
                "details" => readAllTracksForSpecificRecord($record_id),
            ]);
        }
        break;
    case "update-record":
        if ($_SERVER["REQUEST_METHOD"] === "GET") {
            $record_id = $_GET["record-id"];
            echo $twig->render("record-form.twig", [
                "record" => readOneRecord($record_id),
            ]);
        }

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $record_id = htmlspecialchars($_POST["record-id"]);
            $artist = htmlspecialchars($_POST["artist"]);
            $title = htmlspecialchars($_POST["title"]);
            $release_type = htmlspecialchars($_POST["release-type"]);
            $release_year = htmlspecialchars($_POST["release-year"]);
            $message = updateRecord($record_id, $artist, $title, $release_type, $release_year);

            echo $twig->render("record.twig", [
                "message" => $message,
                "record" => readOneRecord($record_id),
                "details" => readAllTracksForSpecificRecord($record_id),
            ]);
        }
        break;
    case "delete-record":
        $record_id = $_GET["record-id"];
        $message = deleteRecord($record_id);
        echo $twig->render("records.twig", [
            "records" => readAllRecords(),
            "message" => $message,
        ]);
        break;
    case "add-track":
        if ($_SERVER["REQUEST_METHOD"] === "GET") {
            $record_id = $_GET["record-id"];
            echo $twig->render("track-form.twig", [
                "record" => readOneRecord($record_id)]);
        }

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $record_id = htmlspecialchars($_POST["record-id"]);
            $title = htmlspecialchars($_POST["title"]);
            $message = createTrack($record_id, $title);

            echo $twig->render("record.twig", [
                "message" => $message,
                "record" => readOneRecord($record_id),
                "details" => readAllTracksForSpecificRecord($record_id),
            ]);
        }
        break;
    case "update-track":
        $message = null;
        $record_id = null;
        $track_id = null;

        if ($_SERVER["REQUEST_METHOD"] === "GET") {
            $record_id = $_GET["record-id"];
            $track_id = $_GET["track-id"];
        }

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $record_id = htmlspecialchars($_POST["record-id"]);
            $track_id = htmlspecialchars($_POST["track-id"]);
            $title = htmlspecialchars($_POST["title"]);
            $message = updateTrack($track_id, $record_id, $title);
        }

        echo $twig->render("track-form.twig", [
            "record" => readOneRecord($record_id),
            "track" => readOneTrack($track_id),
            "message" => $message,
        ]);
        break;
    case "delete-track":
        $record_id = $_GET["record-id"];
        $track_id = $_GET["track-id"];
        $message = deleteTrack($track_id);

        echo $twig->render("record.twig", [
            "record" => readOneRecord($record_id),
            "details" => readAllTracksForSpecificRecord($record_id),
            "message" => $message,
        ]);

        break;
    default:
        header("HTTP/1.0 404 Not Found");
        echo $twig->render("404.twig");
        break;
}

?>
