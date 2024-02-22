<?php 
    $configFile = $_SERVER['DOCUMENT_ROOT'] . "/database/config.txt";
    $config = file($configFile);

    $title = $config[0];
?>

<html>
<head>
    <link rel="stylesheet" href="./css/style.css" type="text/css">
    <link rel="icon" href="favicon.png">
    <title><?php echo $title; ?> - Explanation</title>

    <div class="titleText">
        <h1><?php echo $title; ?></h1>
        <h3>Explanation</h3>
    </div>
</head>

<body>
<p>
    All tasks are stored in a database file called <i>tasks.txt</i>. Each task has it's own line. Each line is formatted as such:<br>
    <pre>   taskName|completionStatus</pre></p><p>
    CompletionStatus is either a 0 or a 1, 0 indicating uncompleted (unchecked) and 1 indicating completed (checked).<br>
    <br>
    When index.php is loaded, it calls up list_tasks.php which reads the database file and lists each tasks individually. It also adds the tasks own checkboxes and the js scripts required for these checkboxes to function.<br>
    <br>
    When you type in a taskName and click submit, add_task.php is loaded with the taskName appended  to the URL in a GET form style. This script then writes a new line to the database file in the format previously mentioned and sets the completion status to 0 by default.<br>
    <br>
    When a checkbox is clicked, you're redirected to modify_task_status.php with the taskName.<br>
    This php script then finds where in the database file this TaskName is present, and inverts the completionStatus.<br>
    <br>
    When you delete a task, delete_tasks.php is loaded with the TaskName, and the line of the database file that contains the TaskName to be deleted is removed. All following tasks are moved up a line.<br>

</p>
<br>
<h3 class="lim">Fixes</h3>
<p>
    A primary key system has been implemented - and actually made the code simpler!<br>
    A tasks primary key is just its line number in the database.<br>
    This fixes the previous limitations including not being able to have two tasks with the same name, and not being able to have symbols in the task name.
</p>
<br>
<a href="index.php">Back</a>
</body>

<footer>
<p>Copyright © <?php include "./php/copyright.php"; ?> Darcy Johnson.		<br>All Rights Reserved.</p>
</footer>

</html>