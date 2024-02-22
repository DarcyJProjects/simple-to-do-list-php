<?php

$dirStart = "";
if ($dir4footer == "index") {
    $dirStart = "./";
} else {
    $dirStart = "../";
}

?>

<footer>
<p>Copyright © <?php include $dirStart . "php/copyright.php"; ?> Darcy Johnson.		<br>All Rights Reserved. &nbsp;<a href="https://github.com/DarcyJProjects/simple-to-do-list-php" target="_blank">GitHub</a></p>
<img class="footerLogo" id="footerLogo" onclick="creatorLink()" src="<?php echo $dirStart; ?>img/footerLogo
<?php
if ($darkmode == "true") {
    echo '_darkmode';
}
?>
.png">

<script>
    function creatorLink() {
        window.open("https://darcyjprojects.xyz");
    }

    document.getElementById("footerLogo").addEventListener("mouseover", function() {
        this.src = "<?php echo $dirStart; ?>img/hoverfooterLogo<?php
if ($darkmode == "true") {
    echo '_darkmode';
}
?>.png";
    });

    document.getElementById("footerLogo").addEventListener("mouseout", function() {
        this.src = "<?php echo $dirStart; ?>img/footerLogo<?php
if ($darkmode == "true") {
    echo '_darkmode';
}
?>.png";
    });
</script>

</footer>