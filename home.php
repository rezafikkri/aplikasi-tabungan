<?php  
	$dbLogin = new login;
	if($dbLogin->cek_login_no()) { 
		header("Location: ".config::base_url('index.php?pg=login'));
		die;
	}

	$anggota = $dbAnggota->tampil_anggota('*');
?>
<div class="col-lg-8 col-lg-offset-2 mb-100">
	<h2 class="judul text-center">Aplikasi Tabungan <span class="small">v 0.1</span></h2>
	<p></p>

	<a href="<?= config::base_url('login/proses.php?action=logout'); ?>" class="btn btn-danger pull-right"><span class="glyphicon glyphicon-log-out"></span></a>
	<a href="<?= config::base_url('index.php?pg=admin'); ?>" class="btn btn-default pull-right mr-5">Admin</a>
	<a href="<?= config::base_url('index.php?pg=tambah_anggota'); ?>" class="btn btn-success mb-10 pull-right mr-5">Tambah Anggota!</a>

	<div class="input-group search">
		<input type="text" class="form-control" name="nama" placeholder="Nama anggota...">
	    <span class="input-group-btn">
	    	<div class="div-loading-btn mr-5">
				<div class="loading-bg btn hidden"></div>
				<div class="loading-btn hidden"></div>
				<button class="btn btn-success" id="search_anggota">Cari!</button>
			</div>
	    </span>
    </div><!-- /input-group -->

	<div class="list-group">
		<li class="list-group-item list-group-item-warning"><h4 class="list-group-item-heading">Daftar Anggota</h4><span class="badge normal" id="jml_anggota"><?= count($anggota??[]); ?></span></li>

		<div class="loading-bg hidden" id="loading_bg_list"></div>
		<div class="loading hidden" id="loading_list"></div>

		<daftarAnggota>
		<?php 
			if($anggota) : 
			foreach($anggota as $r) :
		?>
		<li class="list-group-item pl-20">
			<h4 class="list-group-item-heading"><?= $r['nama']; ?></h4> 
			<p class="list-group-item-text">Bergabung sejak <?= date("d M Y, h:i a", $r['waktu']); ?></p>
			<span class="badge">Rp <?= number_format($r['jml_tabungan'],0,',','.'); ?></span>

			<a href="<?= config::base_url('index.php?pg=detail_anggota&anggota_id='.$r['anggota_id']); ?>" class="text-info nopadding-l mt-10 display-inline-block">Detail Anggota</a>
			<a href="<?= config::base_url('index.php?pg=tabungan_detail&anggota_id='.$r['anggota_id']); ?>" class="text-info padding-l-10px display-inline-block">Transaksi</a>
		</li>
		<?php endforeach; endif; ?>
		</daftarAnggota>
	</div>
</div>
<alert></alert>
<script type="text/javascript">
// search anggota
const btnSearch_anggota = document.querySelector("button#search_anggota");
const loading_btnSearch_anggota = btnSearch_anggota.previousElementSibling;
const loading_bgSearch_anggota = loading_btnSearch_anggota.previousElementSibling;
const loading_list = document.querySelector("div#loading_list");
const loading_bg_list = document.querySelector('div#loading_bg_list');
btnSearch_anggota.addEventListener('click', () => {
	// cek apakah input ada isinya
	const keyword = document.querySelector("input[name=nama]").value;
	if(keyword.length === 0) return false;
	// loading btn
	loading_btnSearch_anggota.classList.remove('hidden');
	loading_bgSearch_anggota.classList.remove('hidden');
	// loading list
	loading_list.classList.remove('hidden');
	loading_bg_list.classList.remove('hidden');
	
	fetch('<?= config::base_url('anggota/proses.php?action=search_anggota'); ?>', {
		method: "post",
		headers: {
			'Content-Type':'application/x-www-form-urlencoded'
		},
		body: `keyword=${keyword}`
	})
	.finally(()=> {
		// loading btn
		loading_btnSearch_anggota.classList.add('hidden');
		loading_bgSearch_anggota.classList.add('hidden');
		// loading list
		loading_list.classList.add('hidden');
		loading_bg_list.classList.add('hidden');
	})
	// handling errors
	.then(response => {
		if(!response.ok) {
			// set error agar bisa ditangkap oleh catch()
			throw new Error(response.statusText);
		}
		return response.json();
	})
	.then(response => {
		if(response.data === "kosong") {
			document.querySelector('daftarAnggota').innerHTML = `<li class="list-group-item"><p class="list-group-item-text">Data kosong</p>		</li>`;
			document.querySelector('span#jml_anggota').innerHTML = 0;
			return false;

		} else {
			const data = response.data.map(ang => `
				<li class="list-group-item pl-20" href="<?= config::base_url('index.php?pg=tabungan_detail&anggota_id='); ?>${ang.anggota_id}">
				<h4 class="list-group-item-heading">${ang.nama}</h4>
				<p class="list-group-item-text">Bergabung sejak ${ang.waktu}</p>
				<span class="badge">Rp ${ang.jml_tabungan}</span>

				<a href="<?= config::base_url('index.php?pg=detail_anggota&anggota_id='); ?>${ang.anggota_id}" class="text-info nopadding-l mt-10 display-inline-block">Detail Anggota</a>
				<a href="<?= config::base_url('index.php?pg=tabungan_detail&anggota_id='); ?>${ang.anggota_id}" class="text-info padding-l-10px display-inline-block">Transaksi</a>
				</li>`).join('');
			document.querySelector('daftarAnggota').innerHTML = data;
			document.querySelector('span#jml_anggota').innerHTML = response.data.length;
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
</script>