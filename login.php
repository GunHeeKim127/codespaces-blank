<?php
require 'auth.php';
if(current_user()){header('Location:index.php');exit;}
$error='';
if($_SERVER['REQUEST_METHOD']==='POST' && !login_user($_POST['username']??'',$_POST['password']??'')) $error='아이디 또는 비밀번호가 올바르지 않습니다.';
elseif($_SERVER['REQUEST_METHOD']==='POST'){header('Location:index.php');exit;}
?>
<!doctype html><html lang="ko"><head><meta charset="utf-8"><title>Admin Lab Login</title><link rel="stylesheet" href="style.css"></head>
<body class="login"><div class="card"><h2>관리자 로그인</h2><p class="muted">화이트해커 실습용 더미 사이트</p>
<?php if($error):?><div class="error"><?=e($error)?></div><?php endif;?>
<form method="post"><label>아이디</label><input name="username" required><label>비밀번호</label><input type="password" name="password" required><button>로그인</button></form>
<hr><small>admin / admin123<br>editor / editor123<br>viewer / viewer123</small></div></body></html>
