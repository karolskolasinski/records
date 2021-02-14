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
        $record_id = $_GET["record_id"];
        echo $twig->render("record.twig", [
            "record" => readOneRecord($record_id),
            "details" => readAllTracksForSpecificRecord($record_id),
        ]);
        break;
    case "add-record":
        echo $twig->render("add-record.twig");
        break;
    default:
        header("HTTP/1.0 404 Not Found");
        echo $twig->render("404.twig");
        break;
}

?>
