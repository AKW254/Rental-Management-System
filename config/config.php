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
//Google Maps API Key
 /* Google Maps API Key */
$config = [
    'google_maps_api_key' => ''
];

/*Mpesa config*/
$sql="SELECT * FROM mpesa_config LIMIT 1";
$res=$mysqli->query($sql);
$mpesa_settings=$res->fetch_object();
return [
    'consumerKey' => $mpesa_settings->consumer_key,
    'consumerSecret' => $mpesa_settings->consumer_secret,
   //shortcode' => $mpesa_settings->lipa_na_mpesa_online_shortcode,
    //ipaNaMpesaOnlinePasskey' => $mpesa_settings->lipa_na_mpesa_online_passkey,
    //ipaNaMpesaOnlineShortcode' => $mpesa_settings->lipa_na_mpesa_online_shortcode,
    'callbackUrl' => $mpesa_settings->callback_url,
];