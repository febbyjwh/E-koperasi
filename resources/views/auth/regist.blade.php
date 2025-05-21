<!DOCTYPE html>
<html>
<head>
    <title>Halaman Registrasi</title>
</head>
<body>
    <h2>Form Registrasi</h2>
    <form action="register.php" method="POST">
        <label for="username">Username:</label><br>
        <input type="text" name="username" required><br><br>

        <label for="password">Password:</label><br>
        <input type="password" name="password" required><br><br>

        <button type="submit" name="register">Daftar</button>
    </form>

    <?php
    // Proses registrasi
    if (isset($_POST['register'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Enkripsi password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Simulasi penyimpanan (seharusnya ke database)
        echo "<p>Registrasi berhasil!</p>";
        echo "<p>Username: $username</p>";
        echo "<p>Password terenkripsi: $hashedPassword</p>";

        // Di dunia nyata, gunakan kode berikut untuk menyimpan ke database:
        // 1. Koneksi ke DB
        // 2. Query INSERT
    }
    ?>
</body>
</html>
