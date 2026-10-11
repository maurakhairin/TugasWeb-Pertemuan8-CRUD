<?php
require 'includes/init.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

$pdo = Database::getInstance()->getConnection();

$id_produk   = (int) ($_POST['id_produk'] ?? 0);
$nama_produk = trim($_POST['nama_produk'] ?? '');
$id_kategori = (int) ($_POST['id_kategori'] ?? 0);
$id_supplier = (int) ($_POST['id_supplier'] ?? 0);
$stok        = (int) ($_POST['stok'] ?? 0);
$harga       = (float) ($_POST['harga'] ?? 0);
$satuan      = trim($_POST['satuan'] ?? '');

if ($id_produk === 0 || $nama_produk === '' || $id_kategori === 0 || $id_supplier === 0 || $satuan === '') {
    setFlash('gagal', 'Data tidak lengkap, produk gagal diupdate.');
    header('Location: index.php');
    exit;
}

try {
    $sql = "UPDATE produk
            SET nama_produk = :nama_produk,
                id_kategori = :id_kategori,
                id_supplier = :id_supplier,
                stok = :stok,
                harga = :harga,
                satuan = :satuan
            WHERE id_produk = :id_produk";

    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':nama_produk', $nama_produk, PDO::PARAM_STR);
    $stmt->bindValue(':id_kategori', $id_kategori, PDO::PARAM_INT);
    $stmt->bindValue(':id_supplier', $id_supplier, PDO::PARAM_INT);
    $stmt->bindValue(':stok', $stok, PDO::PARAM_INT);
    $stmt->bindValue(':harga', $harga);
    $stmt->bindValue(':satuan', $satuan, PDO::PARAM_STR);
    $stmt->bindValue(':id_produk', $id_produk, PDO::PARAM_INT);
    $stmt->execute();

    setFlash('sukses', "Produk \"{$nama_produk}\" berhasil diupdate.");
} catch (PDOException $e) {
    setFlash('gagal', 'Gagal mengupdate produk: ' . $e->getMessage());
}

header('Location: index.php');
exit;
