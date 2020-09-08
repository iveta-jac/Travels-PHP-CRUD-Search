<?
/**
 * Main page with a little info about website.
 */

include("include/session.php");
?>
<html>
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=9"; type="text/html"; charset="utf-8"/>
    <title>Kelionės</title>
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
                <div style="text-align:center; color:#38B2B5">
                    <br><br>
                    <h1>Įrašų registravimo ir paieškos sistema "Kelionės"</h1>
                </div>
                <div style="text-align:center; font-size:20px; line-height:1.5em; color:#000000">
                    <p>Tai lietuviška kelionių įrašų duomenų bazė internete.<br>
                    Čia galite sukurti naują įrašą ir atlikti paiešką tarp savo esamų.</p>
                </div>
                <br>
                <?
            // If there are any errors then error messages are shown
            } else {
                echo "<div align=\"center\">";
                if ($form->num_errors > 0) {
                    echo "<font size=\"3\" color=\"#ff0000\">Klaidų: " . $form->num_errors . "</font>";
                }
                // If user isn't logged in, then login form is shown
                echo "<table class=\"center\"><tr><td>";
                include("include/loginForm.php");
                echo "</td></tr></table></div><br></td></tr>";
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