<?php  
	$dbLogin = new login;
	if($dbLogin->cek_login_yes()) { 
		header("Location: ".config::base_url('index.php')); 
		die;
	}
	$errors = $dbLogin->get_form_errors();
?>
<div class="col-lg-4 col-lg-offset-4 mt-30">
	<h2 class="judul text-center">Aplikasi Tabungan <span class="small">v 0.1</span></h2>
	<div class="login">
		<form method="post" action="<?= config::base_url('login/proses.php?action=login'); ?>">
			<?= $errors['username']??''; ?>
			<input type="text" class="form-control" name="username" placeholder="Username...">
			<?= $errors['password']??''; ?>
			<input type="password" class="form-control mb-10" name="password" placeholder="Password...">
			<button class="btn btn-success btn-block">Masuk!</button>
		</form>
		<p class="copy-right mt-20">Copyright &copy; Reza Sariful Fikri. All Right Reserved</p>
	</div>
</div>