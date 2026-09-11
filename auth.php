<?php
require_once __DIR__.'/config.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function current_user(){
    return $_SESSION['user'] ?? null;
}

function e($v){
    return htmlspecialchars($v, ENT_QUOTES, 'UTF-8');
}

function login_user($username, $password){
    global $pdo;

    $sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $u = $pdo->query($sql)->fetch();

    if($u){
        $_SESSION['user'] = $u;
        return true;
    }

    return false;
}

function require_login(){
    if (!isset($_SESSION['user'])) {
        header('Location: login.php');
        exit;
    }
}

function require_role($roles){
    require_login();

    $roles = (array)$roles;

    if (!in_array($_SESSION['user']['role'], $roles, true)) {
        http_response_code(403);
        exit('403 Forbidden');
    }
}