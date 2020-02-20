<?php
	$dbLogin = new login;
	if($dbLogin->cek_login_no()) { 
		header("Location: ".config::base_url('index.php?pg=login'));
		die;
	}
	  
	$dbAdmin = new admin;
	$admin_id = filter_input(INPUT_GET, 'admin_id', FILTER_SANITIZE_STRING);
	$r = $dbAdmin->get_one_admin($admin_id, 'admin_id, nama, username');
?>
<div class="col-lg-6 col-lg-offset-3 mb-100">
	<h2 class="judul text-center">Admin Detail</h2>
	<form id="ubah_admin">
	<div class="panel panel-success">
		<div class="panel-heading">
			<h3 class="panel-title small">Informasi lengkap mengenai akun kamu</h3>
		</div>
	  	<div class="panel-body">
	  		<input type="hidden" name="admin_id" value="<?= $r['admin_id']??''; ?>">
	    	<label>Nama</label>
	    	<p class="text-danger pesan" id="pesan_nama"></p>
	    	<input class="form-control mb-10" type="text" name="nama" placeholder="nama..." value="<?= $r['nama']??''; ?>">
	    	<label>Username</label>
	    	<p class="text-danger pesan" id="pesan_username"></p>
	    	<input class="form-control mb-10" type="text" name="username" placeholder="username..." value="<?= $r['username']??''; ?>">
	    	<label>Password Baru</label>
	    	<p>Kosongkan password jika tidak ingin mengubah password!</p>
	    	<p class="text-danger pesan" id="pesan_password"></p>
	    	<input class="form-control mb-20" type="password" name="password" placeholder="Password Baru...">

	    	<label>Password Sekarang</label>
	    	<p>Untuk konfirmasi perubahan kamu Masukkan Password!</p>
	    	<p class="text-danger pesan" id="pesan_password_now"></p>
	    	<input class="form-control" type="password" name="password_now" placeholder="Password Sekarang...">
	  	</div>
	</div>
	<a href="<?= config::base_url('index.php?pg=admin'); ?>" class="btn btn-default">Kembali!</a>
	<div class="div-loading-btn">
		<div class="loading-bg btn hidden"></div>
		<div class="loading-btn hidden"></div>
		<button class="btn btn-success" id="simpan_data">Simpan!</button>
	</div>
	</form>

	<form id="hapus_akun">
	<div class="panel panel-danger mt-30">
	  	<div class="panel-body">
	    	<label>Password Sekarang</label>
	    	<p>Jika kamu yakin untuk <strong class="text-danger">menghapus akun ini</strong>, masukkan password lalu klik hapus akun!</p>
	    	<p class="text-danger" id="pesan_password_hapus_akun"></p>
	    	<input class="form-control" type="password" name="password_akun" placeholder="Password Sekarang...">
	  	</div>
	</div>
	<div class="div-loading-btn">
		<div class="loading-bg btn hidden"></div>
		<div class="loading-btn hidden"></div>
		<button class="btn btn-danger" id="hapus_akun">Hapus akun!</button>
	</div>
	</form>

	<p class="copy-right mt-20 mb-100">Copyright &copy; Reza Sariful Fikri. All Right Reserved</p>
