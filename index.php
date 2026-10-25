<?php
require 'koneksi.php';

// ===== AMBIL DATA UNTUK EDIT =====
$edit = null;

if (isset($_GET['edit'])) {
  $stmt = $pdo->prepare("SELECT * FROM hp WHERE id_hp = ?");
  $stmt->execute([(int) $_GET['edit']]);
  $edit = $stmt->fetch(PDO::FETCH_ASSOC);
}

// ===== AMBIL SEMUA DATA HP =====
$data = $pdo->query("SELECT * FROM hp ORDER BY id_hp DESC")
  ->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Rental Ponsel</title>

  <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>

  <!-- LOADING -->
  <div id="loading-screen">
    <div class="loader">
      <span></span>
      <span></span>
      <span></span>
      <span></span>
    </div>
  </div>

  <!-- KONTEN UTAMA -->
  <main id="main-content">

    <h1 id="title">Rental Ponsel</h1>

    <section id="subtitle">

      <p class="desc">
        Kami menyediakan Android dan IOS mulai dari generasi lama
        hingga generasi terbaru.
      </p>

      <br><br><br><br>

      <!-- NOTIFIKASI BERHASIL -->
      <?php if (isset($_GET['msg'])): ?>
        <div class="alert ok">
          <?= htmlspecialchars($_GET['msg']) ?>
        </div>
      <?php endif; ?>

      <!-- NOTIFIKASI ERROR -->
      <?php if (isset($_GET['error'])): ?>
        <div class="alert err">
          <?= htmlspecialchars($_GET['error']) ?>
        </div>
      <?php endif; ?>


      <!-- FORM TAMBAH DAN EDIT HP -->
      <form method="POST" action="crud.php" class="card">

        <input
          type="hidden"
          name="action"
          value="<?= $edit ? 'update' : 'create' ?>">

        <?php if ($edit): ?>
          <input
            type="hidden"
            name="id_hp"
            value="<?= $edit['id_hp'] ?>">
        <?php endif; ?>


        <!-- NAMA HP -->
        <label>Nama HP</label>

        <input
          type="text"
          name="nama_hp"
          placeholder="Contoh: iPhone 15"
          required
          value="<?= $edit ? htmlspecialchars($edit['nama_hp']) : '' ?>">


        <!-- MEREK -->
        <label>Merek</label>

        <input
          type="text"
          name="merek"
          placeholder="Contoh: Apple"
          required
          value="<?= $edit ? htmlspecialchars($edit['merek']) : '' ?>">


        <!-- HARGA SEWA -->
        <label>Harga Sewa / hari</label>

        <input
          type="number"
          name="harga_sewa"
          min="1"
          step="0.01"
          placeholder="Contoh: 150000"
          required
          value="<?= $edit ? $edit['harga_sewa'] : '' ?>">


        <!-- STOK -->
        <label>Stok</label>

        <input
          type="number"
          name="stok"
          min="0"
          placeholder="Contoh: 5"
          required
          value="<?= $edit ? $edit['stok'] : '' ?>">


        <!-- TOMBOL SUBMIT -->
        <button type="submit" class="btn">
          <?= $edit ? 'Update Data' : 'Tambah Data' ?>
        </button>


        <!-- TOMBOL BATAL EDIT -->
        <?php if ($edit): ?>
          <a href="index.php" class="btn-link">
            Batal
          </a>
        <?php endif; ?>

      </form>


      <!-- TABEL DATA HP -->
      <table class="table">

        <thead>
          <tr>
            <th>ID</th>
            <th>Nama HP</th>
            <th>Merek</th>
            <th>Harga Sewa / Hari</th>
            <th>Stok</th>
            <th>Aksi</th>
          </tr>
        </thead>

        <tbody>

          <!-- JIKA DATA KOSONG -->
          <?php if (empty($data)): ?>

            <tr>
              <td colspan="6" style="text-align:center">
                Belum ada data HP
              </td>
            </tr>

          <?php else: ?>

            <!-- TAMPILKAN DATA -->
            <?php foreach ($data as $row): ?>

              <tr>

                <!-- ID -->
                <td>
                  <?= $row['id_hp'] ?>
                </td>


                <!-- NAMA HP -->
                <td>
                  <?= htmlspecialchars($row['nama_hp']) ?>
                </td>


                <!-- MEREK -->
                <td>
                  <?= htmlspecialchars($row['merek']) ?>
                </td>


                <!-- HARGA -->
                <td>
                  Rp <?= number_format(
                        $row['harga_sewa'],
                        0,
                        ',',
                        '.'
                      ) ?>
                </td>


                <!-- STOK -->
                <td>
                  <?= $row['stok'] ?>
                </td>


                <!-- AKSI -->
                <td>

                  <!-- EDIT -->
                  <a
                    href="index.php?edit=<?= $row['id_hp'] ?>"
                    class="btn-sm">
                    Edit
                  </a>


                  <!-- HAPUS -->
                  <form
                    method="POST"
                    action="crud.php"
                    style="display:inline"
                    onsubmit="return confirm('Yakin ingin menghapus data ini?')">

                    <input
                      type="hidden"
                      name="action"
                      value="delete">

                    <input
                      type="hidden"
                      name="id_hp"
                      value="<?= $row['id_hp'] ?>">

                    <button
                      type="submit"
                      class="btn-sm danger">
                      Hapus
                    </button>

                  </form>

                </td>

              </tr>

            <?php endforeach; ?>

          <?php endif; ?>

        </tbody>

      </table>

    </section>

  </main>


  <!-- JAVASCRIPT -->
  <script src="assets/js/script.js"></script>

</body>

</html>