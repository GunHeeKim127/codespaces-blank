<?php require 'header.php';
$q=$_GET['q']??'';
$s=$pdo->prepare("SELECT p.*,u.name author FROM posts p JOIN users u ON p.author_id=u.id WHERE p.title LIKE ? ORDER BY p.id DESC");
$s->execute(["%$q%"]);$rows=$s->fetchAll();
?>
<div class="top"><h2>콘텐츠 관리</h2><a class="btn" href="post_form.php">+ 생성</a></div>
<div class="card"><form><input name="q" value="<?=e($q)?>" placeholder="제목 검색"><button>검색</button></form></div>
<div class="card"><table><tr><th>ID</th><th>제목</th><th>작성자</th><th>작성일</th><th>관리</th></tr>
<?php foreach($rows as $r):?><tr><td><?=$r['id']?></td><td><a href="post.php?id=<?=$r['id']?>"><?=e($r['title'])?></a></td><td><?=e($r['author'])?></td><td><?=$r['created_at']?></td><td><a class="btn gray" href="post_form.php?id=<?=$r['id']?>">수정</a> <a class="btn danger" href="post_delete.php?id=<?=$r['id']?>" onclick="return confirm('삭제할까요?')">삭제</a></td></tr><?php endforeach;?>
</table></div><?php require 'footer.php';?>
