<?
/**
 * This page is for those users who have forgotten their
 * password and want to have a new password generated for
 * them and sent to the email address attached to their
 * account in the database. The new password is not
 * displayed on the website for security purposes.
 *
 * Note: If your server is not properly setup to send
 * mail, then this page is essentially useless and it
 * would be better to not even link to this page from
 * your website.
 */

include("include/session.php");
?>
<html>
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=9; text/html; charset=utf-8"/>
    <title>Slaptažodžio priminimas</title>
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
            <table style="background-color:#F8F8F8;">
                <tr>
                    <td>
                        Atgal į <a href="index.php">pradžią</a>
                    </td>
                </tr>
            </table>
            <br>
            <?
            /**
             * Forgot Password form has been submitted and no errors
             * were found with the form (the username is in the database)
             */
            if (isset($_SESSION['forgotpass'])) {
                /**
                 * New password was generated for user and sent to user's
                 * email address.
                 */
                if ($_SESSION['forgotpass']) {
                    echo "<p style=\"margin-left:20px\">Naujas slaptažodis buvo sugeneruotas ir nusiųstas el. paštu. <br><br></p>";
                } else {
                    /**
                     * Email could not be sent, therefore password was not
                     * edited in the database.
                     */
                    echo "<h1>Klaida</h1>";
                    echo "<p>Įvyko klaida siunčiant slaptažodį, todėl slaptažodis pakeistas nebuvo.<br> "
                        . "<a href=\"index.php\">Pradžia</a>.</p>";
                }
                unset($_SESSION['forgotpass']);
            } else {
                /**
                 * Forgot password form is displayed, if error found
                 * it is displayed.
                 */
                ?>
                <div align="left" style="margin-left:20px">
                    Naujas slaptažodis bus nusiųstas su Jūsų paskyra susietu el. pašto adresu.<br>
                    Įveskite vartotojo vardą:<br><br>
                    <?
                    echo $form->error("user");
                    ?>
                    <form action="process.php" method="POST">
                        <input type="text" name="user" maxlength="30" value="<? echo $form->value("user"); ?>">
                        <input type="hidden" name="subforgot" value="1">
                        <input type="submit" value="Naujas slaptažodis">
                    </form>
                </div>
                <?
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