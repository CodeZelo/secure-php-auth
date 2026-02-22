<?php
session_start();
require_once "helpers/auth.php";

auth_require_login();

$user = auth_user();
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Auth System (Dashboard)</title>
    <link rel="stylesheet" href="assets/style.css" />
</head>

<body>
    <?php include "layouts/navbar.php"; ?>

    <div class="page-container">
        <div class="main-dashboard">
            <h2>Welcome, <?= htmlspecialchars($user['name']) ?>!</h2>
            <p>Your email: <?= htmlspecialchars($user['email']) ?></p>
            <p>Your gender: <?= htmlspecialchars($user['gender']) ?></p>
        </div>
    </div>
    <script src="assets/main.js"></script>
</body>

</html>