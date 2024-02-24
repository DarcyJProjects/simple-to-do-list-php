<?php 
    $databaseFile = $_SERVER['DOCUMENT_ROOT'] . "/database/tasks.txt";
    $categoriesFile = $_SERVER['DOCUMENT_ROOT'] . "/database/categories.txt";
    $archiveFile = $_SERVER['DOCUMENT_ROOT'] . "/database/archive.txt";
    $configFile = $_SERVER['DOCUMENT_ROOT'] . "/database/config.txt";
    $config = file($configFile);

    $title = $config[0];
    $taskName = $_GET['id'];
    $darkmode = $_GET['darkmode'] ?? 'false';
    $archive = $_GET['archive'] ?? 'false';

    if ($archive == "true") {
        $databaseFile = $archiveFile;
    }

    $rawData = explode("|", file($databaseFile)[$taskName]);
    $task = $rawData[0] ?? "Not Set";
    $status = $rawData[1] ?? 0;
    $description = str_replace("\\n", "<br>", $rawData[2] ?? "Not Set");
    $duedate = $rawData[3] ?? "Not Set";
    $category = $rawData[4] ?? "Not Set";
    $created = $rawData[5] ?? "Unknown";
    $lastModified = $rawData[6] ?? "Unkown";

    $rawCategories = file($categoriesFile);

    $categoriesDictionary = [];

    foreach ($rawCategories as $element) {
        $parts = explode('|', $element);
        $key = $parts[0];
        $values = array_slice($parts, 1);
        $categoriesDictionary[$key] = $values;
    }

    $checkedDarkMode = "";
    if ($darkmode == "true") {
        $checkedDarkMode = "checked";
    }

    $checked = "";
    if ($status == "1") {
        $checked = "checked";
    }
?>

<html>
<head>
<script>
        function toggleDarkmode() {
            var current = <?php echo $darkmode; ?>;
            window.location.href = "view_task.php?id=<?php echo $taskName; ?>&darkmode=" + !current;
        }
    </script>

    <?php
    if ($darkmode == "true") {
        echo '<link rel="stylesheet" href="../css/style_darkmode.css" type="text/css">';
    } else {
        echo '<link rel="stylesheet" href="../css/style.css" type="text/css">';
    }
    ?>

    <link rel="icon" href="favicon.png">
    <title><?php echo $title; ?> - Viewing Task</title>
    
    <div class="boxed">
        <div class="titleContainer">
            <img class="titleLogo" src="../favicon.png">
            <h1 class="title"><?php echo $title; ?></h1>
        </div>
        <div style="margin-left: 55px">
            <h3>Viewing Task</h3>
        </div>
    </div>

    <div class="darkmodeToggle">
        <input type="checkbox" <?php echo $checkedDarkMode; ?> onclick="toggleDarkmode()">  Dark Mode
    </div>
</head>

<body>
    <br>
    <form class="boxed">
        <h2 class="lim"><?php echo $task; ?></h2><br>
        <b>Completed: <input type="checkbox" <?php echo $checked; ?> onclick="window.location.href='modify_task_status.php?id=<?php echo $taskName; ?>&viewing=true&darkmode=<?php echo $darkmode; ?>'"></b><br>
        <div class="m5">
            <b>Category:</b> <?php
            if ($category != "Not Set") {
                echo $categoriesDictionary[$category][0];
            } else {
                echo "Not Set";
            }
            ?><br>
        </div>  
        <div class="m5">
            <b>Due Date:</b> <?php echo $duedate; ?>
        </div>
        <br>
        <div class="m5">
            <b>Created:</b> <?php echo $created; ?>
        </div>
        <div class="m5">
            <b>Last Modified:</b> <?php echo $lastModified; ?>
        </div>
        
        <h4 class="lim">Description:</h4>
        <p><?php echo $description ?></p>
        <br>
        <?php 
        $visible = "";
        $visible2 = "hidden='hidden'";
        if ($archive == "true") {
            $visible = "hidden='hidden'";
            $visible2 = "";
        }
        ?>
        <input class="btnEdit" <?php echo $visible; ?> type="button" value="   Edit   " onclick="window.location.href='edit_task.php?id=<?php echo $taskName; ?>&darkmode=<?php echo $darkmode; ?>'">
        <input class="btnDelete" type="button" value=" Delete " onclick="window.location.href='delete_task.php?id=<?php echo $taskName; ?>&darkmode=<?php echo $darkmode; ?>'">
        <input class="btnArchive" <?php echo $visible; ?> type="button" value=" Archive " onclick="window.location.href='archive_task.php?id=<?php echo $taskName; ?>&darkmode=<?php echo $darkmode; ?>'">
        <input class="btnArchive" <?php echo $visible2; ?> type="button" value=" Un-Archive " onclick="window.location.href='archive_task.php?id=<?php echo $taskName; ?>&darkmode=<?php echo $darkmode; ?>&mode=unarchive'">
    </form>
    <br>
    <div class="boxed">
    <a href="../api/index.php?id=<?php echo $taskName; ?>">Export JSON</a>
<br><br><br><br>
<a href="../index.php?darkmode=<?php echo $darkmode; ?>">Back</a>
</div>
</body><br><br><br>

<?php
$dir4footer = "php";
include "../php/footer.php";
?>

</html>

