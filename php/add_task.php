<?php
$databaseFile = $_SERVER['DOCUMENT_ROOT'] . "/database/tasks.txt";
$configFile = $_SERVER['DOCUMENT_ROOT'] . "/database/config.txt";
$config = file($configFile);

$timezone = $config[1];
date_default_timezone_set($timezone);

$taskName = $_GET['taskName'];
$darkmode = $_GET['darkmode'] ?? 'false';

if (!empty($taskName)) {
    $created = date("d/m/Y");

    $taskFile = fopen($databaseFile, "a") or die("Couldn't open the database file!");
    $content = $taskName . "|" . "0|Not Set|dd/mm/yyyy|Not Set|" . $created . "|" . "\n";
    fwrite($taskFile, $content);
    fclose($taskFile);
}

header("Location: ../index.php?darkmode=" . $darkmode);
die();
?>