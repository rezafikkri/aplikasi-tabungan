<?php

include '../init.php';
$dbTabungan = new tabungan;
$dbAnggota = new anggota;
$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);

if($action === "tambah_tabungan") {
	echo $dbTabungan->tambah_tabungan($dbAnggota);
	die;
}