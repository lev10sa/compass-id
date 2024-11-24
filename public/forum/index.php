<?php

include "./connection.php";

if (isset($_SESSION['s_em']) && isset($_SESSION['s_pw'])) {
    header('location: ./home.php');
} else {
    header('location: ./login.php');
}
