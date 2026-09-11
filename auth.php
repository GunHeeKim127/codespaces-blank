<?php
session_start();
require_once __DIR__.'/config.php';

function current_user(){ return $_SESSION['user'] ?? null; }
function e($v){ return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8'); }

function login_user($username,$password){
 global $pdo;
 $s=$pdo->prepare('SELECT * FROM users WHERE username=?');
 $s->execute([$username]);
 $u=$s->fetch();
 if($u && $password === $u['password']){
  $_SESSION['user']=['id'=>$u['id'],'username'=>$u['username'],'name'=>$u['name'],'role'=>$u['role']];
  return true;
 }
 return false;
}
function require_login(){
//  if(!current_user()){ header('Location: login.php'); exit; }
}
function require_role($roles){
 require_login();
//  if(!in_array(current_user()['role'],(array)$roles,true)){ http_response_code(403); exit('403 Forbidden'); }
}
