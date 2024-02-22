<?php
$databaseFile = $_SERVER['DOCUMENT_ROOT'] . "/database/tasks.txt";

if (!file_exists($databaseFile)) {
    $file = fopen($databaseFile, "w");
    fwrite($file, "");
    fclose($file);
}

$rawData = file($databaseFile);

if ($rawData != NULL) {
    for ($i = 0; $i < count($rawData); $i++) {
        $tasks = explode("|", $rawData[$i])[0];
        $tasksStatus = explode("|", $rawData[$i])[1];

        $checked = "";
        if ($tasksStatus == 1) {
            $checked = "checked";
        }

        $tasksREPLACED = str_replace(" ", "$$$", $tasks);

        echo "<script>\n";
        echo "function submitForm" . $tasksREPLACED . "() {\n";
        echo "  window.location.href = '../php/modify_task_status.php?taskName=" . $tasksREPLACED  . "';";
        echo "}\n";
        echo "</script>\n";

        echo "<form method='GET'><input type='checkbox' " . $checked . " onclick='submitForm" . $tasksREPLACED . "()'>";
        echo $tasks . " <a href='../php/delete_task.php?taskName=" . $tasksREPLACED . "'> (delete)</a></form>";
    }
}
?>