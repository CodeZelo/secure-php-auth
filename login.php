<?php
session_start();

require_once "helpers/validation.php";
require_once "helpers/csrf.php";
require_once "helpers/auth.php";

auth_redirect_if_logged();

$errors = [];

if (isset($_POST['login'])) {

    if (!csrf_verify()) {
        $errors[] = "Invalid CSRF token.";
    }

    $data = [
        "login" => $_POST['login'] ?? '',
        "password" => $_POST['password'] ?? '',
    ];

    $rules = [
        "login" => ["required"],
        "password" => ["required"]
    ];

    $errors = array_merge($errors, validate($rules, $data));

    if (empty($errors)) {
        if (auth_attempt($data['login'], $data['password'])) {
            header("Location: dashboard.php");
            exit;
        }
        $errors[] = "Invalid credentials.";
    }
}
?>


<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Auth System (Login)</title>
    <link rel="stylesheet" href="assets/style.css" />
</head>

<body>
    <?php require_once "layouts/navbar.php"; ?>

    <div class="page-container">

        <!-- Form -->
        <form class="authForm" method="POST">
            <?php if ($errors): ?>
                <ul class="errors">
                    <?php foreach ($errors as $fieldErrors): ?>
                        <?php foreach ($fieldErrors as $error): ?>
                            <li><?= $error ?></li>
                        <?php endforeach; ?>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>


            <h2>Login Form</h2>

            <?= csrf_input() ?>

            <input type="text" name="login" placeholder="Email or Username" required />
            <input type="password" name="password" placeholder="Your Password" required />

            <button type="submit">Login</button>
        </form>
    </div>
    <script src="assets/main.js"></script>
</body>

</html>