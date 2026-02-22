<?php
session_start();

require_once "helpers/validation.php";
require_once "helpers/csrf.php";
require_once "helpers/auth.php";

$errors = [];
$success = false;

if (isset($_POST['submit'])) {

    if (!csrf_verify()) {
        $errors[] = "Invalid CSRF token.";
    }

    $data = [
        "name" => $_POST['name'] ?? '',
        "email" => $_POST['email'] ?? '',
        "password" => $_POST['password'] ?? '',
        "confirmation_password" => $_POST['confirmation_password'] ?? '',
        "gender" => $_POST['gender'] ?? ''
    ];

    $rules = [
        "name" => ["required", "string", "min:3", "max:50"],
        "email" => ["required", "email", "max:50"],
        "password" => [
            "required",
            "min:6",
            "has_number",
            "has_special",
            "has_upper",
            "has_lower"
        ],
        "confirmation_password" => ["password_confirmation"],
        "gender" => ["required", "in:male,female"]
    ];

    $errors = array_merge($errors, validate($rules, $data));

    if (empty($errors)) {
        $result = auth_register($data);

        if ($result === true) {
            $success = true;
        } else {
            $errors[] = $result;
        }
    }
}

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Auth System (Register)</title>
    <link rel="stylesheet" href="assets/style.css" />
</head>

<body>
    <?php include "layouts/navbar.php"; ?>

    <div class="page-container">
        <!-- Form -->
        <form class="authForm" method="POST">
            <?php if ($success): ?>
                <p style="color:green;">Registration successful! <a href="login.php">Login here</a></p>
            <?php endif; ?>

            <?php if ($errors): ?>
                <ul class="errors">
                    <?php foreach ($errors as $fieldErrors): ?>
                        <?php foreach ($fieldErrors as $error): ?>
                            <li><?= $error ?></li>
                        <?php endforeach; ?>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>


            <h2>Registration Form</h2>

            <?= csrf_input() ?>

            <input type="text" name="name" placeholder="Your Name" value="<?= htmlspecialchars($data['name'] ?? '') ?>">
            <input type="email" name="email" placeholder="Your Email" value="<?= htmlspecialchars($data['email'] ?? '') ?>">
            <input type="password" name="password" placeholder="Your Password">
            <input type="password" name="confirmation_password" placeholder="Repeat Your Password">
            <select name="gender">
                <option value="">Select Gender</option>
                <option value="male" <?= ($data['gender'] ?? '') == 'male' ? 'selected' : '' ?>>Male</option>
                <option value="female" <?= ($data['gender'] ?? '') == 'female' ? 'selected' : '' ?>>Female</option>
            </select>
            <button type="submit" name="submit">Register</button>
        </form>
    </div>
    <script src="assets/main.js"></script>
</body>

</html>