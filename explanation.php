<?php 
    $configFile = $_SERVER['DOCUMENT_ROOT'] . "/database/config.txt";
    $config = file($configFile);

    $title = $config[0];
    $darkmode = $_GET['darkmode'] ?? 'false';
    $checked = "";
    if ($darkmode == "true") {
        $checked = "checked";
    }
?>

<html>
<head>
    <script>
        function toggleDarkmode() {
            var current = <?php echo $darkmode; ?>;
            window.location.href = "explanation.php?darkmode=" + !current;
        }
    </script>

    <?php
    if ($darkmode == "true") {
        echo '<link rel="stylesheet" href="./css/style_darkmode.css" type="text/css">';
    } else {
        echo '<link rel="stylesheet" href="./css/style.css" type="text/css">';
    }
    ?>
    <link rel="icon" href="favicon.png">
    <title><?php echo $title; ?> - Explanation</title>
    
    <div class="titleContainer boxed">
        <img class="titleLogo" src="favicon.png">
        <h1 class="title"><?php echo $title; ?></h1>
    </div>

    <div class="darkmodeToggle">
        <input type="checkbox" <?php echo $checked; ?> onclick="toggleDarkmode()">  Dark Mode
    </div>
</head>

<body>
<div class="boxed">
<p>
<u>This page is outdated, but will be updated soon.</u><br><br>

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
</div>
<br>
<div class="boxed">
<h3 class="lim">Fixes</h3>
<p>
    A primary key system has been implemented - and actually made the code simpler!<br>
    A tasks primary key is just its line number in the database.<br>
    This fixes the previous limitations including not being able to have two tasks with the same name, and not being able to have symbols in the task name.
</p>
</div>
<br>
<div class="boxed">
<a href="index.php?darkmode=<?php echo $darkmode; ?>">Back</a>
</div>
</body>
<br><br><br><br><br>

<?php
$dir4footer = "index";
include "./php/footer.php";
?>

</html>