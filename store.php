<?php
require 'includes/init.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: create.php');
    exit;
}

$pdo = Database::getInstance()->getConnection();
$nama_produk = trim($_POST['nama_produk'] ?? '');
$id_kategori = (int) ($_POST['id_kategori'] ?? 0);
$id_supplier = (int) ($_POST['id_supplier'] ?? 0);
$stok        = (int) ($_POST['stok'] ?? 0);
$harga       = (float) ($_POST['harga'] ?? 0);
$satuan      = trim($_POST['satuan'] ?? '');

if ($nama_produk === '' || $id_kategori === 0 || $id_supplier === 0 || $satuan === '') {
    setFlash('gagal', 'Semua field wajib diisi.');
    header('Location: create.php');
    exit;
}

try {
    $sql = "INSERT INTO produk (nama_produk, id_kategori, id_supplier, stok, harga, satuan)
            VALUES (:nama_produk, :id_kategori, :id_supplier, :stok, :harga, :satuan)";

    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':nama_produk', $nama_produk, PDO::PARAM_STR);
    $stmt->bindValue(':id_kategori', $id_kategori, PDO::PARAM_INT);
    $stmt->bindValue(':id_supplier', $id_supplier, PDO::PARAM_INT);
    $stmt->bindValue(':stok', $stok, PDO::PARAM_INT);
    $stmt->bindValue(':harga', $harga);
    $stmt->bindValue(':satuan', $satuan, PDO::PARAM_STR);
    $stmt->execute();

    setFlash('sukses', "Produk \"{$nama_produk}\" berhasil ditambahkan.");
} catch (PDOException $e) {
    setFlash('gagal', 'Gagal menyimpan produk: ' . $e->getMessage());
}

header('Location: index.php');
exit;
