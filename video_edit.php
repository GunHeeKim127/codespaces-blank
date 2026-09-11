<?php

require 'header.php';

$id = $_GET['id'] ?? 0;

$sql = "SELECT * FROM videos WHERE id=$id";

$video = $pdo->query($sql)->fetch();

if (!$video) {

    http_response_code(404);

    exit('동영상을 찾을 수 없습니다.');
}


/* =========================
   수정
========================= */

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $title = $_POST['title'] ?? '';
    $url = $_POST['url'] ?? '';

    /*
     * 링크 수정
     */

    if ($url !== '') {

        $sql = "
            UPDATE videos
            SET
                title='$title',
                filename='$url',
                original_name='$url'
            WHERE id=$id
        ";

    } else {

        /*
         * 파일 업로드 항목을 비워두면
         * 기존 파일을 유지
         */

        $sql = "
            UPDATE videos
            SET
                title='$title'
            WHERE id=$id
        ";
    }

    $pdo->exec($sql);

    header('Location: videos.php');

    exit;
}

?>

<h2>동영상 수정</h2>

<div class="card">

<form method="post">

<label>제목</label>

<input
    type="text"
    name="title"
    value="<?= $video['title'] ?>"
    required
>


<label>동영상 링크</label>

<input
    type="text"
    name="url"
    value="<?= $video['filename'] ?>"
    placeholder="링크를 변경하려면 입력"
>


<p class="muted">

현재 파일 / 링크:

<a
    href="<?= $video['filename'] ?>"
    target="_blank"
>
    <?= $video['original_name'] ?>
</a>

</p>


<button>
    수정
</button>

<a
    class="btn gray"
    href="videos.php"
>
    취소
</a>

</form>

</div>

<?php require 'footer.php'; ?>