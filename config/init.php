<?php

session_start();

require "config/db.php";
require "classes/Users.php";

$conn = new Db();
$db = $conn->connect();

$users = new Users($db);

//Sanitize inputs
function sanitise_inputs($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}