<?php

$host = "localhost";
$dbname = "giesteiralogin_db";
$username = "root";
$password = "";

$mysqli = new mysqli($host, $username, $password, $dbname);

if ($mysqli->connect_errno) {
    die("Erro de conexão" . $mysqli->connect_errno);
}

return $mysqli;
?>