<?php

/**
 * 
 */
class admin extends config {
	
	public function tambah_admin() {
		// form validation
		$this->form_validation([
			'nama[Nama]' => 'required|maxLength[32]',
			'username[Username]' => 'required|maxLength[32]|unique[admin.username]',
			'password[Password]' => 'required|minLength[8]',
			'password_you[Password Kamu]' => 'required'
		], false);
		// cek apakah password valid
		$password_you = filter_input(INPUT_POST, 'password_you', FILTER_SANITIZE_STRING);
		$passsworddb = $this->get_one_admin($_SESSION['tabungan']['admin_id'], 'password');
		if($passsworddb !== null) {
			if(!isset($_SESSION['tabungan']['form_errors']['password_you']) && !password_verify($password_you, $passsworddb['password'])) {
				$_SESSION['tabungan']['form_errors']['password_you'] = 'Password kamu salah!';
			}

		} else {
			return json_encode(['message'=>'kamu ilegal']);
		}
		// cek form errors
		$errors = $this->get_form_errors();
		if($errors) {
			return json_encode(['form_errors'=>$errors]);
		}

		// buat admin id
		$admin_id = $this->generate_uuid();
		// tangkap variabel dan filter
		$nama = filter_input(INPUT_POST, 'nama', FILTER_SANITIZE_STRING);
		$username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
		$password = password_hash(filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING), PASSWORD_ARGON2I);
		// waktu untuk keterangan waktu sebuah akun dibuat
		$waktu = time();
		// insert into db
		$tambah = $this->db->prepare("INSERT INTO admin set admin_id=:admin_id, nama=:nama, username=:username, password=:password, waktu=:waktu");
		$tambah->execute(['admin_id'=>$admin_id, 'nama'=>$nama, 'username'=>$username, 'password'=>$password, 'waktu'=>$waktu]);
		if($tambah->rowCount() > 0) {
			return json_encode(['success'=>'yes']);
		}
		return json_encode(['success'=>'no']);
	}

	public function get_one_admin($admin_id, $select) {
		$get = $this->db->prepare("SELECT $select from admin where admin_id=:admin_id");
		$get->execute(['admin_id'=>$admin_id]);
		if($get->rowCount() > 0) {
			return $get->fetch(PDO::FETCH_ASSOC);
		}
		return null;
	}

	public function ubah_admin() {
		$admin_id = filter_input(INPUT_POST, 'admin_id', FILTER_SANITIZE_STRING);
		// form validation
		$this->form_validation([
			'nama[Nama]' => 'required|maxLength[32]',
			'username[Username]' => 'required|maxLength[32]|unique[admin.username][admin_id.'.$admin_id.']',
			'password_now[Password Sekarang]' => 'required'
		], false);
		// filter min length passsword jika password ada
		$password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
		if(!empty(trim($password))) {
			$this->form_validation([
				'password[Password]'=>'minLength[8]'
			], false);
		}
		// cek apakah password now valid
		$password_now = filter_input(INPUT_POST, 'password_now', FILTER_SANITIZE_STRING);
		$password_nowdb = $this->get_one_admin($admin_id, 'password');
		if($password_nowdb !== null) {
			if(!isset($_SESSION['tabungan']['form_errors']['password_now']) && !password_verify($password_now, $password_nowdb['password'])) {
				$_SESSION['tabungan']['form_errors']['password_now'] = 'Password sekarang salah!';
			}

		} else {
			return json_encode(['message'=>'kamu ilegal']);
		}
		// cek form errors
		$errors = $this->get_form_errors();
		if($errors) {
			return json_encode(['form_errors'=>$errors]);
		}

		$nama = filter_input(INPUT_POST, 'nama', FILTER_SANITIZE_STRING);
		$username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
		$password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
		// jika password kosong
		if(!empty(trim($password))) {
			$password = password_hash($password, PASSWORD_ARGON2I);
			$ubah = $this->db->prepare("UPDATE admin set username=:username, nama=:nama, password=:password where admin_id=:admin_id");
			$ubah->execute(['username'=>$username, 'nama'=>$nama, 'password'=>$password, 'admin_id'=>$admin_id]);
			return json_encode(['success'=>'yes']);

		} else {
			$ubah = $this->db->prepare("UPDATE admin set username=:username, nama=:nama where admin_id=:admin_id");
			$ubah->execute(['username'=>$username, 'nama'=>$nama, 'admin_id'=>$admin_id]);
			return json_encode(['success'=>'yes']);
		}
	}

	public function tampil_admin($select) {
		$tampil = $this->db->prepare("SELECT $select FROM admin");
		$tampil->execute();
		while ($r=$tampil->fetch(PDO::FETCH_ASSOC)) {
			$hasil[]=$r;
		}
		return @$hasil;
	}

	public function pesan_edit_admin() {
		if(isset($_SESSION['tabungan']['pesan_edit_admin']) && $_SESSION['tabungan']['pesan_edit_admin'] === "success") {
			unset($_SESSION['tabungan']['pesan_edit_admin']);
			return '<p class="text-success">Admin berhasil diedit!</p>';

		} elseif(isset($_SESSION['tabungan']['pesan_edit_admin'])) {
			unset($_SESSION['tabungan']['pesan_edit_admin']);
			return '<p class="text-success">Admin berhasil diedit!</p>';
		}
	}
}