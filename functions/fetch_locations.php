<?php
include('../config/config.php');
header('Content-Type: application/json');

$sql = "SELECT latitude,longitude FROM user_locations";
$result = $mysqli->query($sql);

$locations = [];

while ($row = $result->fetch_assoc()) {
    $locations[] = $row;
}

echo json_encode($locations);
