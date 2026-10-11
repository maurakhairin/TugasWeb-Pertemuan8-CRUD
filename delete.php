<?php
require 'includes/init.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

$pdo = Database::getInstance()->getConnection();

$id_produk = (int) ($_POST['id_produk'] ?? 0);

if ($id_produk === 0) {
    setFlash('gagal', 'ID produk tidak valid.');
    header('Location: index.php');
    exit;
}

try {
    $pdo->beginTransaction();
    $stmtCek = $pdo->prepare("SELECT nama_produk FROM produk WHERE id_produk = :id");
    $stmtCek->bindValue(':id', $id_produk, PDO::PARAM_INT);
    $stmtCek->execute();
    $produk = $stmtCek->fetch();

    if (!$produk) {
        throw new Exception('Produk tidak ditemukan (mungkin sudah dihapus sebelumnya).');
    }

    $stmtHapus = $pdo->prepare("DELETE FROM produk WHERE id_produk = :id");
    $stmtHapus->bindValue(':id', $id_produk, PDO::PARAM_INT);
    $stmtHapus->execute();

    $keterangan = "Produk \"{$produk['nama_produk']}\" (ID: {$id_produk}) dihapus";
    $stmtLog = $pdo->prepare(
        "INSERT INTO log_aktivitas (aksi, keterangan) VALUES ('HAPUS', :keterangan)"
    );
    $stmtLog->bindValue(':keterangan', $keterangan, PDO::PARAM_STR);
    $stmtLog->execute();
    $pdo->commit();

    setFlash('sukses', "Produk \"{$produk['nama_produk']}\" berhasil dihapus.");
} catch (Exception $e) {
    $pdo->rollBack();
    setFlash('gagal', 'Gagal menghapus produk: ' . $e->getMessage());
}

header('Location: index.php');
exit;
