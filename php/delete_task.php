<?php
$databaseFile = $_SERVER['DOCUMENT_ROOT'] . "/database/tasks.txt";

$taskName = str_replace("$$$", " ", $_GET['taskName']);

$rawData = file($databaseFile);

if ($rawData != NULL) {
    for ($i = 0; $i < count($rawData); $i++) {
        $tasks = explode("|", $rawData[$i])[0];
        
        if ($tasks == $taskName) {
            unset($rawData[$i]);
            $rawData = array_values($rawData);

            $taskFile = fopen($databaseFile, "w");
            foreach ($rawData as $rawLine) {
                fwrite($taskFile, $rawLine);
            }

            fclose($taskFile);
        } 
    }
}

header("Location: ../index.php");
die();
?>