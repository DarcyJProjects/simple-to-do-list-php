<?php 
    $databaseFile = $_SERVER['DOCUMENT_ROOT'] . "/database/tasks.txt";
    $categoriesFile = $_SERVER['DOCUMENT_ROOT'] . "/database/categories.txt";
    $coloursFile = $_SERVER['DOCUMENT_ROOT'] . "/database/colours.txt";
    $configFile = $_SERVER['DOCUMENT_ROOT'] . "/database/config.txt";
    $config = file($configFile);

    $title = $config[0];
    $taskName = $_GET['id'];
    $darkmode = $_GET['darkmode'] ?? 'false';

    $darkenMultiplier = $config[2];

    $rawData = explode("|", file($databaseFile)[$taskName]);
    $task = $rawData[0] ?? "Not Set";
    $status = $rawData[1] ?? 0;
    $description = str_replace("\\n", "<br>", $rawData[2] ?? "Not Set");
    $duedate = $rawData[3] ?? "Not Set";
    $category = $rawData[4] ?? "Not Set";
    $created = $rawData[5] ?? "Unknown";
    $lastModified = $rawData[6] ?? "Unkown";

    $rawColours = file($coloursFile);

    $rawCategories = file($categoriesFile);

    $categoriesDictionary = [];

    foreach ($rawCategories as $element) {
        $parts = explode('|', $element);
        $key = $parts[0];
        $values = array_slice($parts, 1);
        $categoriesDictionary[$key] = $values;
    }

    $checkedDarkMode = "";
    if ($darkmode == "true") {
        $checkedDarkMode = "checked";
    }

    $checked = "";
    if ($status == "1") {
        $checked = "checked";
    }
?>

