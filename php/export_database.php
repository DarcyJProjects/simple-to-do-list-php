<?php
$databaseFile = $_SERVER['DOCUMENT_ROOT'] . "/database/tasks.txt";

$type = $_GET['type'];
if ($type != "csv" && $type != "txt") {
    die("Unsupported export file type. Supported file types: txt, csv");
}

if ($type == "txt") {
    header('Content-Description: File Transfer');
	header('Content-Type: application/octet-stream');
	header('Content-Disposition: attachment; filename="' . basename($databaseFile) . '"');
	header('Expires: 0');
	header('Cache-Control: must-revalidate');
	header('Pragma: public');
	header('Content-Length: ' . filesize($databaseFile));
	readfile($databaseFile);
    die();
} else if ($type == "csv") {
    $raw = file($databaseFile);
    $processed[0] = "name,completed,description,duedate,category\n";
    for ($i = 0; $i < count($raw); $i++) {
        $processed[$i + 1] = str_replace("|", ",", $raw[$i]);
    }
    
    $tempCSV = "tasks.csv";
    file_put_contents($tempCSV, $processed);

    header('Content-Description: File Transfer');
	header('Content-Type: application/octet-stream');
	header('Content-Disposition: attachment; filename="' . basename($tempCSV) . '"');
	header('Expires: 0');
	header('Cache-Control: must-revalidate');
	header('Pragma: public');
	header('Content-Length: ' . filesize($tempCSV));
	readfile($tempCSV);
    unlink($tempCSV);
    die();
}
?>