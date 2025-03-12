<?php

/* Procedural Database Connecrions */
$dbuser = "root"; /* Database Username */
$dbpass = ""; /* Database Username Password */
$host = "localhost"; /* Database Host */
$db = "rms";  /* Database Name */
$mysqli = new mysqli($host, $dbuser, $dbpass, $db); /* Connection Function */

/* Get Set Timezones */
$timezones_ret = "SELECT * FROM timezones";
$timezones_stmt = $mysqli->prepare($timezones_ret);
$timezones_stmt->execute(); //ok
$timezones_res = $timezones_stmt->get_result();
while ($timezone_settings = $timezones_res->fetch_object()) {
    /* Global Values */
    $timezone = $timezone_settings->timezone_name;
    $timezone_offset = str_replace(['UTC'], '', $timezone_settings->timezone_utcoffset);

    global $timezone, $timezone_offset;
}
