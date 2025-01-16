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

$no = mysqli_query($conn, "SELECT * FROM saldo_bank");
$jumlahData = mysqli_num_rows($no);
$hitung = $jumlahData - 1;

if($hitung < 0){
  $saldoAkhir = 0;
} else {
  $saldo = query("SELECT * FROM saldo_bank")[$hitung];
  $saldoAkhir = ($saldo['totalSaldo']);
}


$stock = query("SELECT stock FROM stock_sampah");

$users = mysqli_query($conn, "SELECT * FROM users");
$jumlahDataUsers = mysqli_num_rows($users);
$total = 0;
foreach ($stock as $row){
  $row['stock'];
  $total += $row['stock'] ;
};

$title = "Admin";
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
						<h4 class="card-title">Data Admin</h4>
					</div>
					<div class="card-body">
						<div class="basic-form">

							<div class="row">
								<div class="mb-3 col-md-12">
									<label class="form-label">Nomor Induk Admin:</label>
									<input type="text" class="form-control" disabled="disabled" value="<?php echo $biodata["IdAdmin"]; ?>">
								</div>
								<div class="mb-3 col-md-12">
									<label class="form-label">Nama Admin:</label>
									<input type="text" class="form-control" disabled="disabled" value="<?php echo $biodata["namaAdmin"]; ?>">
								</div>
								<div class="mb-3 col-md-12">
									<label class="form-label">Username:</label>
									<input type="text" class="form-control" disabled="disabled" value="<?php echo $biodata["usernameAdmin"]; ?>">
								</div>
								<div class="mb-3 col-md-12">
									<label class="form-label">Level:</label>
									<input type="text" class="form-control" disabled="disabled" value="<?php echo $biodata["level"]; ?>">
								</div>
							</div>
							<a href="editAdmin.php?IdAdmin=<?php echo $biodata["IdAdmin"]; ?>">
								<button type="submit" name="submit" class="btn btn-primary">Edit Data</button>
							</a>
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