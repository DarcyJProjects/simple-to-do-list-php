<?php 
    $configFile = $_SERVER['DOCUMENT_ROOT'] . "/database/config.txt";
    $config = file($configFile);

    $title = $config[0];
?>

<html>
<head>
    <link rel="stylesheet" href="../css/style.css" type="text/css">
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
</pre>
<br>
<a href="../index.php">Back</a>
</body>

<footer>
<p>Copyright © <?php include "../php/copyright.php"; ?> Darcy Johnson.		<br>All Rights Reserved.</p>
</footer>

</html>