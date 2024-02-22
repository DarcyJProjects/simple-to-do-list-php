<?php

$createdYear = "2024";
$currentYear = date("Y");

if ($createdYear == $currentYear) {
    echo $createdYear;
} else {
    echo $createdYear . "-" . $currentYear;
}

?>