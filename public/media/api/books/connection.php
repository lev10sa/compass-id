<?php

$svn = "localhost";
$sun = "u802091730_compass";
$spw = "CompassPub2024!";
$db = "u802091730_seg";

try {
    $con = new PDO("mysql:host=$svn;dbname=$db", $sun, $spw);
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    print $e->getMessage();
}