</div>
<alert></alert>
<script type="text/javascript">
// ubah admin
const btnSimpan_data = document.querySelector("button#simpan_data");
const loadingUbah_admin = btnSimpan_data.previousElementSibling;
const loadingBgUbah_admin = loadingUbah_admin.previousElementSibling;
btnSimpan_data.addEventListener('click', e => {
	// menghapus fungsi default button
	e.preventDefault();
	// loading btn
	loadingUbah_admin.classList.remove('hidden');
	loadingBgUbah_admin.classList.remove('hidden');
	// reset ppesan
	const ppesans = document.querySelectorAll('p.pesan');
	ppesans.forEach((pesan) => {
		pesan.innerText = "";
	})
	// ambil data form
	const nama = document.querySelector('input[name=nama]').value;
	const username = document.querySelector('input[name=username]').value;
	const password = document.querySelector('input[name=password]').value;
	const password_now = document.querySelector('input[name=password_now]').value;
	const admin_id = document.querySelector('input[name=admin_id]').value;

	fetch('<?= config::base_url(); ?>/admin/proses.php?action=ubah_admin', {
		method: "POST",
		headers: {
			'Content-Type': 'application/x-www-form-urlencoded'
		},
		body: `nama=${nama}&username=${username}&password=${password}&password_now=${password_now}&admin_id=${admin_id}`
	})
	// ketika request selesai dijalankan maka
	.finally(() => {
		loadingUbah_admin.classList.add('hidden');
		loadingBgUbah_admin.classList.add('hidden');
		document.querySelector('input[name=password]').value = '';
		document.querySelector('input[name=password_now]').value = '';

	})
	.then(response => {
		// handling error
		if(!response.ok) {
			throw new Error(response.statusText);
		}
		return response.json();
	})
	.then(response => {
		// form validation
		if(response.form_errors !== undefined) {
			if(response.form_errors.nama != undefined) {
				const ppesan_nama = document.querySelector('p#pesan_nama');
				ppesan_nama.innerText = response.form_errors.nama;
			}
			if(response.form_errors.username != undefined) {
				const ppesan_username = document.querySelector('p#pesan_username');
				ppesan_username.innerText = response.form_errors.username;
			}
			if(response.form_errors.password != undefined) {
				const ppesan_password = document.querySelector('p#pesan_password');
				ppesan_password.innerText = response.form_errors.password;
			}
			if(response.form_errors.password_now != undefined) {
				const ppesan_password_now = document.querySelector('p#pesan_password_now');
				ppesan_password_now.innerText = response.form_errors.password_now;
			}
		return false;

		} else if(response.success === "yes") {
			document.querySelector('alert').innerHTML = `
			<div class="alert alert-success alert-dismissible mt-30 fixed" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<strong>Selamat!</strong> Admin berhasil diubah!.
			</div>`;
			return true;
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

// hapus akun
const btnHapus_akun = document.querySelector("button#hapus_akun");
const loadingHapus_akun = btnHapus_akun.previousElementSibling;
const loadingBgHapus_akun = loadingHapus_akun.previousElementSibling;
btnHapus_akun.addEventListener('click', e => {
	// menghapus fungsi default button
	e.preventDefault();
	// loading btn
	loadingHapus_akun.classList.remove('hidden');
	loadingBgHapus_akun.classList.remove('hidden');
	// reset ppesan
	const ppesans = document.querySelector('p#pesan_password_hapus_akun').innerText = "";
	// ambil data form
	const password = document.querySelector("input[name=password_akun]").value;
	const admin_id = document.querySelector("input[name=admin_id]").value;

	fetch('<?= config::base_url('admin/proses.php?action=hapus_akun'); ?>', {
		method: "post",
		headers: {
			'Content-Type':'application/x-www-form-urlencoded'
		},
		body: `password=${password}&admin_id=${admin_id}`
	})
	.finally(() => {
		// loading btn
		loadingHapus_akun.classList.add('hidden');
		loadingBgHapus_akun.classList.add('hidden');
		// reset form
		document.querySelector("form#hapus_akun").reset();
	})
	// handling errors
	.then(response => {
		if(!response.ok) {
			throw new Error(response.statusText);
		}
		return response.json();
	})
	.then(response => {
		if(response.form_errors !== undefined && response.form_errors.password != undefined) {
			const ppesan_password = document.querySelector('p#pesan_password_hapus_akun');
			ppesan_password.innerText = response.form_errors.password;
			return false;

		} else if(response.success != undefined && response.success === "yes") {
			window.location = '<?= config::base_url('index.php?pg=login'); ?>';
			return true;

		} else if(response.success != undefined && response.success === "no") {
			document.querySelector('alert').innerHTML = `
			<div class="alert alert-warning alert-dismissible mt-30 fixed" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<strong>Peringatan!</strong> Admin gagal dihapus!.
			</div>`;
			return false;
		}
	})
	// proses handling errors
	.catch(error => {
		document.querySelector('alert').innerHTML = `
		<div class="alert alert-warning alert-dismissible mt-30 fixed" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<strong>Peringatan!</strong> Cek koneksi internet kamu lalu coba kembali!.
		</div>`;
		return false;
	})

});
</script>