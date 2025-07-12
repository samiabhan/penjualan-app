<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}
$filename = 'admin_db_penjualan.php';

// Jika form disubmit, simpan ke file CSV
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        $_POST['no'],
        $_POST['id_transaksi'],
        $_POST['tanggal'],
        $_POST['nama_produk'],
        $_POST['kategori'],
        $_POST['harga'],
        $_POST['jumlah'],
        $_POST['total'],
        $_POST['metode'],
        $_POST['status']
    ];

    $file = fopen($filename, 'a');
    fputcsv($file, $data);
    fclose($file);
}

// Ambil semua data yang sudah disimpan
$data_penjualan = [];
if (file_exists($filename)) {
    $file = fopen($filename, 'r');
    while (($row = fgetcsv($file)) !== FALSE) {
        $data_penjualan[] = $row;
    }
    fclose($file);
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Admin Penjualan - Buat Data Excel</title>
    <link href="https://cdn.tailwindcss.com" rel="stylesheet">
</head>
<body class="bg-gray-100 p-6">
    <div class="max-w-4xl mx-auto bg-white p-6 rounded shadow">
        <h1 class="text-2xl font-bold mb-4 text-gray-800">Tambah Data Penjualan</h1>
        <form action="" method="POST" class="grid grid-cols-2 gap-4">
            <input type="text" name="no" placeholder="No" class="p-2 border rounded" required>
            <input type="text" name="id_transaksi" placeholder="ID Transaksi" class="p-2 border rounded" required>
            <input type="date" name="tanggal" class="p-2 border rounded" required>
            <input type="text" name="nama_produk" placeholder="Nama Produk" class="p-2 border rounded" required>
            <input type="text" name="kategori" placeholder="Kategori" class="p-2 border rounded" required>
            <input type="number" name="harga" placeholder="Harga Satuan" class="p-2 border rounded" required>
            <input type="number" name="jumlah" placeholder="Jumlah" class="p-2 border rounded" required>
            <input type="number" name="total" placeholder="Total" class="p-2 border rounded" required>
            <select name="metode" class="p-2 border rounded" required>
                <option value="">Pilih Metode</option>
                <option value="Transfer Bank">Transfer Bank</option>
                <option value="Kartu Kredit">Kartu Kredit</option>
                <option value="COD">COD</option>
                <option value="E-Wallet">E-Wallet</option>
            </select>
            <select name="status" class="p-2 border rounded" required>
                <option value="">Pilih Status</option>
                <option value="Sukses">Sukses</option>
                <option value="Pending">Pending</option>
                <option value="Gagal">Gagal</option>
            </select>
            <div class="col-span-2">
                <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">Simpan ke Excel</button>
            </div>
        </form>
    </div>

    <div class="max-w-6xl mx-auto mt-8 bg-white p-6 rounded shadow">
        <h2 class="text-xl font-bold mb-4">Data Penjualan</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm border-collapse border border-gray-300">
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
                        <tr class="hover:bg-gray-50">
                            <?php foreach ($row as $cell): ?>
                                <td class="border p-2"><?php echo htmlspecialchars($cell); ?></td>
                            <?php endforeach; ?>
                        </tr>
                    <?php endforeach; ?>
                    <?php if (count($data_penjualan) === 0): ?>
                        <tr><td colspan="10" class="text-center p-4 text-gray-500">Belum ada data</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
