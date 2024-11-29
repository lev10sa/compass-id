<?php
include './connection.php';

if (isset($_GET['post_id'])) {

    $postId = $_GET['post_id'];

    if (isset($postId) && isset($_GET['comm_id']) && isset($_GET['type']) == 'del') {

        $commId = $_GET['comm_id'];
        $delSQL = "DELETE FROM comments WHERE post_id = '$postId' AND id = '$commId'";
        $con->query($delSQL);
        header('location: ./post.php?post_id=' . $postId);
    }

    if (isset($_GET['acc_main']) && isset($_GET['acc_sec']) && isset($_GET['type'])) {

        $acc_main = $_GET['acc_main'];
        $acc_sec = $_GET['acc_sec'];

        if (isset($_SESSION['s_em']) && isset($_SESSION['s_pw'])) {

            if ($_GET['type'] == 'follow') {
                $flSQL = "INSERT IGNORE INTO follows (acc_main, acc_sec, dt) VALUES ('$acc_main', '$acc_sec', NOW())";
                $con->query($flSQL);
                header('location: ./post.php?post_id=' . $postId);
            } else if ($_GET['type'] == 'unfollow') {
                $ulfSQL = "DELETE FROM follows WHERE acc_main = '$acc_main' AND acc_sec = '$acc_sec'";
                $con->query($ulfSQL);
                header('location: ./post.php?post_id=' . $postId);
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
                header('location: ./post.php?post_id=' . $postId);
            } else if ($_GET['type'] == 'unlike') {
                $ulkSQL = "DELETE FROM likes WHERE likes.acc_id = '$acc_id' AND likes.post_id = '$post_id'";
                $con->query($ulkSQL);
                header('location: ./post.php?post_id=' . $postId);
            }

            if ($_GET['type'] == 'save') {
                $lkSQL = "INSERT IGNORE INTO saves (acc_id, post_id) VALUES ('$acc_id', '$post_id')";
                $con->query($lkSQL);
                header('location: ./post.php?post_id=' . $postId);
            } else if ($_GET['type'] == 'unsave') {
                $ulkSQL = "DELETE FROM saves WHERE saves.acc_id = '$acc_id' AND saves.post_id = '$post_id'";
                $con->query($ulkSQL);
                header('location: ./post.php?post_id=' . $postId);
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
        <link rel="stylesheet" href="https://forum.compasspubindonesia.com/login.css">
        <link rel="stylesheet" href="https://forum.compasspubindonesia.com/home.css">
        <link rel="stylesheet" href="https://forum.compasspubindonesia.com/comment.css">
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
                if (isset($_SESSION['s_em']) && isset($_SESSION['s_pw'])) {
                    $em = $_SESSION['s_em'];
                    $pw = $_SESSION['s_pw'];

                    $sqlProf = "SELECT * FROM accounts WHERE email = :email AND password = :password";
                    $stmt = $con->prepare($sqlProf);
                    $stmt->execute(['email' => $em, 'password' => $pw]);
                    $prof = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($prof as $prf) {
                        $id = $prf['id'];

                        if (isset($_POST['r_com'])) {
                            $body = addslashes($_POST['body']);
                            $media = ''; // Default value jika tidak ada file diunggah

                            if (isset($_FILES["mediam"]) && $_FILES["mediam"]["error"] === UPLOAD_ERR_OK) {
                                $fname = $_FILES["mediam"]["name"];
                                $ftmp = $_FILES["mediam"]["tmp_name"];
                                $tar = './user/' . $prf['username'] . '/comment/';
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
                            $sqlPos = "INSERT INTO comments (acc_id, post_id, body, media, dt) VALUES (:acc_id, :post_id, :body, :media, NOW())";
                            $stmt = $con->prepare($sqlPos);
                            $stmt->execute(['acc_id' => $id, 'post_id' => $postId, 'body' => $body, 'media' => $media]);
                            header('location: ./post.php?post_id=' . $postId);
                        }

                        $sqlsv = "SELECT COUNT(*) FROM saves WHERE acc_id = :id";
                        $stmt = $con->prepare($sqlsv);
                        $stmt->execute(['id' => $id]);
                        $sv = $stmt->fetchColumn();
                ?>
                        <div class="hero">
                            <div class="image">
                                <img loading="lazy" src="<?= htmlspecialchars($prf['profile_pic']); ?>" alt="">
                            </div>
                            <div class="label">
                                <a href="./profile.php?un=<?= htmlspecialchars($prf['username']); ?>"><?= htmlspecialchars($prf['name']); ?></a>
                                <p>@<?= htmlspecialchars($prf['username']); ?></p>
                            </div>
                        </div>
                <?php
                    }
                }
                ?>
                <div class="tabs">
                    <?php
                    if (isset($_SESSION['s_em']) && isset($_SESSION['s_pw'])) {
                    ?>
                        <a href="./"><i class="fas fa-home"></i> Beranda</a>
                        <a href="./search_user.php?key="><i class="fas fa-search"></i> Cari</a>
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
                    <a href="./post.php?post_id=<?= $postId; ?>" class="active">POSTINGAN</a>
                    <?php
                    if (isset($_SESSION['s_em']) && isset($_SESSION['s_pw'])) {
                    ?>
                        <a></a>
                        <a></a>
                    <?php
                    }
                    ?>
                </div>
                <div class="posted">
                    <?php

                    $sqlArt = "SELECT accounts.username, accounts.name, accounts.email, accounts.profile_pic, posts.id, posts.dt, posts.body, posts.media, posts.acc_id FROM accounts, posts WHERE accounts.id = posts.acc_id AND posts.id = '$postId' ORDER BY posts.dt DESC LIMIT 30";
                    $selArt = $con->query($sqlArt);
                    $selArt->setFetchMode(PDO::FETCH_ASSOC);
                    $art = $selArt->fetchAll();

                    if ($art) {

                        foreach ($art as $pos) {

                    ?>
                            <div class="post">
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
                                            <a href="./post.php?acc_main=<?= $id ?>&acc_sec=<?= $pos['acc_id'] ?>&type=follow" class="fol">Ikuti</a>
                                        <?php

                                        } else if ($pos['acc_id'] == $id) {

                                        ?>
                                            <a href="./post_edit.php?post_id=<?= $pos['id'] ?>" class="ufol"><i class="fas fa-edit"></i> Edit</a>
                                        <?php
                                        }
                                    } else if ($flo) {

                                        ?>
                                        <a onclick="unfol()" class="ufol">Mengikuti</a>
                                        <script>
                                            let unfol = () => {

                                                if (confirm('Berhenti mengikuti <?= $pos["name"]; ?>?')) {
                                                    window.open("./post.php?acc_main=<?= $id ?>&acc_sec=<?= $pos['acc_id'] ?>&type=unfollow", '_self')
                                                }

                                            }
                                        </script>
                                    <?php
                                    } else if ($flod) {

                                    ?>
                                        <a href="./post.php?acc_main=<?= $id ?>&acc_sec=<?= $pos['acc_id'] ?>&type=follow" class="fol">Ikuti Balik</a>
                                    <?php
                                    }

                                    ?>
                                    <div class="image">
                                        <img loading="lazy" src="<?= htmlspecialchars($pos['profile_pic']); ?>" alt="">
                                    </div>
                                    <div class="label">
                                        <a href="./profile.php?un=<?= htmlspecialchars($pos['username']); ?>"><?= htmlspecialchars($pos['name']); ?></a>
                                        <p>@<?= htmlspecialchars($pos['username']); ?></p>
                                        <p><?= htmlspecialchars($pos['dt']); ?> WIB</p>
                                    </div>
                                </div>
                                <div class="content">
                                    <pre><?= stripslashes($pos['body']); ?></pre>
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
                                        <a href="./post.php?acc_id=<?= $id; ?>&post_id=<?= $pos['id'] ?>&type=unlike" target="_self" rel="noopener noreferrer" class="active"><i class="fas fa-thumbs-up"></i>Disukai</a>
                                    <?php
                                    } else {

                                    ?>
                                        <a href="./post.php?acc_id=<?= $id; ?>&post_id=<?= $pos['id'] ?>&type=like" target="_self" rel="noopener noreferrer"><i class="fas fa-thumbs-up"></i>Suka</a>
                                    <?php
                                    }

                                    ?>
                                    <a href="./post.php?post_id=<?= $pos['id'] ?>" target="_self" rel="noopener noreferrer"><i class="fas fa-comment"></i>Komentar</a>
                                    <?php
                                    if ($svdsc == 1) {
                                    ?>
                                        <a href="./post.php?acc_id=<?= $id; ?>&post_id=<?= $pos['id'] ?>&type=unsave" target="_self" rel="noopener noreferrer" class="active"><i class="fas fa-bookmark"></i>Disimpan</a>
                                    <?php
                                    } else {
                                    ?>
                                        <a href="./post.php?acc_id=<?= $id; ?>&post_id=<?= $pos['id'] ?>&type=save" target="_self" rel="noopener noreferrer"><i class="fas fa-bookmark"></i>Simpan</a>
                                    <?php
                                    }
                                    ?>
                                    <a onclick="copi()"><i class="fas fa-share"></i>Bagikan</a>

                                    <script>
                                        let copi = (val) => {
                                            let uri = "./post.php?post_id=<?= $pos['id'] ?>"
                                            navigator.clipboard.writeText(uri)
                                            alert('Tautan tersalin!')
                                        }
                                    </script>
                                </div>
                            </div>
                    <?php

                        }
                    }

                    ?>
                </div>
                <div class="comment">
                    <?php

                    $comieSQL = "SELECT comments.id, comments.post_id, comments.acc_id, comments.media, comments.body, comments.dt, accounts.username, accounts.name, accounts.profile_pic, accounts.email FROM comments, accounts WHERE accounts.id = comments.acc_id AND comments.post_id = '$postId' ORDER BY dt DESC";
                    $commie = $con->query($comieSQL);
                    $comn = $commie->fetchAll(PDO::FETCH_ASSOC);

                    $comiedSQL = "SELECT COUNT(*) FROM comments WHERE post_id = '$postId' ORDER BY dt DESC";
                    $commied = $con->query($comiedSQL);
                    $comnd = $commied->fetchColumn();

                    ?>
                    <label><?= $comnd; ?> komentar</label>
                    <?php

                    foreach ($comn as $cm) {

                    ?>
                        <div class="cmnt">
                            <div class="fig">
                                <div class="image">

                                    <img loading="lazy" src="<?= htmlspecialchars($cm['profile_pic']); ?>" alt="">
                                </div>
                                <div class="label">
                                    <a href="./profile.php?un=<?= htmlspecialchars($cm['username']); ?>"><?= htmlspecialchars($cm['name']); ?></a>
                                    <p>@<?= htmlspecialchars($cm['username']); ?></p>
                                    <p><?= htmlspecialchars($cm['dt']); ?> WIB</p>
                                </div>
                            </div>
                            <div class="content">
                                <?php
                                if ($cm['body'] !== '') {
                                ?>
                                    <pre><?= $cm['body']; ?></pre>
                                <?php
                                }

                                if ($cm['media'] !== '') {
                                ?>
                                    <img loading="lazy" src="<?= htmlspecialchars($cm['media']); ?>" alt="">
                                <?php

                                }

                                ?>

                            </div>
                            <div class="tip">

                                <?php
                                if ($cm['email'] == $_SESSION['s_em'] || $_SESSION['s_em'] == $pos['email']) {
                                ?>
                                    <a onclick="dele(<?= $cm['id']; ?>)">Hapus Komentar</a>

                                <?php
                                }
                                ?>

                                <?php
                                if ($cm['media']) {
                                ?>
                                    <a href="<?= $cm['media']; ?>" download="">Unduh Gambar</a>

                                <?php
                                }
                                ?>
                            </div>
                        </div>
                    <?php
                    }
                    ?>
                </div>

                <?php
                if (isset($_SESSION['s_em']) && isset($_SESSION['s_pw'])) {
                ?>
                    <div class="maked">
                        <form action="./post.php?post_id=<?= $postId; ?>" method="post" enctype="multipart/form-data">
                            <textarea name="body" id="body" placeholder="Tuliskan sesuatu. (max. 1000 karakter)" required maxlength="1000"></textarea>
                            <input type="file" name="mediam" id="mediam" accept="image/jpg, image/png, image/jpeg, image/webp">
                            <input type="submit" name="r_com" id="r_com" value="KOMENTARI">
                        </form>
                    </div>
                <?php
                }

                ?>
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

                                        if ($_SESSION['s_em'] !== $p3['email']) {

                                    ?>
                                            <a href="./post.php?post_id=<?= $postId; ?>&acc_main=<?= $id ?>&acc_sec=<?= $p3['id'] ?>&type=follow">Ikuti</a>
                                        <?php

                                        }
                                    } else if ($flot) {

                                        ?>
                                        <a onclick="unfol(<?= $p3['id']; ?>)">Mengikuti</a>
                                    <?php
                                    } else if ($flodt) {

                                    ?>
                                        <a href="./post.php?post_id=<?= $postId; ?>&acc_main=<?= $id ?>&acc_sec=<?= $p3['id'] ?>&type=follow">Ikuti Balik</a>
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
            <div class="makedt">
                <form action="./post.php?post_id=<?= $postId; ?>" method="post" enctype="multipart/form-data">
                    <textarea name="body" id="body" placeholder="Tuliskan sesuatu. (max. 1000 karakter)" required maxlength="1000"></textarea>
                    <input type="file" name="mediam" id="mediam" accept="image/jpg, image/png, image/jpeg, image/webp">
                    <input type="submit" name="r_com" id="r_com" value="KOMENTARI">
                </form>
            </div>
        <?php
        }

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

<?php
} else {
    header('location: ./trends.php');
}
?>
<script type="text/javascript">
    let dele = (vari) => {
        if (confirm("Yakin untuk menghapus komentar ini?")) {

            window.open("./post.php?post_id=<?= $postId; ?>&comm_id=" + vari + "&type=del", "_self");

        }
    }
</script>