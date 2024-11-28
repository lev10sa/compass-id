<?php

date_default_timezone_set('Asia/Jakarta');

session_start();

error_reporting(0);

$svn = "localhost";
$sun = "u802091730_compass";
$spw = "CompassPub2024!";
$db = "u802091730_seg";

try {

    $con = new PDO("mysql:host=$svn;dbname=$db", $sun, $spw);
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $con->query("SET time_zone = '+07:00'");
} catch (PDOException $e) {
    print $e->getMessage();
}

try {

    $accSQL = "CREATE TABLE IF NOT EXISTS accounts (
    id int not null auto_increment primary key,
    username varchar(30) not null unique,
    name text(3000) not null,
    birthdate text(3000) not null,
    gender text(3000) not null,
    email varchar(99) not null unique,
    phone text(3000) not null,
    password text(3000) not null,
    profile_pic text(3000),
    cover_pic text(3000),
    dt datetime not null
    )";
    $con->query($accSQL);

    $likeSQL = "CREATE TABLE IF NOT EXISTS likes (
    id int not null auto_increment primary key,
    acc_id text(3000) not null,
    post_id text(3000) not null,
    comm_id text(3000) not null,
    dt datetime not null
    )";
    $con->query($likeSQL);

    $folSQL = "CREATE TABLE IF NOT EXISTS follows (
    id int not null auto_increment primary key,
    acc_main text(3000) not null,
    acc_sec text(3000) not null,
    dt datetime not null
    )";
    $con->query($folSQL);

    $commSQL = "CREATE TABLE IF NOT EXISTS comments (
    id int not null auto_increment primary key,
    post_id text(3000) not null,
    acc_id text(3000) not null,
    body text(3000) not null,
    media text(3000) not null,
    dt datetime not null
    )";
    $con->query($commSQL);

    $msgSQL = "CREATE TABLE IF NOT EXISTS messages (
    id int not null auto_increment primary key,
    acc_main text(3000) not null,
    acc_sec text(3000) not null,
    body text(3000) not null,
    media text(3000) not null,
    status text(3000) not null,
    dt datetime not null
    )";
    $con->query($msgSQL);

    $postSQL = "CREATE TABLE IF NOT EXISTS posts (
    id int not null auto_increment primary key,
    acc_id text(3000) not null,
    media text(3000),
    body text(3000) not null,
    dt datetime not null
    )";
    $con->query($postSQL);

    $saveSQL = "CREATE TABLE IF NOT EXISTS saves (
    id int not null auto_increment primary key,
    acc_id text(3000) not null,
    post_id text(3000) not null
    )";
    $con->query($saveSQL);

    $visitSQL = "CREATE TABLE IF NOT EXISTS visitors (
    id int not null auto_increment primary key,
    acc_id text(3000) not null,
    ip text(3000) not null,
    dt datetime not null
    )";
    $con->query($visitSQL);
} catch (PDOException $e) {
    print $e->getMessage();
}
