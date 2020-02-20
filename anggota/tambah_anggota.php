<?php
	$dbLogin = new login;
	if($dbLogin->cek_login_no()) { 
		header("Location: ".config::base_url('index.php?pg=login'));
		die;
	}
?>
<div class="col-lg-6 col-lg-offset-3">
	<h2 class="judul text-center">Tambah Anggota</h2>
	<form id="tambah_anggota">
	<div class="panel panel-success mt-30">
		<div class="panel-body">
		    <label>Nama Anggota</label>
		    <p class="text-danger pesan" id="pesan_nama"></p>
		    <input type="text" name="nama" class="form-control mb-10" placeholder="Nama Lengkap ...">
		</div>
	</div>
	<a href="<?= config::base_url(''); ?>" class="btn btn-default">Kembali!</a>
	<div class="div-loading-btn">
		<div class="loading-bg btn hidden"></div>
		<div class="loading-btn hidden"></div>
		<button class="btn btn-success" id="tambah_anggota">Tambah Anggota!</button>
	</div>
	</form>

	<p class="copy-right mt-20">Copyright &copy; Reza Sariful Fikri. All Right Reserved</p>
</div>
<alert></alert>
<script type="text/javascript">
// tambah anggota
const btnTambah_anggota = document.querySelector("button#tambah_anggota");
const loading_btnTambah_anggota = btnTambah_anggota.previousElementSibling;
const loading_bgTambah_anggota = loading_btnTambah_anggota.previousElementSibling;
btnTambah_anggota.addEventListener('click', e => {
	// menghapus fungsi default button
	e.preventDefault();
	// loading btn
	loading_btnTambah_anggota.classList.remove('hidden');
	loading_bgTambah_anggota.classList.remove('hidden');
	// reset ppesan
	const ppesans = document.querySelector('p.pesan').innerText = "";
	// ambil data form
	const nama = document.querySelector("input[name=nama]").value;

	fetch('<?= config::base_url('anggota/proses.php?action=tambah_anggota'); ?>', {
		method: "post",
		headers: {
			'Content-Type':'application/x-www-form-urlencoded'
		},
		body: `nama=${nama}`
	})
	.finally(() => {
		// loading btn
		loading_btnTambah_anggota.classList.add('hidden');
		loading_bgTambah_anggota.classList.add('hidden');
	})
	// handling errors
	.then(response => {
		if(!response.ok) {
			// set error supaya bisa ditangkap oleh cath()
			throw new Error(response.statusText);
		}
		return response.json();
	})
	.then(response => {
		if(response.form_errors !== undefined && response.form_errors.nama !== undefined) {
			const ppesan_nama = document.querySelector("p#pesan_nama");
			ppesan_nama.innerText = response.form_errors.nama;
			return false;

		} else if(response.success !== undefined && response.success === "yes") {
			document.querySelector('alert').innerHTML = `
			<div class="alert alert-success alert-dismissible mt-30 fixed" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<strong>Selamat!</strong> Anggota berhasil ditambahkan.
			</div>`;
			// reset form
			document.querySelector("form#tambah_anggota").reset();
			return false;

		} else if(response.success !== undefined && response.success === "no") {
			document.querySelector('alert').innerHTML = `
			<div class="alert alert-success alert-dismissible mt-30 fixed" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<strong>Peringatan!</strong> Anggota gagal ditambahkan.
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

});
</script>