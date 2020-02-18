<?php

/**
 * 
 */
class anggota extends config {
	
	public function tambah_anggota() {
		$this->form_validation([
			'nama[Nama]' => 'required|maxLength[32]'
		], false);
		// cek form errors
		$errors = $this->get_form_errors();
		if($errors) {
			return json_encode(['form_errors'=>$errors]);
		}

		// ambil data
		$nama = filter_input(INPUT_POST, 'nama', FILTER_SANITIZE_STRING);
		$anggota_id = $this->generate_uuid();
		$waktu = time();
		$tambah = $this->db->prepare("INSERT INTO anggota set anggota_id=:anggota_id, nama=:nama, waktu=:waktu");
		$tambah->execute(['anggota_id'=>$anggota_id, 'nama'=>$nama, 'waktu'=>$waktu]);
		if($tambah->rowCount() > 0) {
			return json_encode(['success'=>'yes']);
		}
		return json_encode(['success'=>'no']);
	}

	public function tampil_anggota($select, $where=null, $execute=null) {
		$get = $this->db->prepare("SELECT $select from anggota $where order by waktu desc");
		$get->execute($execute);
		if($get->rowCount() > 0) {
			while ($r=$get->fetch(PDO::FETCH_ASSOC)) {
				$hasil[]=$r;
			}
			return $hasil;
		} else {
			return null;
		}
	}

	public function get_one_anggota($anggota_id, $select) {
		$get = $this->db->prepare("SELECT $select from anggota where anggota_id=:anggota_id");
		$get->execute(['anggota_id'=>$anggota_id]);
		if($get->rowCount() > 0) {
			return $get->fetch(PDO::FETCH_ASSOC);
		}
		return null;
	}

	public function ubah_anggota($dbAdmin) {
		// form validation
		$this->form_validation([
			'nama[Nama]' => 'required|maxLength[32]',
			'password_you[Password Kamu]' => 'required'
		], false);
		// cek apakah password valid
		$password_you = filter_input(INPUT_POST, 'password_you', FILTER_SANITIZE_STRING);
		$passworddb = $dbAdmin->get_one_admin($_SESSION['tabungan']['admin_id'], 'password');
		if($passworddb !== null) {
			if(!isset($_SESSION['tabungan']['form_errors']['password_you']) && !password_verify($password_you, $passworddb['password'])) {
				$_SESSION['tabungan']['form_errors']['password_you'] = 'Password Kamu salah!';
			}

		} else {
			return json_encode(['message'=>'Kamu ilegal']);
		}
		// get form errors
		$errors = $this->get_form_errors();
		if($errors) {
			return json_encode(['form_errors'=>$errors]);
		}

		// ambil data
		$nama = filter_input(INPUT_POST, 'nama', FILTER_SANITIZE_STRING);
		$anggota_id = filter_input(INPUT_POST, 'anggota_id', FILTER_SANITIZE_STRING);
		$ubah = $this->db->prepare("UPDATE anggota set nama=:nama where anggota_id=:anggota_id");
		$ubah->execute(['nama'=>$nama, 'anggota_id'=>$anggota_id]);
		return json_encode(['success'=>'yes']);	
	}

	public function hapus_anggota($dbAdmin) {
		// form validation
		$this->form_validation([
			'password_hapus_anggota[Password Kamu]' => 'required'
		], false);
		// cek apakah password valid
		$password_hapus_anggota = filter_input(INPUT_POST, 'password_hapus_anggota', FILTER_SANITIZE_STRING);
		$passworddb = $dbAdmin->get_one_admin($_SESSION['tabungan']['admin_id'], 'password');
		if($passworddb !== null) {
			if(!isset($_SESSION['tabungan']['form_errors']['password_hapus_anggota']) && !password_verify($password_hapus_anggota, $passworddb['password'])) {
				$_SESSION['tabungan']['form_errors']['password_hapus_anggota'] = 'Password Kamu salah!';
			}

		} else {
			return json_encode(['message'=>'Kamu ilegal']);
		}
		// get form errors
		$errors = $this->get_form_errors();
		if($errors) {
			return json_encode(['form_errors'=>$errors]);
		}

		// ambil data
		$anggota_id = filter_input(INPUT_POST, 'anggota_id', FILTER_SANITIZE_STRING);
		try {
			$hapus = $this->db->prepare("DELETE FROM anggota where anggota_id=:anggota_id");
			$hapus->execute(['anggota_id'=>$anggota_id]);
		} catch (PDOException $e) {}
		if($hapus->rowCount() > 0) {
			return json_encode(['success'=>'yes']);
		}
		return json_encode(['success'=>'no']);
	}
}