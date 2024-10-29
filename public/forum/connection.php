<?php

error_reporting(0);

$svn = "localhost";
$sun = "u802091730_compass";
$spw = "CompassPub2024!";
$db = "u802091730_seg";

try {
    $con = new PDO("mysql:host=$svn;dbname=$db", $sun, $spw);
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $c_acc_sql = "CREATE TABLE IF NOT EXISTS account (
    id int not null auto_increment primary key,
    username text(3000) not null,
    name text(3000) not null,
    birthdate text(3000),
    gender text(3000) not null,
    email text(3000) not null,
    phone text(3000) not null,
    password text(3000) not null,
    profile_pic text(3000),
    cover_pic text(3000),
    job text(3000),
    workplace text(3000),
    subject text(3000),
    education text(3000),
    city text(3000),
    dt datetime not null
    )";

    $c_post_sql = "CREATE TABLE IF NOT EXISTS post (
    id int not null auto_increment primary key,
    acc_id int not null,
    group_id int not null,
    body text(3000),
    dt datetime not null,
    media_1 text(3000),
    media_2 text(3000),
    media_3 text(3000),
    media_4 text(3000)
    )";

    $c_foll_sql = "CREATE TABLE IF NOT EXISTS following (
    id int not null auto_increment primary key,
    acc_id_1 int not null,
    acc_id_2 int not null,
    dt datetime not null
    )";

} catch (PDOException $e) {
    print $e->getMessage();
}
