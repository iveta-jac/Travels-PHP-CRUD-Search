<?
/**
 * This page is for users to view their account information
 */
include("include/session.php");
?>
<html>
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=9; text/html; charset=utf-8"/>
    <title>Mano paskyra</title>
    <link href="include/styles.css" rel="stylesheet" type="text/css" />
</head>
<body>
<table class="center" >
    <tr>
        <td>
            <center><img src="pictures/top.png"/></center>
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
                /* Requested Username error checking */
                if (isset($_GET['user'])) {
                    $req_user = trim($_GET['user']);
                } else {
                    $req_user = null;
                }
                if (!$req_user || strlen($req_user) == 0 ||
                    !eregi("^([0-9a-z])+$", $req_user) ||
                    !$database->usernameTaken($req_user)) {
                    echo "<br><br>";
                    die("Vartotojas nėra užsiregistravęs");
                }

                /* Display requested user information */
                $req_user_info = $database->getUserInfo($req_user);

                echo "<br><table border=1 style=\"text-align:left; margin-left:20px\" cellspacing=\"3\" cellpadding=\"3\"><tr><td><b>Vartotojo vardas: </b></td>"
                    . "<td>" . $req_user_info['username'] . "</td></tr>"
                    . "<tr><td><b>El. paštas:</b></td>"
                    . "<td>" . $req_user_info['email'] . "</td></tr></table><br>";

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