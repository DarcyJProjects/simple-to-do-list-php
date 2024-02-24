<?php
$databaseFile = $_SERVER['DOCUMENT_ROOT'] . "/database/tasks.txt";
$categoryFile = $_SERVER['DOCUMENT_ROOT'] . "/database/categories.txt";
$configFile = $_SERVER['DOCUMENT_ROOT'] . "/database/config.txt";
$config = file($configFile);

$timezone = $config[1];
date_default_timezone_set($timezone);

$category = $_GET['cat'];
$taskName = $_GET['id'];

$rawData = file($categoryFile);

if ($rawData != NULL) {
    unset($rawData[$category]);
    $rawData = array_values($rawData);
    
    $categoriesFileToWrite = fopen($categoryFile, "w");
    foreach ($rawData as $rawLine) {
        fwrite($categoriesFileToWrite, $rawLine);
    }

    fclose($categoriesFileToWrite);
}

$rawData2 = file($databaseFile);
if ($rawData2 != NULL) {
    //update task
    $exploded = explode("|", $rawData2[$taskName]);
    $taskTitle = $exploded[0];
    $tasksStatus = $exploded[1];
    $description = $exploded[2];
    $duedate = $exploded[3];
    $category = "Not Set";
    $created = $exploded[5] ?? "Unknown";
    $lastModified = date("d/m/Y h:i a");

    $rawData2[$taskName] = str_replace("\n", "Not Set",($taskTitle . "|" . $tasksStatus . "|")) . $description . str_replace("\n", "Not Set", "|" . $duedate . "|" . $category . "|" . $created . "|". $lastModified) . "|\n";

    $taskFile = fopen($databaseFile, "w");
    foreach ($rawData2 as $rawLine) {
        fwrite($taskFile, $rawLine);
    }

    fclose($taskFile);
}

echo "<script>window.close();</script>";
die();
?>

