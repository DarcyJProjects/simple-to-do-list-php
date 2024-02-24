<?php
$databaseFile = $_SERVER['DOCUMENT_ROOT'] . "/database/tasks.txt";
$archiveFile = $_SERVER['DOCUMENT_ROOT'] . "/database/archive.txt";

$taskName = $_GET['id'];
$darkmode = $_GET['darkmode'] ?? 'false';
$archive = $_GET['archive'] ?? 'false';

if ($archive == "delete") {
    $databaseFile = $archiveFile;
}

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

if ($archive == "true") {
    header("Location: ./view_archive.php?darkmode=" . $darkmode);
} else {
    header("Location: ../index.php?darkmode=" . $darkmode);
}

die();
?>