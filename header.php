<?php require_once __DIR__.'/auth.php'; require_login(); ?>
<!doctype html><html lang="ko"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Admin Lab</title><link rel="stylesheet" href="style.css"></head>
<body><div class="layout"><aside class="side"><h1>ADMIN LAB</h1>
<a href="index.php">대시보드</a><a href="posts.php">콘텐츠 관리</a><a href="post_form.php">콘텐츠 생성</a><a href="videos.php">동영상 업로드</a>
<?php if((current_user()['role'] ?? '') === 'admin'):?><a href="users.php">권한 관리</a><?php endif;?>
<a href="logout.php">로그아웃</a></aside><main class="main"><div class="top"><strong><?=e(current_user()['name'] ?? '게스트')?></strong> <span class="tag"><?=e(current_user()['role'] ?? 'guest')?></span></div>