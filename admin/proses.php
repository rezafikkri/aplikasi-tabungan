<?php

include '../init.php';
$dbAdmin = new admin;
$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);

if($action === "tambah_admin") {
	if($dbAdmin->tambah_admin() === true) {
		header("Location: ".config::base_url('index.php?pg=admin'));
		die;
	} else {
		header("Location: ".config::base_url('index.php?pg=tambah_admin'));
		die;
	}
}