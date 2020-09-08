<?
/**
 * The Mailer class is meant to simplify the task of sending
 * emails to users. Note: this email system will not work
 * if your server is not setup to send mail.
 *
 * If you are running Windows and want a mail server, check
 * out this website to see a list of freeware programs:
 * <http://www.snapfiles.com/freeware/server/fwmailserver.html>
 */

class Mailer {

    /**
     * sendWelcome - Sends a welcome message to the newly
     * registered user, also supplying the username and
     * password.
     */
    function sendWelcome($user, $email, $pass) {
        $headers = "From: " . EMAIL_FROM_NAME . " <" . EMAIL_FROM_ADDR . ">\r\n";
        $headers .= "Content-type: text; charset=UTF-8\r\n";
        $subject = "Kelionės - Registracija";
        $body = $user . ",\n\n"
            . "Sveiki! Jūs užsiregistravote į Kelionių sistemą "
            . "su sekančiais duomenimis:\n\n"
            . "Vartotojo vardas: " . $user . "\n"
            . "Slaptažodis: " . $pass . "\n\n";
        return mail($email, $subject, $body, $headers);
    }

    /**
     * sendNewPass - Sends the newly generated password
     * to the user's email address that was specified at
     * sign-up.
     */
    function sendNewPass($user, $email, $pass) {
        $headers = "From: " . EMAIL_FROM_NAME . " <" . EMAIL_FROM_ADDR . ">\r\n";
        $headers .= "Content-type: text; charset=UTF-8\r\n";
        $subject = "Kelionės - Naujas slaptažodis";
        $body = $user . ",\n\n"
            . "Jūsų naujas slaptažodis:\n\n"
            . "Vartotojo vardas: " . $user . "\n"
            . "Naujas slaptažodis: " . $pass . "\n\n";
        return mail($email, $subject, $body, $headers);
    }
}

/* Initialize mailer object */
$mailer = new Mailer;
?>