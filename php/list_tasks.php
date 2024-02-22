<?php
$databaseFile = $_SERVER['DOCUMENT_ROOT'] . "/database/tasks.txt";

if (!file_exists($databaseFile)) {
    $file = fopen($databaseFile, "w");
    fwrite($file, "");
    fclose($file);
}

$rawData = file($databaseFile);

$totalTasks = count($rawData);
$completedTasks = 0;

if ($rawData != NULL) {
    for ($i = 0; $i < $totalTasks; $i++) {
        $tasks = explode("|", $rawData[$i])[0];
        $tasksStatus = explode("|", $rawData[$i])[1];

        $checked = "";
        if ($tasksStatus == 1) {
            $checked = "checked";
            $completedTasks++;
        };

        echo "<script>\n";
        echo "function submitForm" . $i . "() {\n";
        echo "  window.location.href = '../php/modify_task_status.php?id=" . $i  . "';";
        echo "}\n";
        echo "</script>\n";

        echo "<form method='GET'><input type='checkbox' " . $checked . " onclick='submitForm" . $i . "()'>";
        echo "<a class='task' href='../php/view_task.php?id=" . $i . "'>";
        echo $tasks . "</a> <!--<a href='../php/delete_task.php?id=" . $i . "'> (delete)</a>--></form>";
    }
}

$completionPercentage = number_format(($completedTasks / $totalTasks) * 100, 2, ".", "");
echo "<br><b>Completed " . $completedTasks . "/" . $totalTasks . " tasks - " . $completionPercentage . "%</b>"; 
?>