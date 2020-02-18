<?php
	$dbLogin = new login;
	if($dbLogin->cek_login_no()) { 
		header("Location: ".config::base_url('index.php?pg=login'));
		die;
	}
?>
<div class="col-lg-6 col-lg-offset-3 mb-100">
	<h2 class="judul text-center">Anggota Detail</h2>
	<form id="ubah_anggota">
	<div class="panel panel-success">
		<div class="panel-heading">
			<h3 class="panel-title small">Informasi lengkap mengenai anggota</h3>
		</div>
	  	<div class="panel-body">
	  		<input type="hidden" name="admin_id" value="<?= $r['admin_id']??''; ?>">
	  		<p>Jumlah Tabungan <strong class="text-success">Rp 300.000</strong></p>
	    	<label>Nama</label>
	    	<p class="text-danger pesan" id="pesan_nama"></p>
	    	<input class="form-control mb-10" type="text" name="nama" placeholder="nama..." value="<?= $r['nama']??''; ?>">

	    	<label>Password Kamu</label>
	    	<p>Untuk konfirmasi perubahan kamu Masukkan Password!</p>
	    	<p class="text-danger pesan" id="pensa_password_kamu"></p>
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

	<form id="hapus_akun">
	<div class="panel panel-danger mt-30">
	  	<div class="panel-body">
	    	<label>Password Kamu</label>
	    	<p>Jika kamu yakin untuk <strong class="text-danger">menghapus akun ini</strong>, masukkan password lalu klik hapus akun!</p>
	    	<p class="text-danger" id="pesan_password_hapus_akun"></p>
	    	<input class="form-control" type="password" name="password" placeholder="Password Kamu...">
	  	</div>
	</div>
	<div class="div-loading-btn">
		<div class="loading-bg btn hidden"></div>
		<div class="loading-btn hidden"></div>
		<button class="btn btn-danger" id="hapus_akun">Hapus akun!</button>
	</div>
	</form>
</div>
<alert></alert>
<script type="text/javascript">

</script>