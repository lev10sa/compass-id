<?php

include './connection.php';

if (isset($_SESSION['s_em']) && isset($_SESSION['s_pw'])) {

    header('location: ./home.php');
} else {

    $em = $_POST['email'];
    $pw = $_POST['pass'];

    if (isset($em) && isset($pw)) {

        $selsql = "SELECT COUNT(*) FROM accounts WHERE email = '$em' AND password = '$pw'";
        $sel = $con->query($selsql);
        $sel->setFetchMode(PDO::FETCH_ASSOC);
        $num = $sel->fetchColumn();

        if ($num == 1) {
            $_SESSION['s_em'] = $em;
            $_SESSION['s_pw'] = $pw;
            header('location: ./home.php');
        } else {

?>
            <script>
                alert("Email/Kata Sandi yang anda masukkan salah! Untuk mengatur ulang Email/Kata Sandi, silakan hubungi CS kami via WhatsApp: 0851-7444-8002.");
            </script>
    <?php

        }
    }

    ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Forum | Compass Publishing Indonesia</title>
        <link rel="icon" href="https://compasspubindonesia.com/favicon.ico" type="image/x-icon">
        <link rel="stylesheet" href="https://compasspubindonesia.com/forum/style.css">
    </head>

    <body>

        <section class="login">

            <div class="form">
                <img src="https://compasspubindonesia.com/logo.png" alt="" onclick="window.open('./', 'blank')">
                <h1>Masuki Forum, dan telusuri berbagai sudut pandang.</h1>
                <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" placeholder="blabla@blabla.com" required>
                    <label for="pass">Password</label>
                    <input type="password" name="pass" id="pass" placeholder="a-z, A-Z, 1-9" required>
                    <button type="submit">MASUKI FORUM</button>
                    <a href="./register.php" target="_self" rel="noopener noreferrer">BUAT AKUN BARU</a>
                </form>
            </div>

            <div class="banner">
                <img src="https://compasspubindonesia.com//assets/img/banner/c.jpg" alt="">
                <img src="https://compasspubindonesia.com//assets/img/banner/b.jpg" alt="">
                <img src="https://compasspubindonesia.com//assets/img/banner/d.jpg" alt="">
            </div>

        </section>

    </body>

    </html>
<?php

}

?>