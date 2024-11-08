<?php
session_start();
require "../connection.php"; // Pastikan ini sudah menggunakan titik koma

if (isset($_POST['signup-btn'])) {
    // Sanitasi input
    $username = htmlspecialchars($_POST['username']);
    $no_hp = htmlspecialchars($_POST['no_hp']);
    $password = $_POST['password'];
    $verified_password = $_POST['verified-password'];

    // Periksa apakah no_hp sudah ada di database
    $stmt = $conn->prepare("SELECT COUNT(*) FROM customer WHERE no_hp = ?");
    $stmt->bind_param("s", $no_hp);
    $stmt->execute();
    $stmt->bind_result($no_hp_count);
    $stmt->fetch();
    $stmt->close();

    // Jika username sudah ada, tampilkan pesan error
    if ($no_hp_count > 0) {
?>
        <div class="warning animate__animated animate__fadeInDown">
            <div>
                Kamu sudah memiliki akun loh!
            </div>
            <script src="../style-js.js"></script>
        </div>
    <?php
    } elseif ($password != $verified_password) {
    ?>
        <div class="warning animate__animated animate__fadeInDown">
            <div>
                Password yang anda masukkan tidak sama
            </div>
        </div>
        <script src="../style-js.js"></script>
<?php
    } elseif (strlen($password) < 8 && strlen($verified_password) < 8) {
        ?>
        <div class="warning animate__animated animate__fadeInDown">
            <div>
                Password minimal 8 karakter
            </div>
        </div>
        <script src="../style-js.js"></script>
        <?php
    }
    
    else {
        // Hash password sebelum menyimpan
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Menggunakan prepared statement untuk menyimpan data
        $stmt = $conn->prepare("INSERT INTO customer (username, no_hp, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $no_hp, $hashed_password);

        // Eksekusi dan cek hasilnya
        if ($stmt->execute()) {
            $_SESSION['sign_up_success'] = "Yeay! Kamu Berhasil Sign-Up";
            header("Location: login.php"); // Redirect ke halaman login
            exit;
        } else {
            echo "Gagal Sign Up: " . $stmt->error;
        }

        // Menutup prepared statement

        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Sign-Up</title>
    <style>
        /* Untuk Chrome, Safari, Edge, dan Opera */
        input[type="number"]::-webkit-outer-spin-button,
        input[type="number"]::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
    </style>
</head>

<body>
    <div style="margin-top: 20px;" class="back">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8" />
        </svg>
        <a href="login.php">Back Log-In</a>
    </div>
    <div style="margin-top: 10px;" class="container">
        <div class="content">
            <h1 class="animate__animated animate__zoomIn">Sign-Up</h1>
            <form action="" method="POST">
                <div class="field">
                    <label>Username</label>
                    <input type="text" id="username" name="username" placeholder="Masukkan Username Anda" required>
                </div>
                <div class="field">
                    <label>Nomor HP</label>
                    <input type="number" id="no_hp" name="no_hp" placeholder="Masukkan Nomor HP Anda" required>
                </div>
                <div class="field">
                    <label>Password</label>
                    <input type="password" id="password" name="password" placeholder="Masukkan Password Anda" required>
                </div>
                <div class="field">
                    <label>Verifikasi Password</label>
                    <input type="password" id="verified-password" name="verified-password" placeholder="Verifikasi Password" required>
                </div>
                <button href="login.php" type="submit" name="signup-btn">Sign-Up</button>
            </form>
        </div>
    </div>
</body>

</html>