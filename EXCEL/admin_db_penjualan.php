<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}
// Koneksi database
$host = "localhost";
$user = "root";
$pass = "";
$db   = "simulator_penjualan";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Proses form input
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $tanggal            = $_POST['tanggal'];
    $id_transaksi       = $_POST['id_transaksi'];
    $nama_produk        = $_POST['nama_produk'];
    $kategori           = $_POST['kategori'];
    $harga_satuan       = $_POST['harga_satuan'];
    $jumlah             = $_POST['jumlah'];
    $total              = $harga_satuan * $jumlah;
    $metode_pembayaran  = $_POST['metode_pembayaran'];
    $status             = $_POST['status'];

    $stmt = $conn->prepare("INSERT INTO penjualan (tanggal, id_transaksi, nama_produk, kategori, harga_satuan, jumlah, total, metode_pembayaran, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssiiiss", $tanggal, $id_transaksi, $nama_produk, $kategori, $harga_satuan, $jumlah, $total, $metode_pembayaran, $status);
    $stmt->execute();
}

// Ambil semua data
$result = $conn->query("SELECT * FROM penjualan ORDER BY id DESC");
$data_penjualan = $result->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Admin Penjualan</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
    </style>
</head>
<body class="bg-gray-100">

<!-- 🌐 Navbar -->
<nav class="bg-white shadow sticky top-0 z-50">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex justify-between items-center h-16">
      <div class="text-blue-600 text-xl font-bold flex items-center gap-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-6h13m-7 0a4 4 0 00-8 0v4m4 4H5.41a1 1 0 01-.71-1.71l7-7a1 1 0 011.42 0l7 7a1 1 0 01-.71 1.71H15z" />
        </svg>
        Admin Panel
      </div>
      <div class="flex space-x-2 mb-4">
    <a href="export_excel.php" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded transition">Export Excel</a>
    <a href="export_word.php" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded transition">Export Word</a>
    <a href="logout.php" class="text-red-600 hover:underline ml-auto">Logout</a>

</div>
      <div class="space-x-4 hidden md:flex">
        <a href="index.php" class="text-gray-700 hover:text-blue-600 font-medium transition">🏠 Home</a>
        <a href="admin_db_penjualan.php" class="text-gray-700 hover:text-blue-600 font-medium transition">🛠️ Admin</a>
      </div>
    </div>
  </div>
</nav>

<!-- 👨‍💼 Form Input & Tabel -->
<div class="max-w-6xl mx-auto p-6">
    <!-- Form -->
    <div class="bg-white p-6 rounded-lg shadow mb-8">
        <h2 class="text-2xl font-semibold text-gray-800 mb-4">Tambah Data Penjualan</h2>
        <form method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <input type="date" name="tanggal" class="p-2 border rounded" required>
            <input type="text" name="id_transaksi" placeholder="ID Transaksi" class="p-2 border rounded" required>
            <input type="text" name="nama_produk" placeholder="Nama Produk" class="p-2 border rounded" required>
            <input type="text" name="kategori" placeholder="Kategori" class="p-2 border rounded" required>
            <input type="number" name="harga_satuan" placeholder="Harga Satuan" class="p-2 border rounded" required>
            <input type="number" name="jumlah" placeholder="Jumlah" class="p-2 border rounded" required>
            <input type="text" name="metode_pembayaran" placeholder="Metode Pembayaran" class="p-2 border rounded" required>
            <select name="status" class="p-2 border rounded" required>
                <option value="Sukses">Sukses</option>
                <option value="Pending">Pending</option>
                <option value="Gagal">Gagal</option>
            </select>
            <button type="submit" class="col-span-1 md:col-span-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold p-2 rounded transition">
                Simpan Data
            </button>
        </form>
    </div>

    <!-- Tabel Data -->
    <div class="bg-white p-6 rounded-lg shadow">
        <h2 class="text-2xl font-semibold text-gray-800 mb-4">Riwayat Transaksi</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm bg-white border border-gray-200 rounded-lg shadow">
                <thead class="bg-gray-100 text-gray-700">
                    <th class="px-6 py-3 text-left">Aksi</th>
                    <tr>
                        <th class="border p-2">No</th>
                        <th class="border p-2">ID Transaksi</th>
                        <th class="border p-2">Tanggal</th>
                        <th class="border p-2">Nama Produk</th>
                        <th class="border p-2">Kategori</th>
                        <th class="border p-2">Harga</th>
                        <th class="border p-2">Jumlah</th>
                        <th class="border p-2">Total</th>
                        <th class="border p-2">Metode</th>
                        <th class="border p-2">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data_penjualan as $row): ?>
                        <tr class="hover:bg-blue-50 transition duration-150 ease-in-out">
                            <td class="border p-2 text-center"><?= htmlspecialchars($row['no']) ?></td>
                            <td class="border p-2"><?= htmlspecialchars($row['id_transaksi']) ?></td>
                            <td class="border p-2"><?= htmlspecialchars($row['tanggal']) ?></td>
                            <td class="border p-2"><?= htmlspecialchars($row['nama_produk']) ?></td>
                            <td class="border p-2"><?= htmlspecialchars($row['kategori']) ?></td>
                            <td class="border p-2 text-right">Rp <?= number_format($row['harga_satuan'], 0, ',', '.') ?></td>
                            <td class="border p-2 text-center"><?= $row['jumlah'] ?></td>
                            <td class="border p-2 text-right font-semibold text-blue-700">Rp <?= number_format($row['total'], 0, ',', '.') ?></td>
                            <td class="border p-2"><?= $row['metode_pembayaran'] ?></td>
                            <td class="border p-2 text-center">
                                <span class="px-2 py-1 rounded-full text-xs 
                                    <?= $row['status'] === 'Sukses' ? 'bg-green-100 text-green-800' : 
                                       ($row['status'] === 'Pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') ?>">
                                    <?= $row['status'] ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 space-x-1">
    <a href="edit.php?id=<?= $row['id'] ?>" class="bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1 rounded text-sm">Edit</a>
    <a href="delete.php?id=<?= $row['id'] ?>" onclick="return confirm('Yakin ingin menghapus data ini?')" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm">Hapus</a>
</td>
                        </tr>
                    <?php endforeach; ?>
                    <?php if (count($data_penjualan) === 0): ?>
                        <tr><td colspan="10" class="text-center p-4 text-gray-500">Belum ada data</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>
