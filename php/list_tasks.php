<?php
error_reporting(1);

$databaseFile = $_SERVER['DOCUMENT_ROOT'] . "/database/tasks.txt";
$categoriesFile = $_SERVER['DOCUMENT_ROOT'] . "/database/categories.txt";
$coloursFile = $_SERVER['DOCUMENT_ROOT'] . "/database/colours.txt";
$configFile = $_SERVER['DOCUMENT_ROOT'] . "/database/config.txt";
$config = file($configFile);

$darkenMultiplier = $config[2];

$timezone = $config[1];
date_default_timezone_set($timezone);

if (!file_exists($databaseFile)) {
    $file = fopen($databaseFile, "w");
    fwrite($file, "");
    fclose($file);
}

$rawData = file($databaseFile);
$rawCategories = file($categoriesFile);

$rawColours = file($coloursFile);

$categoriesDictionary = [];

foreach ($rawCategories as $element) {
    $parts = explode('|', $element);
    $key = $parts[0];
    $values = array_slice($parts, 1);
    $categoriesDictionary[$key] = $values;
}

$totalTasks = count($rawData);
$completedTasks = 0;

if ($rawData != "" && $rawData != NULL) {
    for ($i = 0; $i < $totalTasks; $i++) {
        $tasks = explode("|", $rawData[$i])[0];
        $tasksStatus = explode("|", $rawData[$i])[1];
        $duedate = explode("|", $rawData[$i])[3];
        $category = explode("|", $rawData[$i])[4];
        $categoryName = $categoriesDictionary[$category][0];
        $categoryColour = $categoriesDictionary[$category][1];

        $categoryHEX = explode("|", $rawColours[$categoryColour])[1];
        
        $catClass = "catGood";
        $daysLeftTxt = "days left";
        $doDate = true;
        $today = false;
        $ex = "";
        try {
            $duedateCreated = date_create(str_replace("/","-",$duedate));

            if ($duedateCreated === false) {
                // Handle the case where $duedate is not a valid date
                $ex = $ex . "Invalid date format for \$duedate\n";
            } else {
                $currentDate = new DateTime();
                
                $interval = date_diff($currentDate, $duedateCreated);

                if ($interval !== false) {
                    $daysLeft = ($currentDate < $duedateCreated) ? $interval->days : -$interval->days;
                } else {
                    // Handle the case where date_diff fails
                    $ex = $ex . "Error calculating the duedate to currentdate difference\n";
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

        echo "<style>";
        echo ".cat" . $category . " {";
        echo "  background-color: " . $categoryHEX . ";";

        $hex_duos = str_split(str_replace("#", "", $categoryHEX), 2);
        $catR = hexdec($hex_duos[0]) * $darkenMultiplier;
        $catG = hexdec($hex_duos[1]) * $darkenMultiplier;
        $catB = hexdec($hex_duos[2]) * $darkenMultiplier;
        $catDarken = "rgb(" . $catR . ", " . $catG . ", " . $catB . ")";
        echo "  border: 2px solid " . $catDarken . ";";
        echo "}";
        echo "</style>";
        if ($category != "Not Set" && $category != "") {
            echo "<div class='cat cat" . $category . "'>" . $categoryName . "</div>";
        }

        if ($checked == "checked") {
            $doDate = false;
            echo "</a>";
        }
        
        if ($doDate) {
            if ($ex != "") {
                echo "</a>";
                echo "<div id='error" . $i . "' class='catUrgent errorDiv'> ERROR </div>\n";

                #modal
                echo "<div class='modal' id='errorModal" . $i . "'>";
                echo "    <div class='modalContent'>";
                echo "        <h2>Error:</h2>";
                echo "        <pre>" . $ex . "</pre>"; 
                echo "        <input type='button' id='btnErrorModalClose" . $i . "' value='Close'><br><br>";
                echo "    </div>";
                echo "</div>";

                #js
                echo "<script>\n";

                echo "var modal" . $i . " = document.getElementById('errorModal" . $i . "');\n";
                echo "var close" . $i . " = document.getElementById('btnErrorModalClose" . $i . "');\n";

                echo "close" . $i . ".onclick = function() {\n";
                echo "    modal" . $i . ".style.display = 'none';\n";
                echo "}\n";

                echo "var errorDiv" . $i . " = document.getElementById('error" . $i . "');\n";
                echo "errorDiv" . $i . ".onclick = function(event) {\n";
                echo "  modal" . $i . ".style.display = 'block';\n";
                echo "}\n";

                #echo "document.getElementById('error" . $i . "').addEventListener('mouseover', function() {\n";
                #echo "  window.alert('An error occured:' + decodeURIComponent('" . urlencode('\n' . $ex) . "').replace(/\+/gi, ' '));\n";
                #echo "});\n";

                echo "</script>\n";
            } else {
                if ($daysLeft == 0) {
                    echo "<div id='urgent" . $i . "' class='" . $catClass . "'> TODAY </div>\n";

                    echo "<script>";
                    echo "  var urgent" . $i . " = document.getElementById('urgent" . $i . "');\n";
                    echo "  function flash" . $i . "() {\n";
                    echo "    if (urgent" . $i . ".classList.contains('catUrgentFlash')) {\n";
                    echo "      urgent" . $i . ".classList.remove('catUrgentFlash');\n";
                    echo "    } else {\n";
                    echo "      urgent" . $i . ".classList.add('catUrgentFlash');\n";
                    echo "    }\n";
                    echo "  }\n";
                    echo "setInterval(flash" . $i . ", 500);\n";
                    echo "</script>\n";
                } else {
                    if ($daysLeft < 0) {
                        $daysLeft = abs($daysLeft);
                    }
                    echo "<div id='urgent" . $i . "' class='" . $catClass . "'>" . $daysLeft . " " . $daysLeftTxt . "</div>";
                } 
                echo "</a>";
            }
            
        }
        echo "</form>";
    } 
    
    $completionPercentage = number_format(($completedTasks / $totalTasks) * 100, 2, ".", "");
    echo "<br><b>Completed " . $completedTasks . "/" . $totalTasks . " tasks - " . $completionPercentage . "%</b>"; 
} else {
    echo "No tasks found in the database!";
}


?>

