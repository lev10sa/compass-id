<?php
include './connection.php';

if (isset($_GET['un'])) {

    if (isset($_SESSION['s_em']) && isset($_SESSION['s_pw'])) {

        $em = $_SESSION['s_em'];

        $sqlPrif = "SELECT * FROM accounts WHERE email = :email";
        $stmtz = $con->prepare($sqlPrif);
        $stmtz->execute(['email' => $em]);
        $prif = $stmtz->fetchAll(PDO::FETCH_ASSOC);
    }

    $un = $_GET['un'];

    $sqlProf = "SELECT * FROM accounts WHERE username = :email";
    $stmt = $con->prepare($sqlProf);
    $stmt->execute(['email' => $un]);
    $prof = $stmt->fetchAll(PDO::FETCH_ASSOC);


    foreach ($prof as $prf) {

        $ids = $prf['id'];

        foreach ($prif as $pref) {
            $id = $pref['id'];

            if (isset($_GET['acc_main']) && isset($_GET['acc_sec']) && isset($_GET['type'])) {

                $acc_main = $_GET['acc_main'];
                $acc_sec = $_GET['acc_sec'];

                if (isset($_SESSION['s_em']) && isset($_SESSION['s_pw'])) {

                    if ($_GET['type'] == 'follow') {
                        $flSQL = "INSERT IGNORE INTO follows (acc_main, acc_sec, dt) VALUES ('$acc_main', '$acc_sec', NOW())";
                        $con->query($flSQL);
                        header('location: ./profile.php?un=' . $prf['username']);
                    } else if ($_GET['type'] == 'unfollow') {
                        $ulfSQL = "DELETE FROM follows WHERE acc_main = '$acc_main' AND acc_sec = '$acc_sec'";
                        $con->query($ulfSQL);
                        header('location: ./profile.php?un=' . $prf['username']);
                    }
                } else {

                    header('location: ./login.php');
                }
            }

            if (isset($_GET['acc_id']) && isset($_GET['post_id']) && isset($_GET['type'])) {

                $acc_id = $_GET['acc_id'];
                $post_id = $_GET['post_id'];

                if (isset($_SESSION['s_em']) && isset($_SESSION['s_pw'])) {

                    if ($_GET['type'] == 'like') {
                        $lkSQL = "INSERT IGNORE INTO likes (acc_id, post_id, dt) VALUES ('$acc_id', '$post_id', NOW())";
                        $con->query($lkSQL);
                        header('location: ./profile.php?un=' . $prf['username']);
                    } else if ($_GET['type'] == 'unlike') {
                        $ulkSQL = "DELETE FROM likes WHERE likes.acc_id = '$acc_id' AND likes.post_id = '$post_id'";
                        $con->query($ulkSQL);
                        header('location: ./profile.php?un=' . $prf['username']);
                    }

                    if ($_GET['type'] == 'save') {
                        $lkSQL = "INSERT IGNORE INTO saves (acc_id, post_id) VALUES ('$acc_id', '$post_id')";
                        $con->query($lkSQL);
                        header('location: ./profile.php?un=' . $prf['username']);
                    } else if ($_GET['type'] == 'unsave') {
                        $ulkSQL = "DELETE FROM saves WHERE saves.acc_id = '$acc_id' AND saves.post_id = '$post_id'";
                        $con->query($ulkSQL);
                        header('location: ./profile.php?un=' . $prf['username']);
                    }
                } else {

?>
                    <script>
                        alert('Anda harus masuk terlebih dahulu!');
                    </script>
            <?php

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
                <link rel="stylesheet" href="https://compasspubindonesia.com/login.css">
                <link rel="stylesheet" href="https://compasspubindonesia.com/home.css">
                <link rel="stylesheet" href="https://compasspubindonesia.com/profile.css">
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
                </div>

                <div class="body">

                    <div class="left">
                        <a onclick="menu(0)" class="cld"><i class="fas fa-close"></i> Tutup</a>
                        <img loading="lazy" class="logo" src="https://compasspubindonesia.com/logo.png" alt="" onclick="window.open('./', '_self')">
                        <?php

                        if (isset($_POST['r_ok'])) {
                            $body = addslashes($_POST['body']);
                            $media = ''; // Default value jika tidak ada file diunggah

                            if (isset($_FILES["mediam"]) && $_FILES["mediam"]["error"] === UPLOAD_ERR_OK) {
                                $fname = $_FILES["mediam"]["name"];
                                $ftmp = $_FILES["mediam"]["tmp_name"];
                                $tar = './user/' . $pref['username'] . '/post/';
                                $media = $tar . basename($fname);

                                // Buat direktori jika belum ada
                                if (!is_dir($tar)) {
                                    if (!mkdir($tar, 0777, true)) {
                                        echo "Gagal membuat direktori: $tar";
                                        exit;
                                    }
                                }

                                // Pindahkan file ke direktori tujuan
                                if (!move_uploaded_file($ftmp, $media)) {
                                    echo "Gagal memindahkan file.";
                                    exit;
                                }
                            }

                            // Simpan data ke database
                            $sqlPosv = "INSERT INTO posts (acc_id, body, media, dt) VALUES ('$id', '$body', '$media', NOW())";
                            $stmtv = $con->query($sqlPosv);
                            header('location: ./profile.php?un=' . $pref['username']);
                        }

                        $sqlsv = "SELECT COUNT(*) FROM saves WHERE acc_id = :id";
                        $stmt = $con->prepare($sqlsv);
                        $stmt->execute(['id' => $id]);
                        $sv = $stmt->fetchColumn();

                        if (isset($_SESSION['s_em']) && isset($_SESSION['s_pw'])) {
                        ?>
                            <div class="hero">
                                <div class="image">
                                    <img loading="lazy" src="<?= htmlspecialchars($pref['profile_pic']); ?>" alt="">
                                </div>
                                <div class="label">
                                    <a href="./profile.php?un=<?= $pref['username']; ?>&un=<?= htmlspecialchars($pref['username']); ?>"><?= htmlspecialchars($pref['name']); ?></a>
                                    <p>@<?= htmlspecialchars($pref['username']); ?></p>
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
                        <a href="./profile.php?un=<?= $pref['username']; ?>"><i class="fas fa-user-circle"></i> Profil</a>
                        <a href="./followers.php?un=<?= $pref['username']; ?>"><i class="fas fa-user-plus"></i> Koneksi</a>
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
                            <a href="./profile.php?un=<?= $pref['username']; ?>" class="active">Profil</a>
                            <?php

                            if ($prf['email'] == $pref['email'] && $prf['password'] == $pref['password']) {
                            ?>
                                <a href="./profile_edit.php">Edit Profil</a>
                            <?php
                            }
                            ?>
                        </div>
                        <div class="tomo">
                            <div class="cover">
                                <img src="<?= $prf['cover_pic'] ?>" alt="">
                            </div>
                            <div class="hero">
                                <div class="pic">
                                    <img src="<?= $prf['profile_pic'] ?>" alt="">
                                </div>
                                <div class="label">
                                    <a href="./profile.php?un=<?= $pref['username']; ?>&un=<?= htmlspecialchars($prf['username']); ?>"><?= htmlspecialchars($prf['name']); ?></a>
                                    <p>@<?= htmlspecialchars($prf['username']); ?></p>
                                </div>
                            </div>
                            <div class="panel">
                                <a><?php if ($prf['gender'] == 'Laki-laki') { ?><i class="fas fa-mars"></i> <?= $prf['gender']; ?><?php } else if ($prf['gender'] == 'Perempuan') { ?><i class="fas fa-venus"></i> <?= $prf['gender']; ?><?php } ?></a>
                                <?php
                                $sqlf = "SELECT COUNT(*) FROM follows WHERE acc_main = '$id'";
                                $st = $con->query($sqlf);
                                $fti = $st->fetchColumn();

                                $sqlfd = "SELECT COUNT(*) FROM follows WHERE acc_sec = '$id'";
                                $std = $con->query($sqlfd);
                                $ftid = $std->fetchColumn();
                                ?>
                                <a href="./followers.php?un=<?= $un; ?>"><?= $ftid ?> Pengikut</a>
                                <a href="./followings.php?un=<?= $un; ?>"><?= $fti ?> Diikuti</a>
                            </div>
                        </div>
                        <?php
                        if ($prf['email'] == $pref['email'] && $prf['password'] == $pref['password']) {
                        ?>
                            <div class="make">
                                <form action="./profile.php?un=<?= $pref['username'] ?>" method="post" enctype="multipart/form-data">
                                    <textarea name="body" id="body" placeholder="Tuliskan sesuatu. (max. 1000 karakter)" required maxlength="1000"></textarea>
                                    <input type="file" name="mediam" id="mediam" accept="image/jpg, image/png, image/jpeg, image/webp">
                                    <input type="submit" name="r_ok" id="r_ok" value="POSTING">
                                </form>
                            </div>
                        <?php
                        }
                        ?>
                        <div class="posed">
                            <?php

                            $sqlArt = "SELECT accounts.username, accounts.name, accounts.email, accounts.profile_pic, posts.id, posts.dt, posts.body, posts.media, posts.acc_id FROM accounts, posts WHERE accounts.id = posts.acc_id AND posts.acc_id = '$ids' ORDER BY posts.dt DESC";
                            $selArt = $con->query($sqlArt);
                            $selArt->setFetchMode(PDO::FETCH_ASSOC);
                            $art = $selArt->fetchAll();

                            if ($art) {

                                foreach ($art as $pos) {

                            ?>
                                    <div class="pos">
                                        <div class="fig">
                                            <?php

                                            $idp = $pos['acc_id'];

                                            $sqlflo = "SELECT * FROM follows WHERE acc_main = '$id' AND acc_sec = '$idp'";
                                            $stmto = $con->query($sqlflo);
                                            $flo = $stmto->fetchAll();

                                            $sqlflod = "SELECT * FROM follows WHERE acc_main = '$idp' AND acc_sec = '$id'";
                                            $stmtd = $con->query($sqlflod);
                                            $flod = $stmtd->fetchAll();

                                            if (!$flo && !$flod) {

                                                if ($_SESSION['s_em'] !== $pos['email']) {

                                            ?>
                                                    <a href="./profile.php?un=<?= $prf['username']; ?>&acc_main=<?= $id ?>&acc_sec=<?= $pos['acc_id'] ?>&type=follow" class="fol">Ikuti</a>
                                                <?php

                                                } else if ($pos['acc_id'] == $id) {

                                                ?>
                                                    <a href="./post_edit.php?post_id=<?= $pos['id'] ?>" class="ufol"><i class="fas fa-edit"></i> Edit</a>
                                                <?php
                                                }
                                            } else if ($flo) {

                                                ?>
                                                <a onclick="unfol(<?= $pos['acc_id'] ?>)" class="ufol">Mengikuti</a>

                                            <?php
                                            } else if ($flod) {

                                            ?>
                                                <a href="./profile.php?un=<?= $prf['username']; ?>&acc_main=<?= $id ?>&acc_sec=<?= $pos['acc_id'] ?>&type=follow" class="fol">Ikuti Balik</a>
                                            <?php
                                            }

                                            ?>
                                            <div class="image">
                                                <img loading="lazy" src="<?= htmlspecialchars($pos['profile_pic']); ?>" alt="">
                                            </div>
                                            <div class="label">
                                                <a href="./profile.php?un=<?= $pref['username']; ?>&un=<?= htmlspecialchars($pos['username']); ?>"><?= htmlspecialchars($pos['name']); ?></a>
                                                <p>@<?= htmlspecialchars($pos['username']); ?></p>
                                                <p><?= htmlspecialchars($pos['dt']); ?> WIB</p>
                                            </div>
                                        </div>
                                        <div class="content">
                                            <pre><?= $pos['body']; ?></pre>
                                            <?php
                                            if ($pos['media'] !== '') {
                                            ?>
                                                <img loading="lazy" src="<?= htmlspecialchars($pos['media']); ?>" alt="">
                                            <?php

                                            }

                                            ?>
                                        </div>
                                        <?php

                                        $posId = $pos['id'];

                                        $sqlLike = "SELECT COUNT(*) FROM likes, posts WHERE likes.post_id = posts.id AND likes.post_id = '$posId'";
                                        $selLike = $con->query($sqlLike);
                                        $likes = $selLike->fetchColumn();

                                        $sqlComm = "SELECT COUNT(*) FROM comments WHERE post_id = '$posId'";
                                        $selComm = $con->query($sqlComm);
                                        $comms = $selComm->fetchColumn();

                                        $sqlSvd = "SELECT COUNT(*) FROM posts, saves WHERE posts.id = saves.post_id AND saves.post_id = '$posId'";
                                        $selSvd = $con->query($sqlSvd);
                                        $svds = $selSvd->fetchColumn();

                                        $sqlLikes = "SELECT COUNT(*) FROM likes, posts WHERE likes.post_id = posts.id AND likes.acc_id = '$id' AND likes.post_id = '$posId'";
                                        $selLikes = $con->query($sqlLikes);
                                        $liked = $selLikes->fetchColumn();

                                        $sqlSvds = "SELECT COUNT(*) FROM posts, saves WHERE posts.id = saves.post_id AND saves.acc_id = '$id' AND saves.post_id = '$posId'";
                                        $selSvds = $con->query($sqlSvds);
                                        $svdsc = $selSvds->fetchColumn();
                                        ?>
                                        <div class="cnt">
                                            <p><?= $likes; ?> Menyukai</p>
                                            <p><?= $comms; ?> Mengomentari</p>
                                            <p><?= $svds; ?> Tersimpan</p>
                                        </div>
                                        <div class="panel">
                                            <?php
                                            if ($liked == 1) {
                                            ?>
                                                <a href="./profile.php?un=<?= $pref['username']; ?>&acc_id=<?= $id; ?>&post_id=<?= $pos['id'] ?>&type=unlike" target="_self" rel="noopener noreferrer" class="active"><i class="fas fa-thumbs-up"></i>Disukai</a>
                                            <?php
                                            } else {

                                            ?>
                                                <a href="./profile.php?un=<?= $pref['username']; ?>&acc_id=<?= $id; ?>&post_id=<?= $pos['id'] ?>&type=like" target="_self" rel="noopener noreferrer"><i class="fas fa-thumbs-up"></i>Suka</a>
                                            <?php
                                            }

                                            ?>
                                            <a href="./post.php?post_id=<?= $pos['id'] ?>" target="_self" rel="noopener noreferrer"><i class="fas fa-comment"></i>Komentar</a>
                                            <?php
                                            if ($svdsc == 1) {
                                            ?>
                                                <a href="./profile.php?un=<?= $pref['username']; ?>&acc_id=<?= $id; ?>&post_id=<?= $pos['id'] ?>&type=unsave" target="_self" rel="noopener noreferrer" class="active"><i class="fas fa-bookmark"></i>Disimpan</a>
                                            <?php
                                            } else {
                                            ?>
                                                <a href="./profile.php?un=<?= $pref['username']; ?>&acc_id=<?= $id; ?>&post_id=<?= $pos['id'] ?>&type=save" target="_self" rel="noopener noreferrer"><i class="fas fa-bookmark"></i>Simpan</a>
                                            <?php
                                            }
                                            ?>
                                            <a onclick="copi(<?= $pos['id']; ?>)"><i class="fas fa-share"></i>Bagikan</a>


                                        </div>
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

                                $sqlflod = "SELECT * FROM follows WHERE acc_main = '$id' AND acc_sec = '$idPer3'";
                                $stmtod = $con->query($sqlflod);
                                $flot = $stmtod->fetchAll();

                                $sqlflodt = "SELECT * FROM follows WHERE acc_main = '$idPer3' AND acc_sec = '$id'";
                                $stmtdt = $con->query($sqlflodt);
                                $flodt = $stmtdt->fetchAll();

                                if (!$flot  && $idPer3 !== $id) {


                            ?>
                                    <div class="fig">
                                        <div class="image">
                                            <img loading="lazy" src="<?= htmlspecialchars($p3['profile_pic']); ?>" alt="">
                                        </div>
                                        <div class="label">
                                            <a href="./profile.php?un=<?= htmlspecialchars($p3['username']); ?>"><?= htmlspecialchars($p3['name']); ?></a>
                                            <p>@<?= htmlspecialchars($p3['username']); ?></p>
                                        </div>
                                        <div class="fol">
                                            <?php
                                            if (!$flot && !$flodt) {

                                                if ($_SESSION['s_em'] !== $pos['email']) {

                                            ?>
                                                    <a href="./profile.php?un=<?= $prf['username']; ?>&acc_main=<?= $id ?>&acc_sec=<?= $idPer3 ?>&type=follow">Ikuti</a>
                                                <?php

                                                }
                                            } else if ($flot) {

                                                ?>
                                                <a onclick="unfol(<?= $idPer3; ?>)">Mengikuti</a>
                                            <?php
                                            } else if ($flodt) {

                                            ?>
                                                <a href="./profile.php?un=<?= $prf['username']; ?>&acc_main=<?= $id ?>&acc_sec=<?= $idPer3 ?>&type=follow">Ikuti Balik</a>
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
                            <a href="./followers.php?un=<?= $pref['username']; ?>"><i class="fas fa-group"></i></a>
                            <a href="./saved.php"><i class="fas fa-bookmark"></i></a>
                            <a href="./profile.php?un=<?= $pref['username']; ?>"><i class="fas fa-user-circle"></i></a>
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
        <?php
    } else {

        header('location: ./trends.php');
    }
        ?>

        <script>
            let copi = (vil) => {
                let urie = "https://compasspubindonesia.com/forum/post.php?post_id=" + vil;
                navigator.clipboard.writeText(urie);
                alert('Tautan tersalin!');
            }
        </script>
        <script>
            let unfol = (abs) => {

                if (confirm('Berhenti mengikuti <?= $pos["name"]; ?>?')) {
                    window.open("./profile.php?un=<?= $prf['username']; ?>&acc_main=<?= $id ?>&acc_sec=" + abs + "&type=unfollow", '_self')
                }

            }
        </script>