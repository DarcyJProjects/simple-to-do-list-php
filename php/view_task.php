<?php 
    $databaseFile = $_SERVER['DOCUMENT_ROOT'] . "/database/tasks.txt";
    $configFile = $_SERVER['DOCUMENT_ROOT'] . "/database/config.txt";
    $config = file($configFile);

    $title = $config[0];
    $taskName = $_GET['id'];

    $rawData = explode("|", file($databaseFile)[$taskName]);
    $task = $rawData[0];
    $status = $rawData[1];
    $description = str_replace("\\n", "<br>", $rawData[2]);
    $duedate = $rawData[3];
    $category = $rawData[4];

    $checked = "";
    if ($status == "1") {
        $checked = "checked";
    }
?>

<html>
<head>
    <link rel="stylesheet" href="../css/style.css" type="text/css">
    <link rel="icon" href="favicon.png">
    <title><?php echo $title; ?> - Viewing Task</title>

    <div class="titleText">
        <h1><?php echo $title; ?></h1>
        <h3>Viewing Task</h3>
    </div>
</head>

<body>
    <br>
    <form>
        <h2 class="lim"><?php echo $task; ?></h2><br>
        <b>Completed: <input type="checkbox" <?php echo $checked; ?> onclick="window.location.href='modify_task_status.php?id=<?php echo $taskName; ?>&viewing=true'"></b><br>
        <div class="m5">
            <b>Category:</b> <?php echo $category; ?><br>
        </div>  
        <div class="m5">
            <b>Due Date:</b> <?php echo $duedate; ?>
        </div>
        
        <h4 class="lim">Description:</h4>
        <p><?php echo $description ?></p>
        <br>
        <input class="btnEdit" type="button" value="   Edit   " onclick="window.location.href='edit_task.php?id=<?php echo $taskName; ?>'">
        <input class="btnDelete" type="button" value=" Delete " onclick="window.location.href='delete_task.php?id=<?php echo $taskName; ?>'">
    </form>
    <br>
    <a href="../api/index.php?id=<?php echo $taskName; ?>">Export JSON</a>
<br><br><br><br>
<a href="../index.php">Back</a>

</body>

<footer>
<p>Copyright © <?php include "copyright.php"; ?> Darcy Johnson.		<br>All Rights Reserved.</p>
</footer>

</html>

