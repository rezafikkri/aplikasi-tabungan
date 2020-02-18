<?php

/**
 * 
 */
class login extends config {
	
	public function proses_login() {
		$this->form_validation([
			'username[Username]' => 'required',
			'password[Password]' => 'required'
		], false);
		// set delimiters
		$this->set_delimiter('<p class="text-danger mt-20">', '</p>');
		// cek form errors
		if($this->has_formErrors() === true) {
			return false;
		}

		$username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
		$password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
		$get = $this->db->prepare("SELECT admin_id, username, password from admin where username=:username");
		$get->execute(['username'=>$username]);
		if($get->rowCount() > 0) {
			$r = $get->fetch(PDO::FETCH_ASSOC);
			// cek apakah password valid
			if(password_verify($password, $r['password'])) {
				$_SESSION['tabungan']['login_status'] = 'yes';
				$_SESSION['tabungan']['admin_id'] = $r['admin_id'];
				$_SESSION['tabungan']['username'] = $r['username'];
				return "berhasil_login";

			} else {
				$_SESSION['tabungan']['form_errors']['password'] = '<p class="text-danger mt-20">Password salah!</p>';
				return false;
			}

		} else {
			$_SESSION['tabungan']['form_errors']['username'] = '<p class="text-danger mt-20">Username tidak ditemukan!</p>';
			return false;
		}
	}

	public function cek_login_no() {
		if(!isset($_SESSION['tabungan']['login_status'])) {
			return true;
		}
		return false;
	}

	// for halaman login
	public function cek_login_yes() {
		if(isset($_SESSION['tabungan']['login_status'])) {
			return true;
		}
		return false;
	}
}