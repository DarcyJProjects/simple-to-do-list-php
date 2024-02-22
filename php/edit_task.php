<?php 
    $databaseFile = $_SERVER['DOCUMENT_ROOT'] . "/database/tasks.txt";
    $configFile = $_SERVER['DOCUMENT_ROOT'] . "/database/config.txt";
    $config = file($configFile);

    $title = $config[0];
    $taskName = $_GET['id'];
    $darkmode = $_GET['darkmode'] ?? 'false';

    $rawData = explode("|", file($databaseFile)[$taskName]);
    $task = $rawData[0];
    $status = $rawData[1];
    $description = str_replace("\\n", "\n", $rawData[2]);
    $duedate = $rawData[3];
    $category = $rawData[4];

    $checked = "";
    if ($status == "1") {
        $checked = "checked";
    }
?>

<html>
<head>
    <?php
    if ($darkmode == "true") {
        echo '<link rel="stylesheet" href="../css/style_darkmode.css" type="text/css">';
    } else {
        echo '<link rel="stylesheet" href="../css/style.css" type="text/css">';
    }
    ?>
    <link rel="icon" href="favicon.png">
    <title><?php echo $title; ?> - Viewing Task</title>

    <div class="titleText">
        <h1><?php echo $title; ?></h1>
        <h3>Viewing Task</h3>
    </div>
</head>

<body>

<script>
    function save() {
        var id = "<?php echo $taskName; ?>";
        var taskTitle = document.getElementById("tasktitle").value;
        var category = document.getElementById("category").value;
        var duedate = document.getElementById("duedate").value;
        var description = document.getElementById("description").value;

        window.location.href = "update_task.php?id=" + id + "&task=" + encodeURIComponent(taskTitle) + "&cat=" + encodeURIComponent(category) + "&duedate=" + encodeURIComponent(duedate) + "&desc=" + encodeURIComponent(description) + "&darkmode=<?php echo $darkmode; ?>";
    }
</script>


    <br>
    <form>
        <input class="lim tasktitle" id="tasktitle" value="<?php echo $task; ?>"><br><br>
        <b>Completed: <input type="checkbox" <?php echo $checked; ?>></b><br>
        <div class="m5">
            <b>Category:</b> <input type="text" id="category" value="<?php echo $category; ?>"><br>
        </div>  
        <div class="m5">
            <b>Due Date:</b> <input type="text" id="duedate" value="<?php echo $duedate; ?>"><br>
        </div>
        
        <h4 class="lim">Description:</h4><br>
        <textarea class="txtDesc" id="description" type="text" value=""><?php echo $description ?></textarea><br>
        <br>
        <input class="btnSave" type="button" value="Save Changes" onclick="save()">
    </form>
    <br>
    <a href="../index.php?darkmode=<?php echo $darkmode; ?>">Back (Discards any changes)</a>
</body>

<footer>
<p>Copyright © <?php include "copyright.php"; ?> Darcy Johnson.		<br>All Rights Reserved.</p>
</footer>

</html>

