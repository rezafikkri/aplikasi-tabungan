<?php
	$dbLogin = new login;
	if($dbLogin->cek_login_no()) { 
		header("Location: ".config::base_url('index.php?pg=login'));
		die;
	}
?>
<div class="col-lg-6 col-lg-offset-3 mb-100">
	<h2 class="judul text-center">Tambah Admin</h2>
	<form id="tambah_admin">
	<div class="panel panel-success">
		<div class="panel-body">
		    <label>Nama</label>
		    <p class="text-danger pesan" id="pesan_nama"></p>
		    <input type="text" name="nama" class="form-control mb-10" placeholder="Nama..." value="<?= $old['nama']??''; ?>">
		    <label>Username</label>
		    <p class="text-danger pesan" id="pesan_username"></p>
		    <input type="text" name="username" class="form-control mb-10" placeholder="username..." value="<?= $old['username']??''; ?>">
		    <label>Password</label>
		    <p class="text-danger pesan" id="pesan_password"></p>
		    <input type="password" name="password" class="form-control mb-20" placeholder="password..." value="<?= $old['password']??''; ?>">

		    <label>Password Kamu</label>
		    <p>Untuk menyimpan, Masukkan password kamu!</p>
		    <p class="text-danger pesan" id="pesan_password_you"></p>
		    <input type="password" name="password_you" class="form-control mb-10" placeholder="Password kamu..." value="<?= $old['password_you']??''; ?>">
		</div>
	</div>
	<a href="<?= config::base_url('index.php?pg=admin'); ?>" class="btn btn-default">Kembali!</a>
	<div class="div-loading-btn">
		<div class="loading-bg btn hidden"></div>
		<div class="loading-btn hidden"></div>
		<button class="btn btn-success" id="tambah_admin">Simpan!</button>
	</div>
	</form>

	<p class="copy-right mt-20 mb-100">Copyright &copy; Reza Sariful Fikri. All Right Reserved</p>
</div>
<alert></alert>
<script type="text/javascript">
// tambah admin
const btnTambah_admin = document.querySelector("button#tambah_admin");
const loadingTambah_admin = btnTambah_admin.previousElementSibling;
const loadingBgTambah_admin = loadingTambah_admin.previousElementSibling;
btnTambah_admin.addEventListener('click', e => {
	// menghapus fungsi default button
	e.preventDefault();
	// loading btn
	loadingTambah_admin.classList.remove('hidden');
	loadingBgTambah_admin.classList.remove('hidden');
	// reset ppesan
	const ppesans = document.querySelectorAll('p.pesan');
	ppesans.forEach((pesan) => {
		pesan.innerText = "";
	})
	// ambil data form
	const nama = document.querySelector('input[name=nama]').value;
	const username = document.querySelector('input[name=username]').value;
	const password = document.querySelector('input[name=password]').value;
	const password_you = document.querySelector('input[name=password_you]').value;

	fetch('<?= config::base_url('admin/proses.php?action=tambah_admin'); ?>', {
		method: "post",
		headers: {
			'Content-Type':'application/x-www-form-urlencoded',
		},
		body: `nama=${nama}&username=${username}&password=${password}&password_you=${password_you}`
	})
	.finally(() => {
		// loading btn
		loadingTambah_admin.classList.add('hidden');
		loadingBgTambah_admin.classList.add('hidden');
	})
	// handling errors
	.then(response => {
		if(!response.ok) {
			throw new Error(response.statusText);
		}
		return response.json();
	})
	.then(response => {
		if(response.form_errors !== undefined) {
			if(response.form_errors.nama != undefined) {
				const ppesan_nama = document.querySelector("p#pesan_nama");
				ppesan_nama.innerText = response.form_errors.nama;
			}
			if(response.form_errors.username != undefined) {
				const ppesan_username = document.querySelector("p#pesan_username");
				ppesan_username.innerText = response.form_errors.username;
			}
			if(response.form_errors.password != undefined) {
				const ppesan_password = document.querySelector("p#pesan_password");
				ppesan_password.innerText = response.form_errors.password;
			}
			if(response.form_errors.password_you != undefined) {
				const ppesan_password_you = document.querySelector("p#pesan_password_you");
				ppesan_password_you.innerText = response.form_errors.password_you;
			}
			return false;

		} else if(response.success !== undefined && response.success === "yes") {
			document.querySelector('alert').innerHTML = `
			<div class="alert alert-success alert-dismissible mt-30 fixed" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<strong>Selamat!</strong> Admin berhasil ditambahkan.
			</div>`;
			// reset form
			document.querySelector('form#tambah_admin').reset();
			return true;

		} else {
			document.querySelector('alert').innerHTML = `
			<div class="alert alert-warning alert-dismissible mt-30 fixed" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<strong>Peringatan!</strong> Admin gagal ditambahkan.
			</div>`;
			return false;
		}
	})
	// proses handling error
	.catch(error => {
		document.querySelector('alert').innerHTML = `
		<div class="alert alert-warning alert-dismissible mt-30 fixed" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<strong>Peringatan!</strong> Cek koneksi internet kamu lalu coba kembali.
		</div>`;
		return false;
	})
});
</script>