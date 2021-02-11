<?php

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

require_once "../vendor/autoload.php";
require_once "../service/recordService.php";

$loader = new FilesystemLoader("./");
$twig = new Environment($loader);

echo $twig->render("records.html.twig", [
    "records" => readAll(),
]);
?>
