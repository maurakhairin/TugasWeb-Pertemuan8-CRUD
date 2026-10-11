CREATE DATABASE IF NOT EXISTS inventaris_db;
USE inventaris_db;
CREATE TABLE IF NOT EXISTS kategori (
    id_kategori INT AUTO_INCREMENT PRIMARY KEY,
    nama_kategori VARCHAR(50) NOT NULL
);

CREATE TABLE IF NOT EXISTS supplier (
    id_supplier INT AUTO_INCREMENT PRIMARY KEY,
    nama_supplier VARCHAR(100) NOT NULL,
    kontak VARCHAR(50),
    alamat VARCHAR(150)
);

CREATE TABLE IF NOT EXISTS produk (
    id_produk INT AUTO_INCREMENT PRIMARY KEY,
    nama_produk VARCHAR(100) NOT NULL,
    id_kategori INT NOT NULL,
    id_supplier INT NOT NULL,
    stok INT NOT NULL DEFAULT 0,
    harga DECIMAL(12,2) NOT NULL DEFAULT 0,
    satuan VARCHAR(20) NOT NULL DEFAULT 'pcs',
    FOREIGN KEY (id_kategori) REFERENCES kategori(id_kategori),
    FOREIGN KEY (id_supplier) REFERENCES supplier(id_supplier)
);

CREATE TABLE IF NOT EXISTS log_aktivitas (
    id_log INT AUTO_INCREMENT PRIMARY KEY,
    aksi VARCHAR(20) NOT NULL,
    keterangan VARCHAR(255) NOT NULL,
    waktu DATETIME DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO kategori (nama_kategori) VALUES
('Elektronik'),
('Alat Tulis'),
('Makanan & Minuman'),
('Perlengkapan Kantor'),
('Kebersihan');

INSERT INTO supplier (nama_supplier, kontak, alamat) VALUES
('PT Sumber Makmur', '0811-2233-4455', 'Jl. Merdeka No. 10, Medan'),
('CV Berkah Jaya', '0822-3344-5566', 'Jl. Sisingamangaraja No. 25, Medan'),
('Toko Aneka Grosir', '0833-4455-6677', 'Jl. Gatot Subroto No. 7, Medan'),
('UD Mitra Sejahtera', '0844-5566-7788', 'Jl. Ringroad No. 12, Medan'),
('PT Cahaya Abadi', '0855-6677-8899', 'Jl. Krakatau No. 3, Medan');

INSERT INTO produk (nama_produk, id_kategori, id_supplier, stok, harga, satuan) VALUES
('Keyboard USB', 1, 1, 25, 85000, 'pcs'),
('Mouse Wireless', 1, 1, 30, 65000, 'pcs'),
('Pulpen Pilot', 2, 2, 100, 3500, 'pcs'),
('Buku Tulis 38 Lembar', 2, 4, 150, 4000, 'pcs'),
('Air Mineral 600ml', 3, 3, 200, 3000, 'botol'),
('Kertas HVS A4', 4, 4, 50, 45000, 'rim'),
('Sabun Cuci Tangan', 5, 5, 40, 12000, 'botol');