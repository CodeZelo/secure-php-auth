<?php
session_start();
require_once "helpers/auth.php";

auth_logout();
header("Location: login.php");
exit;
