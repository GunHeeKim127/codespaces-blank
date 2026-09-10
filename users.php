<?php require 'header.php';require_role(['admin']);
if(isset($_POST['id'],$_POST['role']) && in_array($_POST['role'],['admin','editor','viewer'],true)){$s=$pdo->prepare('UPDATE users SET role=? WHERE id=?');$s->execute([$_POST['role'],(int)$_POST['id']]);}
$rows=$pdo->query('SELECT id,username,name,role,created_at FROM users ORDER BY id')->fetchAll();?>
<h2>권한 관리</h2><div class="card"><table><tr><th>ID</th><th>아이디</th><th>이름</th><th>권한</th><th>변경</th></tr>
<?php foreach($rows as $r):?><tr><td><?=$r['id']?></td><td><?=e($r['username'])?></td><td><?=e($r['name'])?></td><td><span class="tag"><?=e($r['role'])?></span></td><td><form method="post"><input type="hidden" name="id" value="<?=$r['id']?>"><select name="role"><option <?= $r['role']=='admin'?'selected':''?>>admin</option><option <?= $r['role']=='editor'?'selected':''?>>editor</option><option <?= $r['role']=='viewer'?'selected':''?>>viewer</option></select><button>적용</button></form></td></tr><?php endforeach;?>
</table></div><?php require 'footer.php';?>
