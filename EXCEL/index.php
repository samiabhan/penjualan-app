<?php
// Koneksi database
$host = "localhost";
$user = "root";
$pass = "";
$db   = "simulator_penjualan";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$result = $conn->query("SELECT * FROM penjualan ORDER BY id DESC");
$data_penjualan = $result->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Penjualan - Halaman Utama</title>
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
        Penjualan App
      </div>
      <div class="space-x-4 hidden md:flex">
        <a href="index.php" class="text-gray-700 hover:text-blue-600 font-medium transition">🏠 Home</a>
     <a href="login.php" class="text-gray-700 hover:text-blue-600 font-medium transition">🛠️ Admin</a>

      </div>
    </div>
  </div>
</nav>

<!-- 🧾 Konten Utama -->
<div class="max-w-7xl mx-auto p-6">
    <div class="bg-white p-6 rounded-lg shadow">
        <h1 class="text-3xl font-bold text-gray-800 mb-2">Data Penjualan</h1>
        <p class="text-gray-600 mb-6">Berikut adalah daftar transaksi penjualan terbaru yang tercatat dalam sistem.</p>

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm bg-white border border-gray-200 rounded-lg shadow">
                <thead class="bg-gray-100 text-gray-700">
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
                        </tr>
                    <?php endforeach; ?>
                    <?php if (count($data_penjualan) === 0): ?>
                        <tr><td colspan="10" class="text-center p-4 text-gray-500">Tidak ada data penjualan</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>
