<?php
$databaseFile = $_SERVER['DOCUMENT_ROOT'] . "/database/tasks.txt";
$archiveFile = $_SERVER['DOCUMENT_ROOT'] . "/database/archive.txt";
$configFile = $_SERVER['DOCUMENT_ROOT'] . "/database/config.txt";
$config = file($configFile);

$timezone = $config[1];
date_default_timezone_set($timezone);

$taskName = $_GET['id'];
$darkmode = $_GET['darkmode'] ?? 'false';
$mode = $_GET['mode'] ?? 'normal';

if ($mode == "unarchive") {
    $temp = $databaseFile;
    $databaseFile = $archiveFile;
    $archiveFile = $temp;
}

$rawData = explode("|", file($databaseFile)[$taskName]);
$task = $rawData[0] ?? "Not Set";
$status = $rawData[1] ?? 0;
$description = str_replace("\\n", "<br>", $rawData[2] ?? "Not Set");
$duedate = $rawData[3] ?? "Not Set";
$category = $rawData[4] ?? "Not Set";
$created = $rawData[5] ?? "Unknown";
$lastModified = date("d-m-Y h:i a");

$rawData = file($databaseFile);

if ($rawData != NULL) {
    $archiveRecord = str_replace("\n", "Not Set",($task . "|" . $status . "|")) . $description . str_replace("\n", "Not Set", "|" . $duedate . "|" . $category . "|" . $created . "|". $lastModified) . "|\n";

    $archive = fopen($archiveFile, "a");
    fwrite($archive, $archiveRecord);

    fclose($archive);

    if ($mode == "unarchive") {
        header("Location: delete_task.php?id=" . $taskName . "&darkmode=" . $darkmode . "&archive=delete");
    } else {
        header("Location: delete_task.php?id=" . $taskName . "&darkmode=" . $darkmode . "&archive=true");
    }
    die();
}

die();
?>