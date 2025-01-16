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

// Ambil data di URL
$id = $_GET["idSetoran"];
$setor = query("SELECT * FROM setoran WHERE idSetor = '$id'")[0];
$idu = $setor['idUser'];
$users = query("SELECT * FROM users WHERE idUser = '$idu'")[0];
$ids = $setor['idSampah'];
$sampah = query("SELECT * FROM sampah WHERE idSampah = '$ids'")[0];

if (isset($_POST["submit"]) ){

    if (editSetoranBerat($_POST) > 0 ) {
        if (editSetoranHarga($_POST) > 0 ) {
            if (editSetoran($_POST) > 0 ) {
                echo "
                <script>
                    alert('Setoran Berhasil Diedit');
                    document.location.href = 'setoranAdmin.php';
                </script>
            ";
            } else {
                echo "    
                    <script>
                        alert('Setoran Gagal Diedit!');
                        document.location.href = 'setoranAdmin.php';
                    </script>
                ";
            }
        }
    } 
}

$title = "Edit Setoran";
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
                        <h4 class="card-title">Edit Setoran</h4>
                    </div>
                    <div class="card-body">
                        <div class="basic-form">
                            <form action="" method="post" class="mt-3" enctype="multipart/form-data">

                                <div class="row">
                                    <div class="mb-3 col-md-12">
                                        <label class="form-label">Nama Penyetor:</label>
                                        <select name="penyetor" id="penyetor" required="required" class="default-select form-control wide" tabindex="null">
                                            <option selected="">Pilih Salah satu</option>
                                            <?php  
                                                $no = mysqli_query($conn, "SELECT * FROM users");
                                                $jumlahData = mysqli_num_rows($no);
                                            ?>
                                            <?php for ($i = 0; $i < $jumlahData; $i++) { ?>
                                                <?php   $namapenyetor = query("SELECT namaUser FROM users")[$i]; ?>
                                                <?php foreach ( $namapenyetor as $nmp)  : ?>
                                                <?php $selectednmp=""; ?>
                                                <?php if($users["namaUser"] == $nmp){ $selectednmp="selected"; } ?>
                                                <option value="<?php echo $nmp; ?>" <?php echo $selectednmp; ?>>
                                                    <?php echo $nmp; ?>
                                                </option>
                                                <?php endforeach; ?>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="mb-3 col-md-12">
                                        <label class="form-label">Nama Sampah:</label>
                                        <select name="sampah" id="sampah" required="required" class="default-select form-control wide" tabindex="null">
                                            <option selected="">Pilih Salah satu</option>
                                            <?php  
                                                $no = mysqli_query($conn, "SELECT * FROM sampah");
                                                $jumlahData = mysqli_num_rows($no);
                                            ?>
                                            <?php for ($i = 0; $i < $jumlahData; $i++) { ?>
                                                <?php   $namasampah = query("SELECT namaSampah FROM sampah")[$i]; ?>
                                                <?php foreach ( $namasampah as $ns)  : ?>
                                                <?php $selectedns=""; ?>
                                                <?php if($sampah["namaSampah"] == $ns){ $selectedns="selected"; } ?>
                                                <option value="<?php echo $ns; ?>" <?php echo $selectedns; ?>>
                                                    <?php echo $ns; ?>
                                                </option>
                                                <?php endforeach; ?>
                                            <?php } ?>    
                                        </select>
                                    </div>
                                    <div class="mb-3 col-md-12">
                                        <label class="form-label">Tanggal Setoran:</label>
                                        <input type="date" name="tanggal" id="tanggal" required="required" class="form-control" value="<?php echo date('Y-m-d', strtotime($setor['tglSetor'])); ?>">
                                    </div>
                                    <div class="mb-3 col-md-12">
                                        <label class="form-label">Berat:</label>
                                        <input type="number" name="berat" id="berat" required="required" class="form-control" value="<?php echo $setor["berat"]; ?>">
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
