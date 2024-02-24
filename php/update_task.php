<?php
$databaseFile = $_SERVER['DOCUMENT_ROOT'] . "/database/tasks.txt";
$categoriesFile = $_SERVER['DOCUMENT_ROOT'] . "/database/categories.txt";
$configFile = $_SERVER['DOCUMENT_ROOT'] . "/database/config.txt";
$config = file($configFile);

$timezone = $config[1];
date_default_timezone_set($timezone);

$taskName = $_GET['id'];
$taskTitle = $_GET['task'];
$category = $_GET['cat'];
$duedate = $_GET['duedate'];
$description = str_replace("\n", "\\n", $_GET['desc']);
$darkmode = $_GET['darkmode'] ?? 'false';

$categoryName = $_GET['catName'] ?? "na";
$categoryColour = $_GET['catColour'] ?? "na";

$rawData = explode("|", file($databaseFile)[$taskName]);
$created = $rawData[5] ?? "Unknown";
$lastModified = date("d/m/Y h:i a");

$rawData = file($databaseFile);

if ($rawData != NULL) {
    //new category
    if ($categoryName != "na" && $categoryName != "") {
        $catFile = fopen($categoriesFile, "a");
        $toWrite = $category . "|" . $categoryName . "|" . $categoryColour . "|\n";
        fwrite($catFile, $toWrite);
        fclose($catFile);  
    }


    //update task
    $tasks = explode("|", $rawData[$taskName])[0];
    $tasksStatus = explode("|", $rawData[$taskName])[1];

    $rawData[$taskName] = str_replace("\n", "Not Set",($taskTitle . "|" . $tasksStatus . "|")) . $description . str_replace("\n", "Not Set", "|" . $duedate . "|" . $category . "|" . $created . "|". $lastModified) . "|\n";

    $taskFile = fopen($databaseFile, "w");
    foreach ($rawData as $rawLine) {
        fwrite($taskFile, $rawLine);
    }

    fclose($taskFile);
}

header("Location: view_task.php?id=" . $taskName . "&darkmode=" . $darkmode);
die();
?>