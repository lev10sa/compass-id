<?php
include './connection.php';

$un = $_GET['un'];

if (isset($_GET['un'])) {


    if (isset($_GET['acc_main']) && isset($_GET['acc_sec']) && isset($_GET['type'])) {

        $acc_main = $_GET['acc_main'];
        $acc_sec = $_GET['acc_sec'];

        if (isset($_SESSION['s_em']) && isset($_SESSION['s_pw'])) {

            if ($_GET['type'] == 'follow') {
                $flSQL = "INSERT IGNORE INTO follows (acc_main, acc_sec, dt) VALUES ('$acc_main', '$acc_sec', NOW())";
                $con->query($flSQL);
                $selfoSQL = "SELECT * FROM follows WHERE acc_main = '$acc_main' AND acc_sec = '$acc_sec'";
                $selfo = $con->query($selfoSQL);
                $selfo->fetchAll(PDO::FETCH_ASSOC);
                foreach ($selfo as $slfo) {

                    $fol_id = $slfo['id'];
                    $fiSQL = "INSERT INTO notifications (acc_main, acc_sec, fol_id, dt) VALUES ('$acc_main', '$acc_sec', '$fol_id', NOW())";
                    $con->query($fiSQL);
                }
                header('location: ./followers.php?un=' . $un);
            }

            if ($_GET['type'] == 'unfollow') {
                $ulfSQL = "DELETE FROM follows WHERE acc_main = '$acc_main' AND acc_sec = '$acc_sec'";
                $con->query($ulfSQL);
                $ulfsSQL = "DELETE FROM notifications WHERE acc_main = '$acc_main' AND acc_sec = '$acc_sec' AND fol_id LIKE '%$fol_id%'";
                $con->query($ulfsSQL);
                header('location: ./followers.php?un=' . $un);
            }
        } else {

            header('location: ./login.php');
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
        <link rel="stylesheet" href="./login.css">
        <link rel="stylesheet" href="./home.css">
        <link rel="stylesheet" href="./followers.css">
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

        <div class="navbar">
            <img loading="lazy" class="logo" src="https://compasspubindonesia.com/logo.png" alt="" onclick="window.open('./', '_self')">
            <a onclick="menu(1)"><i class="fas fa-bars"></i></a>
            <a href="./notify.php"><i class="fas fa-bell"></i> (0)</a>
            <a href="./chats.php"><i class="fas fa-envelope"></i> (0)</a>
        </div>

        <div class="body">

            <div class="left">
                <a onclick="menu(0)" class="cld"><i class="fas fa-close"></i> Tutup</a>
                <img loading="lazy" class="logo" src="https://compasspubindonesia.com/logo.png" alt="" onclick="window.open('./', '_self')">
                <?php
                if (isset($_SESSION['s_em']) && isset($_SESSION['s_pw'])) {
                    $em = $_SESSION['s_em'];
                    $pw = $_SESSION['s_pw'];

                    $sqlProf = "SELECT * FROM accounts WHERE email = '$em' AND password = '$pw'";
                    $stmt = $con->query($sqlProf);
                    $prof = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    $sqlPrif = "SELECT * FROM accounts WHERE username = '$un'";
                    $stmti = $con->query($sqlPrif);
                    $prif = $stmti->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($prof as $prf) {
                        $ids = $prf['id'];
                        foreach ($prif as $pref) {
                            $id = $pref['id'];

                ?>
                            <div class="hero">
                                <div class="image">
                                    <img loading="lazy" src="<?= htmlspecialchars($prf['profile_pic']); ?>" alt="">
                                </div>
                                <div class="label">
                                    <a href="./profile.php?un=<?= htmlspecialchars($prf['username']); ?>"><?= ucwords(htmlspecialchars($prf['name'])); ?></a>
                                    <p>@<?= htmlspecialchars($prf['username']); ?></p>
                                </div>
                            </div>
                <?php
                        }
                    }
                }
                ?>
                <div class="tabs">
                    <?php
                    if (isset($_SESSION['s_em']) && isset($_SESSION['s_pw'])) {
                    ?>
                        <a href="./"><i class="fas fa-home"></i> Beranda</a>
                        <a href="./search_user.php?key="><i class="fas fa-search"></i> Cari</a>
                        <a href="./notify.php"><i class="fas fa-bell"></i> Notifikasi (0)</a>
                        <a href="./chats.php"><i class="fas fa-envelope"></i> Pesan (0)</a>
                        <a href="./profile.php?un=<?= $prf['username']; ?>"><i class="fas fa-user-circle"></i> Profil</a>
                        <a href="./followers.php?un=<?= $prf['username']; ?>"><i class="fas fa-user-plus"></i> Koneksi</a>
                        <a href="./saved.php"><i class="fas fa-bookmark"></i> Tersimpan</a>
                        <a href="https://wa.me/6285156357557"><i class="fas fa-headset"></i> Pusat Bantuan</a>
                        <a href="https://chat.whatsapp.com/Ly97FaHU2nyAsNGxMCVZWd"><i class="fas fa-users"></i> Komunitas</a>
                        <a onclick="ext()"><i class="fa fa-sign-out"></i> Keluar</a>
                        <script>
                            let ext = () => {

                                if (confirm('Yakin, mau keluar!?')) {
                                    window.open('./logout.php', '_self')
                                }

                            }
                        </script>
                    <?php

                    } else {

                    ?>
                        <div class="logi">
                            <a href="./login.php">MASUKI AKUN</a>
                            <a href="./register.php">BUAT AKUN BARU</a>
                        </div>
                    <?php
                    }
                    ?>
                </div>

            </div>

            <div class="mid">
                <div class="tabs">
                    <a href="./followers.php?un=<?= $pref['username']; ?>" class="active">Pengikut</a>
                    <a href="./followings.php?un=<?= $pref['username']; ?>">Mengikuti</a>
                    <a></a>
                </div>
                <div class="flower">
                    <?php
                    $sqlArt = "SELECT accounts.username, accounts.name, accounts.email, accounts.profile_pic, accounts.id, follows.acc_main, follows.acc_sec FROM accounts, follows WHERE accounts.id = follows.acc_main AND follows.acc_sec = '$id'";
                    $selArt = $con->query($sqlArt);
                    $selArt->setFetchMode(PDO::FETCH_ASSOC);
                    $art = $selArt->fetchAll();

                    $sqlArtd = "SELECT COUNT(*) FROM accounts, follows WHERE accounts.id = follows.acc_main AND follows.acc_sec = '$id'";
                    $selArtd = $con->query($sqlArtd);
                    $artd = $selArtd->fetchColumn();

                    ?>
                    <p class="label"><?= $artd; ?> Orang Mengikuti</p>
                    <?php

                    if ($art) {

                        foreach ($art as $pos) {

                            $idp = $pos['id'];

                    ?>
                            <div class="flow">
                                <img src="<?= $pos['profile_pic']; ?>" />
                                <a href="./profile.php?un=<?= $pos['username']; ?>"><?= ucwords(htmlspecialchars($pos['name'])); ?></a>
                                <p>@<?= $pos['username']; ?></p>
                                <?php

                                $sqlflo = "SELECT * FROM follows WHERE acc_main = '$ids' AND acc_sec = '$idp'";
                                $stmto = $con->query($sqlflo);
                                $flo = $stmto->fetchAll();

                                $sqlflod = "SELECT * FROM follows WHERE acc_main = '$idp' AND acc_sec = '$ids'";
                                $stmtd = $con->query($sqlflod);
                                $flod = $stmtd->fetchAll();

                                if ($ids == $idp) {

                                ?>
                                    <a class="ufol">Mengikuti Anda</a>
                                    <?php
                                } else if (!$flo && !$flod) {

                                    if ($_SESSION['s_em'] !== $pos['email']) {

                                    ?>
                                        <a href="./followers.php?un=<?= $un; ?>&acc_main=<?= $ids ?>&acc_sec=<?= $pos['acc_main'] ?>&type=follow" class="fol">Ikuti</a>
                                    <?php

                                    }
                                } else if ($flo) {

                                    ?>
                                    <a onclick="unfol(<?= $pos['acc_main']; ?>)" class="ufol">Mengikuti</a>
                                <?php
                                } else if ($flod) {

                                ?>
                                    <a href="./followers.php?un=<?= $un; ?>&acc_main=<?= $ids; ?>&acc_sec=<?= $pos['acc_main']; ?>&type=follow" class="fol">Ikuti Balik</a>
                                <?php
                                }

                                ?>
                            </div>
                    <?php
                        }
                    }

                    ?>

                </div>
            </div>

            <div class="right">
                <div class="srch">
                    <form action="./search_user.php?key=" method="get">
                        <input type="text" name="key" id="key" placeholder="Cari..">
                    </form>
                </div>
                <div class="rec">
                    <p>Saran Koneksi</p>
                    <?php

                    $sqlPer3 = "SELECT * FROM accounts LIMIT 10";
                    $selPer3 = $con->query($sqlPer3);
                    $selPer3->setFetchMode(PDO::FETCH_ASSOC);
                    $per3 = $selPer3->fetchAll();

                    foreach ($per3 as $p3) {

                        $idPer3 = $p3['id'];

                        $sqlflod = "SELECT * FROM follows WHERE acc_main = '$ids' AND acc_sec = '$idPer3'";
                        $stmtod = $con->query($sqlflod);
                        $flot = $stmtod->fetchAll();

                        $sqlflodt = "SELECT * FROM follows WHERE acc_main = '$idPer3' AND acc_sec = '$ids'";
                        $stmtdt = $con->query($sqlflodt);
                        $flodt = $stmtdt->fetchAll();

                        if (!$flot  && $idPer3 !== $ids) {

                    ?>
                            <div class="fig">
                                <div class="image">
                                    <img loading="lazy" src="<?= htmlspecialchars($p3['profile_pic']); ?>" alt="">
                                </div>
                                <div class="label">
                                    <a href="./profile.php?un=<?= htmlspecialchars($p3['username']); ?>"><?= ucwords(htmlspecialchars($p3['name'])); ?></a>
                                    <p>@<?= htmlspecialchars($p3['username']); ?></p>
                                </div>
                                <div class="fol">
                                    <?php
                                    if (!$flot && !$flodt) {

                                        if ($_SESSION['s_em'] !== $p3['email']) {

                                    ?>
                                            <a href="./followers.php?un=<?= $un; ?>&acc_main=<?= $ids ?>&acc_sec=<?= $p3['id'] ?>&type=follow">Ikuti</a>
                                        <?php

                                        }
                                    } else if ($flot) {

                                        ?>
                                        <a onclick="unfol(<?= $p3['id']; ?>)">Mengikuti</a>
                                    <?php
                                    } else if ($flodt) {

                                    ?>
                                        <a href="./followers.php?un=<?= $un; ?>&acc_main=<?= $ids ?>&acc_sec=<?= $p3['id'] ?>&type=follow">Ikuti Balik</a>
                                    <?php
                                    }


                                    ?>
                                </div>
                            </div>
                    <?php

                        }
                    }


                    ?>
                </div>
            </div>

        </div>

        <?php
        if (isset($_SESSION['s_em']) && isset($_SESSION['s_pw'])) {
        ?>
            <div class="sidenav">
                <div class="tabs">
                    <a href="./"><i class="fas fa-home"></i></a>
                    <a href="./search_user.php?key="><i class="fas fa-search"></i></a>
                    <a href="./followers.php?un=<?= $prf['username']; ?>"><i class="fas fa-group"></i></a>
                    <a href="./saved.php"><i class="fas fa-bookmark"></i></a>
                    <a href="./profile.php?un=<?= $prf['username']; ?>"><i class="fas fa-user-circle"></i></a>
                <?php

            }
                ?>

    </body>

    </html>
    <script>
        let menu = (val) => {

            if (val == 0) {
                document.querySelector('.left').style = 'display: none';
            } else if (val == 1) {
                document.querySelector('.left').style = 'display: block';
            }

        }
    </script>
    <script>
        let copi = (vel) => {
            let uri = `./post.php?post_id=${vel}`;
            let copied = navigator.clipboard.writeText(uri);
            if (copied) {
                alert('Tautan tersalin!');
            }
        }
    </script>
    <script>
        let unfol = (vlb) => {

            if (confirm('Berhenti mengikuti orang ini?')) {
                window.open("./followers.php?un=<?= $un; ?>&acc_main=<?= $ids; ?>&acc_sec=" + vlb + "&type=unfollow", '_self')
            }

        }
    </script>

<?php
} else {

    header('location: ./trends.php');
}
?>