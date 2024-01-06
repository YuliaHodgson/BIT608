<?php
include "config.php"; 

$db_connection = new mysqli(DBHOST, DBUSER, DBPASSWORD, 'motueka');
$fromDate = $db_connection->real_escape_string($_GET['fromDate']);
$toDate = $db_connection->real_escape_string($_GET['toDate']);


$query = "SELECT roomID, roomname FROM rooms WHERE roomID NOT IN (
            SELECT roomID FROM bookings 
            WHERE checkInDate <= ? AND checkOutDate >= ?
          )";

$stmt = $db_connection->prepare($query);

if ($stmt) {
    $stmt->bind_param('ss', $toDate, $fromDate);
    $stmt->execute();
    $result = $stmt->get_result();
    $rooms = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
} else {
    echo "Error preparing statement: " . $db_connection->error;
    exit;
}

$db_connection->close();
echo json_encode($rooms); 
?>
