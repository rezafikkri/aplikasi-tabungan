<?php  
	$dbLogin = new login;
	if($dbLogin->cek_login_no()) { 
		header("Location: ".config::base_url('index.php?pg=login'));
		die;
	}
?>
<div class="col-lg-8 col-lg-offset-2">
	<h2 class="judul text-center">Aplikasi Tabungan <span class="small">v 0.1</span></h2>
	<p></p>

	<a href="<?= config::base_url('login/proses.php?action=logout'); ?>" class="btn btn-danger pull-right"><span class="glyphicon glyphicon-log-out"></span></a>
	<a href="<?= config::base_url('index.php?pg=admin'); ?>" class="btn btn-default pull-right mr-5">Admin</a>
	<a href="<?= config::base_url('index.php?pg=tambah_anggota'); ?>" class="btn btn-success mb-10 pull-right mr-5">Tambah Anggota!</a>
	<div class="input-group search">
		<input type="text" class="form-control" placeholder="Nama anggota...">
	    <span class="input-group-btn">
	    	<button class="btn btn-success mr-5" type="button">Cari!</button>
	    </span>
    </div><!-- /input-group -->

	<div class="list-group">
		<li class="list-group-item list-group-item-warning"><h4 class="list-group-item-heading">Daftar Anggota</h4><span class="badge normal">4</span></li>

		<div class="loading-bg hidden"></div>
		<div class="loading hidden"></div>

		<a class="list-group-item" href="<?= config::base_url('index.php?pg=tabungan_detail'); ?>">
			<h4 class="list-group-item-heading">Reza Sariful Fikri</h4> 
			<p class="list-group-item-text">3 Januari 2020, 03:13 pm</p>
			<span class="badge">Rp 300.000</span>
		</a>
		<a class="list-group-item" href="#">
			<h4 class="list-group-item-heading">Glora Indah</h4> 
			<p class="list-group-item-text">1 February 2020, 13:45 am</p>
			<span class="badge">Rp 0</span>
		</a>
		<a class="list-group-item" href="#">
			<h4 class="list-group-item-heading">Hati Murdani</h4> 
			<p class="list-group-item-text">3 Januari 2020, 16:00 pm</p>
			<span class="badge">Rp 30.000</span>
		</a>
		<a class="list-group-item" href="#">
			<h4 class="list-group-item-heading">Rina</h4> 
			<p class="list-group-item-text">3 Januari 2020, 08:13 pm</p>
			<span class="badge">Rp 0</span>
		</a>
	</div>
</div>