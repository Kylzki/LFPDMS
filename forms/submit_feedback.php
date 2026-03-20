<?php
// forms/submit_feedback.php

require_once __DIR__ . '/../includes/dbcon.php'; // must provide $conn (PDO)

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  http_response_code(405);
  exit('Method Not Allowed');
}

$name    = trim($_POST['name'] ?? '');
$comment = trim($_POST['comment'] ?? '');

if ($name === '' || $comment === '') {
  header("Location: /lfpdms/feedback.php?error=" . urlencode("Name and comment are required."));
  exit;
}

try {
  // Table: system_feedback
  // Columns: name, comment, feedback_date (auto default or nullable)
$stmt = $conn->prepare("
  INSERT INTO system_feedback (name, comment, feedback_date)
  VALUES (:name, :comment, NOW())
");
$stmt->execute([
  ':name' => $name,
  ':comment' => $comment
]);


  header("Location: /lfpdms/feedback.php?sent=1");
  exit;

} catch (Exception $e) {
  header("Location: /lfpdms/feedback.php?error=" . urlencode("Database error. Check table/columns."));
  exit;
}
