<?php

include '../init.php';
$dbAdmin = new admin;
$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);

if($action === "tambah_admin") {
	echo $dbAdmin->tambah_admin();
	die;

} elseif($action === "ubah_admin") {
	echo $dbAdmin->ubah_admin();
	die;
}