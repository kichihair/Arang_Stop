<?php
include('header.php');
include('connection.php');

// Ensure order_id is set in the session
if (!isset($_SESSION['order_id'])) {
    die("No Order Yet");
}

// Retrieve cart data from the session
$cart = $_SESSION['cart'] ?? [];
$total_amount = 0;

// Get order_id and order_type from the session
$order_id = $_SESSION['order_id']; // Get the order ID from session
$order_type = $_SESSION['order_type']; // Get the order type from session

// Fetch order details
$query_order_type = "SELECT order_type FROM orders WHERE order_id = $order_id";
$result_order_type = mysqli_query($condb, $query_order_type);

if (!$result_order_type) {
    die("Database query failed: " . mysqli_error($condb));
}

// Prepare data for printing and calculate total amount
$data_get = [
    'cart' => json_encode($cart),  // Encode cart as JSON string
    'total_amount' => $total_amount,
    'order_type' => $order_type, // Add the order type
];

// Calculate the total amount for the cart
foreach ($cart as $menu_id => $quantity) {
    $query = "SELECT * FROM menu WHERE menu_id = $menu_id";
    $result = mysqli_query($condb, $query);
    if ($result) {
        $item = mysqli_fetch_assoc($result);
        $price = $item['price'];
        $total_price = $price * $quantity;
        $total_amount += $total_price;
    }
}

$data_get['total_amount'] = $total_amount;  // Add the total_amount to data_get

// Initialize table_no with a default value if not set
$table_no = $_SESSION['table_no'] ?? null;

// Fetch payment_type from the orders table
$query_payment_type = "SELECT payment_type FROM orders WHERE order_id = $order_id";
$result_payment_type = mysqli_query($condb, $query_payment_type);

if ($result_payment_type && mysqli_num_rows($result_payment_type) > 0) {
    $row = mysqli_fetch_assoc($result_payment_type);
    $payment_type = $row['payment_type'];
} else {
    die("Error fetching payment type: " . mysqli_error($condb));
}


$data_get['payment_type'] = $payment_type;
?>


<div class="w3-row">
    <div class="w3-quarter w3-container"></div>
    <div class="w3-half w3-container w3-margin-top w3-card-2">
        <div class="w3-margin w3-animate-opacity">
            <!-- Displays order -->
            <h4>Order Detail</h4>
            <ul class="w3-ul">
			<!-- Display order type -->
			<div class="w3-margin-top">
    <b>Service Mode:</b> 
    <?php echo $order_type == 'Take Out' ? 'Take-Out' : 'Dine-In'; ?>
    <?php if ($order_type == 'Dine In'): ?>
        <br>
        <b>Table Number:</b> <?php echo htmlspecialchars($table_no); ?>
    <?php endif; ?>
</div>
<hr>
<?php
// Save table number in the session if submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['table_no'])) {
    $table_no = (int)$_POST['table_no'];
    if ($table_no >= 1 && $table_no <= 20) {
        $_SESSION['table_no'] = $table_no;
    } else {
        echo "<script>alert('Table number must be between 1 and 20.');</script>";
    }
}

// Add the table number to the data sent to print.php
$table_no = $_SESSION['table_no'] ?? '';
$data_get['table_no'] = $table_no;
?>

                <?php
                if (!empty($cart)) {
                    foreach ($cart as $menu_id => $quantity) {
                        $query = "SELECT * FROM menu WHERE menu_id = $menu_id";
                        $result = mysqli_query($condb, $query);
                        if ($result) {
                            $item = mysqli_fetch_assoc($result);
                            $item_name = htmlspecialchars($item['item_name']);
                            $price = $item['price'];
                            $total_price = $price * $quantity;
                            echo "
                            <li>
                                $item_name <b>x</b> $quantity 
                                <span>(RM" . number_format($price, 2) . " each)</span><br>
                                <b>Price:</b> RM" . number_format($total_price, 2) . "
                            </li>";
                        }
                    }
                }
                ?>
            </ul>
            <div class="w3-right-align w3-margin-top">
                <b>Total Price: RM<?php echo number_format($total_amount, 2); ?></b>
            </div>
            <hr>

            <!-- SAVE Button -->
<a href="javascript:void(0);" onclick="saveOrder()" class="w3-button w3-blue-grey w3-round-xxlarge w3-margin-bottom">RECEIPT</a>

<script>
    function saveOrder() {
        // Display the alert
        alert('Order confirmation is sent to your email successfully.');

        // Open the print.php page in a new tab
        const printWindow = window.open('print.php?<?php echo http_build_query($data_get); ?>', '_blank');
        if (printWindow) {
            printWindow.focus();
        } else {
            alert('Please allow pop-ups for this website.');
        }
    }
</script>



            <!-- PRINT Button -->
            <button onclick="printOrder()" class="w3-button w3-green w3-round-xxlarge w3-margin-bottom">PRINT</button>

            <script>
                function printOrder() {
                    // Open print.php in a new tab
                    const printWindow = window.open('print.php?<?php echo http_build_query($data_get); ?>', '_blank');
                    printWindow.focus();

                    // Wait for the content to load, then trigger the print dialog
                    printWindow.onload = function () {
                        printWindow.print();
                    };
                }
            </script
			
			<!-- Order Status Button -->
<a href="order_status.php" class="w3-button w3-orange w3-round-xxlarge w3-margin-bottom">ORDER STATUS</a>

        </div>
    </div>
    <div class="w3-quarter w3-container"></div>
</div>
