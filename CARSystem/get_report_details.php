<?php
require 'config.php';

header('Content-Type: application/json');

if (!isset($_GET['case_id'])) {
    echo json_encode(['error' => 'Case ID not provided']);
    exit;
}

$case_id = $_GET['case_id'];

try {
    // Get report details
    $stmt = $pdo->prepare("SELECT * FROM reports WHERE case_id = ?");
    $stmt->execute([$case_id]);
    $report = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$report) {
        echo json_encode(['error' => 'Report not found']);
        exit;
    }

    // Get associated media
    $stmt = $pdo->prepare("SELECT * FROM media_evidence WHERE case_id = ?");
    $stmt->execute([$case_id]);
    $media = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Prepare media URLs (we'll create view_media.php next)
    foreach ($media as &$item) {
        $item['view_url'] = "view_media.php?id=" . $item['id'];
    }

    echo json_encode([
        'report' => $report,
        'media' => $media,
        'media_count' => count($media)
    ]);
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>