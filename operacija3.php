<?
/**
 * Edit entry page.
 * Only administrator can see this.
 */

include("include/session.php");
?>
<html>
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=9"; type="text/html"; charset="utf-8"/>
    <title>Operacija3</title>
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
            if ($session->logged_in) {
                include("include/menu.php");
                ?>
                <table style="background-color:#F8F8F8;">
                    <tr>
                        <td>
                            Atgal į <a href="index.php">pradžią</a>
                        </td>
                    </tr>
                </table>
                <br>
                <?
                // isset determine if a variable is set.
                if (isset($_GET['id'])) {
                    $travel_id = trim($_GET['id']);

                    global $database;

                    $q = "SELECT * " . "FROM " . TBL_TRAVELS . " WHERE id = '$travel_id'";
                    $result   = $database->query($q);

                    /* Error occurred */
                    $num_rows = mysql_numrows($result);
                    if (!$result || ($num_rows < 0)) {
                        echo "Nepavyko prisijungti prie duomenų bazės. Bandykite vėliau.";
                        return;
                    }
                    if ($num_rows == 0) {
                        echo "Įrašo duomenų bazėje nerasta.";
                        return;
                    }
                    // gali būti ir 0 ir for ciklo nereik, nes id tik vienas
                    for ($i = 0; $i < $num_rows; $i++) {
                        $name				= mysql_result($result, $i, "name");
                        $continent			= mysql_result($result, $i, "continent");
                        $duration			= mysql_result($result, $i, "duration");
                        $seasons			= mysql_result($result, $i, "seasons");
                        $traveltype			= mysql_result($result, $i, "traveltype");
                        $data				= mysql_result($result, $i, "data");
                    }

                    ?>
                    <div style="margin-left:20px; color:#38B2B5">
                        <h1>Įrašo redagavimas</h1>
                    </div>
                    <table style="margin-left:20px; margin-bottom:20px;">
                        <tr>
                            <td>
                                <form action="../admin/adminprocess.php" style="text-align:left;" method="POST">
                                    <p>Pavadinimas:<br><input type="text" name="pavadinimas" value="<?php echo $name; ?>">
                                    </p>
                                    <p>Žemynas:<br>
                                        <select name="zemynas">
                                            // strcmp — Binary safe string comparison
                                            <option <?php if (!strcmp($continent, "Afrika")) echo 'selected' ; ?> value="Afrika">Afrika</option>
                                            <option <?php if (!strcmp($continent, "Amerika")) echo 'selected' ; ?> value="Amerika">Australija</option>
                                            <option <?php if (!strcmp($continent, "Europa")) echo 'selected' ; ?> value="Europa">Europa</option>
                                            <option <?php if (!strcmp($continent, "PietuAmerika")) echo 'selected' ; ?> value="PietuAmerika">Pietų Amerika</option>
                                            <option <?php if (!strcmp($continent, "SiauresAmerika")) echo 'selected' ; ?> value="SiauresAmerika">Šiaurės Amerika</option>
                                        </select>
                                    </p>
                                    <p>Trukmė (d.):<br><input type="number" name="trukme" min="1" max="3652" value="<?php echo $duration;?>"></p>
                                    <p>Metų laikas:<br>
                                        // (explode)—split a string by string.masyva ismeta i eile visa
                                        // (in_array)—checks if a value exists in an array
                                        <input type="checkbox" name="metulaikas[]" value="Pavasaris" <?php $seasons2 = explode(" ", $seasons); if (in_array("Pavasaris", $seasons2)) { echo 'checked'; } ?> > Pavasaris<br>
                                        <input type="checkbox" name="metulaikas[]" value="Ruduo" <?php $seasons2 = explode(" ", $seasons); if (in_array("Ruduo", $seasons2)) { echo 'checked'; } ?> > Ruduo<br>
                                        <input type="checkbox" name="metulaikas[]" value="Vasara" <?php $seasons2 = explode(" ", $seasons); if (in_array("Vasara", $seasons2)) { echo 'checked'; } ?> > Vasara<br>
                                        <input type="checkbox" name="metulaikas[]" value="Žiema" <?php $seasons2 = explode(" ", $seasons); if (in_array("Žiema", $seasons2)) { echo 'checked'; } ?> > Žiema<br>
                                    </p>
                                    <p>Kelionės tipas:<br>
                                        <input type="radio" name="kelionestipas" value="Poilsinė" <?php if (!strcmp($traveltype, "Poilsinė")) echo 'checked' ; ?> > Poilsinė<br>
                                        <input type="radio" name="kelionestipas" value="Pažintinė" <?php if (!strcmp($traveltype, "Pažintinė")) echo 'checked' ; ?> > Pažintinė<br>
                                        <input type="radio" name="kelionestipas" value="Kita" <?php if (!strcmp($traveltype, "Kita")) echo 'checked' ; ?> > Kita<br>
                                    </p>
                                    <input type="hidden" name="subedit" value="<?php echo "$travel_id"; ?>">
                                    <input type="submit" value="Redaguoti">
                                </form>
                            </td>
                        </tr>
                    </table>
                    <?
                } else {
                    echo "<p style=\"margin-left:20px; margin-bottom:20px;\">Nepasirinkote įrašo. Įrašų paieškoje spauskite ant įrašo pavadinimo. </p>";
                }
                ?>
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