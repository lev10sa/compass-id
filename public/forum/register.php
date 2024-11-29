<?php

include './connection.php';

if (isset($_SESSION['s_em']) && isset($_SESSION['s_pw'])) {

    header('location: ./trends.php');
} else {

    $un = $_POST['un'];
    $fn = $_POST['fn'];
    $bd = $_POST['bd'];
    $gn = $_POST['gn'];
    $em = $_POST['em'];
    $pn = $_POST['pn'];
    $pw = $_POST['pw'];
    $pp = "https://compasspubindonesia.com/user.png";
    $cp = "https://compasspubindonesia.com/cover.png";

    if (isset($un) && isset($fn) && isset($bd) && isset($gn) && isset($em) && isset($pn) && isset($pw)) {

        $inssql = "INSERT IGNORE INTO accounts (username, name, birthdate, gender, email, phone, password, profile_pic, cover_pic, dt) VALUES ('$un', '$fn', '$bd', '$gn', '$em', '$pn', '$pw', '$pp', '$cp', NOW())";
        $ins = $con->query($inssql);

        if ($ins) {

            $selsql = "SELECT COUNT(*) FROM accounts WHERE email = '$em' AND password = '$pw'";
            $sel = $con->query($selsql);
            $sel->setFetchMode(PDO::FETCH_ASSOC);
            $num = $sel->fetchColumn();

            if ($num == 1) {
                $_SESSION['s_em'] = $em;
                $_SESSION['s_pw'] = $pw;
                header('location: ./trends.php');
            } else {

?>
                <script>
                    alert("Email/Kata Sandi yang anda masukkan salah! Untuk mengatur ulang Email/Kata Sandi, silakan hubungi CS kami via WhatsApp: 0851-7444-8002.");
                </script>
            <?php

            }
        } else {

            ?>
            <script>
                alert("Akun dengan informasi serupa, sudah tersedia! Silakan isi dengan informasi yang lain.");
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
        <link rel="stylesheet" href="https://compasspubindonesia.com/login.css">
        <link
            rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
        <link
            rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
        <link
            rel="stylesheet"
            href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
        <link
            rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    </head>

    <body>

        <section class="login">

            <div class="form">
                <img loading="lazy" src="https://compasspubindonesia.com/logo.png" alt="" onclick="window.open('./', '_self')">
                <h1>Bergabung bersama komunitas pengajar, dan bagikan kisahmu.</h1>
                <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
                    <label for="un">ID Pengguna</label>
                    <input type="text" name="un" id="un" placeholder="Contoh: blabla_official" required>
                    <label for="fn">Nama Lengkap</label>
                    <input type="text" name="fn" id="fn" placeholder="Contoh: John Doe" required>
                    <label for="bd">Tanggal Lahir</label>
                    <input type="date" name="bd" id="bd" placeholder="Contoh: 01/01/1981" required>
                    <label for="bd">Jenis Kelamin</label>
                    <select name="gn" id="gn" required>
                        <option value="">--- Pilih Jenis Kelamin ---</option>
                        <option value="Laki-laki">Laki-laki</option>
                        <option value="Perempuan">Perempuan</option>
                    </select>
                    <label for="em">Email</label>
                    <input type="email" name="em" id="em" placeholder="Contoh: blabla@blabla.com" required>
                    <label for="pn">Telepon</label>
                    <input type="phone" name="pn" id="pn" placeholder="Contoh: 085122213331" required>
                    <label for="pw">Kata Sandi</label>
                    <input type="password" name="pw" id="pw" placeholder="Contoh: Blablabla1234" required>
                    <button type="submit">BUAT AKUN BARU</button>
                    <a href="./login.php" target="_self" rel="noopener noreferrer">MASUKI FORUM</a>
                </form>
            </div>

            <div class="banner">
                <img loading="lazy" src="https://compasspubindonesia.com//assets/img/banner/c.jpg" alt="">
                <img loading="lazy" src="https://compasspubindonesia.com//assets/img/banner/b.jpg" alt="">
                <img loading="lazy" src="https://compasspubindonesia.com//assets/img/banner/d.jpg" alt="">
            </div>

        </section>

    </body>

    </html>
<?php

}

?>