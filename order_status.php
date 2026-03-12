<?php
include('header.php');
include('connection.php');

// Ensure order_id is set in the session
if (!isset($_SESSION['order_id'])) {
    die("No Order Yet");
}

$order_id = $_SESSION['order_id']; // Get the order ID from session

// Fetch order status from the database
$query_status = "SELECT status FROM orders WHERE order_id = $order_id";
$result_status = mysqli_query($condb, $query_status);

if (!$result_status) {
    die("Database query failed: " . mysqli_error($condb));
}

$status_row = mysqli_fetch_assoc($result_status);
$order_status = $status_row['status'] ?? 'Unknown'; // Default to 'Unknown' if status is null
?>

<div class="w3-row">
    <div class="w3-quarter w3-container"></div>
    <div class="w3-half w3-container w3-margin-top w3-card-2">
        <div class="w3-margin w3-animate-opacity w3-center">
            <h4>Order Status</h4>
            
            <?php
            // Check the order status and display corresponding message
            if ($order_status == 'Completed') {
                echo "<p>No order status available. Your meal has been served and completed. Enjoy!</p>";
            } elseif ($order_status == 'In Progress') {
                echo "<p>Your current order status is: <b>" . htmlspecialchars($order_status) . "</b></p>";
                echo "<p class='w3-margin-top'>Thank you for your order! Please be patient while we prepare your meal. It will be served to you shortly, and we appreciate your understanding.</p>";
            } elseif ($order_status == 'Pending') {
                echo "<p>Your current order status is: <b>" . htmlspecialchars($order_status) . "</b></p>";
                echo "<p class='w3-margin-top'>Your payment has not been settled yet. Please settle it first to proceed with your order.</p>";
            } elseif ($order_status == 'Ready') {
                echo "<p>Your current order status is: <b>" . htmlspecialchars($order_status) . "</b></p>";
                echo "<p class='w3-margin-top'>Your food is ready to be served! Enjoy your meal!</p>";
            } else {
                echo "<p>Your current order status is: <b>" . htmlspecialchars($order_status) . "</b></p>";
                echo "<p class='w3-margin-top'>Thank you for your order! Please check back later for updates.</p>";
            }
            ?>
        </div>
    </div>
    <div class="w3-quarter w3-container"></div>
</div>

<?php
// Optionally, provide a button to return to the receipt page
echo '<a href="receipt.php" class="w3-button w3-blue w3-round-xxlarge w3-margin-top">BACK</a>';
?>
