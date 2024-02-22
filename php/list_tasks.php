<?php
error_reporting(1);

$databaseFile = $_SERVER['DOCUMENT_ROOT'] . "/database/tasks.txt";
$configFile = $_SERVER['DOCUMENT_ROOT'] . "/database/config.txt";
$config = file($configFile);

$timezone = $config[1];
date_default_timezone_set($timezone);

if (!file_exists($databaseFile)) {
    $file = fopen($databaseFile, "w");
    fwrite($file, "");
    fclose($file);
}

$rawData = file($databaseFile);

$totalTasks = count($rawData);
$completedTasks = 0;

if ($rawData != "" && $rawData != NULL) {
    for ($i = 0; $i < $totalTasks; $i++) {
        $tasks = explode("|", $rawData[$i])[0];
        $tasksStatus = explode("|", $rawData[$i])[1];
        $duedate = explode("|", $rawData[$i])[3];
        $category = explode("|", $rawData[$i])[4];
        
        $catClass = "catGood";
        $daysLeftTxt = "days left";
        $doDate = true;
        $today = false;
        try {
            $duedateCreated = date_create(str_replace("/","-",$duedate));

            if ($duedateCreated === false) {
                // Handle the case where $duedate is not a valid date
                echo "Invalid date format for \$duedate";
            } else {
                $currentDate = new DateTime();
                
                $interval = date_diff($currentDate, $duedateCreated);

                if ($interval !== false) {
                    $daysLeft = ($currentDate < $duedateCreated) ? $interval->days : -$interval->days;
                } else {
                    // Handle the case where date_diff fails
                    echo "Error calculating the difference";
                }
            }
            
            if ($daysLeft < 3) {
                $catClass = "catUrgent";
                if ($daysLeft == 1) {
                    $daysLeftTxt = "day left";
                } else if ($daysLeft < 0) {
                    $catClass = "catNegative";
                    $daysLeftTxt = "days ago";
                }
            }

        } catch (Exception $throwaway) {
            $doDate = false;
        }
        

        $checked = "";
        if ($tasksStatus == 1) {
            $checked = "checked";
            $completedTasks++;
        };

        echo "<script>\n";
        echo "function submitForm" . $i . "() {\n";
        echo "  window.location.href = '../php/modify_task_status.php?id=" . $i  . "&darkmode=" . $darkmode . "';";
        echo "}\n";
        echo "</script>\n";

        echo "<form method='GET'><input type='checkbox' class='checkbox'" . $checked . " onclick='submitForm" . $i . "()'>";
        echo "&nbsp <a class='task' href='../php/view_task.php?id=" . $i . "&darkmode=" . $darkmode . "'>";
        echo  $tasks;
        if ($category != "Not Set" && $category != "") {
            echo "<div class='cat'>" . $category . "</div>";
        }
        if ($doDate) {
            echo "<div class='" . $catClass . "'>" . $daysLeft . " " . $daysLeftTxt . "</div>";
        }
        if ($today) {
            echo "ITS TODAY OMG";
        } 
        echo "</a></form>";
    } 
    
    $completionPercentage = number_format(($completedTasks / $totalTasks) * 100, 2, ".", "");
    echo "<br><b>Completed " . $completedTasks . "/" . $totalTasks . " tasks - " . $completionPercentage . "%</b>"; 
} else {
    echo "No tasks found in the database!";
}


?>