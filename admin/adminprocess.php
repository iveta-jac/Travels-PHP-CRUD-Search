<?
/**
 * The AdminProcess class is meant to simplify the task of processing
 * admin submitted forms from the admin center, these deal with
 * member system adjustments.
 */

include("../include/session.php");

class AdminProcess {

    /* Class constructor */
    function AdminProcess() {
        global $session;
        /* Make sure administrator is accessing page */
        if (!$session->isAdmin()) {
            header("Location: ../index.php");
            return;
        }
        /* Admin submitted update user level form */
        if (isset($_POST['subupdlevel'])) {
            $this->procUpdateLevel();
        }
        /* Admin submitted delete user form */
        else if (isset($_POST['subdeluser'])) {
            $this->procDeleteUser();
        }
        /* Admin submitted delete inactive users form */
        else if (isset($_POST['subdelinact'])) {
            $this->procDeleteInactive();
        }
        /* Admin submitted ban user form */
        else if (isset($_POST['subbanuser'])) {
            $this->procBanUser();
        }
        /* Admin submitted delete banned user form */
        else if (isset($_POST['subdelbanned'])) {
            $this->procDeleteBannedUser();
        }
        /* Admin submitted delete entry form */
        else if (isset($_POST['subdelentry'])) {
            $this->procDeleteEntry();
        }
        /* Admin submitted edit entry form */
        else if (isset($_POST['subedit'])) {
            $this->procUpdateEntry();
        }
        /* Should not get here, redirect to home page */
        else {
            header("Location: ../index.php");
        }
    }

    /**
     * procUpdateLevel - If the submitted username is correct,
     * their user level is updated according to the admin's
     * request.
     */
    function procUpdateLevel() {
        global $session, $database, $form;
        /* Username error checking */
        $subuser = $this->checkUsername("upduser");

        /* Errors exist, have user correct them */
        if ($form->num_errors > 0) {
            $_SESSION['value_array'] = $_POST;
            $_SESSION['error_array'] = $form->getErrorArray();
            header("Location: " . $session->referrer);
        }
        /* Update user level */
        else {
            $database->updateUserField($subuser, "userlevel", (int) $_POST['updlevel']);
            header("Location: " . $session->referrer);
        }
    }

    /**
     * procUpdateEntry - if the submitted entry name is correct,
     * upadating all details of entry.
     */
    function procUpdateEntry() {
        global $session, $database;

        $field = "pavadinimas";  //Use field name for travels

        $id = $_POST['subedit'];
        $name = $_POST['pavadinimas'];
        $continent = $_POST['zemynas'];
        $duration = $_POST['trukme'];

        $seasons = "";
        foreach($_POST['metulaikas'] as $season) {
            $seasons .= $season . " ";  /* use space, because in my case it's one word. If there would be two words then it should be separated for example by a comma. Otherwise, if a space is repeated then it would be impossible to separate them */
        }

        $traveltype = $_POST['kelionestipas'];

        /* Update travels details */
        $q = "UPDATE " . TBL_TRAVELS .
            " SET name = '$name', continent = '$continent', duration = '$duration', seasons = '$seasons', traveltype = '$traveltype' WHERE id = '$id'";
        $database->query($q);
        header("Location: ../operacija2.php");
    }

    /**
     * procDeleteUser - If the submitted username is correct,
     * the user is deleted from the database.
     */
    function procDeleteUser() {
        global $session, $database, $form;
        /* Username error checking */
        $subuser = $this->checkUsername("deluser");

        /* Errors exist, have user correct them */
        if ($form->num_errors > 0) {
            $_SESSION['value_array'] = $_POST;
            $_SESSION['error_array'] = $form->getErrorArray();
            header("Location: " . $session->referrer);
        }
        /* Delete user from database */
        else {
            $q = "DELETE FROM " . TBL_USERS . " WHERE username = '$subuser'";
            $database->query($q);
            header("Location: " . $session->referrer);
        }
    }

    /**
     * procDeleteInactive - All inactive users are deleted from
     * the database, not including administrators. Inactivity
     * is defined by the number of days specified that have
     * gone by that the user has not logged in.
     */
    function procDeleteInactive() {
        global $session, $database;
        $inact_time = $session->time - $_POST['inactdays'] * 24 * 60 * 60;
        $q = "DELETE FROM " . TBL_USERS . " WHERE timestamp < $inact_time "
            . "AND userlevel != " . ADMIN_LEVEL;
        $database->query($q);
        header("Location: " . $session->referrer);
    }

    /**
     * procBanUser - If the submitted username is correct,
     * the user is banned from the member system, which entails
     * removing the username from the users table and adding
     * it to the banned users table.
     */
    function procBanUser() {
        global $session, $database, $form;
        /* Username error checking */
        $subuser = $this->checkUsername("banuser");

        /* Errors exist, have user correct them */
        if ($form->num_errors > 0) {
            $_SESSION['value_array'] = $_POST;
            $_SESSION['error_array'] = $form->getErrorArray();
            header("Location: " . $session->referrer);
        }
        /* Ban user from member system */
        else {
            $q = "DELETE FROM " . TBL_USERS . " WHERE username = '$subuser'";
            $database->query($q);

            $q = "INSERT INTO " . TBL_BANNED_USERS . " VALUES ('$subuser', $session->time)";
            $database->query($q);
            header("Location: " . $session->referrer);
        }
    }

    /**
     * procDeleteBannedUser - If the submitted username is correct,
     * the user is deleted from the banned users table, which
     * enables someone to register with that username again.
     */
    function procDeleteBannedUser() {
        global $session, $database, $form;
        /* Username error checking */
        $subuser = $this->checkUsername("delbanuser", true);

        /* Errors exist, have user correct them */
        if ($form->num_errors > 0) {
            $_SESSION['value_array'] = $_POST;
            $_SESSION['error_array'] = $form->getErrorArray();
            header("Location: " . $session->referrer);
        }
        /* Delete user from database */
        else {
            $q = "DELETE FROM " . TBL_BANNED_USERS . " WHERE username = '$subuser'";
            $database->query($q);
            header("Location: " . $session->referrer);
        }
    }

    /**
     * checkUsername - Helper function for the above processing,
     * it makes sure the submitted username is valid, if not,
     * it adds the appropritate error to the form.
     */
    function checkUsername($uname, $ban = false) {
        global $database, $form;
        /* Username error checking */
        $subuser = $_POST[$uname];
        $field = $uname;  //Use field name for username
        if (!$subuser || strlen($subuser = trim($subuser)) == 0) {
            $form->setError($field, "* Neįvedėte vartotojo vardo<br>");
        } else {
            /* Make sure username is in database */
            $subuser = stripslashes($subuser);
            if (strlen($subuser) < 5 || strlen($subuser) > 30 ||
                !eregi("^([0-9a-z])+$", $subuser) ||
                (!$ban && !$database->usernameTaken($subuser))) {
                $form->setError($field, "* Tokio vartotojo nėra<br>");
            }
        }
        return $subuser;
    }

    /**
     * procDeleteEntry - the entry is deleted from the database.
     */
    function procDeleteEntry() {
        global $session, $database;

        $entryid = $_POST['subdelentry'];
        $q = "DELETE FROM " . TBL_TRAVELS . " WHERE id = '$entryid'";
        $database->query($q);
        header("Location: " . $session->referrer);
    }
}

/* Initialize process */
$adminprocess = new AdminProcess;
?>