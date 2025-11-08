<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $case_id = $_POST['case_id'];
    
    try {
        $pdo->beginTransaction();
        
        // Delete media first
        $stmt = $pdo->prepare("DELETE FROM media_evidence WHERE case_id = ?");
        $stmt->execute([$case_id]);
        
        // Then delete report
        $stmt = $pdo->prepare("DELETE FROM reports WHERE case_id = ?");
        $stmt->execute([$case_id]);
        
        $pdo->commit();
        echo json_encode(['success' => true]);
    } catch (PDOException $e) {
        $pdo->rollBack();
        echo json_encode(['error' => $e->getMessage()]);
    }
}
?>