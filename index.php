
<?php
require 'koneksi.php';

// ===== AMBIL DATA UNTUK EDIT =====
$edit = null;

if (isset($_GET['edit'])) {
    $stmt = $pdo->prepare("SELECT * FROM ponsel WHERE id = ?");
    $stmt->execute([(int) $_GET['edit']]);
    $edit = $stmt->fetch(PDO::FETCH_ASSOC);
}

// ===== AMBIL SEMUA DATA PONSEL =====
$data = $pdo->query("SELECT * FROM ponsel ORDER BY id DESC")
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

        <!-- HEADER -->
        <header class="page-header">
            <h1 id="title">Rental Ponsel</h1>
            <p class="desc">
                Kami menyediakan Android dan IOS mulai dari generasi lama
                hingga generasi terbaru.
            </p>
        </header>

        <section id="subtitle">

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

            <!-- FORM TAMBAH DAN EDIT -->
            <form method="POST" action="crud.php" class="card">

                <input
                    type="hidden"
                    name="action"
                    value="<?= $edit ? 'update' : 'create' ?>"
                >

                <?php if ($edit): ?>
                    <input
                        type="hidden"
                        name="id"
                        value="<?= $edit['id'] ?>"
                    >
                <?php endif; ?>

                <label>Merk HP</label>
                <input
                    type="text"
                    name="merk"
                    maxlength="50"
                    placeholder="Contoh: Apple"
                    required
                    value="<?= $edit ? htmlspecialchars($edit['merk']) : '' ?>"
                >

                <label>Model HP</label>
                <input
                    type="text"
                    name="model"
                    maxlength="50"
                    placeholder="Contoh: iPhone 15"
                    required
                    value="<?= $edit ? htmlspecialchars($edit['model']) : '' ?>"
                >

                <label>Harga Sewa / hari</label>
                <input
                    type="number"
                    name="harga_sewa"
                    min="1"
                    step="1"
                    placeholder="Contoh: 150000"
                    required
                    value="<?= $edit ? htmlspecialchars((string) $edit['harga_sewa']) : '' ?>"
                >

                <label>Stok</label>
                <input
                    type="number"
                    name="stok"
                    min="0"
                    step="1"
                    placeholder="Contoh: 5"
                    required
                    value="<?= $edit ? htmlspecialchars((string) $edit['stok']) : '' ?>"
                >

                <button type="submit" class="btn">
                    <?= $edit ? 'Update Data' : 'Tambah Data' ?>
                </button>

                <?php if ($edit): ?>
                    <a href="index.php" class="btn-link">Batal</a>
                <?php endif; ?>

            </form>

            <!-- DATA PONSEL -->
            <div class="table-section">
                <h2 class="section-title">Data Ponsel</h2>

                <div class="table-wrapper">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Merk</th>
                                <th>Model</th>
                                <th>Harga Sewa / Hari</th>
                                <th>Stok</th>
                                <th>Update</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php if (empty($data)): ?>
                                <tr>
                                    <td colspan="6" style="text-align:center">
                                        Belum ada data ponsel
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($data as $row): ?>
                                    <tr>
                                        <td><?= $row['id'] ?></td>
                                        <td><?= htmlspecialchars($row['merk']) ?></td>
                                        <td><?= htmlspecialchars($row['model']) ?></td>
                                        <td>
                                            Rp <?= number_format(
                                                $row['harga_sewa'],
                                                0,
                                                ',',
                                                '.'
                                            ) ?>
                                        </td>
                                        <td><?= $row['stok'] ?></td>
                                        <td>
                                            <a
                                                href="index.php?edit=<?= $row['id'] ?>"
                                                class="btn-sm"
                                            >Edit</a>

                                            <form
                                                method="POST"
                                                action="crud.php"
                                                style="display:inline"
                                                onsubmit="return confirm('Yakin ingin menghapus data ini?')"
                                            >
                                                <input
                                                    type="hidden"
                                                    name="action"
                                                    value="delete"
                                                >

                                                <input
                                                    type="hidden"
                                                    name="id"
                                                    value="<?= $row['id'] ?>"
                                                >

                                                <button
                                                    type="submit"
                                                    class="btn-sm danger"
                                                >Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </section>
    </main>

    <!-- JAVASCRIPT -->
    <script src="assets/js/script.js"></script>

</body>
</html>
