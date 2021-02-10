<?php

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

require_once "./vendor/autoload.php";
require_once "./service/recordService.php";

$loader = new FilesystemLoader("./views");
$twig = new Environment($loader);

function allRecords($twig) {
    return $twig->render("records.html.twig", [
        "records" => readAll(),
    ]);
}

function oneRecord($twig, $id) {
    return $twig->render("records.html.twig", [
        "record" => readOne($id),
    ]);
}

?>
