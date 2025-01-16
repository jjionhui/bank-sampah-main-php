<?php 
session_start();
require 'functions.php';

if ( !isset($_SESSION["login"]) ){
	echo "<script>
			alert('Anda Harus Login Terlebih Dahulu!');
      document.location.href ='login.php';
		</script>";
}

$id = $_SESSION["IdAdmin"];
$biodata = query("SELECT * FROM admins WHERE IdAdmin = '$id'")[0];
//ambil data di url
$id = $_GET["idUser"];
$pengguna = query("SELECT * FROM users WHERE idUser = '$id'")[0];

if (isset($_POST["submit"]) ){

	
	if (editPengguna($_POST) > 0 ) {
		echo "
			<script>
				alert('Data berhasil diubah');
				document.location.href = 'pengguna.php';
			</script>
		";
	} else {
		echo("\n \n \n \n \n \n");
		echo ("Error description:" .$conn -> error);
	}

 }
 $title = "Edit Pengguna";
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
						<h4 class="card-title">Edit Data Pengguna</h4>
					</div>
					<div class="card-body">
						<div class="basic-form">
                            <form action="" method="post" class="mt-3" enctype="multipart/form-data">
                            <input type="hidden" name="gambarlama" value="<?= $data["gambar"]; ?>">

								<div class="row">
									<div class="mb-3 col-md-12">
										<label class="form-label">Nama Lengkap:</label>
										<input type="text" name="nama" id="nama" required="required" class="form-control" value="<?php echo $pengguna["namaUser"]; ?>">
									</div>
									<div class="mb-3 col-md-12">
                                        <label for="gambar" class="form-label">Gambar</label>
                                        <img src="img/user/<?= $pengguna["gambar"]?>" width="30%"> 
                                        <br>
                                        <input class="form-control" type="file" name="gambar" id="gambar">
									</div>
									<div class="mb-3 col-md-12">
										<label class="form-label">NIK:</label>
										<input type="text" name="nik" id="nik" required="required" class="form-control" value="<?php echo $pengguna["nik"]; ?>">
									</div>
									<div class="mb-3 col-md-12">
										<label class="form-label">Alamat:</label>
										<input type="text" name="alamat" id="alamat" required="required" class="form-control" value="<?php echo $pengguna["alamat"]; ?>">
									</div>
									<div class="mb-3 col-md-12">
										<label class="form-label">Keterangan:</label>
										<input type="text" name="ket" id="ket" placeholder="Keterangan" required="required" class="form-control" value="<?php echo $ket["ket"]; ?>">
									</div>
									<div class="mb-3 col-md-12">
										<label class="form-label">Telepon:</label>
										<input type="number" name="telepon" id="telepon" required="required" class="form-control" value="<?php echo $pengguna["telepon"]; ?>">
									</div>
									<div class="mb-3 col-md-12">
										<label class="form-label">Jumlah Setoran:</label>
										<input type="number" name="setoran" id="setoran" required="required" placeholderclass="form-control" value="<?php echo $pengguna["jmlSetoran"]; ?>">
									</div>
									<div class="mb-3 col-md-12">
										<label class="form-label">Saldo:</label>
										<input type="number" name="saldo" id="saldo" required="required" class="form-control" value="<?php echo $pengguna["saldo"]; ?>">
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