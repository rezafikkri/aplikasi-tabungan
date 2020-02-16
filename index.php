<?php include 'init.php'; ?>
<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">

    <title>App Tabungan</title>

    <!-- Bootstrap core CSS -->
    <link href="<?= config::base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles -->
    <link href="<?= config::base_url(); ?>assets/css/tabungan.css" rel="stylesheet">
  </head>

  <div class="container">
    <?php

    $pg = filter_input(INPUT_GET, 'pg', FILTER_SANITIZE_STRING);
    switch ($pg) {
         default:
            if(!file_exists("home.php")) die ("file kosong");
            include "home.php";
            break;
        case 'tambah_anggota':
            if(!file_exists("tambah_anggota.php")) die ("file kosong");
            include "tambah_anggota.php";
            break;
    }

    ?>
  </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="<?= config::base_url(); ?>assets/js/jquery-3.3.1.min.js"></script>
    <script src="<?= config::base_url(); ?>assets/js/bootstrap.min.js"></script>
  </body>
</html>
