<!DOCTYPE HTML>
<html>
<head>
    <title>Add Booking</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="style/style.css" title="style" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script type="text/javascript">
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
// error_reporting 
error_reporting(E_ALL);
ini_set('display_errors', 1);

include "config.php"; 
$db_connection = new mysqli(DBHOST, DBUSER, DBPASSWORD, 'motueka');

if ($db_connection->connect_error) {
    echo "Error: Unable to connect to MySQL. " . $db_connection->connect_error;
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieving data from POST and cleaning it before using it in a request
    $customerID = $db_connection->real_escape_string($_POST['customerID']);
    $roomID = $db_connection->real_escape_string($_POST['roomID']);
    $checkInDate = $db_connection->real_escape_string($_POST['checkInDate']);
    $checkOutDate = $db_connection->real_escape_string($_POST['checkOutDate']);
    $numberAdults = $db_connection->real_escape_string($_POST['numberAdults']);
    $numberChildren = $db_connection->real_escape_string($_POST['numberChildren']);
    $totalPrice = 0; 

    // Preparing an insertion request
    $query = "INSERT INTO bookings (customerID, roomID, checkInDate, checkOutDate, numberAdults, numberChildren, totalPrice) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $db_connection->prepare($query);

    if ($stmt) {
        $stmt->bind_param('iissiid', $customerID, $roomID, $checkInDate, $checkOutDate, $numberAdults, $numberChildren, $totalPrice);
        if ($stmt->execute()) {
            echo "<h2>New booking added successfully.</h2>";
        } else {
            echo "<h2>Error adding new booking: " . $stmt->error . "</h2>";
        }
        $stmt->close();
    } else {
        echo "<h2>Error preparing statement: " . $db_connection->error . "</h2>";
    }
    $db_connection->close();
}
?>

<h1>Add Booking Details</h1>
<h2>
    <a href="index.php" class="button-style">Return to main page</a>
    <a href="browsebookings.php" class="button-style">Return to Booking List</a>
</h2>
<form action="addbooking.php" method="post" name="bookingForm" onsubmit="return validateForm();">
    <table border="1">
        <tr>
            <th>Detail</th>
            <th>Information</th>
        </tr>       
        <tr>
            <td>Customer</td>
            <td>
                <select name="customerID" required>
                    <?php
                    $customer_query = "SELECT customerID, firstname, lastname FROM customers";
                    $customer_result = $db_connection->query($customer_query);
                    while ($customer = $customer_result->fetch_assoc()) {
                        echo '<option value="'. htmlspecialchars($customer['customerID']) .'">' . htmlspecialchars($customer['firstname']) . ' ' . htmlspecialchars($customer['lastname']) . '</option>';
                    }
                    ?>
                </select>
            </td>
        </tr>

        <tr>
            <td>Search for Available Rooms</td>
            <td>
                <select name="roomID">
                <?php
                    $room_query = "SELECT roomID, roomname FROM rooms";
                    $room_result = $db_connection->query($room_query);
                    while ($room = $room_result->fetch_assoc()) {
                        echo '<option value="'. htmlspecialchars($room['roomID']) .'">' . htmlspecialchars($room['roomname']) . '</option>';
                    }
                    ?>
                </select>
            </td>
        </tr>

        <!--<tr>
            <td>Search for Available Rooms</td>
            <td>
            <label for="fromDate">Check-In Date:</label>
                <input type="date" id="fromDate" name="fromDate" required>
                
                <label for="toDate">Check-Out Date:</label>
                <input type="date" id="toDate" name="toDate" required>
                
                <input type="button" id="searchButton" value="Search Rooms" class="button-style">
            </td>
        </tr> -->


        <tr>
            <td>Check-In Date</td>
            <td><input type="date" name="checkInDate" required></td>
        </tr>
       
        <tr>
            <td>Check-Out Date</td>
            <td><input type="date" name="checkOutDate" required></td>
        </tr>
        <tr>
            <td>Number of Adults</td>
            <td>
                <select name="numberAdults">
                    <?php for ($i = 1; $i <= 10; $i++): ?>
                        <option value="<?php echo $i; ?>">
                            <?php echo $i; ?>
                        </option>
                    <?php endfor; ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>Number of Children</td>
            <td>
                <select name="numberChildren">
                    <?php for ($i = 0; $i <= 10; $i++): ?>
                        <option value="<?php echo $i; ?>">
                            <?php echo $i; ?>
                        </option>
                    <?php endfor; ?>
                </select>
            </td>
        </tr>
    </table>

    <h2>
        <!-- need to change CSS
    Sorry, I have not time for CSS! Merry X-mas and Happy New Year! -->
        <input type="submit" value="Add Booking" class="button-style">
    </h2>
</form>



<script>
$(document).ready(function() {
    $('form[name="bookingForm"]').on('submit', function(e) {
        e.preventDefault(); // Prevent standard form submission

        var formData = $(this).serialize(); // Serializing form data

        $.ajax({
            url: 'addbooking.php', // URL to process the form
            type: 'POST',
            data: formData,
            success: function(response) {
                alert('Reservation added successfully.');
            },
            error: function() {
                alert('Error adding a reservation.');
            }
        });
    });
});
$(document).ready(function() {

    function checkRoomAvailability() {
        var checkInDate = $('input[name="checkInDate"]').val();
        var checkOutDate = $('input[name="checkOutDate"]').val();

        if (checkInDate && checkOutDate) {
            $.ajax({
                url: 'check_availability.php',
                type: 'GET',
                data: {
                    'checkInDate': checkInDate,
                    'checkOutDate': checkOutDate
                },
                success: function(response) {
                    var rooms = JSON.parse(response);
                    var roomSelect = $('select[name="roomID"]');
                    roomSelect.empty(); 

                    $.each(rooms, function(index, room) {
                        roomSelect.append($('<option>', {
                            value: room.roomID,
                            text: room.roomname
                        }));
                    });
                }
            });
        }
    }

    // Call checkRoomAvailability when dates change
    $('input[name="checkInDate"], input[name="checkOutDate"]').on('change', checkRoomAvailability);
});

</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
$(document).ready(function() {
    $('#searchButton').click(function() {
        var fromDate = $('#fromDate').val();
        var toDate = $('#toDate').val();

        if (new Date(fromDate) >= new Date(toDate)) {
            alert('Check-out date must be after check-in date');
            return;
        }

        $.ajax({
            url: 'roomsearch.php',
            method: 'GET',
            data: {
                'fromDate': fromDate,
                'toDate': toDate
            },
            success: function(response) {
                var rooms = JSON.parse(response);
                var roomSelect = $('select[name="roomID"]');
                roomSelect.empty(); 

                rooms.forEach(function(room) {
                    roomSelect.append(new Option(room.roomname, room.roomID));
                });
            },
            error: function() {
                alert('Error searching for rooms');
            }
        });
    });
});
</script>


</body>
</html>
