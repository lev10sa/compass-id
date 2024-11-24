<?php

require "./connection.php";

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, PATCH, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$method = $_SERVER['REQUEST_METHOD'];

if ($method === "GET") {

    $key = $_GET['key'];

    if ($key !== "") {
        $sql = "SELECT * FROM books WHERE isbn LIKE '%$key%' OR name LIKE '%$key%' OR category LIKE '%$key%' ORDER BY name ASC";
        $data = $con->query($sql);
        $data->setFetchMode(PDO::FETCH_ASSOC);
        $books = $data->fetchAll();
    } else {
        $sql = "SELECT * FROM books ORDER BY name ASC";
        $data = $con->query($sql);
        $data->setFetchMode(PDO::FETCH_ASSOC);
        $books = $data->fetchAll();
    }

    print json_encode($books);
}
