<?php 
    $configFile = $_SERVER['DOCUMENT_ROOT'] . "/database/config.txt";
    $config = file($configFile);

    $title = $config[0];
    $darkmode = $_GET['darkmode'] ?? 'false';
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
    <title><?php echo $title; ?> - View Database</title>

    <div class="titleText">
        <h1><?php echo $title; ?></h1>
        <h3>Viewing Database</h3>
    </div>
</head>

<body>
<pre>
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
<a class="export" href="export_database.php?type=txt">Export TXT</a><br>
<a class="export" href="export_database.php?type=csv">Export CSV</a>
<br><br>
<a href="../index.php?darkmode=<?php echo $darkmode; ?>">Back</a>
</body>

<?php
$dir4footer = "php";
include "../php/footer.php";
?>

</html>