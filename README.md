# Secure PHP Authentication System (Native PHP)

A professional-grade, modular User Authentication System built from scratch using Native PHP and MySQL. This project demonstrates clean coding practices, secure session management, and protection against common web vulnerabilities.

[Video Tutorial](https://youtu.be/R-Hs_qfc8Zw)
[Article Tutorial](https://codezelo.com/en/categories/projects/secure-php-auth/)

## Screenshots

![Light Register Page Screenshot](/screenshots/light-register.png "Light Register Page Screenshot")

![Dark Register Page Screenshot](/screenshots/dark-register.png "Dark Register Page Screenshot")

![Login Page Screenshot](/screenshots/login.png "Login Page Screenshot")

![Login with validation form Screenshot](/screenshots/login-wirh-validation.png "Login with validation form Screenshot")

![Dashboard Page Screenshot](/screenshots/dynamic-dashboard.png "Dashboard Page Screenshot")

## 🚀 Features

- **Secure Registration:** Validates user inputs (email, password strength, matching confirmation) before persisting to the database.
- **Dual-Login Support:** Users can log in using either their **Username** or **Email**.
- **Advanced Security:**
  - **Password Hashing:** Uses PHP's `password_hash()` with `PASSWORD_DEFAULT` (Bcrypt).
  - **CSRF Protection:** Custom-built token system to prevent Cross-Site Request Forgery.
  - **SQL Injection Prevention:** Fully utilizes PDO with **Prepared Statements**.
  - **XSS Protection:** Implements `htmlspecialchars()` on all dynamic outputs.
  - **Session Security:** Implements `session_regenerate_id()` to prevent Session Hijacking.
- **Modular Helper Architecture:** Logic is separated into dedicated helper files (`auth.php`, `validation.php`, `csrf.php`).
- **Dynamic UI:** Navbar and content adapt based on the user's authentication state.
- **UX Focused:** Preserves "Old Input" data if a form submission fails.

## 🛠️ Tech Stack

- **Backend:** PHP 8.x (Native)
- **Database:** MySQL (PDO)
- **Frontend:** HTML5, CSS3 (Custom styles)

## 📁 Project Structure

```text
├── assets/             # CSS and JS files
├── helpers/            # Core logic files
│   ├── auth.php        # Auth lifecycle (Register, Login, Logout)
│   ├── csrf.php        # Security token management
│   ├── validation.php  # Reusable validation engine
├── layouts/            # Reusable UI components (Navbar)
├── database.php        # PDO Connection (Singleton-like pattern)
├── index.php           # Registration Page
├── login.php           # Login Page
├── dashboard.php       # Protected User Area
└── logout.php          # Secure Session Termination

```

## ⚙️ Installation & Setup

1. **Clone the repository:**

```bash
git clone https://github.com/CodeZelo/secure-php-auth.git
```

2. **Database Setup:**

- Create a database named `authsystem`.
- Run the following SQL command to create the users table:

```sql
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    email VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    gender ENUM('male', 'female') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

```

3. **Configure Database:**

- Open `database.php` and update your database credentials (`host`, `dbname`, `user`, `pass`).

4. **Run the project:**

- Move the project to your local server (XAMPP/WAMP htdocs).
- Open `http://localhost/your-folder-name/index.php` or `http://your-folder-name.test`.

## 🔒 Security Best Practices Implemented

- **Validation Engine:** A custom-built, extensible rule-based validator.
- **Access Control:** `auth_require_login()` and `auth_redirect_if_logged()` middleware-like functions to guard routes.
- **CSRF Protection:** Tokens are generated and stored in the session, then verified against every POST request.
- **Secure Logout:** Wipes the `$_SESSION` array, destroys the session, and clears session cookies for a 100% secure exit.

## 📄 License

This project is open-source and available under the [MIT License](https://www.google.com/search?q=LICENSE).
