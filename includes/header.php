<?php
require_once __DIR__ . '/init.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Inventaris — Tugas Rutin 8</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <nav class="navbar">
        <h1>📦 Sistem Inventaris</h1>
        <div class="nav-links">
            <a href="index.php">Daftar Produk</a>
            <a href="log_aktivitas.php">Log Aktivitas</a>
        </div>
    </nav>

    <main class="container">
        <?php showFlash(); ?>
