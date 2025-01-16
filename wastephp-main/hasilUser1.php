<?php 
// Mulai session
session_start();
require 'functions.php';

// Pastikan pengguna telah login
if (!isset($_SESSION["login"])) {
    echo "<script>
            alert('Anda Harus Login Terlebih Dahulu!');
            document.location.href = 'login.php';
          </script>";
    exit;
}

// Ambil data pengguna berdasarkan idUser
$id = $_SESSION["idUser"];
$biodata = query("SELECT * FROM users WHERE idUser = '$id'")[0] ?? null;

// Jika pengguna tidak ditemukan, tampilkan pesan kesalahan
if (!$biodata) {
    echo "<script>
            alert('Data pengguna tidak ditemukan!');
            document.location.href = 'logout.php';
          </script>";
    exit;
}

// Ambil data setoran
$setoran = query("SELECT * FROM setoran WHERE idUser = '$id' ORDER BY tglSetor ASC");
$title = "Hasil Pengumpulan"
?>

<?php include_once("header_user.php"); ?>
<?php include_once("sidebar_user.php"); ?>

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
                        <div class="table-responsive active-projects style-2">
                            <div class="tbl-caption d-flex justify-content-between align-items-center">
                                <h4 class="heading mb-0">Data Pengumpulan Anda</h4>
                                <div class="d-flex align-items-center">
                                    <input type="text" id="searchInput" class="form-control form-control-sm" placeholder="Cari..." style="width: 200px;">
                                </div>
                            </div>
                            <table id="empoloyees-tblwrapper" class="table">
                                <thead>
                                    <tr align="center">
                                        <th>No</th>
                                        <th>Tanggal Setoran</th>
                                        <th>Nama Sampah</th>
                                        <th>Berat</th>
                                        <th>Harga/KG</th>
                                        <th class="total-column">Total</th> <!-- Tambahkan kelas untuk kolom Total -->
                                    </tr>
                                </thead>
                                <tbody id="tableBody">
                                <?php if (!empty($setoran)) : ?>
                                    <?php $i = 1; ?>
                                    <?php foreach ($setoran as $row): ?>
                                        <?php 
                                        $kode2 = $row["idSampah"];
                                        $namaSampah = query("SELECT namaSampah, harga FROM sampah WHERE idSampah = '$kode2'")[0] ?? null;
                                        ?>
                                        <tr align="center">
                                            <td><?php echo $i; ?></td>
                                            <td><?php echo htmlspecialchars($row['tglSetor']); ?></td>
                                            <?php if ($namaSampah): ?>
                                                <td><?php echo htmlspecialchars($namaSampah['namaSampah']); ?></td>
                                                <td><?php echo htmlspecialchars($row['berat']) . " KG"; ?></td>
                                                <td><?php echo "Rp. " . number_format($namaSampah['harga'], 2, ",", "."); ?></td>
                                                <td class="total-column"><?php echo "Rp. " . number_format($row['total'], 2, ",", "."); ?></td> <!-- Tambahkan kelas di sini juga -->
                                            <?php else: ?>
                                                <td colspan="4">Data sampah tidak ditemukan</td>
                                            <?php endif; ?>
                                        </tr>
                                        <?php $i++; ?>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="6" align="center">Tidak ada data setoran.</td>
                                    </tr>
                                <?php endif; ?>
                                </tbody>
                            </table>

                            <style>
                                #empoloyees-tblwrapper {
                                    width: 100%; /* Menjaga tabel agar memenuhi lebar kontainer */
                                }
                                #empoloyees-tblwrapper th, 
                                #empoloyees-tblwrapper td {
                                    text-align: center; /* Memastikan semua teks dalam tabel terpusat */
                                    padding: 10px; /* Menambahkan padding untuk semua sel */
                                }
                                .total-column {
                                    padding-right: 20px; /* Menambahkan jarak khusus untuk kolom Total */
                                }
                            </style>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    document.getElementById('searchInput').addEventListener('input', function () {
        const filter = this.value.toLowerCase();
        const rows = document.querySelectorAll('#tableBody tr');

        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(filter) ? '' : 'none';
        });
    });
</script>
<!--**********************************
    Content body end
***********************************-->

<?php include_once("footer.php"); ?>