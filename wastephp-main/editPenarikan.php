<?php 
session_start();
require 'functions.php';

if (!isset($_SESSION["login"])) {
    echo "<script>
            alert('Anda Harus Login Terlebih Dahulu!');
            document.location.href ='login.php';
        </script>";
}

$id = $_SESSION["IdAdmin"];
$biodata = query("SELECT * FROM admins WHERE IdAdmin = '$id'")[0];

// Ambil data dari URL
$id = $_GET["idPenarikan"];
$penarikan = query("SELECT * FROM penarikan WHERE idTarik = '$id'")[0];
$idu = $penarikan['idUser'];
$users = query("SELECT * FROM users WHERE idUser = '$idu'")[0];

if (isset($_POST["submit"])) {

    // Logika untuk mengedit penarikan
    if (editPenarikanSaldoUser($_POST) > 0) {
        if (editPenarikanSaldoBank($_POST) > 0) {
            if (editPenarikan($_POST) > 0) {
                // Tambahkan record baru ke saldo_bank
                if (tambahRecordSaldoBank($_POST) > 0) {
                    echo "<script>
                            alert('Penarikan Berhasil Diedit');
                            document.location.href = 'penarikanAdmin.php';
                        </script>";
                }
            } else {
                echo "<script>
                        alert('Data Penarikan Gagal Diedit!');
                        document.location.href = 'penarikanAdmin.php';
                    </script>";
            }
        }
    }
}

$title = "Edit Penarikan";
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
                        <h4 class="card-title">Edit Data Penarikan</h4>
                    </div>
                    <div class="card-body">
                        <div class="basic-form">
                            <form action="" method="post" class="mt-3" enctype="multipart/form-data">

                                <div class="row">
                                    <div class="mb-3 col-md-12">
                                        <label class="form-label">Nama Penarik:</label>
                                        <select name="penarik" id="penarik" required="required" class="default-select form-control wide" tabindex="null">
                                            <option selected="">Pilih Salah satu</option>
                                            <?php  
                                                $no = mysqli_query($conn, "SELECT * FROM users");
                                                $jumlahData = mysqli_num_rows($no);
                                            ?>
                                            <?php for ($i = 0; $i < $jumlahData; $i++) { ?>
                                                <?php   $namapenyetor = query("SELECT namaUser FROM users")[$i]; ?>
                                                <?php foreach ($namapenyetor as $nmp) : ?>
                                                <?php $selectednmp = ""; ?>
                                                <?php if ($users["namaUser"] == $nmp) { $selectednmp = "selected"; } ?>
                                                <option value="<?php echo $nmp; ?>" <?php echo $selectednmp; ?>>
                                                    <?php echo $nmp; ?>
                                                </option>
                                                <?php endforeach; ?>
                                            <?php } ?>	
                                        </select>
                                    </div>
                                    <div class="mb-3 col-md-12">
                                        <label class="form-label">Tanggal Penarikan:</label>
                                        <input type="date" name="tanggal" id="tanggal" required="required" class="form-control" value="<?php echo $penarikan["tglTarik"]; ?>">
                                    </div>
                                    <div class="mb-3 col-md-12">
                                        <label class="form-label">Jumlah Saldo yang Ditarik:</label>
                                        <input type="number" name="jmlPenarikan" id="jmlPenarikan" required="required" class="form-control" value="<?php echo $penarikan["jmlPenarikan"]; ?>">
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