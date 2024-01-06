<!DOCTYPE HTML>
<html>
<head>
    <title>Edit Booking</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="style/style.css" title="style" />
    <script type="text/javascript">
        function confirmEdit() {
            return confirm("Are you sure you want to change this?");
        }
        function validateForm() {
        var checkInDate = document.forms["bookingForm"]["checkInDate"].value;
        var checkOutDate = document.forms["bookingForm"]["checkOutDate"].value;
        if (checkInDate === "" || checkOutDate === "") {
            alert("Both check-in and check-out dates must be filled out");
            return false;
        }
        if (new Date(checkInDate) >= new Date(checkOutDate)) {
            alert("Check-out date must be after check-in date");
            return false;
        }
        return true;
    }
    </script>
</head>
<body>

<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

include "config.php";
$db_connection = new mysqli(DBHOST, DBUSER, DBPASSWORD, 'motueka');
$success = false; 

if ($db_connection->connect_error) {
    die("Connection failed: " . $db_connection->connect_error);
}

$bookingID = 0; 
$booking = null; 

if (isset($_GET['bookingID'])) {
    $bookingID = $db_connection->real_escape_string($_GET['bookingID']);
    
    $query = "SELECT b.*, c.firstname, c.lastname, c.email 
              FROM bookings b 
              INNER JOIN customers c ON b.customerID = c.customerID 
              WHERE b.bookingID = ?";

    $stmt = $db_connection->prepare($query);
    $stmt->bind_param('i', $bookingID);

    if (!$stmt->execute()) {
        echo "Error executing the request: " . $stmt->error;
    } else {
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $booking = $result->fetch_assoc();
        } else {
            echo "No booking found with the given ID.";
        }
    }
    $stmt->close();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['bookingID'])) {
    $firstname = $db_connection->real_escape_string($_POST['firstname']);
    $lastname = $db_connection->real_escape_string($_POST['lastname']);
    $email = $db_connection->real_escape_string($_POST['email']);

    $update_query = "UPDATE bookings SET firstname = ?, lastname = ?, email = ? WHERE bookingID = ?";
    $update_stmt = $db_connection->prepare($update_query);
    $update_stmt->bind_param('sssi', $firstname, $lastname, $email, $bookingID);

    if ($update_stmt->execute()) {
        echo "<p>Edit booking updated successfully.</p>";
    } else {
        echo "<p>Error updating booking: " . $update_stmt->error . "</p>";
    }
    $update_stmt->close();
}
?>

<h1>Edit Booking Details</h1>
<h2>
    <a href="index.php" class="button-style">Return to main page</a>
    <a href="browsebookings.php" class="button-style">Return to Booking List</a>
</h2>
<form action="editbooking.php?bookingID=<?php echo $bookingID; ?>" method="post">
    <table border="1">
        <tr>
            <th>Detail</th>
            <th>Information</th>
        </tr>
        <input type="hidden" name="bookingID" value="<?php echo $bookingID; ?>" />
        <tr>
            <td>First Name</td>
            <td><input type="text" name="firstname" value="<?php echo htmlspecialchars($booking['firstname'] ?? ''); ?>" required></td>
        </tr>
        <tr>
            <td>Last Name</td>
            <td><input type="text" name="lastname" value="<?php echo htmlspecialchars($booking['lastname'] ?? ''); ?>" required></td>
        </tr>
        <tr>
            <td>Email</td>
            <td><input type="email" name="email" value="<?php echo htmlspecialchars($booking['email'] ?? ''); ?>" required></td>
        </tr>
        <tr>
            <td>Room Name</td>
            <td>
                <select name="roomID" required>
                <?php
                    $room_query = "SELECT roomID, roomname FROM rooms";
                    if ($room_result = $db_connection->query($room_query)) {
                        while ($room = $room_result->fetch_assoc()) {
                            $selected = (isset($booking['roomID']) && $booking['roomID'] == $room['roomID']) ? 'selected' : '';
                            echo '<option value="'. htmlspecialchars($room['roomID']) .'" '. $selected .'>' . htmlspecialchars($room['roomname']) . '</option>';
                        }
                    }    
                ?>
                </select>
            </td>
        </tr>
        
        <tr>
            <td>Check-In Date</td>
            <td><input type="date" name="checkInDate" value="<?php echo htmlspecialchars($booking['checkInDate'] ?? ''); ?>" required></td>
        </tr>
        <tr>
            <td>Check-Out Date</td>
            <td><input type="date" name="checkOutDate" value="<?php echo htmlspecialchars($booking['checkOutDate'] ?? ''); ?>" required></td>
        </tr>
        <tr>
            <td>Number of Adults</td>
            <td>
                <select name="numberAdults" required>
                    <?php for ($i = 1; $i <= 10; $i++): ?>
                        <option value="<?php echo $i; ?>" <?php if ((int)($booking['numberAdults'] ?? 1) === $i) echo 'selected'; ?>>
                            <?php echo $i; ?>
                        </option>
                    <?php endfor; ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>Number of Children</td>
            <td>
                <select name="numberChildren" required>
                    <?php for ($i = 0; $i <= 10; $i++): ?>
                        <option value="<?php echo $i; ?>" <?php if ((int)($booking['numberChildren'] ?? 0) === $i) echo 'selected'; ?>>
                            <?php echo $i; ?>
                        </option>
                    <?php endfor; ?>
                </select>
            </td>
        </tr>
        
        <input type="hidden" name="bookingID" value="<?php echo $bookingID; ?>"> 
    </table>
    
    <h2>
        <!-- need to change CSS
    Sorry, I have not time for CSS! Merry X-mas and Happy New Year! -->
        <input type="submit" value="Edit Booking" class="button-style">
    </h2>

</form>

</body>
</html>

