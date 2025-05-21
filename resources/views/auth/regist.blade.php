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

        <label for="no_telp">No. Telepon:</label><br>
        <input type="text" name="no_telp" required><br><br>

        <label for="jenis_kelamin">Jenis Kelamin:</label><br>
        <input type="radio" name="jenis_kelamin" value="L" required> Laki-laki
        <input type="radio" name="jenis_kelamin" value="P"> Perempuan<br><br>

        <label for="alamat">Alamat:</label><br>
        <textarea name="alamat" rows="3" cols="30" required></textarea><br><br>

        <label for="jabatan">Jabatan:</label><br>
        <select name="jabatan" required>
            <option value="">-- Pilih Jabatan --</option>
            <option value="siswa">Siswa</option>
            <option value="staff">Staff</option>
            <option value="guru">Guru</option>
        </select><br><br>

        <button type="submit" name="register">Daftar</button>
    </form>

    <?php
    // Proses registrasi
    if (isset($_POST['register'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $no_telp = $_POST['no_telp'];
        $jenis_kelamin = $_POST['jenis_kelamin'];
        $alamat = $_POST['alamat'];
        $jabatan = $_POST['jabatan'];

        // Enkripsi password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Simulasi penyimpanan (seharusnya ke database)
        echo "<h3>Registrasi Berhasil!</h3>";
        echo "<p>Username: $username</p>";
        echo "<p>No. Telp: $no_telp</p>";
        echo "<p>Jenis Kelamin: " . ($jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan') . "</p>";
        echo "<p>Alamat: $alamat</p>";
        echo "<p>Jabatan: $jabatan</p>";
        echo "<p>Password terenkripsi: $hashedPassword</p>";
    }
    ?>
</body>
</html>
