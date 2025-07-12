<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "simulator_penjualan";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=penjualan_" . date("Y-m-d") . ".xls");

echo "<table border='1'>";
echo "<tr>
        <th>No</th><th>ID Transaksi</th><th>Tanggal</th><th>Nama Produk</th>
        <th>Kategori</th><th>Harga</th><th>Jumlah</th><th>Total</th>
        <th>Metode Pembayaran</th><th>Status</th>
      </tr>";

$result = $conn->query("SELECT * FROM penjualan ORDER BY id DESC");
while ($row = $result->fetch_assoc()) {
    echo "<tr>
        <td>{$row['no']}</td>
        <td>{$row['id_transaksi']}</td>
        <td>{$row['tanggal']}</td>
        <td>{$row['nama_produk']}</td>
        <td>{$row['kategori']}</td>
        <td>{$row['harga_satuan']}</td>
        <td>{$row['jumlah']}</td>
        <td>{$row['total']}</td>
        <td>{$row['metode_pembayaran']}</td>
        <td>{$row['status']}</td>
    </tr>";
}
echo "</table>";
?>
