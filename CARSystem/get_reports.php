<?php
require 'config.php';

header('Content-Type: application/json');

try {
    $stmt = $pdo->query("
        SELECT r.*, COUNT(m.id) as media_count 
        FROM reports r
        LEFT JOIN media_evidence m ON r.case_id = m.case_id
        GROUP BY r.id
        ORDER BY r.created_at DESC
    ");
    $reports = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode($reports);
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>
