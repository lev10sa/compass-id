<?php

error_reporting(0);

$svn = "localhost";
$sun = "u802091730_compass";
$spw = "CompassPub2024!";
$db = "u802091730_seg";

try {

    $con = new PDO("mysql:host=$svn;dbname=$db", $sun, $spw);
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $c_acc_sql = "CREATE TABLE IF NOT EXISTS accounts (
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

    $c_thread_sql = "CREATE TABLE IF NOT EXISTS threads (
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

    $c_comm_sql = "CREATE TABLE IF NOT EXISTS comments (
    id int not null auto_increment primary key,
    post_id int not null,
    acc_id int not null,
    body text(3000),
    dt datetime not null
    )";

    $c_reply_sql = "CREATE TABLE IF NOT EXISTS replies (
    id int not null auto_increment primary key,
    post_id int not null,
    comm_id int not null,
    acc_id int not null,
    body text(3000),
    dt datetime not null
    )";

    $c_foll_sql = "CREATE TABLE IF NOT EXISTS follows (
    id int not null auto_increment primary key,
    acc_id_1 int not null,
    acc_id_2 int not null,
    dt datetime not null
    )";

    $c_channel_sql = "CREATE TABLE IF NOT EXISTS channels (
    id int not null auto_increment primary key,
    name text(3000) not null,
    detail text(3000),
    cover_pic text(3000)
    )";

    $c_like_sql = "CREATE TABLE IF NOT EXISTS likes (
    id int not null auto_increment primary key,
    post_id int,
    reply_id int,
    comm_id int,
    acc_id int not null,
    dt datetime not null
    )";

    $c_visitor_sql = "CREATE TABLE IF NOT EXISTS visitors (
    id int not null auto_increment primary key,
    acc_id int not null,
    ip text(3000) not null,
    dt date not null
    )";

    $c_member_sql = "CREATE TABLE IF NOT EXISTS members (
    id int not null auto_increment primary key,
    acc_id int not null,
    channel_id int not null,
    status text(3000),
    dt datetime not null
    )";

    $sql = [$c_acc_sql, $c_comm_sql, $c_foll_sql, $c_channel_sql, $c_reply_sql, $c_thread_sql, $c_like_sql, $c_member_sql, $c_visitor_sql];

    for($i = 0; $i <= count($sql); $i++) {
            $con->query($sql[$i]);    
    }

} catch (PDOException $e) {
    print $e->getMessage();
}
