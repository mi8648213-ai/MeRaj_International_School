<?php
session_start();
require 'config.php';
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    if ($name && filter_var($email, FILTER_VALIDATE_EMAIL) && strlen($password) >= 10) {
        $stmt = db()->prepare("INSERT INTO admins(name,email,password_hash) VALUES(?,?,?)");
        $stmt->execute([$name,$email,password_hash($password,PASSWORD_DEFAULT)]);
        $message = 'Admin created successfully. DELETE setup_admin.php from the server now.';
    } else {
        $message = 'Enter a name, valid email and password of at least 10 characters.';
    }
}
?><!doctype html><html><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Create Admin</title><link rel="stylesheet" href="assets/css/style.css"></head><body class="center"><form class="card auth" method="post"><img src="assets/images/school-logo.png" class="auth-logo"><h1>Create Admin</h1><p><?=e($message)?></p><input name="name" placeholder="Full name" required><input type="email" name="email" placeholder="Email" required><input type="password" name="password" placeholder="Password (10+ characters)" required><button class="btn" type="submit">Create Admin</button></form></body></html>