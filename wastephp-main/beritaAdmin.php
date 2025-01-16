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
$berita = query("SELECT * FROM berita ORDER BY idBerita ASC");

$title = "Data Berita";
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
                    <div class="card-body p-0">
                        <div class="table-responsive active-projects style-1">
                            <div class="tbl-caption">
                                <h4 class="heading mb-0">Daftar Berita</h4>
                                <div>
                                    <a href="tambahBerita.php" class="btn btn-primary btn-sm">+ Tambah</a>
                                </div>
                            </div>
                            <table id="empoloyees-tblwrapper" class="table">
                                <thead>
                                    <tr align="center">
                                        <th>No</th>
                                        <th>ID Berita</th>
                                        <th>Judul</th>
                                        <th>Isi</th>
                                        <th>Gambar</th>
                                        <th>Sumber</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    <?php foreach ( $berita as $row)  : ?>                                        
                                        <tr align="center">
                                        <td><?php echo $i; ?></td>
                                        <td><?php echo $row['idBerita'] ?></td>
                                        <td>
                                        <?php 
                                            $a = $row['judul'];
                                            // echo $a;
                                            if (strlen($a) > 20) {
                                                echo substr($a, 0, 20), " (...)";
                                            } else {
                                                echo $a;
                                            }
                                        ?>
                                        </td>
                                        <td>
                                        <?php 
                                            $a = $row['isi'];
                                            // echo $a;
                                            if (strlen($a) > 30) {
                                                echo substr($a, 0, 30), " (...)";
                                            } else {
                                                echo $a;
                                            }
                                        ?>
                                        </td>
                                        <td><img src="img/berita/<?php echo $row["gambar"]; ?>" width="50"></td>
                                        <td>
                                        <?php 
                                            $a = $row['sumber'];
                                            // echo $a;
                                            if (strlen($a) > 20) {
                                                echo substr($a, 0, 20), " (...)";
                                            } else {
                                                echo $a;
                                            }
                                        ?>
                                        </td>
                                        
                                        
                                            <td>
                                                <div class="d-flex">
                                                    <a href="editBerita.php?idBerita=<?php echo $row["idBerita"]; ?>" class="btn btn-primary shadow btn-xs sharp me-1"><i class="fa fa-pencil"></i></a>
                                                    <a onclick="return confirm('Anda yakin ingin menghapus data ini?')" href="hapus.php?action=delete&id=<?php echo $row["idBerita"]; ?>" class="btn btn-danger shadow btn-xs sharp"><i class="fa fa-trash"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php $i++; ?>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
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





























<!--<td><php
                                            $a = $row['ket'];
                                            if (strlen($a) > 20) {
                                                echo substr($a, 0, 20), " (...)";
                                            } else {
                                                echo $a;
                                            }
                                            ?>
                                        </td>-->