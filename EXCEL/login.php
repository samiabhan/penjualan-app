<?php
session_start();
$conn = new mysqli("localhost", "root", "", "simulator_penjualan");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = $_POST['username'];
    $pass = md5($_POST['password']); // gunakan hashing MD5 (untuk latihan, di produksi gunakan bcrypt)

    $query = $conn->query("SELECT * FROM admin WHERE username='$user' AND password='$pass'");
    if ($query->num_rows > 0) {
        $_SESSION['admin'] = $user;
        header("Location: admin_db_penjualan.php");
        exit();
    } else {
        $error = "Username atau Password salah!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="flex justify-center items-center min-h-screen">
        <div class="bg-white p-8 rounded shadow-lg w-full max-w-sm">
            <h2 class="text-2xl font-bold mb-6 text-center">Login Admin</h2>
            <?php if (isset($error)): ?>
                <div class="bg-red-100 text-red-700 px-4 py-2 rounded mb-4"><?= $error ?></div>
            <?php endif; ?>
            <form method="POST" class="space-y-4">
                <input type="text" name="username" placeholder="Username" class="w-full p-2 border rounded" required>
                <input type="password" name="password" placeholder="Password" class="w-full p-2 border rounded" required>
                <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">Login</button>
            </form>
        </div>
    </div>
</body>
</html>
