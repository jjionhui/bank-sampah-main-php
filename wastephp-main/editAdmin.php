<?php 
session_start();
require 'functions.php';

if ( !isset($_SESSION["login"]) ){
	echo "<script>
			alert('Anda Harus Login Terlebih Dahulu!');
      document.location.href ='login.php';
		</script>";
}

//ambil data di url
$id = $_GET["IdAdmin"];

$biodata = query("SELECT * FROM admins WHERE IdAdmin = '$id'")[0];

if (isset($_POST["submit"]) ){
	
	if (ubahAdmin($_POST) > 0 ) {
		echo "
			<script>
				alert('Data Admin berhasil diubah');
				document.location.href = 'admin.php';
			</script>
		";
	} else {
		echo("\n \n \n \n \n \n");
		echo ("Error description:" .$conn -> error);
	}

 }

 $title = "Ubah Admin";
?>

<?php include_once("header.php"); ?>
<?php include_once("sidebar.php"); ?>
		
<!--**********************************
	Content body start
***********************************-->
<div class="content-body">
	<div class="container-fluid">
		
		<!-- row -->
		<div class="row">
			<div class="col-xl-12 col-lg-12">
				<div class="card">
					<div class="card-header">
						<h4 class="card-title">Edit Data Admin</h4>
					</div>
					<div class="card-body">
						<div class="basic-form">
                            <form action="" method="post" class="mt-3">

								<div class="row">
									<div class="mb-3 col-md-12">
										<label class="form-label">Nama Lengkap:</label>
										<input type="text" name="nama" id="nama" required="required" class="form-control" placeholder="Masukkan Nama Lengkap Anda" value="<?php echo $biodata["namaAdmin"]; ?>">
									</div>
									<div class="mb-3 col-md-12">
										<label class="form-label">Username Admin:</label>
										<input type="text" name="username" id="username" required="required" class="form-control" placeholder="Masukkan Username Anda" value="<?php echo $biodata["usernameAdmin"]; ?>">
									</div>
									<div class="mb-3 col-md-12">
										<label class="form-label">Password:</label>
										<input type="password" name="password" id="password" required="required" class="form-control" placeholder="Masukkan Password Anda" value="<?php echo $biodata["passwordAdmin"]; ?>">
									</div>
									<div class="mb-3 col-md-12">
										<label class="form-label">Konfirmasi Password:</label>
										<input type="password" name="password2" id="password2" required="required" class="form-control" placeholder="Konfirmasi Password Anda" value="<?php echo $biodata["passwordAdmin"]; ?>">
									</div>
								</div>
								<button type="submit" name="submit" class="btn btn-primary">SUBMIT</button>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!--**********************************
	Content body end
***********************************-->

<?php include_once("footer.php"); ?>