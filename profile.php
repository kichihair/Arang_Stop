<?PHP
# Calling the header and connection file
include('header.php');
include('connection.php');

# Handle profile update submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = mysqli_real_escape_string($condb, $_POST['name']);
    $email = mysqli_real_escape_string($condb, $_POST['email']);
    $phone = mysqli_real_escape_string($condb, $_POST['phone']);
    $old_password = mysqli_real_escape_string($condb, $_POST['old_password']);
    $new_password = mysqli_real_escape_string($condb, $_POST['new_password']);

    # Retrieve the current password for the logged-in user
    $query = "SELECT password FROM customers WHERE customer_id = '" . $_SESSION['customer_id'] . "'";
    $result = mysqli_query($condb, $query);

    if ($result && $row = mysqli_fetch_assoc($result)) {
        # Verify if the entered old password matches the stored password
        if ($old_password === $row['password']) {
            # Update the user's profile and password
            $update_query = "
                UPDATE customers 
                SET name = '$name', email = '$email', phone = '$phone', password = '$new_password' 
                WHERE customer_id = '" . $_SESSION['customer_id'] . "'
            ";

            if (mysqli_query($condb, $update_query)) {
                $_SESSION['name'] = $name;
                $_SESSION['email'] = $email;
                $_SESSION['phone'] = $phone;

                $message = "Profile updated successfully.";
            } else {
                $message = "Error updating profile: " . mysqli_error($condb);
            }
        } else {
            $message = "The old password you entered is incorrect.";
        }
    } else {
        $message = "Error fetching user details.";
    }
}

# Query to fetch order history for the logged-in user, sorted by latest order date
$query = "
    SELECT 
        menu.item_name, 
        order_items.quantity, 
        orders.order_date, 
        orders.status, 
        orders.total_amount
    FROM 
        menu
    INNER JOIN 
        order_items ON menu.menu_id = order_items.menu_id
    INNER JOIN 
        orders ON orders.order_id = order_items.order_id
    WHERE 
        orders.customer_id = '" . $_SESSION['customer_id'] . "'
    ORDER BY 
        orders.order_date DESC"; // Added ORDER BY clause

# Execute query to get order history
$result = mysqli_query($condb, $query);
?>

<!-- Profile and Edit Modal -->
<div class='w3-row w3-margin'>
    <div class='w3-quarter w3-container w3-margin-bottom'>
        <div class='w3-container w3-card-2 w3-blue'>
            <h4 class='w3-tulisan-p2'>Profile</h4>
        </div>
        <div class='w3-container w3-card-2 w3-white'>
            <?PHP if (isset($message)) { echo "<p class='w3-text-green'>$message</p>"; } ?>
            <p class='w3-margin-top'>Name: <?PHP echo $_SESSION['name']; ?></p>
            <p>Email: <?PHP echo $_SESSION['email']; ?></p>
            <p>Phone No: <?PHP echo $_SESSION['phone']; ?></p>
            <p>Password: <?PHP echo str_repeat('*', strlen($_SESSION['password'])); ?></p>
            <button class="w3-button w3-blue w3-margin-bottom" onclick="document.getElementById('editProfileForm').style.display='block'">Edit Profile</button>
        </div>
    </div>

    <div id="editProfileForm" class="w3-modal">
        <div class="w3-modal-content w3-card-4 w3-animate-zoom" style="max-width:600px">
            <div class="w3-center"><br>
                <span onclick="document.getElementById('editProfileForm').style.display='none'" class="w3-button w3-xlarge w3-transparent w3-display-topright" title="Close Modal">&times;</span>
                <h2>Edit Profile</h2>
            </div>
            <form class="w3-container" method="POST">
                <label for="name">Name:</label>
                <input type="text" class="w3-input w3-margin-bottom" name="name" value="<?PHP echo $_SESSION['name']; ?>" required>
                <label for="email">Email:</label>
                <input type="email" class="w3-input w3-margin-bottom" name="email" value="<?PHP echo $_SESSION['email']; ?>" required>
                <label for="phone">Phone:</label>
                <input type="text" class="w3-input w3-margin-bottom" name="phone" value="<?PHP echo $_SESSION['phone']; ?>" required>
                <label for="old_password">Old Password:</label>
                <input type="password" class="w3-input w3-margin-bottom" name="old_password" required>
                <label for="new_password">New Password:</label>
                <input type="password" class="w3-input w3-margin-bottom" name="new_password" required>
                <button type="submit" class="w3-button w3-blue w3-margin-bottom">Update</button>
            </form>
        </div>
    </div>

    <!-- Order History Section -->
    <div class='w3-threequarter w3-container w3-margin-bottom'>
        <div class='w3-container w3-card-2 w3-blue'>
            <h4 class='w3-tulisan-p2'>Order History</h4>
        </div>
        <div class='w3-container w3-card-2 w3-white w3-center'>
            <?PHP
            if (mysqli_num_rows($result) > 0) {
                echo "
                <table class='w3-table-all w3-margin-top w3-margin-bottom'>
                    <tr>
                        <td>No</td>
                        <td>Menu</td>
                        <td>Order Date</td>
                        <td>Status</td>
                        <td>Price</td>
                    </tr>";
                $bil = 0;
                while ($record = mysqli_fetch_array($result)) {
                    echo "
                    <tr>
                        <td>" . ++$bil . "</td>
                        <td>" . $record['item_name'] . " x " . $record['quantity'] . "</td>
                        <td>" . $record['order_date'] . "</td>
                        <td>" . $record['status'] . "</td>
                        <td>RM " . $record['total_amount'] . "</td>
                    </tr>";
                }
                echo "</table>";
            } else {
                echo "<p> No Order History </p>";
            }
            ?>
        </div>
    </div>
</div>
