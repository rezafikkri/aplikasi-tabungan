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
}