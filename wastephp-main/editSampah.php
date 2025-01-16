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
$id = $_GET["idSampah"];
$sampah = query("SELECT * FROM sampah WHERE idSampah = '$id'")[0];

$coba = query("SELECT idUser FROM users")[0];

if (isset($_POST["submit"]) ){

	
	if (editSampah($_POST) > 0 ) {
		echo "
			<script>
				alert('Sampah Berhasil Diedit');
				document.location.href = 'sampahAdmin.php';
			</script>
		";
	} else {
		echo "	
			<script>
				alert('Sampah Gagal Diedit!');
				document.location.href = 'sampahAdmin.php';
			</script>
		";
	}

 }

 $title = "Edit Sampah";
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
						<h4 class="card-title">Edit Data Sampah</h4>
					</div>
					<div class="card-body">
						<div class="basic-form">
                            <form action="" method="post" class="mt-3" enctype="multipart/form-data">
                            <input type="hidden" name="namalama" value="<?php echo $sampah["namaSampah"]; ?>">

								<div class="row">
									<div class="mb-3 col-md-12">
										<label class="form-label">Jenis Sampah:</label>
										<select name="jenisSampah" id="jenisSampah" required="required" class="default-select form-control wide" tabindex="null">
                                            <option selected="">Pilih Salah satu</option>
                                            <?php 
                                                $selectedOrganik=""; 
                                                $selectedAnorganik=""; 

                                                if ($sampah["jenisSampah"]=="Organik") {
                                                    $selectedOrganik="selected"; 
                                                } else{
                                                    $selectedAnorganik="selected"; 
                                                }
                                            ?>
                                            <option value="Organik" <?php echo $selectedOrganik ?>>Organik</option>
                                            <option value="Anorganik" <?php echo $selectedAnorganik; ?>>Anorganik</option>
                                        </select>
									</div>
									<div class="mb-3 col-md-12">
										<label class="form-label">Nama Sampah:</label>
										<input type="text" name="namaSampah" id="namaSampah" required="required" class="form-control" value="<?php echo $sampah["namaSampah"]; ?>">
									</div>
                                    <div class="row">
                                        <div class="mb-3 col-md-8">
                                            <label class="form-label">Harga:</label>
                                            <input type="number" name="harga" id="harga" required="required" class="form-control" value="<?php echo $sampah["harga"]; ?>">
                                        </div>
                                        <div class="mb-3 col-md-4">
                                            <label class="form-label">Satuan:</label>
                                            <select name="satuan" id="satuan" required="required" class="default-select form-control wide" tabindex="null">
                                                <option selected="">Pilih Salah satu</option>
                                                <?php 
                                                    $selectedKG=""; 
                                                    $selectedPC=""; 
                                                    $selectedLT=""; 

                                                    if ($sampah["satuan"]=="KG") {
                                                        $selectedKG="selected"; 
                                                    } elseif ($sampah["satuan"]=="PC") {
                                                        $selectedPC="selected"; 
                                                    } else{
                                                        $selectedLT="selected"; 
                                                    }
                                                ?>
                                                <option value="KG" <?php echo $selectedKG ?>>KG</option>
                                                <option value="PC" <?php echo $selectedPC ?>>PC</option>
                                                <option value="LT" <?php echo $selectedLT ?>>LT</option>
                                            </select>
                                        </div>
                                    </div>
									<div class="mb-3 col-md-12">
                                        <label for="foto" class="form-label">Gambar</label>
                                        <img src="img/sampah/<?= $sampah["gambar"]  ?>" width="30%"> <br>
                                        <input class="form-control" type="file" name="foto" id="foto" value="img/sampah/<?php echo $sampah["gambar"]; ?>">
									</div>
									<div class="mb-3 col-md-12">
										<label class="form-label">Keterangan:</label>
										<textarea class="form-txtarea form-control" rows="2" name="keterangan" required="required" id="keterangan"><?php echo $sampah["deskripsi"]; ?></textarea>
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