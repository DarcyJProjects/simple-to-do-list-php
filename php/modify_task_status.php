<?php
$databaseFile = $_SERVER['DOCUMENT_ROOT'] . "/database/tasks.txt";
$configFile = $_SERVER['DOCUMENT_ROOT'] . "/database/config.txt";
$config = file($configFile);

$taskName = $_GET['id'];
$viewing = $_GET['viewing'];
$darkmode = $_GET['darkmode'] ?? 'false';

$timezone = $config[1];
date_default_timezone_set($timezone);

$rawData = file($databaseFile);

if ($rawData != NULL) {
    $tasks = explode("|", $rawData[$taskName])[0];
    $tasksStatus = explode("|", $rawData[$taskName])[1];
    $description = explode("|", $rawData[$taskName])[2];
    $duedate = explode("|", $rawData[$taskName])[3];
    $category = explode("|", $rawData[$taskName])[4];
    $created = explode("|", $rawData[$taskName])[5];
    $lastModified = date("d/m/Y h:i a");


    if ($tasksStatus == "0") {
        $rawData[$taskName] = $tasks . "|1|" . $description . "|" . $duedate . "|" . $category . "|" . $created . "|" . $lastModified . "|\n";
    } else {
        $rawData[$taskName] = $tasks . "|0|" . $description . "|" . $duedate . "|" . $category . "|" . $created . "|" . $lastModified . "|\n";
    }

    $taskFile = fopen($databaseFile, "w");
    foreach ($rawData as $rawLine) {
        fwrite($taskFile, $rawLine);
    }

    fclose($taskFile);
}

if ($viewing != NULL) {
    header("Location: view_task.php?id=" . $taskName . "&darkmode=" . $darkmode);
} else {
    header("Location: ../index.php" . "?darkmode=" . $darkmode);
}   

die();
?>