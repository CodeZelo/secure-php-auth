<?php

function db(): PDO
{
    static $con = null;

    if ($con === null) {
        $dsn  = "mysql:host=localhost;dbname=authsystem;charset=utf8mb4";
        $user = "root";
        $pass = "";

        try {
            $con = new PDO($dsn, $user, $pass, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]);
        } catch (PDOException $e) {
            die("Database connection failed.");
        }
    }

    return $con;
}

// $dsn = "mysql:host=localhost;dbname=authsystem;";
// $user = "root";
// $pass = "";

// try {
//     $con = new PDO($dsn, $user, $pass);
//     $con->query("SET NAMES utf8");
//     $con->query("SET CHARACTER SET utf8");
// } catch (PDOException $e) {
//     echo 'failed ' . $e->getMessage();
// }
