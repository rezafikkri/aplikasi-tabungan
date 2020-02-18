<?php
	$dbLogin = new login;
	if($dbLogin->cek_login_no()) { 
		header("Location: ".config::base_url('index.php?pg=login'));
		die;
	}
	$dbAnggota =  new anggota;
	$anggota_id = filter_input(INPUT_GET, 'anggota_id', FILTER_SANITIZE_STRING);
	$r = $dbAnggota->get_one_anggota($anggota_id, '*');
?>
<div class="col-lg-6 col-lg-offset-3 mb-100">
	<h2 class="judul text-center">Anggota Detail</h2>
	<form id="ubah_anggota">
	<div class="panel panel-success">
		<div class="panel-heading">
			<h3 class="panel-title small">Informasi lengkap mengenai anggota</h3>
		</div>
	  	<div class="panel-body">
	  		<input type="hidden" name="anggota_id" value="<?= $r['anggota_id']??''; ?>">
	  		<p>Jumlah Tabungan <strong class="text-success">Rp <?= $r['jml_tabungan']??''; ?></strong></p>
	    	<label>Nama</label>
	    	<p class="text-danger pesan" id="pesan_nama"></p>
	    	<input class="form-control mb-10" type="text" name="nama" placeholder="nama..." value="<?= $r['nama']??''; ?>">

	    	<label>Password Kamu</label>
	    	<p>Untuk konfirmasi perubahan kamu Masukkan Password!</p>
	    	<p class="text-danger pesan" id="pesan_password_you"></p>
	    	<input class="form-control" type="password" name="password_you" placeholder="Password Kamu...">
	  	</div>
	</div>
	<a href="<?= config::base_url(''); ?>" class="btn btn-default">Kembali!</a>
	<div class="div-loading-btn">
		<div class="loading-bg btn hidden"></div>
		<div class="loading-btn hidden"></div>
		<button class="btn btn-success" id="simpan_data">Simpan!</button>
	</div>
	</form>

	<form id="hapus_anggota">
	<div class="panel panel-danger mt-30">
	  	<div class="panel-body">
	    	<label>Password Kamu</label>
	    	<p>Jika kamu yakin untuk <strong class="text-danger">menghapus akun ini</strong>, masukkan password lalu klik hapus akun!</p>
	    	<p class="text-danger" id="pesan_password_hapus_anggota"></p>
	    	<input class="form-control" type="password" name="password_hapus_anggota" placeholder="Password Kamu...">
	  	</div>
	</div>
	<div class="div-loading-btn">
		<div class="loading-bg btn hidden"></div>
		<div class="loading-btn hidden"></div>
		<button class="btn btn-danger" id="hapus_anggota">Hapus akun!</button>
	</div>
	</form>
