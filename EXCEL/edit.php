<?php
$conn = new mysqli("localhost", "root", "", "simulator_penjualan");

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $data = $conn->query("SELECT * FROM penjualan WHERE id=$id")->fetch_assoc();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = $_POST['id'];
    $nama_produk = $_POST['nama_produk'];
    $kategori = $_POST['kategori'];
    $harga_satuan = $_POST['harga_satuan'];
    $jumlah = $_POST['jumlah'];
    $metode_pembayaran = $_POST['metode_pembayaran'];
    $status = $_POST['status'];
    $total = $harga_satuan * $jumlah;

    $conn->query("UPDATE penjualan SET 
        nama_produk='$nama_produk',
        kategori='$kategori',
        harga_satuan='$harga_satuan',
        jumlah='$jumlah',
        total='$total',
        metode_pembayaran='$metode_pembayaran',
        status='$status'
        WHERE id=$id
    ");

    header("Location: admin_db_penjualan.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Data</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8">
    <div class="max-w-xl mx-auto bg-white p-6 rounded shadow">
        <h2 class="text-xl font-semibold mb-4">Edit Transaksi</h2>
        <form method="POST" class="space-y-4">
            <input type="hidden" name="id" value="<?= $data['id'] ?>">
            <input type="text" name="nama_produk" value="<?= $data['nama_produk'] ?>" class="w-full p-2 border rounded" required>
            <input type="text" name="kategori" value="<?= $data['kategori'] ?>" class="w-full p-2 border rounded" required>
            <input type="number" name="harga_satuan" value="<?= $data['harga_satuan'] ?>" class="w-full p-2 border rounded" required>
            <input type="number" name="jumlah" value="<?= $data['jumlah'] ?>" class="w-full p-2 border rounded" required>
            <input type="text" name="metode_pembayaran" value="<?= $data['metode_pembayaran'] ?>" class="w-full p-2 border rounded" required>
            <select name="status" class="w-full p-2 border rounded">
                <option value="Sukses" <?= $data['status'] == 'Sukses' ? 'selected' : '' ?>>Sukses</option>
                <option value="Pending" <?= $data['status'] == 'Pending' ? 'selected' : '' ?>>Pending</option>
                <option value="Gagal" <?= $data['status'] == 'Gagal' ? 'selected' : '' ?>>Gagal</option>
            </select>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Update</button>
        </form>
    </div>
</body>
</html>
