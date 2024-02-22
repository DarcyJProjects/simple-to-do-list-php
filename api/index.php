<?php
$databaseFile = $_SERVER['DOCUMENT_ROOT'] . "/database/tasks.txt";
$id = $_GET['id'];

$rawData = explode("|", file($databaseFile)[$id]);
$task = $rawData[0];
$status = $rawData[1];
$description = str_replace("\\n", "\n", $rawData[2]);
$duedate = $rawData[3];
$category = $rawData[4];

$data = array('id' => $id, 'name' => $task, 'completed' => $status, 'description' => $description, 'duedate' => $duedate, 'category' => $category);
$json_data = json_encode($data, JSON_PRETTY_PRINT);

$tempJSON = "task" . $id . ".json";
$json_data = str_replace("\/", "/", $json_data);
file_put_contents($tempJSON, $json_data);

header('Content-Description: File Transfer');
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename="' . basename($tempJSON) . '"');
header('Expires: 0');
header('Cache-Control: must-revalidate');
header('Pragma: public');
header('Content-Length: ' . filesize($tempJSON));
readfile($tempJSON);
unlink($tempJSON);
die();
?>