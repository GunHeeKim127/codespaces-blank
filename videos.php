<?php require 'header.php';require_role(['admin','editor']);$msg='';
if($_SERVER['REQUEST_METHOD']==='POST' && isset($_FILES['video'])){
$f=$_FILES['video'];$title=$_POST['title']??'';$dir=__DIR__.'/uploads/';$name=basename($f['name']);$stored=time().'_'.$name;
if($f['error']===UPLOAD_ERR_OK && move_uploaded_file($f['tmp_name'],$dir.$stored)){
$s=$pdo->prepare('INSERT INTO videos(title,filename,original_name,uploader_id) VALUES(?,?,?,?)');$s->execute([$title,$stored,$name,current_user()['id']]);$msg='업로드 완료';
}else $msg='업로드 실패';
}
$rows=$pdo->query('SELECT v.*,u.name uploader FROM videos v JOIN users u ON v.uploader_id=u.id ORDER BY v.id DESC')->fetchAll();?>
<h2>동영상 업로드</h2><div class="card"><p class="muted">실습용으로 파일 검증을 단순화한 업로드 기능</p><?php if($msg):?><p class="tag"><?=e($msg)?></p><?php endif;?>
<form method="post" enctype="multipart/form-data"><label>제목</label><input name="title" required><label>동영상</label><input type="file" name="video" accept="video/*" required><button>업로드</button></form></div>
<div class="card"><table><tr><th>ID</th><th>제목</th><th>파일</th><th>등록자</th><th>일시</th></tr><?php foreach($rows as $r):?><tr><td><?=$r['id']?></td><td><?=e($r['title'])?></td><td><a href="uploads/<?=rawurlencode($r['filename'])?>" target="_blank"><?=e($r['original_name'])?></a></td><td><?=e($r['uploader'])?></td><td><?=$r['created_at']?></td></tr><?php endforeach;?></table></div><?php require 'footer.php';?>
