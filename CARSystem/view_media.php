<?php
require 'config.php';

if (!isset($_GET['id'])) {
    header("HTTP/1.0 404 Not Found");
    exit;
}

try {
    $stmt = $pdo->prepare("SELECT file_type, file_data FROM media_evidence WHERE id = ?");
    $stmt->execute([$_GET['id']]);
    $media = $stmt->fetch();

    if (!$media) {
        header("HTTP/1.0 404 Not Found");
        exit;
    }

    // Set appropriate headers
    switch ($media['file_type']) {
        case 'image':
            header("Content-Type: image/jpeg");
            break;
        case 'video':
            header("Content-Type: video/mp4");
            break;
        case 'audio':
            header("Content-Type: audio/mpeg");
            break;
    }

    echo $media['file_data'];
} catch (PDOException $e) {
    header("HTTP/1.0 500 Internal Server Error");
    echo "Error retrieving media: " . $e->getMessage();
}
?>