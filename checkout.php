<?php
include('header.php');
include('connection.php');

// Handle POST data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['cart'])) {
        $cartData = json_decode($_POST['cart'], true);
        $_SESSION['cart'] = $cartData; // Update session with cart data
    }

    if (isset($_POST['order_type'])) {
        $_SESSION['order_type'] = $_POST['order_type']; // Save order type in session
    }

    if (isset($_POST['table_no'])) {
        $_SESSION['table_no'] = intval($_POST['table_no']); // Save table number in session
    }
}

// Retrieve session data
$cart = $_SESSION['cart'] ?? [];
$total_amount = 0;
$order_type = $_SESSION['order_type'] ?? 'Not Selected';
$table_no = $_SESSION['table_no'] ?? 'Not Provided';

?>


<script>
    window.onload = function() {
        // Check if cart exists in localStorage
        let cart = JSON.parse(localStorage.getItem("cart"));
        if (cart && Object.keys(cart).length > 0) {
            // Send cart data to server (via POST request)
            const formData = new FormData();
            formData.append('cart', JSON.stringify(cart));

            fetch('checkout.php', {
                method: 'POST',
                body: formData
            }).then(response => response.json())
              .then(data => {
                  console.log('Cart data synced successfully.');
              }).catch(error => {
                  console.error('Error syncing cart data:', error);
              });
        }
    };
</script>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
</head>
<body>
<div class="w3-row">
    <div class="w3-quarter w3-container"></div>
    <div class="w3-half w3-container w3-margin-top w3-card-2">
        <div class='w3-margin w3-animate-opacity'>
            <h4>Order Detail</h4>
			<div class="w3-center" style="display: flex; align-items: center; justify-content: center; gap: 10px;">
    <p style="margin: 0;"><strong>Service Mode:</strong> <?php echo htmlspecialchars($order_type); ?></p>
    <?php if ($order_type === "Dine In") { ?>
        <p style="margin: 0; margin-left: 10px;"><strong>Table No:</strong> <?php echo htmlspecialchars($table_no); ?></p>
    <?php } ?>
    <form action="order_type.php" method="GET" style="margin: 0;">
        <button class="w3-button w3-blue w3-round" type="submit">Change</button>
    </form>
</div>

            <ul class="w3-ul w3-margin-top">
                <?php
                if (!empty($cart)) {
                    foreach ($cart as $menu_id => $quantity) {
                        // Fetch item details from the database
                        $query = "SELECT * FROM menu WHERE menu_id = $menu_id";
                        $result = mysqli_query($condb, $query);
                        if ($result) {
                            $item = mysqli_fetch_assoc($result);
                            $item_name = htmlspecialchars($item['item_name']);
                            $price = $item['price'];
                            $total_price = $price * $quantity;
                            $total_amount += $total_price;

                            echo "
                            <li>
                                $item_name <b>x</b> $quantity 
                                <span>(RM" . number_format($price, 2) . " each)</span><br>
                                <b>Price:</b> RM" . number_format($total_price, 2) . "<br>
                            </li>";
                        }
                    }
                } else {
                    echo "<li>Your cart is empty.</li>";
                }
                ?>
            </ul>
            <div class="w3-right-align w3-margin-top">
                <b>Total Price: RM<?php echo number_format($total_amount, 2); ?></b>
            </div>
            <h4>Payment by card only</h4>
            <hr>
            <form action="pay.php" method="POST" onsubmit="return validatePaymentForm()">
    <input type="hidden" name="order_type" value="<?php echo htmlspecialchars($order_type); ?>">
    <input type="hidden" name="table_no" value="<?php echo htmlspecialchars($table_no); ?>">
                <table class="w3-table w3-striped">
                    <tr>
                        <td colspan="3">
                            <input class="w3-input w3-border w3-round-xxlarge" type="text" name="name_on_card" id="name_on_card" placeholder="Name on Card" required>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3">
                            <input class="w3-input w3-border w3-round-xxlarge" type="text" name="card_no" id="card_no" placeholder="Card Number" maxlength="12" required>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input class="w3-input w3-border w3-round-xxlarge" size="3" maxlength="2" type="text" name="month" id="month" placeholder="MM" required>
                        </td>
                        <td>
                            <input class="w3-input w3-border w3-round-xxlarge" size="3" maxlength="4" type="text" name="year" id="year" placeholder="YYYY" required>
                        </td>
                        <td>
                            <input class="w3-input w3-border w3-round-xxlarge" size="3" maxlength="3" type="text" name="code" id="code" placeholder="CCV" required>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3">
                            <input class="w3-input w3-border w3-round-xxlarge" type="text" name="address" id="address" placeholder="Address" required>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3">
                            <input class="w3-input w3-border w3-round-xxlarge" maxlength="5" type="text" name="postcode" id="postcode" placeholder="Postcode" required>
                        </td>
                    </tr>
                </table>
                <hr>
                <input class="w3-button w3-round-xxlarge w3-blue-grey w3-bar" type="submit" value="Pay">
            </form>
			<form action="cashier.php" method="POST">
    <input type="hidden" name="order_type" value="<?php echo htmlspecialchars($order_type); ?>">
    <input type="hidden" name="table_no" value="<?php echo htmlspecialchars($table_no); ?>">
    <input class="w3-button w3-round-xxlarge w3-blue w3-bar w3-margin-top" type="submit" value="Pay at the Counter">
</form>
        </div>
    </div>
    <div class="w3-quarter w3-container"></div>
</div>

<script>
    function validatePaymentForm() {
        const fields = [
            { id: 'name_on_card', name: 'Name on Card' },
            { id: 'card_no', name: 'Card Number' },
            { id: 'month', name: 'Month' },
            { id: 'year', name: 'Year' },
            { id: 'code', name: 'CCV' },
            { id: 'address', name: 'Address' },
            { id: 'postcode', name: 'Postcode' }
        ];

        for (const field of fields) {
            const value = document.getElementById(field.id).value.trim();
            if (!value) {
                alert(`Please fill out the ${field.name} field.`);
                return false;
            }
        }

        return true;
    }
</script>
</body>
</html>
