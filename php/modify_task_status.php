<?php
$databaseFile = $_SERVER['DOCUMENT_ROOT'] . "/database/tasks.txt";

$taskName = $_GET['id'];
$viewing = $_GET['viewing'];

$rawData = file($databaseFile);

if ($rawData != NULL) {
    $tasks = explode("|", $rawData[$taskName])[0];
    $tasksStatus = explode("|", $rawData[$taskName])[1];
    $description = explode("|", $rawData[$taskName])[2];
    $duedate = explode("|", $rawData[$taskName])[3];
    $category = explode("|", $rawData[$taskName])[4];

    if ($tasksStatus == "0") {
        $rawData[$taskName] = $tasks . "|1|" . $description . "|" . $duedate . "|" . $category . "|\n";
    } else {
        $rawData[$taskName] = $tasks . "|0|" . $description . "|" . $duedate . "|" . $category . "|\n";
    }

    $taskFile = fopen($databaseFile, "w");
    foreach ($rawData as $rawLine) {
        fwrite($taskFile, $rawLine);
    }

    fclose($taskFile);
}

if ($viewing != NULL) {
    header("Location: view_task.php?id=" . $taskName);
} else {
    header("Location: ../index.php");
}   

die();
?>