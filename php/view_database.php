<?php 
    $configFile = $_SERVER['DOCUMENT_ROOT'] . "/database/config.txt";
    $categoriesFile = $_SERVER['DOCUMENT_ROOT'] . "/database/categories.txt";
    $coloursFile = $_SERVER['DOCUMENT_ROOT'] . "/database/colours.txt";
    $categories = file($categoriesFile);
    $config = file($configFile);
    $colours = file($coloursFile);

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
            window.location.href = "view_database.php?darkmode=" + !current;
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
<pre><b>tasks.txt</b>

Format: line number    line content<br>
<?php
$databaseFile = $_SERVER['DOCUMENT_ROOT'] . "/database/tasks.txt";

$raw = file($databaseFile);

for ($i = 0; $i < count($raw); $i++) {
    echo $i . "\t" . $raw[$i];
}

?>
<br>
The line number is the primary key for the task.
</pre>
</div>

<div class="boxed">
<pre><b>categories.txt</b>

Format: line number    line content<br>
<?php
for ($i = 0; $i < count($categories); $i++) {
    echo $i . "\t" . $categories[$i];
}

?>
</pre>
</div>

<div class="boxed">
<pre><b>config.txt</b>

Format: line number    line content<br>
<?php
for ($i = 0; $i < count($config); $i++) {
    echo $i . "\t" . $config[$i];
}

?>
</pre>
</div>

<div class="boxed">
<pre><b>colours.txt</b>

Format: line number    line content<br>
<?php
for ($i = 0; $i < count($colours); $i++) {
    echo $i . "\t" . $colours[$i];
}

?>
</pre>
</div>

<div class="boxed">
<pre style='font-size: 15px'><b>Tasks Database Export</b></pre>
<a class="export" href="export_database.php?type=txt">Export TXT</a><br>
<a class="export" href="export_database.php?type=csv">Export CSV</a>
<br><br>
<a href="../index.php?darkmode=<?php echo $darkmode; ?>">Back</a>
</div>
</body><br><br><br><br>

<?php
$dir4footer = "php";
include "../php/footer.php";
?>

</html>