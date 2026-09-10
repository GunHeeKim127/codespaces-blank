<?php require 'header.php';require_role(['admin','editor']);
$id=(int)($_GET['id']??0);$p=['title'=>'','content'=>''];
if($id){$s=$pdo->prepare('SELECT * FROM posts WHERE id=?');$s->execute([$id]);$p=$s->fetch()?:$p;}
if($_SERVER['REQUEST_METHOD']==='POST'){
$t=$_POST['title']??'';$c=$_POST['content']??'';
if($id){$s=$pdo->prepare('UPDATE posts SET title=?,content=? WHERE id=?');$s->execute([$t,$c,$id]);}
else{$s=$pdo->prepare('INSERT INTO posts(title,content,author_id) VALUES(?,?,?)');$s->execute([$t,$c,current_user()['id']]);}
header('Location:posts.php');exit;}
?>
<div class="card"><h2><?=$id?'콘텐츠 수정':'콘텐츠 생성'?></h2><form method="post"><label>제목</label><input name="title" value="<?=e($p['title'])?>" required><label>내용</label><textarea name="content" required><?=e($p['content'])?></textarea><button>저장</button> <a class="btn gray" href="posts.php">취소</a></form></div><?php require 'footer.php';?>
