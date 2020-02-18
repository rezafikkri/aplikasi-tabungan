<?php

include '../init.php';
$dbLogin = new login;
$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);

if($action === 'login') {
	if($dbLogin->proses_login() === "berhasil_login") {
		header("Location: ".config::base_url('index.php'));

	} else {
		header("Location: ".config::base_url('index.php?pg=login'));
		die;
	}

} else if($action === 'logout') {
	unset($_SESSION['tabungan']);
	header("Location: ".config::base_url('index.php?pg=login'));
	die;
}