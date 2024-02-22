<?php
$databaseFile = $_SERVER['DOCUMENT_ROOT'] . "/database/tasks.txt";

$taskName = $_GET['id'];

$rawData = file($databaseFile);

if ($rawData != NULL) {
    $tasks = explode("|", $rawData[$taskName])[0];
    unset($rawData[$taskName]);
    $rawData = array_values($rawData);

    $taskFile = fopen($databaseFile, "w");
    foreach ($rawData as $rawLine) {
        fwrite($taskFile, $rawLine);
    }

    fclose($taskFile);
}

header("Location: ../index.php");
die();
?>