<!DOCTYPE HTML>
<html>
<head>
    <title>Delete Single Booking</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
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

$bookingID = isset($_GET['id']) ? $_GET['id'] : '';

$query = 'SELECT customers.firstname, customers.lastname, customers.email, rooms.roomname, rooms.description, rooms.roomtype, rooms.beds, bookings.checkInDate, bookings.checkOutDate, bookings.numberAdults, bookings.numberChildren, bookings.totalPrice FROM bookings INNER JOIN customers ON bookings.customerID = customers.customerID INNER JOIN rooms ON bookings.roomID = rooms.roomID WHERE bookings.bookingID = ?';

$stmt = mysqli_prepare($db_connection, $query);
mysqli_stmt_bind_param($stmt, 'i', $bookingID);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($row = mysqli_fetch_assoc($result)) {
?>

<h1>Delete Customer Details</h1>
<h2>
    <a href='index.php' class="button-style">Return to main page</a>
    <a href="browsebookings.php" class="button-style">Return to Booking List</a>
</h2>
<table border="1">
    <tr>
        <th>Detail</th>
        <th>Information</th>
    </tr>
        <tr><td>First Name</td><td><?php echo htmlspecialchars($row['firstname']); ?></td></tr>
        <tr><td>Last Name</td><td><?php echo htmlspecialchars($row['lastname']); ?></td></tr>
        <tr><td>Email</td><td><?php echo htmlspecialchars($row['email']); ?></td></tr>
        <tr><td>Room Name</td><td><?php echo htmlspecialchars($row['roomname']); ?></td></tr>
        <tr><td>Description</td><td><?php echo htmlspecialchars($row['description']); ?></td></tr>
        <tr><td>Room Type</td><td><?php echo htmlspecialchars($row['roomtype']); ?></td></tr>
        <tr><td>Beds</td><td><?php echo htmlspecialchars($row['beds']); ?></td></tr>
        <tr><td>Check-In Date</td><td><?php echo htmlspecialchars($row['checkInDate']); ?></td></tr>
        <tr><td>Check-Out Date</td><td><?php echo htmlspecialchars($row['checkOutDate']); ?></td></tr>
        <tr><td>Number of Adults</td><td><?php echo htmlspecialchars($row['numberAdults']); ?></td></tr>
        <tr><td>Number of Children</td><td><?php echo htmlspecialchars($row['numberChildren']); ?></td></tr>
        <tr><td>Total Price</td><td><?php echo htmlspecialchars($row['totalPrice']); ?></td></tr>
</table>

    <h2 id="delete-confirmation">Are you sure you want to delete this booking?</h2>
    
    <h2>
        <form action="confirmdelete.php" method="post">
            <input type="hidden" name="bookingID" value="<?php echo $bookingID; ?>">
            <!-- need to change CSS for button submit-->
            <input type="submit" value="Yes" class="button-style"> 
            <input type="add" value="No" class="button-style" onclick="window.location='browsebookings.php';">
        </form>
    </h2>
<?php
} else {
    echo "<p>Booking not found.</p>";
}

mysqli_close($db_connection);
?>

</body>
</html>


