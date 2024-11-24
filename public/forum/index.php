<?php

include "./connection.php";

if (ISSET($_SESSION['s_em']) && ISSET($_SESSION['s_pw'])) {
    header('location: ./home.php');
} else {
    header('location: ./login.php');
}

?>