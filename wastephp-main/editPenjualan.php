<?php 
session_start();
require 'functions.php';

if (!isset($_SESSION["login"])) {
    echo "<script>
            alert('Anda Harus Login Terlebih Dahulu!');
            document.location.href = 'login.php';
          </script>";
}

// Ambil ID Penjualan dari URL
if (!isset($_GET['idPenjualan'])) {
    echo "<script>
            alert('ID Penjualan tidak ditemukan!');
            document.location.href = 'penjualan.php';
          </script>";
    exit;
}

$idPenjualan = $_GET['idPenjualan'];
$penjualan = query("SELECT * FROM penjualan WHERE idJual = '$idPenjualan'")[0];
$namaSampah = query("SELECT namaSampah FROM sampah WHERE idSampah = '{$penjualan['idSampah']}'")[0]['namaSampah'];

if (!$penjualan) {
    echo "<script>
            alert('Data Penjualan tidak ditemukan!');
            document.location.href = 'penjualan.php';
          </script>";
    exit;
}

if (isset($_POST['submit'])) {
    $successPenjualan = editPenjualan($_POST);
    $successStock = editPenjualanStock($_POST);
    $successSaldo = updateTotalSaldo($_GET['idPenjualan'], 'Edit Penjualan', $_POST);

    if ($successPenjualan >= 0 && $successStock >= 0 && $successSaldo >= 0) {
        echo "<script>
                alert('Data berhasil diupdate!');
                document.location.href = 'penjualanAdmin.php';
              </script>";
    } else {
        echo "<script>
                alert('Data gagal diupdate!');
              </script>";
    }
}


$title = "Edit Penjualan";
?>

<?php include_once("header.php"); ?>
<?php include_once("sidebar.php"); ?>

<div class="content-body">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Edit Data Penjualan</h4>
                    </div>
                    <div class="card-body">
                        <form action="" method="post">
                            <div class="mb-3">
                                <label for="sampah" class="form-label">Nama Sampah</label>
                                <input type="text" class="form-control" id="sampah" name="sampah" value="<?php echo $namaSampah; ?>" required>
                            </div>

                            <div class="mb-3">
                                <label for="berat" class="form-label">Berat (kg)</label>
                                <input type="number" step="0.01" class="form-control" id="berat" name="berat" value="<?php echo $penjualan['berat']; ?>" required>
                            </div>

                            <div class="mb-3">
                                <label for="tanggal" class="form-label">Tanggal Penjualan</label>
                                <input type="date" class="form-control" id="tanggal" name="tanggal" value="<?php echo $penjualan['tglPenjualan']; ?>" required>
                            </div>

                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama Pembeli</label>
                                <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $penjualan['namaPembeli']; ?>" required>
                            </div>

                            <div class="mb-3">
                                <label for="nomor" class="form-label">Nomor Pembeli</label>
                                <input type="text" class="form-control" id="nomor" name="nomor" value="<?php echo $penjualan['nomorPembeli']; ?>" required>
                            </div>

                            <div class="mb-3">
                                <label for="harga" class="form-label">Harga (Rp)</label>
                                <input type="number" class="form-control" id="harga" name="harga" value="<?php echo $penjualan['harga']; ?>" required>
                            </div>

                            <button type="submit" name="submit" class="btn btn-primary">Simpan</button>
                            <a href="penjualan.php" class="btn btn-secondary">Batal</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once("footer.php"); ?>
