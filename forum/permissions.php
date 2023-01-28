<?php
/* Start session if none */
if (session_status() == PHP_SESSION_NONE) {

    if (isset($_GET["PHPSESSID"])) {
        session_id($_GET["PHPSESSID"]);
    }

    session_start();
}
/* Check if the user logged in */
if (!isset($_SESSION["user"])) {
    die(Header("Location: ./index.php"));
}
?>