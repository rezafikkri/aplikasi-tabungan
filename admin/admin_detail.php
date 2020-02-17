<?php  
	$dbAdmin = new admin;
?>
<div class="col-lg-6 col-lg-offset-3 mb-100">
	<h2 class="judul text-center">Admin Detail</h2>
	<div class="panel panel-success">
		<div class="panel-heading">
			<h3 class="panel-title small">Informasi lengkap mengenai akun kamu</h3>
		</div>
		<form id="ubah_admin">
	  	<div class="panel-body">
	    	<label>Nama</label>
	    	<input class="form-control mb-10" type="text" name="nama" placeholder="nama...">
	    	<label>Username</label>
	    	<input class="form-control mb-10" type="text" name="username" placeholder="username...">
	    	<label>Password Baru</label>
	    	<p>Kosongkan password jika tidak ingin mengubah password!</p>
	    	<input class="form-control mb-20" type="password" name="password" placeholder="Password Baru...">

	    	<label>Password Sekarang</label>
	    	<p>Untuk konfirmasi perubahan kamu Masukkan!</p>
	    	<input class="form-control" type="password" name="password_now" placeholder="Password Sekarang...">
	  	</div>
	  	</form>
	</div>
	<a href="<?= config::base_url('index.php?pg=admin'); ?>" class="btn btn-default">Kembali!</a>
	<div class="div-loading-btn">
		<div class="loading-bg btn hidden"></div>
		<div class="loading-btn hidden"></div>
		<button class="btn btn-success" id="simpan_data">Simpan!</button>
	</div>

	<form>
	<div class="panel panel-danger mt-30">
	  	<div class="panel-body">
	    	<label>Password</label>
	    	<p>Jika kamu yakin untuk <strong class="text-danger">menghapus akun ini</strong>, masukkan password lalu klik hapus akun!</p>
	    	<input class="form-control" type="password" name="password" placeholder="Password...">
	  	</div>
	</div>
	<button class="btn btn-danger">Hapus Akun!</button>
	</form>
</div>
<alert></alert>
<script type="text/javascript">
// ubah admin
const btnSimpan_data = document.querySelector("button#simpan_data");
const loading = btnSimpan_data.previousElementSibling;
const loadingBg = loading.previousElementSibling;
btnSimpan_data.addEventListener('click', () => {
	// loading btn
	loading.classList.remove('hidden');
	loadingBg.classList.remove('hidden');

	fetch('<?= config::base_url(); ?>/admin/proses.php?action=ubah_admin', {
		method: "POST",
		headers: {
			'Content-Type': 'application/x-www-form-urlencoded'
		},
		body: `reza=reza`
	})
	// ketika request selesai dijalankan maka
	.finally(() => {
		loading.classList.add('hidden');
		loadingBg.classList.add('hidden');
	})
	.then(response => {
		// handling error
		if(!response.ok) {
			throw new Error(response.statusText);
		}
		return response.json();
	})
	.then(response => {
		console.log(response);
	})
	.catch(error => {
		document.querySelector('alert').innerHTML = `
		<div class="alert alert-warning alert-dismissible mt-30 fixed" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<strong>Peringatan!</strong> Cek koneksi internet kamu lalu coba kembali.
		</div>`;
	});
});
</script>