<?php require 'header.php';
$u=$pdo->query('SELECT COUNT(*) c FROM users')->fetch()['c'];
$p=$pdo->query('SELECT COUNT(*) c FROM posts')->fetch()['c'];
$v=$pdo->query('SELECT COUNT(*) c FROM videos')->fetch()['c'];
?>
<h2>관리자 대시보드</h2><p class="muted">웹 취약점 점검용 관리자 시스템</p>
<div class="grid"><div class="card">사용자<div class="stat"><?=$u?></div></div><div class="card">콘텐츠<div class="stat"><?=$p?></div></div><div class="card">동영상<div class="stat"><?=$v?></div></div></div>
<div class="card"><h3>실습 흐름</h3><ol><li>로그인/세션 확인</li><li>권한별 메뉴 확인</li><li>게시판 CRUD 확인</li><li>업로드 검증 확인</li><li>입력값/권한/세션 보안 점검</li></ol></div>
<?php require 'footer.php';?>
