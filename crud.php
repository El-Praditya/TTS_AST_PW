
<?php
require 'koneksi.php';

$action = $_POST['action'] ?? '';

// ===== CREATE =====
if ($action === 'create') {
    $merk  = trim($_POST['merk'] ?? '');
    $model = trim($_POST['model'] ?? '');
    $harga = filter_var(
        $_POST['harga_sewa'] ?? null,
        FILTER_VALIDATE_INT
    );
    $stok = filter_var(
        $_POST['stok'] ?? null,
        FILTER_VALIDATE_INT
    );

    if (
        $merk === '' ||
        $model === '' ||
        strlen($merk) > 50 ||
        strlen($model) > 50 ||
        $harga === false || $harga === null || $harga <= 0 ||
        $stok === false || $stok === null || $stok < 0
    ) {
        header('Location: index.php?error=' . urlencode('Data tidak valid'));
        exit;
    }

    $stmt = $pdo->prepare(
        "INSERT INTO ponsel (merk, model, harga_sewa, stok)
         VALUES (?, ?, ?, ?)"
    );

    $stmt->execute([$merk, $model, $harga, $stok]);

    header('Location: index.php?msg=' . urlencode('Data berhasil ditambahkan'));
    exit;
}

// ===== UPDATE =====
if ($action === 'update') {
    $id    = (int)($_POST['id'] ?? 0);
    $merk  = trim($_POST['merk'] ?? '');
    $model = trim($_POST['model'] ?? '');
    $harga = filter_var(
        $_POST['harga_sewa'] ?? null,
        FILTER_VALIDATE_INT
    );
    $stok = filter_var(
        $_POST['stok'] ?? null,
        FILTER_VALIDATE_INT
    );

    if (
        $id <= 0 ||
        $merk === '' ||
        $model === '' ||
        strlen($merk) > 50 ||
        strlen($model) > 50 ||
        $harga === false || $harga === null || $harga <= 0 ||
        $stok === false || $stok === null || $stok < 0
    ) {
        header('Location: index.php?error=' . urlencode('Data tidak valid'));
        exit;
    }

    $stmt = $pdo->prepare(
        "UPDATE ponsel
         SET merk = ?, model = ?, harga_sewa = ?, stok = ?
         WHERE id = ?"
    );

    $stmt->execute([$merk, $model, $harga, $stok, $id]);

    header('Location: index.php?msg=' . urlencode('Data berhasil diupdate'));
    exit;
}

// ===== DELETE =====
if ($action === 'delete') {
    $id = (int)($_POST['id'] ?? 0);

    if ($id > 0) {
        $stmt = $pdo->prepare(
            "DELETE FROM ponsel WHERE id = ?"
        );

        $stmt->execute([$id]);
    }

    header('Location: index.php?msg=' . urlencode('Data berhasil dihapus'));
    exit;
}

header('Location: index.php');
exit;
?>
