
<?php
require 'koneksi.php';

$action = $_POST['action'] ?? '';

// ===== CREATE =====
if ($action === 'create') {
    $nama  = trim($_POST['nama_hp'] ?? '');
    $merek = trim($_POST['merek'] ?? '');
    $harga = (float)($_POST['harga_sewa'] ?? 0);
    $stok  = (int)($_POST['stok'] ?? 0);

    if ($nama === '' || $merek === '' || $harga <= 0 || $stok < 0) {
        header('Location: index.php?error=' . urlencode('Data tidak valid'));
        exit;
    }

    $stmt = $pdo->prepare(
        "INSERT INTO hp (nama_hp, merek, harga_sewa, stok)
         VALUES (?, ?, ?, ?)"
    );
    $stmt->execute([$nama, $merek, $harga, $stok]);

    header('Location: index.php?msg=' . urlencode('Data berhasil ditambahkan'));
    exit;
}

// ===== UPDATE =====
if ($action === 'update') {
    $id    = (int)($_POST['id_hp'] ?? 0);
    $nama  = trim($_POST['nama_hp'] ?? '');
    $merek = trim($_POST['merek'] ?? '');
    $harga = (float)($_POST['harga_sewa'] ?? 0);
    $stok  = (int)($_POST['stok'] ?? 0);

    if ($id <= 0 || $nama === '' || $merek === '' || $harga <= 0 || $stok < 0) {
        header('Location: index.php?error=' . urlencode('Data tidak valid'));
        exit;
    }

    $stmt = $pdo->prepare(
        "UPDATE hp
         SET nama_hp = ?, merek = ?, harga_sewa = ?, stok = ?
         WHERE id_hp = ?"
    );
    $stmt->execute([$nama, $merek, $harga, $stok, $id]);

    header('Location: index.php?msg=' . urlencode('Data berhasil diupdate'));
    exit;
}

// ===== DELETE =====
if ($action === 'delete') {
    $id = (int)($_POST['id_hp'] ?? 0);

    if ($id > 0) {
        $stmt = $pdo->prepare("DELETE FROM hp WHERE id_hp = ?");
        $stmt->execute([$id]);
    }

    header('Location: index.php?msg=' . urlencode('Data berhasil dihapus'));
    exit;
}

header('Location: index.php');
exit;
?>
