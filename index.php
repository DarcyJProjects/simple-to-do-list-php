<?php 
    $configFile = $_SERVER['DOCUMENT_ROOT'] . "/database/config.txt";
    $config = file($configFile);

    $title = $config[0];

    $darkmode = $_GET['darkmode'] ?? "false";

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
            window.location.href = "index.php?darkmode=" + !current;
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
    <title><?php echo $title; ?></title>

    <div class="titleContainer boxed">
        <img class="titleLogo" src="favicon.png">
        <h1 class="title"><?php echo $title; ?></h1>
    </div>

    <div class="darkmodeToggle">
        <input type="checkbox" <?php echo $checked; ?> onclick="toggleDarkmode()">  Dark Mode
    </div>

    <div class="boxed">
        <p>This is a simple to do list created in PHP and JS.<br><br>
        <a href="explanation.php?darkmode=<?php echo $darkmode; ?>">Explanation</a></p>
    </div>
</head>

<body>
    <div class="boxed">
    <h2>Tasks</h2>
    <div class="formarea">
        New Task: <input class="txtAddTask" id="taskName" type="text">  <input type="button" value="Create" onclick="addTask()">
    </div>
    <script>
        document.getElementById('taskName').addEventListener('keyup', function (event) {
            if (event.key === 'Enter') {
                addTask();
            }
        });

        function addTask() {
            var taskName = document.getElementById("taskName").value;
            var darkmode = <?php echo $darkmode; ?>;

            window.location.href = "./php/add_task.php?taskName=" + taskName + "&darkmode=" + darkmode;
        }
    </script>

    <ul>
        <?php include "./php/list_tasks.php"; ?>
    </ul>
    </div>

<br>
<div class="boxed">
    <a href="/php/view_archive.php?darkmode=<?php echo $darkmode; ?>">View Archive</a><br><br>
    <a href="/php/view_database.php?darkmode=<?php echo $darkmode; ?>">View Database</a>
</div>
</body>
<br><br><br><br><br><br>

<?php
$dir4footer = "index";
include "./php/footer.php";
?>

</html>