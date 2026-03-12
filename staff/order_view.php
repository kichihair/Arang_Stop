<?PHP 
include('homepage.php'); 
?>

<div class='w3-container w3-deep-orange'>
<h5>ORDER</h5>
</div>
<div class='w3-container w3-card-2 w3-margin-bottom'>
<form class='w3-margin' action='' method='POST'>
<ul>
<?PHP
# Memanggil fail connection dari folder luaran
include('../connection.php');

# Pastikan order_id wujud dalam URL
if (!isset($_GET['order_id'])) {
    die("Error: Missing order_id parameter.");
}

# Mendapatkan order_id dari URL
$order_id = intval($_GET['order_id']); // Convert to integer for safety

# SQL untuk mendapatkan item berdasarkan order_id, join dengan menu untuk item_name
$item_query = "
    SELECT menu.item_name, order_items.quantity 
    FROM order_items 
    JOIN menu ON order_items.menu_id = menu.menu_id 
    WHERE order_items.order_id = $order_id
";
$item_result = mysqli_query($condb, $item_query);

if (!$item_result) {
    die("Query failed: " . mysqli_error($condb));
}

# Paparkan item_name dan quantity dalam format item_name x quantity
if (mysqli_num_rows($item_result) == 0) {
    echo "<p>No items found for this order.</p>";
} else {
    while ($item = mysqli_fetch_array($item_result)) {
        echo "{$item['item_name']} <b>x</b> {$item['quantity']}<br>";
    }
}

# SQL untuk mendapatkan status, order_type, dan table_no bagi order_id
$status_query = "SELECT status, order_type, table_no FROM orders WHERE order_id = $order_id";
$status_result = mysqli_query($condb, $status_query);

if (!$status_result) {
    die("Query failed: " . mysqli_error($condb));
}

$row = mysqli_fetch_array($status_result);
$current_status = $row['status'];
$order_type = $row['order_type']; // Get the order type
$table_no = $row['table_no']; // Get the table number
?>
</ul>

<!-- Display Order Details -->
<?php
echo "<label><b>Service Mode: </b>{$order_type}</label><br>";
if ($order_type == 'Dine In') {
    echo "<label><b>Table No: </b>{$table_no}</label><br>";
}
?>

<label><b>Current Status: </b><?php echo $current_status; ?></label>

<p><label><b>STATUS</b></label><p>
<select class='w3-select w3-border w3-round-large' name='new_status' required>
    <option disabled selected value>Choose Status</option>
    <?PHP
    # Retrieve all possible statuses, including "ready"
    $status_query = "SELECT DISTINCT status FROM orders";
    $status_result = mysqli_query($condb, $status_query);

    if (mysqli_num_rows($status_result) > 0) {
        while ($status_record = mysqli_fetch_array($status_result)) {
            # Check if the current status matches the status record
            $selected = ($status_record['status'] == $current_status) ? "selected" : "";
            echo "<option value='" . $status_record['status'] . "' $selected>" . $status_record['status'] . "</option>";
        }
    } else {
        echo "<option>No statuses found</option>";
    }
    ?>
</select>
<input class='w3-button w3-yellow w3-round-xxlarge w3-margin-top' type='submit' value='UPDATE'>
</form>
</div>
<div>
</div>
<?PHP
# menyemak kewujudan data POST
if (!empty($_POST)) {
    # mengambil data POST
    $new_status = $_POST['new_status'];

    # arahan untuk mengemaskini data ke dalam jadual orders
    $sql_update = "UPDATE orders SET status='$new_status' WHERE order_id=$order_id";

    if (mysqli_query($condb, $sql_update)) {
        echo "<script>alert('Update Successful');
        window.location.href='current_order.php';
        </script>";
    } else {
        echo "<script>alert('Update Failed: " . mysqli_error($condb) . "');
        window.history.back();</script>";
    }
}
?>
