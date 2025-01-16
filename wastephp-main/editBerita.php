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
$id = $_GET["idBerita"];
$berita = query("SELECT * FROM berita WHERE idBerita = '$id'")[0];


if (isset($_POST["submit"]) ){

	
	if (editBerita($_POST) > 0 ) {
		echo "
			<script>
				alert('Berita Berhasil Diedit');
				document.location.href = 'beritaAdmin.php';
			</script>
		";
	} else {
		echo "	
			<script>
				alert('Berita Gagal Diedit!');
				document.location.href = 'beritaAdmin.php';
			</script>
		";
	}

 }

 $title = "Edit Berita";
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
						<h4 class="card-title">Edit Data Berita</h4>
					</div>
					<div class="card-body">
						<div class="basic-form">
                            <form action="" method="post" class="mt-3" enctype="multipart/form-data">
                            <input type="hidden" name="gambarlama" value="<?= $berita["gambar"]; ?>">

								<div class="row">
									<div class="mb-3 col-md-12">
										<label class="form-label">Judul Berita:</label>
										<input type="text" name="judul" id="judul" placeholder="Judul Berita" required="required" class="form-control" value="<?php echo $berita["judul"]; ?>">
									</div>
									<div class="mb-3 col-md-12">
										<label class="form-label">Isi Berita:</label>
										<textarea class="form-txtarea form-control" rows="3" name="isi" placeholder="Isi Berita" required="required" id="isi"><?php echo $berita["isi"]; ?></textarea>
									</div>
									<div class="mb-3 col-md-12">
                                        <label for="foto" class="form-label">Gambar</label>
                                        <img src="img/berita/<?= $berita["gambar"]  ?>" width="30%"> <br>
                                        <input class="form-control" type="file" name="foto" id="foto" value="img/berita/<?php echo $berita["gambar"]; ?>">
									</div>
									<div class="mb-3 col-md-12">
										<label class="form-label">Sumber Berita:</label>
										<input type="text" name="sumber" id="sumber" placeholder="Sumber Berita" required="required" class="form-control" value="<?php echo $berita["sumber"]; ?>">
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