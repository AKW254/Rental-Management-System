<?php


/* Load This File Anywhere You Want To Pass Alert Via Session */

/* Success Alert Via Session */
if (isset($_SESSION['success'])) {
    $success = $_SESSION['success'];
    unset($_SESSION['success']);
}
