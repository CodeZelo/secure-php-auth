<?php
require_once "database.php";
/**
 * Register new user
 */
function auth_register(array $data): bool|string
{
    // Check email uniqueness
    $stmt = db()->prepare("SELECT id FROM users WHERE email = :email");
    $stmt->execute(['email' => $data['email']]);

    if ($stmt->fetch()) {
        return "Email already registered!";
    }

    $hashed = password_hash($data['password'], PASSWORD_DEFAULT);

    $stmt = db()->prepare(
        "INSERT INTO users (name, email, password, gender)
         VALUES (:name, :email, :password, :gender)"
    );

    $stmt->execute([
        'name'     => $data['name'],
        'email'    => $data['email'],
        'password' => $hashed,
        'gender'   => $data['gender'],
    ]);

    return true;
}


/**
 * Attempt login with email OR username
 */
function auth_attempt(string $login, string $password): bool
{
    $isEmail = filter_var($login, FILTER_VALIDATE_EMAIL);

    $stmt = db()->prepare(
        $isEmail
            ? "SELECT * FROM users WHERE email = :value LIMIT 1"
            : "SELECT * FROM users WHERE name = :value LIMIT 1"
    );

    $stmt->execute(['value' => $login]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user'] = [
            'id' => $user['id'],
            'name' => $user['name'],
            'email' => $user['email'],
            'gender' => $user['gender'],
        ];

        session_regenerate_id(true);

        return true;
    }

    return false;
}

/**
 * Check if user is logged in
 */
function auth_check(): bool
{
    return isset($_SESSION['user']);
}

/**
 * Get logged user
 */
function auth_user(): ?array
{
    return $_SESSION['user'] ?? null;
}

/**
 * Logout user
 */
function auth_logout(): void
{
    $_SESSION = [];

    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(
            session_name(),
            '',
            time() - 42000,
            $params["path"],
            $params["domain"],
            $params["secure"],
            $params["httpOnly"]
        );
    }

    session_destroy();
}


/**
 * Protect page from guests
 */
function auth_require_login(string $redirect = 'login.php'): void
{
    if (!auth_check()) {
        header("Location: $redirect");
        exit;
    }
}

/**
 * Redirect logged user away from guest pages
 */
function auth_redirect_if_logged(string $redirect = 'dashboard.php'): void
{
    if (auth_check()) {
        header("Location: $redirect");
        exit;
    }
}
