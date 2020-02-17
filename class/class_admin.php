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
		// insert into db
		$tambah = $this->db->prepare("INSERT INTO admin set admin_id=:admin_id, nama=:nama, username=:username, password=:password");
		$tambah->execute(['admin_id'=>$admin_id, 'nama'=>$nama, 'username'=>$username, 'password'=>$password]);
		if($tambah->rowCount() > 0) {
			return true;
		}
		return false;
	}
}