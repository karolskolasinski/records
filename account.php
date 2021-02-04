<?php

$login = $_POST['login'];
$password = $_POST['password'];

echo <<<END
    <h1>$login</h1>
    <h1>$password</h1>
END;

?>
