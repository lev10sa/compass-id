<!DOCTYPE html>
<html>

<head>
  <meta property="og:image" content="./thumbnail.png">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" href="./favicon.ico">
  <link rel="stylesheet" href="https://compasspubindonesia.com/res/css/style.css" type="text/css" media="all" />
  <link rel="stylesheet" href="https://compasspubindonesia.com/res/css/materialize.css" type="text/css" media="all" />
  <link rel="stylesheet" href="https://compasspubindonesia.com/res/css/materialize.min.css" type="text/css" media="all" />
  <link rel="stylesheet" href="https://compasspubindonesia.com/res/css/material-icons.css" type="text/css" media="all" />
  <link rel="stylesheet" href="cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
  <link
    rel="stylesheet"
    href="cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
  <title>Email Blast</title>
</head>

<body class="flow-text">

  <div class="section container">
    <div class="section">
      <h3>Email Blast</h3>
      <h5>By Aldi Alfiandi</h5>
      <p>Gunakan template database excel yang sudah disediakan sebagai acuan kontak tujuan pengiriman email.</p>
    </div>
    <form enctype="multipart/form-data" method="post" action="./send.php" class="section">
      <div class="row section">
        <div class="file-field input-field col s12 m6">
          <div class="btn">
            <span><i class="material-icons left">attachment</i>File</span>
            <input name="r_exl" type="file">
          </div>
          <div class="file-path-wrapper">
            <input id="r_exl" name="r_exl" class="file-path validate" type="text">
          </div>
        </div>
        <div class="section right right-align col s12 m12">
          <a class="btn" href="./Template.xlsx" target="_blank" download>Download Template</a>
          <input type="submit" id="r_ok" name="r_ok" class="btn" value="Mulai" />
        </div>
      </div>
    </form>
  </div>


</body>

</html>

<script src="./res/js/materialize.js" type="text/javascript" charset="utf-8"></script>

<script src="./res/js/materialize.min.js" type="text/javascript" charset="utf-8"></script>

<script type="text/javascript" charset="utf-8">
  document.addEventListener('DOMContentLoaded', function() {

    var sP = document.querySelectorAll('.scrollspy');
    M.ScrollSpy.init(sP, {
      throttle: 5,
      scrollOffset: 0
    });

    var seL = document.querySelectorAll('select');
    M.FormSelect.init(seL, {});

    var sL = document.querySelectorAll('.slider');
    M.Slider.init(sL, {
      indicators: true,
      height: 400,
      duration: 3000,
      interval: 3000
    });

    var pX = document.querySelectorAll('.parallax');
    M.Parallax.init(pX);

    var sN = document.querySelectorAll('.sidenav');
    M.Sidenav.init(sN);

    var mB = document.querySelectorAll('.materialboxed');
    M.Materialbox.init(mB);

    var dD = document.querySelectorAll('.dropdown-trigger');
    M.Dropdown.init(dD);

  });

  setTimeout(() => {
    document.getElementById("splash").style = "opacity: 0 !important; display: none !important;";
  }, 1000);

  function mn(val) {
    if (val == 1) {
      document.getElementById("sn").style = "display: block !important;";
    } else if (val == 0) {
      document.getElementById("sn").style = "display: none !important;";
    }
  }
</script>