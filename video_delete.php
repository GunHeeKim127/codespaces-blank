<?php

require 'auth.php';

$id = $_GET['id'] ?? 0;

$sql = "SELECT * FROM videos WHERE id=$id";

$video = $pdo->query($sql)->fetch();

if ($video) {

    /*
     * 실제 업로드 파일이면 파일도 삭제
     */

    if (
        !empty($video['filename'])
        && strpos($video['filename'], 'uploads/') === 0
    ) {

        $file = __DIR__ . '/' . $video['filename'];

        if (is_file($file)) {
            unlink($file);
        }
    }

    $sql = "DELETE FROM videos WHERE id=$id";

    $pdo->exec($sql);
}

header('Location: videos.php');

exit;