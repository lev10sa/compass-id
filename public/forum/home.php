<?php

include './connection.php';

if (isset($_SESSION['s_em']) && isset($_SESSION['s_pw'])) {

?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Forum | Compass Publishing Indonesia</title>
        <link rel="icon" href="https://compasspubindonesia.com/favicon.ico" type="image/x-icon">
        <link rel="stylesheet" href="https://compasspubindonesia.com/style.css">
    </head>

    <body>

    </body>

    </html>
<?php


} else {
    header('location: ./home.php');
}
?>