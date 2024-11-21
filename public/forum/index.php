<?php

include "./connection.php";

if (ISSET($_SESSION['s_un']) && ISSET($_SESSION['s_pw'])) {
    header('location: ./home.php');
} else {
    header('location: ./login.php');
}

?>