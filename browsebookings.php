<!DOCTYPE HTML>
<html><head><title>Browse Bookings</title>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="website description" />
    <meta name="keywords" content="website keywords, website keywords" />
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    <link rel="stylesheet" type="text/css" href="style/style.css" title="style" />
</head>
<body>

<?php 
error_reporting(E_ALL);  
ini_set('display_errors', 1);  

include "config.php"; 
$db_connection = mysqli_connect(DBHOST, DBUSER, DBPASSWORD, 'motueka');

if (mysqli_connect_errno()) {
    echo "Error: Unable to connect to MySQL. " . mysqli_connect_error();
    exit;
}

$query = 'SELECT bookings.bookingID, customers.firstName, customers.lastName, bookings.roomID, bookings.checkInDate, bookings.checkOutDate FROM bookings INNER JOIN customers ON bookings.customerID = customers.customerID ORDER BY checkInDate';
$result = mysqli_query($db_connection, $query);
$rowcount = mysqli_num_rows($result);
?>

<h1>Booking List</h1>
<h2>
    <a href='addbooking.php' class="button-style">Add a Booking</a>
    <a href="index.php" class="button-style">Return to main page</a>
</h2>
<table border="1">
    <thead><tr><th>First Name</th>
            <th>Last Name</th>
            <th>Room</th>
            <th>Date In</th>
            <th>Date Out</th>
            <th>Actions</th>
        </tr>
    </thead>
<tbody>
<?php
if ($rowcount > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['firstName']) . "</td>";
        echo "<td>" . htmlspecialchars($row['lastName']) . "</td>";
        echo "<td>" . htmlspecialchars($row['roomID']) . "</td>";
        echo "<td>" . htmlspecialchars($row['checkInDate']) . "</td>";
        echo "<td>" . htmlspecialchars($row['checkOutDate']) . "</td>";

        echo "<td>";
        echo "<form action='viewsinglebooking.php' method='get' class='inline-form'>";
        echo "<input type='hidden' name='id' value='" . urlencode($row['bookingID']) . "'>";
        echo "<input type='submit' value='View' class='table-button view-button'>";
        echo "</form> ";
        
        echo "<form action='editbooking.php' method='get' class='inline-form'>";
        echo "<input type='hidden' name='id' value='" . urlencode($row['bookingID']) . "'>";
        echo "<input type='submit' value='Edit' class='table-button edit-button'>";
        echo "</form> ";
        
        echo "<form action='deletebooking.php' method='get' class='inline-form'>";
        echo "<input type='hidden' name='id' value='" . urlencode($row['bookingID']) . "'>";
        echo "<input type='submit' value='Delete' class='table-button delete-button'>";
        echo "</form>";
        echo "</td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='6'>No bookings found</td></tr>";
}
?>
</tbody>
</table>

</body>
</html>
