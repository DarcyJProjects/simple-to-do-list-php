<?php
header('Content-type: application/json');
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
echo $json_data;
?>