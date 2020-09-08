<?
/**
 * Menu links.
 */

/**
 * Alternative method for creating menu.
 * We can use class and create it's object
 */
class Menu {
    function Menu($session) {
        if (isset($session) && $session->logged_in) {
            $path = "";
            if (isset($_SESSION['path'])) {
                $path = $_SESSION['path'];
                unset($_SESSION['path']);
            }
            ?>
            <table width=100% border="0" cellspacing="3" cellpadding="3" class="menu">
                <?
                echo "<tr><td>";
                echo "<a href=\"" . $path . "userinfo.php?user=$session->username\">Mano paskyra</a> &nbsp;&nbsp;"
                    . "| &nbsp;&nbsp;"
                    . "<a href=\"" . $path . "useredit.php\">Redaguoti paskyrą</a> &nbsp;&nbsp;"
                    . "| &nbsp;&nbsp;"
                    . "<a href=\"" . $path . "operacija1.php\">Naujas įrašas</a> &nbsp;&nbsp;"
                    . "| &nbsp;&nbsp;"
                    . "<a href=\"" . $path . "operacija2.php\">Įrašų paieška</a> &nbsp;&nbsp;"
                    . "| &nbsp;&nbsp;";

                // operacija3 (edit entry) only can be seen by valdytojas(manager) and administratorius(administrator)
                if ($session->isManager() || $session->isAdmin()) {
                    echo "<a href=\"" . $path . "operacija3.php\">Įrašų redagavimas</a> &nbsp;&nbsp;"
                        . "| &nbsp;&nbsp;";
                }

                // admin (administratoriaus sąsają) only can be seen by administratorius
                if ($session->isAdmin()) {
                    echo "<a href=\"" . $path . "admin/admin.php\">Administratoriaus sąsaja</a> &nbsp;&nbsp;"
                        . "| &nbsp;&nbsp;";
                }
                echo "<a href=\"" . $path . "process.php\">Atsijungti</a>";
                echo "</td></tr>";
                echo "<table align=\"right\"<tr><td>";
                echo "<p style=\"padding-top:5px\">Prisijungęs vartotojas: <b>$session->username</b></p>";
                echo "</td></tr>";
                ?>
            </table>
            <?
        }
    }
}

// Object is created
if (isset($session)) {
    $menu = new Menu($session);
}
?>