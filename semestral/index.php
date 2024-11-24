<?php
//start of the session
//session_start();

if (!isset($_COOKIE['user'])) {
    include "page/account.php";
}
else {
    include "page/main.php";
}

// remove all session variables
//session_unset();
// destroy the session
//session_destroy();