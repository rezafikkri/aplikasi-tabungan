<div class="col-lg-6 col-lg-offset-3">
	<h2 class="judul text-center">Tambah Admin</h2>
	<form>
	<div class="panel panel-success mt-30">
		<div class="panel-body">
		    <label>Nama</label>
		    <input type="text" name="nama" class="form-control mb-10" placeholder="Nama...">
		    <label>Username</label>
		    <input type="text" name="username" class="form-control mb-10" placeholder="username...">
		    <label>Password</label>
		    <input type="password" name="password" class="form-control mb-20" placeholder="password...">

		    <label>Password Kamu</label>
		    <p>Untuk menyimpan, Masukkan password kamu!</p>
		    <input type="password" name="password_you" class="form-control mb-10" placeholder="Password kamu...">
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