<html>
<head>
    <script>
        function toggleDarkmode() {
            var current = <?php echo $darkmode; ?>;
            window.location.href = "edit_task.php?id=<?php echo $taskName; ?>&darkmode=" + !current;
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
    <title><?php echo $title; ?> - Viewing Task</title>

    <div class="boxed">
        <div class="titleContainer">
            <img class="titleLogo" src="../favicon.png">
            <h1 class="title"><?php echo $title; ?></h1>
        </div>
        <div style="margin-left: 55px">
            <h3>Viewing Task</h3>
        </div>
    </div>

    <div class="darkmodeToggle">
        <input type="checkbox" <?php echo $checkedDarkMode; ?> onclick="toggleDarkmode()">  Dark Mode
    </div>
</head>

<body>

<script>
    function save() {
        var id = "<?php echo $taskName; ?>";
        var taskTitle = document.getElementById("tasktitle").value;
        var category = document.getElementById("category").selectedIndex;
        var duedate = document.getElementById("duedate").value;
        var description = document.getElementById("description").value;
        var categoryName = document.getElementById("newCategoryName").value;

        var selectBox = document.getElementById("category");
        if (((selectBox.options[selectBox.selectedIndex].text) == "+ New") && (categoryName != "name")) {
            var categoryName = document.getElementById("newCategoryName").value;
            var colour = colourBox.selectedIndex;

            window.location.href = "update_task.php?id=" + id + "&task=" + encodeURIComponent(taskTitle) + "&cat=" + encodeURIComponent(category) + "&catName=" + encodeURIComponent(categoryName) + "&catColour=" + encodeURIComponent(colour) + "&duedate=" + encodeURIComponent(duedate) + "&desc=" + encodeURIComponent(description) + "&darkmode=<?php echo $darkmode; ?>";
        } else {
            if ((selectBox.options[selectBox.selectedIndex].text) == "+ New") {
                category = "Not Set";
            }
            window.location.href = "update_task.php?id=" + id + "&task=" + encodeURIComponent(taskTitle) + "&cat=" + encodeURIComponent(category) + "&duedate=" + encodeURIComponent(duedate) + "&desc=" + encodeURIComponent(description) + "&darkmode=<?php echo $darkmode; ?>";
        }
    }
</script>


    <br>
    <form class="boxed">
        <input class="lim tasktitle" id="tasktitle" value="<?php echo $task; ?>"><br><br>
        <b>Completed: <input type="checkbox" <?php echo $checked; ?>></b><br><br>
        <div class="m5">
            <!--<b>Category:</b> <input type="text" id="category" value="<?php echo $category; ?>"><br>-->
            <b>Category:</b>

            <select id="category" onchange="selectedIndexChange()">
                <?php 
                    for ($i = 0; $i < count($categoriesDictionary); $i++) {
                        echo "<option value='" . $i . "'>" . $categoriesDictionary[$i][0] . "</option>";
                    }                    
                    echo "<option value='new'>+ New</option>";
                ?>
                </select>

                <b id="newCategoryTxt" ><br><br>Name: <input type="text" id="newCategoryName" oninput="handleText()" value="name" onclick="clearText()"><br></b>
                <b id="newCategoryTxt1" >Colour: <select id="selectColour" onchange="handleColour()">
                <?php
                    for ($i = 0; $i < count($rawColours); $i++) {
                        $colour = explode("|", $rawColours[$i]);
                        $colourName = $colour[0];
                        $colourHEX = $colour[1];

                        echo "<option value='" . $colourHEX . "'>" . $colourName . "</option>";
                    }
                ?>
                </select>
                <br></b>
                <b id="newCategoryTxt2">Preview: <div id="colourPreview" class="cat"><p id="colourPreviewText" style="margin: 0px;">name</p></div><br></b>

            <script>
                var selectBox = document.getElementById("category");
                var colourBox = document.getElementById("selectColour");

                var colourPreview = document.getElementById("colourPreview");
                
                var b1 = document.getElementById("newCategoryName");
                var b2 = document.getElementById("selectColour"); 
                var txt1 = document.getElementById("newCategoryTxt");
                var txt2 = document.getElementById("colourPreviewText");
                var txt3 = document.getElementById("newCategoryTxt1");
                var txt4 = document.getElementById("newCategoryTxt2");
                var div1 = document.getElementById("colourPreview");

                var cat = '<?php echo $category; ?>';
                if (cat == "Not Set") {
                    selectBox.selectedIndex = selectBox.options.length - 1;
                } else {
                    selectBox.selectedIndex = <?php if ($category == "Not Set") { echo '0'; } else { echo $category; } ?>;

                    b1.style.display = 'none';
                    b2.style.display = 'none';
                    txt1.style.display = 'none';
                    txt2.style.display = 'none';
                    txt3.style.display = 'none';
                    txt4.style.display = 'none';
                    div1.style.display = 'none';
                }

                function selectedIndexChange() {
                    if ((selectBox.options[selectBox.selectedIndex].text) == "+ New") {
                        b1.style.display = '';
                        b2.style.display = '';
                        txt1.style.display = '';
                        txt2.style.display = '';
                        txt3.style.display = '';
                        txt4.style.display = '';
                        div1.style.display = '';
                    } else {
                        b1.style.display = 'none';
                        b2.style.display = 'none';
                        txt1.style.display = 'none';
                        txt2.style.display = 'none';
                        txt3.style.display = 'none';
                        txt4.style.display = 'none';
                        div1.style.display = 'none';
                    }
                }

                function handleText() {
                    var nameText = document.getElementById("newCategoryName");
                    var colourPreviewText = document.getElementById("colourPreviewText");
                    colourPreviewText.innerText = nameText.value;
                }

                function handleColour() {
                    $colour = colourBox.value;
                    colourPreview.style.backgroundColor = $colour;
                    
                    colourHEX = $colour.replace("#", "");
                    rHEX = colourHEX[0] + colourHEX[1];
                    gHEX = colourHEX[2] + colourHEX[3];
                    bHEX = colourHEX[4] + colourHEX[5];
                    
                    r = parseInt(rHEX, 16) * <?php echo $darkenMultiplier; ?>;
                    g = parseInt(gHEX, 16) * <?php echo $darkenMultiplier; ?>;
                    b = parseInt(bHEX, 16) * <?php echo $darkenMultiplier; ?>;

                    colourPreview.style.border = "2px solid rgb(" + r + ", " + g + ", " + b + ")";
                }
                
                function clearText() {
                    var nameText = document.getElementById("newCategoryName");
                    nameText.addEventListener('keydown', function (event) {
                        if (nameText.value == "name") {
                            nameText.value = "";
                        }
                    });
                }


            $colour = colourBox.value;
            colourPreview.style.backgroundColor = $colour;
            </script>
                
        </div><br>
        <div class="m5">
            <b>Due Date:</b> <input type="text" id="duedate" value="<?php echo $duedate; ?>"><br>
        </div>
        <br>
        <div class="m5">
            <b>Created:</b> <?php echo $created; ?>
        </div>
        <div class="m5">
            <b>Last Modified:</b> <?php echo $lastModified; ?>
        </div>
        
        <h4 class="lim">Description:</h4><br>
        <textarea class="txtDesc" id="description" type="text" value=""><?php echo str_replace("<br>", "\n", $description); ?></textarea>
        <pre class='m5'>HTML Supported</pre>
        <pre>To set the category to "Not Set" again, just select the category<br>"+ New", don't enter in anything for the Name, and click Save! :)</pre>
        <br>
        <input class="btnSave" type="button" value="Save Changes" onclick="save()">
    </form>
    <br>
    <div class="boxed">
    <a href="./view_task.php?id=<?php echo $taskName; ?>&darkmode=<?php echo $darkmode; ?>">Back (Discards any changes)</a></div>
</body><br><br><br>

<footer>
<p>Copyright © <?php include "copyright.php"; ?> Darcy Johnson.		<br>All Rights Reserved.</p>
</footer>

</html>

