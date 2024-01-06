<?php
// check_availability.php

include "config.php"; 

$db_connection = new mysqli(DBHOST, DBUSER, DBPASSWORD, 'motueka');
$checkInDate = $db_connection->real_escape_string($_GET['checkInDate']);
$checkOutDate = $db_connection->real_escape_string($_GET['checkOutDate']);

// SQL запрос для поиска доступных номеров
$query = "SELECT roomID, roomname FROM rooms WHERE roomID NOT IN (
            SELECT DISTINCT roomID FROM bookings 
            WHERE checkInDate < '$checkOutDate' AND checkOutDate > '$checkInDate'
          )";

$result = $db_connection->query($query);
$rooms = array();
while ($room = $result->fetch_assoc()) {
    $rooms[] = $room;
}

$db_connection->close();
echo json_encode($rooms); 
?>