<?
/**
 * User login form.
 */

if (isset($form) && isset($session) && !$session->logged_in) {
    ?>
    <form action="process.php" method="POST" class="login" style="margin-top:20px;">
        <center style="font-size:18pt;"><b>Prisijungimas</b></label></center>
        <p style="text-align:left;">Vartotojo vardas:<br>
            <input class ="s1" name="user" type="text" value="<? echo $form->value("user"); ?>"/><br>
            <? echo $form->error("user"); ?>
        </p>
        <p style="text-align:left;">Slaptažodis:<br>
            <input class ="s1" name="pass" type="password" value="<? echo $form->value("pass"); ?>"/><br>
            <? echo $form->error("pass"); ?>
        </p>
        <p style="text-align:left;">
            <input type="submit" value="Prisijungti"/>
            <input type="checkbox" name="remember"
                <?
                if ($form->value("remember") != "") {
                    echo "Pažymėtas";
                }
                ?>/>
            Atsiminti
        </p>
        <input type="hidden" name="sublogin" value="1"/>
        <p>
            <a href="forgotpass.php">Negalite prisijungti?</a>&nbsp;&nbsp;
            <a href="register.php">Registracija</a>
        </p>
    </form>
    <?
}
?>