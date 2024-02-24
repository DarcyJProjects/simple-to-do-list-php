<?php
    $databaseFile = $_SERVER['DOCUMENT_ROOT'] . "/database/archive.txt";
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
            window.location.href = "view_archive.php?darkmode=" + !current;
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
    <title><?php echo $title; ?> - View Database</title>

    <div class="titleContainer boxed">
        <img class="titleLogo" src="../favicon.png">
        <h1 class="title"><?php echo $title; ?></h1>
    </div>

    <div class="darkmodeToggle">
        <input type="checkbox" <?php echo $checked; ?> onclick="toggleDarkmode()">  Dark Mode
    </div>
</head>

<body>
<div class="boxed">
<h2>Archived Tasks</h2>
<ul>
<?php
$raw = file($databaseFile);

if (count($raw) == 0) {
    echo "No archived tasks found in the database.";
} else {
    for ($i = 0; $i < count($raw); $i++) {
        $rawExploded = explode("|", $raw[$i]);
    
        $taskName = $rawExploded[0] ?? 'Not Set';
        echo "<a class='task' href='../php/view_task.php?id=" . $i . "&darkmode=" . $darkmode . "&archive=true'>";
        echo $taskName;
        echo "</a><br>";
    }
}


?>

</ul>
</div>

<div class="boxed">
<a href="../index.php?darkmode=<?php echo $darkmode; ?>">Back</a>
</div>
</body><br><br><br><br>

<?php
$dir4footer = "php";
include "../php/footer.php";
?>

</html>