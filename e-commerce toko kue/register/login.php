<?php
session_start();
require "../connection.php";

$pesanubahpassword = '';
if (isset($_SESSION['ubah_password_success'])) {
    $pesanubahpassword = $_SESSION['ubah_password_success']; // Use $pesanubahpassword here
    unset($_SESSION['ubah_password_success']); // Hapus pesan dari sesi setelah ditampilkan
}

$signUpMessage = '';
if (isset($_SESSION['sign_up_success'])) {
    $signUpMessage = $_SESSION['sign_up_success'];
    unset($_SESSION['sign_up_success']); // Hapus pesan dari sesi setelah ditampilkan
}



if (isset($_POST['login-btn']) && isset($_POST['no_hp']) && isset($_POST['password'])) {
    $no_hp = htmlspecialchars($_POST['no_hp']);
    $password = $_POST['password'];

    // Using prepared statements to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM customer WHERE no_hp = ?");
    $stmt->bind_param("s", $no_hp);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();

    if ($data) {
        // Verifying hashed password
        if (password_verify($password, $data['password'])) {
            // Login berhasil
            $_SESSION['login'] = true; // Set login status
            $_SESSION['username'] = $data['username']; // Set username jika ada
            $_SESSION['log_in_success'] = "Yeay! Kamu Berhasil Log-In";
            header("Location: ../index.php"); // Redirect ke halaman index.php
            exit;
        } elseif (strlen($password) < 8) {
?>
            <div class="warning animate__animated animate__fadeInDown">
                <div>
                    Password minimal 8 karakter
                </div>
            </div>
            <script src="../style-js.js"></script>
        <?php
        } else {
        ?>
            <div class="warning animate__animated animate__fadeInDown">
                <div class="error-message">Yah! Password salah</div>
            </div>
            <script src="../style-js.js"></script>
        <?php
        }
    } else {
        ?>
        <div class="warning animate__animated animate__fadeInDown">
            <div>Yah! akun tidak ditemukan</div>
        </div>
        <script src="../style-js.js"></script>
<?php
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap"
        rel="stylesheet">
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link
        rel="stylesheet" type="text/css" href="style.css">
    <title>Log-In</title>
    <style>
        input[type="number"]::-webkit-outer-spin-button,
        input[type="number"]::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
    </style>
</head>

<body>
    <?php if ($pesanubahpassword): ?>
        <div class="warning animate__animated animate__fadeInDown">
            <div><?php echo $pesanubahpassword; ?></div>
        </div>
        <script src="../style-js.js"></script>
    <?php endif; ?>
    <?php if ($signUpMessage): ?>
        <div class="warning animate__animated animate__fadeInDown">
            <div><?php echo $signUpMessage; ?></div>
        </div>
        <script src="../style-js.js"></script>
    <?php endif; ?>
    <div class="back">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8" />
        </svg>
        <a href="../index.php">Back Home</a>
    </div>
    <div style="padding: 50px;" class="container">
        <div class="content">
            <h1 class="animate__animated animate__zoomIn">Log-In</h1>
            <form action="" method="POST">
                <div class="field">
                    <label>No HP</label>
                    <input type="number" id="no_hp" name="no_hp" placeholder="Masukkan Nomor HP Anda" required>
                </div>
                <div class="field">
                    <label>Password</label>
                    <input type="password" id="password" name="password" placeholder="Masukkan Password Anda" required>
                </div>
                <a href="fpassword.php">Kamu Lupa Password?</a>
                <button type="submit" name="login-btn">Log-In</button>
            </form>
            <p>Don't have an account? <a href="signup.php">Sign-Up</a></p>
        </div>
    </div>
</body>

</html>