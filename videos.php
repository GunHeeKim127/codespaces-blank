<?php
require 'header.php';
$msg = '';
$uploadDir = __DIR__ . '/uploads/';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}
/* =========================
   링크 등록
========================= */
if (
    $_SERVER['REQUEST_METHOD'] === 'POST'
    && ($_POST['type'] ?? '') === 'link'
) {
    $title = $_POST['title'] ?? '';
    $url = $_POST['url'] ?? '';
    if ($title && $url) {
        $sql = "
            INSERT INTO videos
            (title, filename, original_name, uploader_id)
            VALUES
            (
                '$title',
                '$url',
                '$url',
                " . current_user()['id'] . "
            )
        ";
        $pdo->exec($sql);
        $msg = '동영상 링크 등록 완료';
    }
}
/* =========================
   파일 / 폴더 업로드
========================= */
if (
    $_SERVER['REQUEST_METHOD'] === 'POST'
    && ($_POST['type'] ?? '') === 'file'
    && isset($_FILES['videos'])
) {
    $title = $_POST['title'] ?? '';
    $files = $_FILES['videos'];
    $count = count($files['name']);
    $uploaded = 0;
    for ($i = 0; $i < $count; $i++) {
        if ($files['error'][$i] !== UPLOAD_ERR_OK) {
            continue;
        }
        $originalName = $files['name'][$i];
        $savePath = $uploadDir . $originalName;
        $saveDir = dirname($savePath);
        if (!is_dir($saveDir)) {
            mkdir($saveDir, 0777, true);
        }
        if (
            move_uploaded_file(
                $files['tmp_name'][$i],
                $savePath
            )
        ) {
            $storedPath = 'uploads/' . $originalName;
            $sql = "
                INSERT INTO videos
                (title, filename, original_name, uploader_id)
                VALUES
                (
                    '$title',
                    '$storedPath',
                    '$originalName',
                    " . current_user()['id'] . "
                )
            ";
            $pdo->exec($sql);
            $uploaded++;
        }
    }
    $msg = $uploaded . '개 파일 업로드 완료';
}
/* =========================
   목록
========================= */
$rows = $pdo
    ->query("
        SELECT v.*, u.name uploader
        FROM videos v
        JOIN users u
        ON v.uploader_id = u.id
        ORDER BY v.id DESC
    ")
    ->fetchAll();
?>
<h2>동영상 관리</h2>
<!-- 링크 등록 -->
<div class="card">
<h3>동영상 링크 등록</h3>
<form method="post">
<input
    type="hidden"
    name="type"
    value="link"
>
<label>제목</label>
<input
    type="text"
    name="title"
    placeholder="동영상 제목"
    required
>
<label>동영상 링크</label>
<input
    type="text"
    name="url"
    placeholder="https://example.com/video.mp4"
    required
>
<button>
    링크 등록
</button>
</form>
</div>
<!-- 파일 / 폴더 업로드 -->
<div class="card">
<h3>동영상 파일 / 폴더 업로드</h3>
<form
    method="post"
    enctype="multipart/form-data"
>
<input
    type="hidden"
    name="type"
    value="file"
>
<label>제목</label>
<input
    type="text"
    name="title"
    placeholder="업로드 제목"
    required
>
<label>파일 선택</label>
<input
    type="file"
    name="videos[]"
    multiple
    accept="videos/*"
>
<label>폴더 선택</label>
<input
    type="file"
    name="videos[]"
    webkitdirectory
    directory
    multiple
>
<button>
    파일 / 폴더 업로드
</button>
</form>
</div>

<?php if ($msg): ?>
<div class="card">
<p class="tag">
    <?= $msg ?>
</p>
</div>
<?php endif; ?>

<!-- 목록 -->
<div class="card">
<h3>등록된 동영상</h3>
<table>
<tr>
    <th>ID</th>
    <th>제목</th>
    <th>파일 / 링크</th>
    <th>등록자</th>
    <th>일시</th>
    <th>관리</th>
</tr>
<?php foreach ($rows as $r): ?>
<tr>
<td>
    <?= $r['id'] ?>
</td>
<td>
    <?= $r['title'] ?>
</td>
<td>
<a
    href="<?= $r['filename'] ?>"
    target="_blank"
>
    <?= $r['original_name'] ?>
</a>
</td>
<td>
    <?= $r['uploader'] ?>
</td>
<td>
    <?= $r['created_at'] ?>
</td>
<td>
<a
    class="btn gray"
    href="video_edit.php?id=<?= $r['id'] ?>"
>
    수정
</a>
<a
    class="btn danger"
    href="video_delete.php?id=<?= $r['id'] ?>"
    onclick="return confirm('정말 삭제할까요?')"
>
    삭제
</a>
</td>
</tr>
<?php endforeach; ?>
</table>
</div>

<?php require 'footer.php'; ?>