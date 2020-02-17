<?php  
	$dbAdmin = new admin;
	$errors = $dbAdmin->get_form_errors();
	$old = $dbAdmin->get_old_value();
?>
<div class="col-lg-6 col-lg-offset-3 mb-100">
	<h2 class="judul text-center">Tambah Admin</h2>
	<form method="post" action="<?= config::base_url('admin/proses.php?action=tambah_admin'); ?>">
	<div class="panel panel-success mt-30">
		<div class="panel-body">
		    <label>Nama</label>
		    <?= $errors['nama']??''; ?>
		    <input type="text" name="nama" class="form-control mb-10" placeholder="Nama..." value="<?= $old['nama']??''; ?>">
		    <label>Username</label>
		    <?= $errors['username']??''; ?>
		    <input type="text" name="username" class="form-control mb-10" placeholder="username..." value="<?= $old['username']??''; ?>">
		    <label>Password</label>
		    <?= $errors['password']??''; ?>
		    <input type="password" name="password" class="form-control mb-20" placeholder="password..." value="<?= $old['password']??''; ?>">

		    <label>Password Kamu</label>
		    <p>Untuk menyimpan, Masukkan password kamu!</p>
		    <?= $errors['password_you']??''; ?>
		    <input type="password" name="password_you" class="form-control mb-10" placeholder="Password kamu..." value="<?= $old['password_you']??''; ?>">
		</div>
	</div>
	<a href="<?= config::base_url('index.php?pg=admin'); ?>" class="btn btn-default">Kembali!</a>
	<div class="div-loading-btn">
		<div class="loading-bg btn hidden"></div>
		<div class="loading-btn hidden"></div>
		<button class="btn btn-success">Simpan!</button>
	</div>
	</form>
</div>