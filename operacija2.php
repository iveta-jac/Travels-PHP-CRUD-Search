<?
/**
 * Searching and viewing entries page.
 */

include("include/session.php");
?>
<html>
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=9"; type="text/html"; charset="utf-8"/>
    <title>Operacija2</title>
    <link href="include/styles.css" rel="stylesheet" type="text/css" />
</head>
<body>
<table class="center">
    <tr>
        <td>
            <img src="pictures/top.png"/>
        </td>
    </tr>
    <tr>
        <td>
            <?
            // If user logged in
            if ($session->logged_in) {
                include("include/menu.php");
                ?>
                <table style="background-color:#F8F8F8;">
                    <tr>
                        <td>Atgal į <a href="index.php">pradžią</a></td>
                    </tr>
                </table>
                <br>

                // Search form
                <div style="margin-left:20px; color: #38b2b5">
                    <h1>Įrašų paieška</h1>
                </div>
                <div style="margin-left:20px;">
                    // Sends form data to the same page (previously we sent it through process.php)
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                        Paieška:<br>
                        <input type="text" name="search">
                        <select name="search2">
                            <option value="pavadinimas">Pavadinimas</option>
                            <option value="zemynas">Žemynas</option>
                            <option value="trukme">Trukmė (d.)</option>
                            <option value="metulaikas">Metų laikas</option>
                            <option value="kelionestipas">Kelionės tipas</option>
                        </select>
                        <input type="hidden" name="subnew" value="1">
                        <input type="submit" value="Ieškoti  |  Rodyti visus įrašus">
                    </form>
                </div>
                <?

                function displayEntries($name, $search2) {
                    global $database;

                    /* (get_magic_quotes_gpc)- it's for security reasons.
                     * To prevent from hackers attacks when they try to enter
                     * SQL commands directly into the field, for example - SELECT
                     */
                    if (!get_magic_quotes_gpc()) {
                        $name = addslashes($name);     // my -name- field
                    }

                    $username = $_SESSION['username']; // checks who is logged in
                    $q = "";

                    /* The administrator search
                     * (strcasecmp)-binary safe case-insensitive string comparison
                     * (strlen)-get string length;
                     * (trim)-strip whitespace or other characters from the beginning and end of a string for example \t\n\r\0\x
                     */
                    if (strcasecmp($username, ADMIN_NAME) == 0) {
                        if (!$name || strlen($name = trim($name)) == 0) { // empty search - display all entries results
                            $q = "SELECT * " . "FROM " . TBL_TRAVELS . " ORDER BY name ASC";
                        } else if($search2 =="pavadinimas") { 			  // exact diary name
                            $q = "SELECT * " . "FROM " . TBL_TRAVELS . " WHERE name LIKE '$name' ORDER BY name ASC";
                        } else if($search2 =="zemynas") { 				  // exact zemynas name
                            $q = "SELECT * " . "FROM " . TBL_TRAVELS . " WHERE continent LIKE '$name' ORDER BY continent ASC";
                        } else if($search2 =="trukme") { 				  // exact trukme name
                            $q = "SELECT * " . "FROM " . TBL_TRAVELS . " WHERE duration LIKE '$name' ORDER BY duration ASC";
                        } else if($search2 =="metulaikas") { 			  // exact or similar metu laikas name
                            $q = "SELECT * " . "FROM " . TBL_TRAVELS . " WHERE seasons LIKE '%$name%' ORDER BY seasons ASC";
                        } else if($search2 =="kelionestipas") { 		  // exact keliones tipas name
                            $q = "SELECT * " . "FROM " . TBL_TRAVELS . " WHERE traveltype LIKE '$name' ORDER BY traveltype ASC";
                        }

                    /* The user search */
                    } else {
                        if (!$name || strlen($name = trim($name)) == 0) { // empty search - display all entries
                            $q = "SELECT * " . "FROM " . TBL_TRAVELS . " WHERE username LIKE '$username' ORDER BY name ASC";
                        } else if($search2 =="pavadinimas") { 			  // exact diary name
                            $q = "SELECT * " . "FROM " . TBL_TRAVELS . " WHERE name LIKE '$name' AND username LIKE '$username' ORDER BY name ASC";
                        } else if($search2 =="zemynas") { 				  // exact zemynas name
                            $q = "SELECT * " . "FROM " . TBL_TRAVELS . " WHERE continent LIKE '$name' AND username LIKE '$username' ORDER BY continent ASC";
                        } else if($search2 =="trukme") {				  // exact trukme name
                            $q = "SELECT * " . "FROM " . TBL_TRAVELS . " WHERE duration LIKE '$name' AND username LIKE '$username' ORDER BY duration ASC";
                        } else if($search2 =="metulaikas") {			 // exact or similar metulaikas name
                            $q = "SELECT * " . "FROM " . TBL_TRAVELS . " WHERE seasons LIKE '%$name%' AND username LIKE '$username' ORDER BY seasons ASC";
                        } else if($search2 =="kelionestipas") { 		  // exact keliones tipas name
                            $q = "SELECT * " . "FROM " . TBL_TRAVELS . " WHERE traveltype LIKE '$name' AND username LIKE '$username' ORDER BY traveltype ASC";
                        }
                    }

                    $result = $database->query($q);
                    /* Error occured, return given name by default */
                    $num_rows = mysql_numrows($result);
                    if (!$result || ($num_rows < 0)) {
                        echo "Nepavyko prisijungti prie duomenų bazės. Bandykite vėliau.";
                        return;
                    }
                    if ($num_rows == 0) {
                        echo "Pagal pateiktą užklausą įrašų nerasta.";
                        return;
                    }

                    /* Display table contents */
                    echo "<table align=\"left\" border=\"1\" cellspacing=\"3\" cellpadding=\"3\">\n";
                    echo "<tr><td><b>Eil.Nr.</b></td><td><b>Pavadinimas</b></td><td><b>Žemynas</b></td><td><b>Trukmė</b></td><td><b>Metų laikas</b></td><td><b>Kelionės tipas</b></td><td><b>Įrašas sukurtas</b></td></tr>\n";
                    for ($i = 0; $i < $num_rows; $i++) {
                        $id					= mysql_result($result, $i, "id");
                        $name				= mysql_result($result, $i, "name");
                        $continent			= mysql_result($result, $i, "continent");
                        $duration			= mysql_result($result, $i, "duration");
                        $seasons			= mysql_result($result, $i, "seasons");
                        $traveltype			= mysql_result($result, $i, "traveltype");
                        $data				= mysql_result($result, $i, "data");
                        $eil_nr				= $i + 1; //numeruoja įrašus nuo 1

                        // if administrator - you can click on an entry and be redirected to edit entry page (operacija3)
                        if (strcasecmp($username, ADMIN_NAME) == 0) {
                            echo "<tr><td>$eil_nr</td><td><a href=\"../operacija3.php?id=$id\">$name</td><td>$continent</td><td>$duration</td><td>$seasons</td><td>$traveltype</td><td>$data</td>\n";
                            echo "<td>"
                            ?>
                            // a form for an entry data deletion, only for administrator
                            <form action="../admin/adminprocess.php" method="POST">
                                <input type="hidden" name="subdelentry" value="<?php echo "$id"; ?>">
                                <input type="image" src="pictures/delete.png" alt="delete" align="left" width="30">
                            </form>
                            <?
                            echo "</tr>\n";

                        // if user
                        } else {
                            echo "<tr><td>$eil_nr</td><td>$name</td><td>$continent</td><td>$duration</td><td>$seasons</td><td>$traveltype</td><td>$data</td>\n";
                        }
                    }   // this is the end for the 'for' cycle
                    echo "</table><br>\n";
                }  // this is the end for a function

                /* Display table */
                /* isset determine if a variable is set. Checks if search is executed.
                If it wasn't here then we would see all search results before even search button is pushed */
                if (isset($_POST['search'], $_POST['search2'])) {
                    ?>
                    <table style="text-align:left; margin-left:20px; border=0;" cellspacing="0" cellpadding="0">
                        <tr>
                            <td>
                                <h3 style="margin-top:0.5em;">Pateikiami jūsų paieškos rezultatai:</h3>
                                <?
                                displayEntries($_POST['search'], $_POST['search2']); // displayEntries function is executed
                                unset($_POST['search'], $_POST['search2']); // no need to check anymore
                                ?>
                    </table>
                    <br>
                    <?
                }
                ?>
                <!-- function php closed -->
                <?
            // If user isn't logged in, then login form is shown
            } else {
                echo "<table align=\"center\" class=\"center\"><tr><td>";
                include("include/loginForm.php");
                echo "</td></tr></table><br></td></tr>";
            }
            echo "<tr><td>";
            include("include/footer.php");
            echo "</td></tr>";
            ?>
        </td>
    </tr>
</table>
</body>
</html>