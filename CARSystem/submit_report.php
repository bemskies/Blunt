<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Text data
    $case_id = 'CASE-' . uniqid();
    $child_name = $_POST['child_name'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $incident_date = $_POST['incident_date'];
    $location = $_POST['location'];
    $description = $_POST['description'];
    $reporter_name = $_POST['reporter_name'];
    $reporter_contact = $_POST['reporter_contact'];

    // Insert report
    $stmt = $pdo->prepare("INSERT INTO reports (case_id, child_name, age, gender, incident_date, location, description, reporter_name, reporter_contact) 
                          VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$case_id, $child_name, $age, $gender, $incident_date, $location, $description, $reporter_name, $reporter_contact]);

    // Handle media uploads
    if (!empty($_FILES['media']['name'][0])) {
        foreach ($_FILES['media']['tmp_name'] as $key => $tmp_name) {
            $file_name = $_FILES['media']['name'][$key];
            $file_type = $_FILES['media']['type'][$key];
            $file_data = file_get_contents($tmp_name);

            // Determine type
            if (strpos($file_type, 'image') !== false) {
                $type = 'image';
            } elseif (strpos($file_type, 'video') !== false) {
                $type = 'video';
            } else {
                $type = 'audio';
            }

            $stmt = $pdo->prepare("INSERT INTO media_evidence (case_id, file_type, file_data, file_name) 
                                  VALUES (?, ?, ?, ?)");
            $stmt->execute([$case_id, $type, $file_data, $file_name]);
        }
    }

    echo json_encode(['success' => true, 'case_id' => $case_id]);
}
?>
