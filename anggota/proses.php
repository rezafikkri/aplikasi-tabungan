<?php  

include '../init.php';
$dbAnggota = new anggota;
$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);

if($action === "tambah_anggota") {
	echo $dbAnggota->tambah_anggota();
	die;
}