</div>
<alert></alert>
<script type="text/javascript">
// ubah anggota
const btnSimpan_data = document.querySelector('button#simpan_data');
const loading_btnSimpan_data = btnSimpan_data.previousElementSibling;
const loading_bgSimpan_data = loading_btnSimpan_data.previousElementSibling;
btnSimpan_data.addEventListener('click', e => {
	// menghapus fungsi default button
	e.preventDefault();
	// loading btn
	loading_btnSimpan_data.classList.remove('hidden');
	loading_bgSimpan_data.classList.remove('hidden');
	// reset ppesan
	const ppesans = document.querySelectorAll('p.pesan');
	ppesans.forEach((pesan) => {
		pesan.innerText = "";
	});
	// ambil data
	const nama = document.querySelector("input[name=nama]").value;
	const password_you = document.querySelector("input[name=password_you]").value;
	const anggota_id = document.querySelector("input[name=anggota_id]").value;

	fetch('<?= config::base_url('anggota/proses.php?action=ubah_anggota'); ?>', {
		method: "post",
		headers: {
			'Content-Type':'application/x-www-form-urlencoded'
		},
		body: `nama=${nama}&password_you=${password_you}&anggota_id=${anggota_id}`
	})
	.finally(() => {
		// loading btn
		loading_btnSimpan_data.classList.add('hidden');
		loading_bgSimpan_data.classList.add('hidden');
	})
	// handling errors
	.then(response => {
		if(!response.ok) {
			// set error agar bisa ditangkap oleh catch()
			throw new Error(response.statusText);
		}
		return response.json();
	})
	.then(response => {
		if(response.form_errors !== undefined) {
			if(response.form_errors.nama !== undefined) {
				const ppesan_nama = document.querySelector("p#pesan_nama");
				ppesan_nama.innerText = response.form_errors.nama;
			}
			if(response.form_errors.password_you !== undefined) {
				const ppesan_password_you = document.querySelector("p#pesan_password_you");
				ppesan_password_you.innerText = response.form_errors.password_you;
			}
			return false;

		} else if(response.success !== undefined && response.success === "yes") {
			document.querySelector('alert').innerHTML = `
			<div class="alert alert-success alert-dismissible mt-30 fixed" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<strong>Selamat!</strong> Anggota berhasil diubah.
			</div>`;
			// reset input password
			document.querySelector("input[name=password_you]").value = "";
			return false;
		}
	})
	// proses error
	.catch(error => {
		document.querySelector('alert').innerHTML = `
		<div class="alert alert-warning alert-dismissible mt-30 fixed" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<strong>Peringatan!</strong> Cek koneksi internet kamu lalu coba kembali.
		</div>`;
		return false;
	});
});

// hapus anggota
const btnHapus_anggota = document.querySelector("button#hapus_anggota");
const loading_btnHapus_anggota = btnHapus_anggota.previousElementSibling;
const loading_bgHapus_anggota = loading_btnHapus_anggota.previousElementSibling;
btnHapus_anggota.addEventListener('click', e => {
	// menghapus fungsi default button
	e.preventDefault();
	// loading btn
	loading_btnHapus_anggota.classList.remove('hidden');
	loading_bgHapus_anggota.classList.remove('hidden');
	// reset ppesan
	const ppesans = document.querySelector('p#pesan_password_hapus_anggota').innerText = "";
	// ambil data
	const password_hapus_anggota = document.querySelector("input[name=password_hapus_anggota]").value;
	const anggota_id = document.querySelector("input[name=anggota_id]").value;

	fetch('<?= config::base_url('anggota/proses.php?action=hapus_anggota'); ?>', {
		method: "post",
		headers: {
			'Content-Type':'application/x-www-form-urlencoded'
		},
		body: `password_hapus_anggota=${password_hapus_anggota}&anggota_id=${anggota_id}`
	})
	.finally(() => {
		// loading btn
		loading_btnHapus_anggota.classList.add('hidden');
		loading_bgHapus_anggota.classList.add('hidden');
	})
	// handling errors
	.then(response => {
		if(!response.ok) {
			// set error agar bisa tangkap oleh catch()
			throw new Error(response.statusText);
		}
		return response.json();
	})
	.then(response => {
		if(response.form_errors !== undefined && response.form_errors.password_hapus_anggota !== undefined) {
			const ppesan_password_hapus_anggota = document.querySelector("p#pesan_password_hapus_anggota");
			ppesan_password_hapus_anggota.innerText = response.form_errors.password_hapus_anggota;
			return false;

		} else if(response.success !== undefined && response.success === "yes") {
			window.location = "<?= config::base_url(''); ?>";
			return false;

		} else if(response.success !== undefined && response.success === "no") {
			document.querySelector('alert').innerHTML = `
			<div class="alert alert-warning alert-dismissible mt-30 fixed" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<strong>Peringatan!</strong> Anggota gagal dihapus.
			</div>`;
			return false;
		}

	})
	.catch(error => {
		document.querySelector('alert').innerHTML = `
		<div class="alert alert-warning alert-dismissible mt-30 fixed" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<strong>Peringatan!</strong> Cek koneksi internet kamu lalu coba kembali.
		</div>`;
		return false;
	});
})
</script>