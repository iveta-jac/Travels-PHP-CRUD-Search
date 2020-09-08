<?
/**
 * This page is for users to edit their account information
 * such as their password, email address, etc. Their
 * usernames can not be edited. When changing their
 * password, they must first confirm their current password.
 */
include("include/session.php");
?>
<html>
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=9; text/html; charset=utf-8"/>
    <title>Paskyros redagavimas</title>
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
            /**
             * If user is not logged in, then do not display anything.
             * If user is logged in, then display the form to edit
             * account information, with the current email address
             * already in the field.
             */
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
                /**
                 * User has submitted form without errors and user's
                 * account has been edited successfully.
                 */
                if (isset($_SESSION['useredit'])) {
                    unset($_SESSION['useredit']);
                    echo "<p><b>$session->username</b>, Jūsų paskyra sėkmingai atnaujinta.<br><br>";
                } else {
                    echo "<div style=\"margin:20px 0 0 20px;\" align=\"left\">";
                    if ($form->num_errors > 0) {
                        echo "<font size=\"3\" color=\"#ff0000\">Klaidų: " . $form->num_errors . "</font>";
                    } else {
                        echo "";
                    }
                    ?>
                    <table style="margin-bottom:20px;" bgcolor=#DCDCDC >
                        <tr>
                            <td>
                                <form action="process.php" style="text-align:left;" method="POST">
                                    <p>Dabartinis slaptažodis:<br>
                                        <input type="password" name="curpass" maxlength="30" size="25" value="<?php echo $form->value("curpass"); ?>">
                                        <br><? echo $form->error("curpass"); ?>
                                    </p>
                                    <p>Naujas slaptažodis:<br>
                                        <input type="password" name="newpass" maxlength="30" size="25" value="<? echo $form->value("newpass"); ?>">
                                        <br><? echo $form->error("newpass"); ?>
                                    </p>
                                    <p>El. paštas:<br>
                                        <input type="text" name="email" maxlength="30" size="25" value="<?
                                        if ($form->value("email") == "") {
                                            echo $session->userinfo['email'];
                                        } else {
                                            echo $form->value("email");
                                        }
                                        ?>"> <br><? echo $form->error("email"); ?>
                                    </p>
                                    <input type="hidden" name="subedit" value="1">
                                    <input type="submit" value="Atnaujinti">
                                </form>
                            </td>
                        </tr>
                    </table>
                    <?
                    echo "</div>";
                }
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