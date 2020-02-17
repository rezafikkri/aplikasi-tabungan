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
			// 'password_you[Password Kamu]' => 'required'
		], true);
		// set delimiters
		$this->set_delimiter('<p class="text-danger">', '</p>');
		// cek form errors
		if($this->has_formErrors() === true) {
			return false;
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
			return true;
		}
		return false;
	}

	public function ubah_admin() {
		// form validation
		$this->form_validation([
			'nama[Nama]' => 'required|maxLength[32]',
			'username[Username]' => 'required|maxLength[32]|unique[admin.username]',
			'password_now[Password Sekarang]' => 'required'
		], false);
		// filter min length passsword jika password ada
		$password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
		if(!empty(trim($password))) {
			$this->form_validation([
				'password[Password]'=>'minLength[8]'
			], false);
		}
		// set delimiters
		$this->set_delimiter('<p class="text-danger">', '</p>');
		// cek form errors
		$errors = $this->get_form_errors();
		if($errors) {
			return json_encode(['form-errors'=>$errors]);
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