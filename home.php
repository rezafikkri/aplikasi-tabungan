<?php  
	$dbLogin = new login;
	if($dbLogin->cek_login_no()) { 
		header("Location: ".config::base_url('index.php?pg=login'));
		die;
	}

	$anggota = $dbAnggota->tampil_anggota('nama, jml_tabungan, waktu');
?>
<div class="col-lg-8 col-lg-offset-2">
	<h2 class="judul text-center">Aplikasi Tabungan <span class="small">v 0.1</span></h2>
	<p></p>

	<a href="<?= config::base_url('login/proses.php?action=logout'); ?>" class="btn btn-danger pull-right"><span class="glyphicon glyphicon-log-out"></span></a>
	<a href="<?= config::base_url('index.php?pg=admin'); ?>" class="btn btn-default pull-right mr-5">Admin</a>
	<a href="<?= config::base_url('index.php?pg=tambah_anggota'); ?>" class="btn btn-success mb-10 pull-right mr-5">Tambah Anggota!</a>

	<div class="input-group search">
		<input type="text" class="form-control" name="nama" placeholder="Nama anggota...">
	    <span class="input-group-btn">
	    	<div class="div-loading-btn">
				<div class="loading-bg btn hidden"></div>
				<div class="loading-btn hidden"></div>
				<button class="btn btn-success mr-5" id="search_anggota">Cari!</button>
			</div>
	    </span>
    </div><!-- /input-group -->

	<div class="list-group">
		<li class="list-group-item list-group-item-warning"><h4 class="list-group-item-heading">Daftar Anggota</h4><span class="badge normal">4</span></li>

		<div class="loading-bg hidden"></div>
		<div class="loading hidden"></div>

		<daftarAnggota>
		<?php 
			if($anggota) : 
			foreach($anggota as $r) :
		?>
		<a class="list-group-item" href="<?= config::base_url('index.php?pg=tabungan_detail'); ?>">
			<h4 class="list-group-item-heading"><?= $r['nama']; ?></h4> 
			<p class="list-group-item-text">Bergabung sejak <?= date("d M Y, h:i a", $r['waktu']); ?></p>
			<span class="badge">Rp <?= number_format($r['jml_tabungan'],0,',','.'); ?></span>
		</a>
		<?php endforeach; endif; ?>
		</daftarAnggota>
	</div>
</div>
<script type="text/javascript">
// search anggota
const btnSearch_anggota = document.querySelector("button#search_anggota");
btnSearch_anggota.addEventListener('click', () => {

});
</script>