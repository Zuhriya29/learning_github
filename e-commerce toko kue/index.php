<?php
require "session.php";

$LogInMessage = '';
if (isset($_SESSION['log_in_success'])) {
    $LogInMessage = $_SESSION['log_in_success'];
    unset($_SESSION['log_in_success']); // Hapus pesan dari sesi setelah ditampilkan
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
    <link
        rel="stylesheet" type="text/css" href="style.css">
    <title>Home</title>
</head>

<body>
    <?php if ($LogInMessage): ?>
        <div class="wadah">
            <div class="warning animate__animated animate__fadeInDown">
                <div><?php echo $LogInMessage; ?></div>
            </div>
            <script src="style-js.js"></script>
        </div>
    <?php endif; ?>
    <h1>Hello <?php echo $_SESSION['username'] ?></h1>
</body>

</html>