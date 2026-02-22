<?php
// $isLoggedIn = isset($_SESSION['user']);
?>

<nav class="navbar">
    <div class="nav-brand">Auth System</div>
    <div class="nav-menu">
        <ul>
            <?php if (!auth_check()): ?>
                <li><a href="index.php">Register</a></li>
                <li><a href="login.php">Login</a></li>
            <?php else: ?>
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="logout.php">Logout</a></li>
            <?php endif; ?>
        </ul>
    </div>
    <button id="themeToggle" class="theme-btn">🌙 Dark</button>
</nav>