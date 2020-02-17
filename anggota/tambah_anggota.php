<div class="col-lg-6 col-lg-offset-3">
	<h2 class="judul text-center">Tambah Anggota</h2>
	<form>
	<div class="panel panel-success mt-30">
		<div class="panel-body">
		    <label>Nama Anggota</label>
		    <p class="text-danger">Nama tidak boleh kosong</p>
		    <input type="text" name="nama" class="form-control mb-10" placeholder="Nama Lengkap ...">
		</div>
	</div>
	<a href="<?= config::base_url(''); ?>" class="btn btn-default">Kembali!</a>
	<div class="div-loading-btn">
		<div class="loading-bg btn hidden"></div>
		<div class="loading-btn hidden"></div>
		<button class="btn btn-success">Simpan!</button>
	</div>
	</form>

	<div class="alert alert-success alert-dismissible mt-30" role="alert">
	  	<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	  	<strong>Selamat!</strong> Anggota berhasil ditambahkan.
	</div>
</div>