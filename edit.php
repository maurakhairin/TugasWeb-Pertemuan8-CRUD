<?php

require_once 'includes/init.php';

$pdo = Database::getInstance()->getConnection();
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

$stmt = $pdo->prepare(
    "SELECT * FROM produk WHERE id_produk = :id"
);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$stmt->execute();

$produk = $stmt->fetch();

if (!$produk) {
    setFlash('gagal', 'Produk tidak ditemukan.');
    header('Location: index.php');
    exit;
}

$kategoriList = $pdo->query(
    "SELECT id_kategori, nama_kategori
     FROM kategori
     ORDER BY nama_kategori"
)->fetchAll();

$supplierList = $pdo->query(
    "SELECT id_supplier, nama_supplier
     FROM supplier
     ORDER BY nama_supplier"
)->fetchAll();

require_once 'includes/header.php';
?>

<h2>Edit Produk</h2>

<form method="POST" action="update.php" class="form-produk">

    <input
        type="hidden"
        name="id_produk"
        value="<?= (int) $produk['id_produk'] ?>"
    >

    <label for="nama_produk">Nama Produk</label>
    <input
        type="text"
        id="nama_produk"
        name="nama_produk"
        value="<?= htmlspecialchars($produk['nama_produk']) ?>"
        required
        autofocus
    >

    <label for="id_kategori">Kategori</label>
    <select id="id_kategori" name="id_kategori" required>
        <?php foreach ($kategoriList as $kategori): ?>
            <option
                value="<?= (int) $kategori['id_kategori'] ?>"
                <?= ((int) $kategori['id_kategori'] === (int) $produk['id_kategori']) ? 'selected' : '' ?>
            >
                <?= htmlspecialchars($kategori['nama_kategori']) ?>
            </option>
        <?php endforeach; ?>
    </select>

    <label for="id_supplier">Supplier</label>
    <select id="id_supplier" name="id_supplier" required>
        <?php foreach ($supplierList as $supplier): ?>
            <option
                value="<?= (int) $supplier['id_supplier'] ?>"
                <?= ((int) $supplier['id_supplier'] === (int) $produk['id_supplier']) ? 'selected' : '' ?>
            >
                <?= htmlspecialchars($supplier['nama_supplier']) ?>
            </option>
        <?php endforeach; ?>
    </select>

    <label for="stok">Stok</label>
    <input
        type="number"
        id="stok"
        name="stok"
        min="0"
        value="<?= (int) $produk['stok'] ?>"
        required
    >

    <label for="harga">Harga (Rp)</label>
    <input
        type="number"
        id="harga"
        name="harga"
        min="0"
        step="0.01"
        value="<?= htmlspecialchars((string) $produk['harga']) ?>"
        required
    >

    <label for="satuan">Satuan</label>
    <input
        type="text"
        id="satuan"
        name="satuan"
        value="<?= htmlspecialchars($produk['satuan']) ?>"
        required
    >

    <div class="form-actions">
        <button type="submit" class="btn btn-primary">
            Update
        </button>

        <a href="index.php" class="btn btn-link">
            Batal
        </a>
    </div>

</form>

<?php require_once 'includes/footer.php'; ?>
