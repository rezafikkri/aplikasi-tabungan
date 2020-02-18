<?php  

include '../init.php';
$dbAnggota = new anggota;
$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);

if($action === "tambah_anggota") {
	echo $dbAnggota->tambah_anggota();
	die;

} else if($action == "search_anggota") {
	$keyword = filter_input(INPUT_POST, 'keyword', FILTER_SANITIZE_STRING);
	if(empty(trim($keyword))) {
		echo json_encode(['data'=>'kosong']);
		die;
	} else {
		$data = $dbAnggota->tampil_anggota('*', "where nama like '$keyword%'");
		if($data) {
			for($i=0; $i<count($data); $i++) {
				$data[$i]['waktu'] = date("d M Y, h:i a", $data[$i]['waktu']);
				$data[$i]['jml_tabungan'] = number_format($data[$i]['jml_tabungan'],0,',','.');
			}
			echo json_encode(['data'=>$data]);
			die;
		} else {
			echo json_encode(['data'=>'kosong']);
			die;
		}
	}
}