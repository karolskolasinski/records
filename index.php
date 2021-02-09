<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Records</title>
</head>

<body>

<?php

use Twig\Environment;
use Twig\Loader\FilesystemLoader;
require_once "./vendor/autoload.php";
include "./service/recordService.php";

$readAll = readAll();

$loader = new FilesystemLoader("./views");
$twig = new Environment($loader);


echo $twig->render("records.html.twig", [
    "records" => $readAll,
]);

?>

</body>
</html>
