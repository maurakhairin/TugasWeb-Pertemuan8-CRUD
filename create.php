<?php

require 'includes/header.php';

$pdo = Database::getInstance()->getConnection();
$kategoriList = $pdo->query("SELECT id_kategori, nama_kategori FROM kategori ORDER BY nama_kategori")->fetchAll();
$supplierList = $pdo->query("SELECT id_supplier, nama_supplier FROM supplier ORDER BY nama_supplier")->fetchAll();
?>

<h2>Tambah Produk Baru</h2>

<form method="POST" action="store.php" class="form-produk">

    <label for="nama_produk">Nama Produk</label>
    <input type="text" id="nama_produk" name="nama_produk" required autofocus>

    <label for="id_kategori">Kategori</label>
    <select id="id_kategori" name="id_kategori" required>
        <option value="">-- Pilih Kategori --</option>
        <?php foreach ($kategoriList as $kategori): ?>
            <option value="<?= (int) $kategori['id_kategori'] ?>">
                <?= htmlspecialchars($kategori['nama_kategori']) ?>
            </option>
        <?php endforeach; ?>
    </select>

    <label for="id_supplier">Supplier</label>
    <select id="id_supplier" name="id_supplier" required>
        <option value="">-- Pilih Supplier --</option>
        <?php foreach ($supplierList as $supplier): ?>
            <option value="<?= (int) $supplier['id_supplier'] ?>">
                <?= htmlspecialchars($supplier['nama_supplier']) ?>
            </option>
        <?php endforeach; ?>
    </select>

    <label for="stok">Stok</label>
    <input type="number" id="stok" name="stok" min="0" value="0" required>

    <label for="harga">Harga (Rp)</label>
    <input type="number" id="harga" name="harga" min="0" step="0.01" value="0" required>

    <label for="satuan">Satuan</label>
    <input type="text" id="satuan" name="satuan" placeholder="contoh: pcs, box, kg, rim" required>

    <div class="form-actions">
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="index.php" class="btn btn-link">Batal</a>
    </div>
</form>

<?php require 'includes/footer.php'; ?>
