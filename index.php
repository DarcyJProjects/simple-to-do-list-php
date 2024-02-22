<?php 
    $configFile = $_SERVER['DOCUMENT_ROOT'] . "/database/config.txt";
    $config = file($configFile);

    $title = $config[0];
?>

<html>
<head>

<link rel="stylesheet" href="./css/style.css" type="text/css">
<link rel="icon" href="favicon.png">
<title><?php echo $title; ?></title>

<h1><?php echo $title; ?></h1>
<p>This is a simple to do list created in PHP and JS.<br>
<a href="explanation.php">Explanation</a></p>
</head>

<body>
    <h2>Tasks</h2>
    <form action="./php/add_task.php" method="GET">
        Create Task: <input name="taskName" type="text">  <input type="submit">
    </form>

    <ul>
        <?php include "./php/list_tasks.php"; ?>
    </ul>
</body>
<br><br><br><br>

<footer>
<p>Copyright © <?php include "./php/copyright.php"; ?> Darcy Johnson.		<br>All Rights Reserved.</p>
</footer>

</html>