<?php
$databaseFile = $_SERVER['DOCUMENT_ROOT'] . "/database/tasks.txt";

$taskName = $_GET['id'];
$taskTitle = $_GET['task'];
$category = $_GET['cat'];
$duedate = $_GET['duedate'];
$description = str_replace("\n", "\\n", $_GET['desc']);
$darkmode = $_GET['darkmode'] ?? 'false';

$rawData = file($databaseFile);

if ($rawData != NULL) {
    $tasks = explode("|", $rawData[$taskName])[0];
    $tasksStatus = explode("|", $rawData[$taskName])[1];

    $rawData[$taskName] = $taskTitle . "|" . $tasksStatus . "|" . $description . "|" . $duedate . "|" . $category . "|\n";


    $taskFile = fopen($databaseFile, "w");
    foreach ($rawData as $rawLine) {
        fwrite($taskFile, $rawLine);
    }

    fclose($taskFile);
}

header("Location: view_task.php?id=" . $taskName . "&darkmode=" . $darkmode);
die();
?>