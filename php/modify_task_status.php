<?php
$databaseFile = $_SERVER['DOCUMENT_ROOT'] . "/database/tasks.txt";

$taskName = $_GET['taskName'];

$rawData = file($databaseFile);

if ($rawData != NULL) {
    $tasks = explode("|", $rawData[$taskName])[0];
    $tasksStatus = explode("|", $rawData[$taskName])[1];

    if ($tasksStatus == "0") {
        $rawData[$taskName] = $tasks . "|1\n";
    } else {
        $rawData[$taskName] = $tasks . "|0\n";
    }

    $taskFile = fopen($databaseFile, "w");
    foreach ($rawData as $rawLine) {
        fwrite($taskFile, $rawLine);
    }

    fclose($taskFile);
}

header("Location: ../index.php");
die();
?>