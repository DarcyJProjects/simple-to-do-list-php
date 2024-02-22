<?php
$databaseFile = $_SERVER['DOCUMENT_ROOT'] . "/database/tasks.txt";

$taskName = $_GET['taskName'];

$taskFile = fopen($databaseFile, "a") or die("Couldn't open the database file!");
$content = $taskName . "|" . "0|Not Set|dd/mm/yyyy|Not Set|" . "\n";
fwrite($taskFile, $content);
fclose($taskFile);

header("Location: ../index.php");
die();
?>