<?php
require 'includes/init.php';

$pdo = Database::getInstance()->getConnection();
$search = isset($_GET['search']) ? trim($_GET['search']) : '';

$sql = "SELECT p.nama_produk, k.nama_kategori, s.nama_supplier, p.stok, p.harga, p.satuan
        FROM produk p
        JOIN kategori k ON p.id_kategori = k.id_kategori
        JOIN supplier s ON p.id_supplier = s.id_supplier
        WHERE p.nama_produk LIKE :search
        ORDER BY p.id_produk ASC";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':search', "%{$search}%", PDO::PARAM_STR);
$stmt->execute();
$data = $stmt->fetchAll();

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=laporan_inventaris_' . date('Y-m-d') . '.csv');

$output = fopen('php://output', 'w');

fputcsv($output, ['Nama Produk', 'Kategori', 'Supplier', 'Stok', 'Harga', 'Satuan']);

foreach ($data as $row) {
    fputcsv($output, [
        $row['nama_produk'],
        $row['nama_kategori'],
        $row['nama_supplier'],
        $row['stok'],
        $row['harga'],
        $row['satuan'],
    ]);
}

fclose($output);
exit;
