<?php

include "./connection.php";

$sd = session_destroy();

if ($sd) {
    header("location: ./");
}

?>