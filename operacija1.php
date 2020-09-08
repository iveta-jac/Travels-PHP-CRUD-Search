<?
/**
 * Create new entry page.
 */

include("include/session.php");
?>
<html>
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=9"; type="text/html"; charset="utf-8"/>
    <title>Operacija1</title>
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
                        <td>
                            Atgal į <a href="index.php">pradžią</a>
                        </td>
                    </tr>
                </table>
                <br>
                <?
                // Isset determine if a variable is set
                // New entry successfully added
                if (isset($_SESSION['regsuccess'])) {
                    unset($_SESSION['regsuccess']);
                    echo "<p><div style=\"margin-left:20px\"> <b>$session->username</b>, naujas įrašas buvo sėkmingai įtrauktas.<br><br></div>";
                } else {
                    echo "<div align=\"center\">";
                    if ($form->num_errors > 0) {
                        echo "<font size=\"3\" color=\"#ff0000\">Klaidų: " . $form->num_errors . "</font>";
                    } else {
                        echo "";
                    }
                    echo "</div>";
                }
                ?>
                // Add new entry form
                <div style="margin-left:20px; color: #38b2b5">
                    <h1>Pridėti naują įrašą</h1>
                </div>
                <form action="process.php" style="margin-left:20px; margin-bottom:20px;" method="POST">
                    <p>Pavadinimas:<br><input type="text" name="pavadinimas"
                                              value="<? echo $form->value("pavadinimas"); ?>"/><br><? echo $form->error("pavadinimas"); ?>
                    </p>
                    <p>Žemynas:<br>
                        <select name="zemynas">
                            <option value="Afrika">Afrika</option>
                            <option value="Amerika">Australija</option>
                            <option value="Azija">Azija</option>
                            <option value="Europa">Europa</option>
                            <option value="Pietų Amerika">Pietų Amerika</option>
                            <option value="Šiaurės Amerika">Šiaurės Amerika</option>
                        </select>
                    </p>
                    <p>Trukmė (d.):<br><input type="number" name="trukme" min="1" max="3652" value="1"><br>
                    </p>
                    <p>Metų laikas:<br>
                        <input type="checkbox" name="metulaikas[]" value="Pavasaris"> Pavasaris<br>
                        <input type="checkbox" name="metulaikas[]" value="Ruduo"> Ruduo<br>
                        <input type="checkbox" name="metulaikas[]" value="Vasara" checked> Vasara<br>
                        <input type="checkbox" name="metulaikas[]" value="Žiema"> Žiema<br>
                    </p>
                    <p>Kelionės tipas:<br>
                        <input type="radio" name="kelionestipas" value="Poilsinė" checked> Poilsinė<br>
                        <input type="radio" name="kelionestipas" value="Pažintinė"> Pažintinė<br>
                        <input type="radio" name="kelionestipas" value="Kita"> Kita<br>
                    </p>
                    <input type="hidden" name="subnew" value="1">
                    <input type="submit" value="Pridėti">
                </form>
                <?
            // If user isn't logged in, then he sees login form
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