<?php

include '../init.php';
$dbTabungan = new tabungan;
$dbAnggota = new anggota;
$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);

if($action === "tambah_tabungan") {
	echo $dbTabungan->tambah_tabungan($dbAnggota);
	die;

} else if($action === "tampil_transaksi") {
	// form validation
	$dbTabungan->form_validation([
		'limit[Limit]' => 'required|must[10,20,40,semua]'
	], false);
	// cek form errors
	$errors = $dbTabungan->get_form_errors();
	if($errors) {
		echo json_encode(['form_errors'=>$errors]);
		die;
	}

	function remake_data($data) {
		for($i=0; $i<count($data); $i++) {
			$data[$i]['jml_uang'] = number_format($data[$i]['jml_uang'],0,',','.');
			$data[$i]['waktu'] = date("d M Y, h:i a", $data[$i]['waktu']);
			$data[$i]['type'] = ($data[$i]['type']==="add")?'Tambah Tabungan':'Ambil Tabungan';
		}
		return $data;
	}

	$limit = filter_input(INPUT_GET, 'limit', FILTER_SANITIZE_STRING);
	$anggota_id = filter_input(INPUT_GET, 'anggota_id', FILTER_SANITIZE_STRING);
	$data_anggota = $dbAnggota->get_one_anggota($anggota_id, 'jml_tabungan');
	if($data_anggota !== null) {

		if($limit === "semua") {
			$data = $dbTabungan->tampil_transaksi('t.jml_uang, t.waktu, t.type, t.waktu, adn.username', $anggota_id);
			// jika data ada
			if($data) {
				$data = remake_data($data);
				echo json_encode([ 'success'=>'yes', 'data'=>$data, 'jml_data'=>count($data??[]), 'jml_tabungan'=>number_format($data_anggota['jml_tabungan'],0,',','.') ]);
				die;
			} else {
				echo json_encode(['success'=>'no']);
			}
			
		} else {
			$data = $dbTabungan->tampil_transaksi('t.jml_uang, t.waktu, t.type, t.waktu, adn.username', $anggota_id, 'limit '.$limit);
			// jika data ada
			if($data) {
				$data = remake_data($data);
				echo json_encode([ 'success'=>'yes', 'data'=>$data, 'jml_data'=>count($data??[]), 'jml_tabungan'=>number_format($data_anggota['jml_tabungan'],0,',','.') ]);
				die;
			} else {
				echo json_encode(['success'=>'no']);
			}
		}

	} else {
		echo json_encode(['message'=>'Kamu Ilegal']);
		die;
	}

} else if($action === "ambil_tabungan") {
	echo $dbTabungan->ambil_tabungan($dbAnggota);
	die;
}