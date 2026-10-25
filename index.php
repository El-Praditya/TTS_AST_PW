<?php
require 'koneksi.php';

// Mode edit
$edit = null;
if (isset($_GET['edit'])) {
    $stmt = $pdo->prepare("SELECT * FROM ponsel WHERE id=?");
    $stmt->execute([(int)$_GET['edit']]);
    $edit = $stmt->fetch(PDO::FETCH_ASSOC);
}

// READ
$data = $pdo->query("SELECT * FROM ponsel ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Website Saya</title>
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

  <!-- LOADING -->
  <div id="loading-screen">
    <div class="loader"><span></span><span></span><span></span><span></span></div>
  </div>

  <!-- KONTEN -->
  <main id="main-content">
    <h1 id="title">Rental Ponsel</h1>

    <section id="subtitle">
      <?php if (isset($_GET['msg'])): ?>
        <div class="alert ok"><?= htmlspecialchars($_GET['msg']) ?></div>
      <?php endif; ?>
      <?php if (isset($_GET['error'])): ?>
        <div class="alert err"><?= htmlspecialchars($_GET['error']) ?></div>
      <?php endif; ?>

      <!-- FORM CREATE/UPDATE -->
      <form method="POST" action="crud.php" class="card">
        <input type="hidden" name="action" value="<?= $edit ? 'update' : 'create' ?>">
        <?php if ($edit): ?>
          <input type="hidden" name="id" value="<?= $edit['id'] ?>">
        <?php endif; ?>

        <label>Merk</label>
        <input type="text" name="merk" required value="<?= $edit ? htmlspecialchars($edit['merk']) : '' ?>">

        <label>Model</label>
        <input type="text" name="model" required value="<?= $edit ? htmlspecialchars($edit['model']) : '' ?>">

        <label>Harga Sewa / hari</label>
        <input type="number" name="harga_sewa" min="1" required value="<?= $edit ? $edit['harga_sewa'] : '' ?>">

        <label>Stok</label>
        <input type="number" name="stok" min="0" required value="<?= $edit ? $edit['stok'] : '' ?>">

        <button type="submit" class="btn"><?= $edit ? 'Update' : 'Tambah' ?></button>
        <?php if ($edit): ?>
          <a href="index.php" class="btn-link">Batal</a>
        <?php endif; ?>
      </form>

      <!-- TABEL DATA -->
      <table class="table">
        <thead>
          <tr><th>ID</th><th>Merk</th><th>Model</th><th>Harga</th><th>Stok</th><th>Aksi</th></tr>
        </thead>
        <tbody>
          <?php if (empty($data)): ?>
            <tr><td colspan="6" style="text-align:center">Belum ada data</td></tr>
          <?php else: ?>
            <?php foreach ($data as $row): ?>
              <tr>
                <td><?= $row['id'] ?></td>
                <td><?= htmlspecialchars($row['merk']) ?></td>
                <td><?= htmlspecialchars($row['model']) ?></td>
                <td>Rp <?= number_format($row['harga_sewa'], 0, ',', '.') ?></td>
                <td><?= $row['stok'] ?></td>
                <td>
                  <a href="index.php?edit=<?= $row['id'] ?>" class="btn-sm">Edit</a>
                  <form method="POST" action="crud.php" style="display:inline" onsubmit="return confirm('Hapus?')">
                    <input type="hidden" name="action" value="delete">
                    <input type="hidden" name="id" value="<?= $row['id'] ?>">
                    <button type="submit" class="btn-sm danger">Hapus</button>
                  </form>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </section>
  </main>

  <script src="assets/js/script.js"></script>
</body>
</html>