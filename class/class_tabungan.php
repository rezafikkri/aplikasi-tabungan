<?php

/**
 * 
 */
class tabungan extends config {

	public function get_one_tabungan($transaksi_id, $select) {
		$get = $this->db->prepare("SELECT $select from transaksi_id where transaksi_id=:transaksi_id");
		$get->execute(['transaksi_id'=>$transaksi_id]);
		if($get->rowCount() > 0) {
			return $get->fetch(PDO::FETCH_ASSOC);
		}
		return null;
	}
	
	public function tambah_tabungan($dbAnggota) {
		// form validation
		$this->form_validation([
			'jml_uang[Jumlah Uang]' => 'required|integer'
		], false);
		// form errors
		$errors = $this->get_form_errors();
		if($errors) {
			return json_encode(['form_errors'=>$errors]);
		}

		$jml_uang = filter_input(INPUT_POST, 'jml_uang', FILTER_SANITIZE_STRING);
		$anggota_id = filter_input(INPUT_POST, 'anggota_id', FILTER_SANITIZE_STRING);

		// get jml_tabungan sekarang
		$data_anggota = $dbAnggota->get_one_anggota($anggota_id, 'jml_tabungan, nama');
		if($data_anggota !== null) {
			// insert into transaksi
			$transaksi_id = $this->generate_uuid();
			$insert = $this->db->prepare("INSERT INTO transaksi set transaksi_id=:transaksi_id, admin_id=:admin_id, anggota_id=:anggota_id, type='add', jml_uang=:jml_uang, waktu=:waktu");
			$insert->execute(['transaksi_id'=>$transaksi_id, 'admin_id'=>$_SESSION['tabungan']['admin_id'], 'anggota_id'=>$anggota_id, 'jml_uang'=>$jml_uang, 'waktu'=>time()]);
			// update jml_tabungan anggota
			$jml_tabunganNew = $data_anggota['jml_tabungan']+$jml_uang;
			$upJmlTbAng = $this->db->prepare("UPDATE anggota set jml_tabungan=:jml_tabungan where anggota_id=:anggota_id");
			$upJmlTbAng->execute(['jml_tabungan'=>$jml_tabunganNew, 'anggota_id'=>$anggota_id]);

			return json_encode(['success'=>'yes', 'data'=>[
				'type'=>'Tambah Tabungan', 
				'jml_uang'=>number_format($jml_uang,0,',','.'), 
				'jml_tabungan'=>number_format($jml_tabunganNew,0,',','.'), 
				'nama_anggota'=>$data_anggota['nama'],
				'waktu'=>date('d M Y, h:i a', time()),
				'oleh'=>$_SESSION['tabungan']['username']
			]]);

		} else {
			return json_encode(['message'=>'Kamu Ilegal']);
		}
	}
}