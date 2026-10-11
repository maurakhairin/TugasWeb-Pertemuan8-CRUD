<?php
require 'includes/header.php';

$pdo = Database::getInstance()->getConnection();
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$dataPerHalaman = 5;
$halamanSekarang = isset($_GET['halaman']) ? (int) $_GET['halaman'] : 1;
if ($halamanSekarang < 1) {
    $halamanSekarang = 1;
}
$offset = ($halamanSekarang - 1) * $dataPerHalaman;

$sqlTotal = "SELECT COUNT(*) AS total FROM produk WHERE nama_produk LIKE :search";
$stmtTotal = $pdo->prepare($sqlTotal);
$stmtTotal->bindValue(':search', "%{$search}%", PDO::PARAM_STR);
$stmtTotal->execute();
$totalData = (int) $stmtTotal->fetch()['total'];
$totalHalaman = (int) ceil($totalData / $dataPerHalaman);
$sql = "SELECT p.id_produk, p.nama_produk, k.nama_kategori, s.nama_supplier,
               p.stok, p.harga, p.satuan
        FROM produk p
        JOIN kategori k ON p.id_kategori = k.id_kategori
        JOIN supplier s ON p.id_supplier = s.id_supplier
        WHERE p.nama_produk LIKE :search
        ORDER BY p.id_produk DESC
        LIMIT :limit OFFSET :offset";

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':search', "%{$search}%", PDO::PARAM_STR);
$stmt->bindValue(':limit', $dataPerHalaman, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$daftarProduk = $stmt->fetchAll();
?>

<div class="page-actions">
    <a href="create.php" class="btn btn-primary">+ Tambah Produk</a>
    <a href="export.php<?= $search !== '' ? '?search=' . urlencode($search) : '' ?>" class="btn btn-secondary">⬇ Export Laporan (CSV)</a>
</div>

<form method="GET" action="index.php" class="search-form">
    <input type="text" name="search" placeholder="Cari nama produk..." value="<?= htmlspecialchars($search) ?>">
    <button type="submit" class="btn btn-secondary">Cari</button>
    <?php if ($search !== ''): ?>
        <a href="index.php" class="btn btn-link">Reset</a>
    <?php endif; ?>
</form>

<table class="data-table">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Produk</th>
            <th>Kategori</th>
            <th>Supplier</th>
            <th>Stok</th>
            <th>Harga</th>
            <th>Satuan</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php if (empty($daftarProduk)): ?>
            <tr>
                <td colspan="8" class="empty-state">
                    <?= $search !== '' ? 'Tidak ada produk yang cocok dengan pencarian.' : 'Belum ada data produk.' ?>
                </td>
            </tr>
        <?php else: ?>
            <?php $no = $offset + 1; ?>
            <?php foreach ($daftarProduk as $produk): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= htmlspecialchars($produk['nama_produk']) ?></td>
                    <td><?= htmlspecialchars($produk['nama_kategori']) ?></td>
                    <td><?= htmlspecialchars($produk['nama_supplier']) ?></td>
                    <td><?= htmlspecialchars((string) $produk['stok']) ?></td>
                    <td>Rp <?= number_format((float) $produk['harga'], 0, ',', '.') ?></td>
                    <td><?= htmlspecialchars($produk['satuan']) ?></td>
                    <td class="aksi">
                        <a href="edit.php?id=<?= (int) $produk['id_produk'] ?>" class="btn btn-edit">Edit</a>
                        <form method="POST" action="delete.php"
                              onsubmit="return confirm('Yakin ingin menghapus produk ini? Data yang sudah dihapus tidak bisa dikembalikan.');">
                            <input type="hidden" name="id_produk" value="<?= (int) $produk['id_produk'] ?>">
                            <button type="submit" class="btn btn-delete">Hapus</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>

<?php if ($totalHalaman > 1): ?>
    <div class="pagination">
        <?php for ($i = 1; $i <= $totalHalaman; $i++): ?>
            <a href="index.php?halaman=<?= $i ?><?= $search !== '' ? '&search=' . urlencode($search) : '' ?>"
               class="<?= $i === $halamanSekarang ? 'active' : '' ?>"><?= $i ?></a>
        <?php endfor; ?>
    </div>
<?php endif; ?>

<?php require 'includes/footer.php'; ?>
