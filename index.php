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

<div class="titleContainer">
    <img class="titleLogo" src="favicon.png">
    <h1 class="title"><?php echo $title; ?></h1>
</div>

<div class="darkmodeToggle">
    <input type="checkbox" <?php echo $checked; ?> onclick="toggleDarkmode()">  Dark Mode
</div>

<p>This is a simple to do list created in PHP and JS.<br>
<a href="explanation.php?darkmode=<?php echo $darkmode; ?>">Explanation</a></p>
</head>

<body>
    <h2>Tasks</h2>
    <script>
        function addTask() {
            var taskName = document.getElementById("taskName").value;
            var darkmode = <?php echo $darkmode; ?>;

            window.location.href = "./php/add_task.php?taskName=" + taskName + "&darkmode=" + darkmode;
        }
    </script>
    <form>
        Create Task: <input id="taskName" type="text">  <input type="button" value="Add" onclick="addTask()">
    </form>

    <ul>
        <?php include "./php/list_tasks.php"; ?>
    </ul>

<br>
<a href="/php/view_database.php?darkmode=<?php echo $darkmode; ?>">View Database</a>
</body>
<br><br><br><br><br><br>

<?php
$dir4footer = "index";
include "./php/footer.php";
?>

</html>