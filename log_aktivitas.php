<?php
require 'includes/header.php';

$pdo = Database::getInstance()->getConnection();

$logs = $pdo->query("SELECT * FROM log_aktivitas ORDER BY waktu DESC")->fetchAll();
?>

<h2>Log Aktivitas</h2>
<p class="subtitle">Riwayat penghapusan produk — tercatat otomatis lewat transaction setiap kali ada data yang dihapus.</p>

<table class="data-table">
    <thead>
        <tr>
            <th>No</th>
            <th>Aksi</th>
            <th>Keterangan</th>
            <th>Waktu</th>
        </tr>
    </thead>
    <tbody>
        <?php if (empty($logs)): ?>
            <tr>
                <td colspan="4" class="empty-state">Belum ada aktivitas yang tercatat.</td>
            </tr>
        <?php else: ?>
            <?php foreach ($logs as $i => $log): ?>
                <tr>
                    <td><?= $i + 1 ?></td>
                    <td><span class="badge badge-<?= htmlspecialchars(strtolower($log['aksi'])) ?>"><?= htmlspecialchars($log['aksi']) ?></span></td>
                    <td><?= htmlspecialchars($log['keterangan']) ?></td>
                    <td><?= htmlspecialchars($log['waktu']) ?></td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>

<p><a href="index.php" class="btn btn-link">&larr; Kembali ke Daftar Produk</a></p>

<?php require 'includes/footer.php'; ?>
