<?php
$conn = new mysqli("localhost", "root", "", "simulator_penjualan");
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $conn->query("DELETE FROM penjualan WHERE id=$id");
}
header("Location: admin_db_penjualan.php");
exit();
?>
