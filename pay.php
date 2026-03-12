<?php
session_start();
include('connection.php');

// Validate payment details
if (empty($_POST['name_on_card']) || empty($_POST['card_no']) || 
    empty($_POST['month']) || empty($_POST['year']) || 
    empty($_POST['code']) || empty($_POST['address']) || 
    empty($_POST['postcode'])) 
{
    echo "<script>alert('Please fill out all payment details.'); window.location.href='checkout.php';</script>";
    exit;
}

// Ensure the cart and order type are valid
if (empty($_SESSION['cart']) || empty($_SESSION['order_type'])) {
    echo "<script>alert('Invalid order data.'); window.location.href='cart.php';</script>";
    exit;
}

$total_amount = 0;
$order_type = $_SESSION['order_type']; // Get the order type
$payment_type = "online"; // Set payment type
$table_no = isset($_POST['table_no']) ? intval($_POST['table_no']) : null;

$sql_keep = "
    INSERT INTO orders (customer_id, order_date, order_type, status, payment_type, total_amount, table_no)
    VALUES ('" . $_SESSION['customer_id'] . "', NOW(), '$order_type', 'in progress', '$payment_type', 0, '$table_no')";


if (mysqli_query($condb, $sql_keep)) {
    $order_id = mysqli_insert_id($condb); // Get the last inserted order ID

    // Insert order items
    foreach ($_SESSION['cart'] as $menu_id => $quantity) {
        $query = "SELECT price FROM menu WHERE menu_id = $menu_id";
        $result = mysqli_query($condb, $query);

        if ($result && $item = mysqli_fetch_assoc($result)) {
            $price = $item['price'];
            $total_price = $price * $quantity;
            $total_amount += $total_price;

            $sql_keep_items = "
                INSERT INTO order_items (order_id, menu_id, quantity, total_price)
                VALUES ('$order_id', '$menu_id', '$quantity', '$total_price')";

            if (!mysqli_query($condb, $sql_keep_items)) {
                echo "<script>alert('Failed to save order items.');</script>";
                exit;
            }
        }
    }

    // Update the total amount in the `orders` table
    $update_order_amount = "
        UPDATE orders
        SET total_amount = '$total_amount'
        WHERE order_id = '$order_id'";

    if (!mysqli_query($condb, $update_order_amount)) {
        echo "<script>alert('Failed to update total amount.');</script>";
        exit;
    }

    // Store order_id and order_type in session for use in the receipt page
    $_SESSION['order_id'] = $order_id;
    $_SESSION['order_type'] = $order_type;

    echo "<script>alert('Payment successful!'); window.location.href='receipt.php';</script>";
} else {
    echo "<script>alert('Order submission failed.');</script>";
}
?>