<div class="col-lg-6 col-lg-offset-3 mb-100">
	<h2 class="judul text-center">Admin Detail</h2>
	<div class="panel panel-success">
		<div class="panel-heading">
			<h3 class="panel-title small">Informasi lengkap mengenai akun kamu</h3>
		</div>
		<form>
	  	<div class="panel-body">
	    	<label>Nama</label>
	    	<input class="form-control mb-10" type="text" name="nama" placeholder="nama...">
	    	<label>Username</label>
	    	<input class="form-control mb-10" type="text" name="username" placeholder="username...">
	    	<label>Password Baru</label>
	    	<input class="form-control mb-20" type="password" name="password" placeholder="Password Baru...">

	    	<label>Password Sekarang</label>
	    	<p>Untuk konfirmasi perubahan kamu Masukkan!</p>
	    	<input class="form-control" type="password" name="password_now" placeholder="Password Sekarang...">
	  	</div>
	  	<div class="panel-footer">
	  		<a href="<?= config::base_url(); ?>" class="btn btn-default">Kembali!</a>
	  		<button class="btn btn-success">Simpan!</button>
	  	</div>
	  	</form>
	</div>

	<div class="panel panel-danger">
		<form>
	  	<div class="panel-body">
	    	<label>Password</label>
	    	<p>Jika kamu yakin untuk <strong class="text-danger">menghapus akun ini</strong>, masukkan password lalu klik hapus akun!</p>
	    	<input class="form-control" type="password" name="password" placeholder="Password...">
	  	</div>
	  	<div class="panel-footer">
	  		<button class="btn btn-danger">Hapus Akun!</button>
	  	</div>
	  	</form>
	</div>
</div>