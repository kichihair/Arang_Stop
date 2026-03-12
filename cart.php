<?php
include('header.php');
include('connection.php');

// Handle Add to Cart POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['cart'])) {
        $cartData = json_decode($_POST['cart'], true);

        // Store cart in session
        $_SESSION['cart'] = $cartData;
    }
}

// Fetch cart data
$cart = $_SESSION['cart'] ?? [];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        .cart-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-bottom: 15px;
            background-color: #f9f9f9;
        }

        .cart-item-details {
            flex: 1;
            margin-left: 15px;
        }

        .cart-item-actions {
            display: flex;
            gap: 10px;
        }

        .cart-item-actions button {
            padding: 5px 10px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }

        .cart-item-actions .add {
            background-color: #4CAF50;
            color: white;
        }

        .cart-item-actions .remove {
            background-color: #f44336;
            color: white;
        }

        .cart-item-actions .delete {
            background-color: #555;
            color: white;
        }

        .total-section {
            margin-top: 20px;
            text-align: center;
        }

        .total-section strong {
            font-size: 1.2em;
        }

        .checkout-button {
            margin-top: 10px;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .checkout-button:hover {
            background-color: #45a049;
        }

        .back-to-menu-button {
            margin-top: 10px;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .back-to-menu-button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <h2>Shopping Cart</h2>

    <?php
    if (empty($cart)) {
        echo "<p>Your cart is empty.</p>";
    } else {
        $total_amount = 0;

        foreach ($cart as $menu_id => $quantity) {
            // Fetch item details
            $query = "SELECT * FROM menu WHERE menu_id = $menu_id";
            $result = mysqli_query($condb, $query);

            if ($result) {
                $item = mysqli_fetch_assoc($result);

                $item_name = htmlspecialchars($item['item_name']);
                $price = $item['price'];
                $total_price = $price * $quantity;
                $total_amount += $total_price;

                echo "
                <div class='cart-item'>
                    <div class='cart-item-details'>
                        <h4>$item_name</h4>
                        <p>Price: RM" . number_format($price, 2) . "</p>
                        <p>Subtotal: RM" . number_format($total_price, 2) . "</p>
                    </div>
                    <div class='cart-item-actions'>
                        <button class='remove' onclick='updateQuantity($menu_id, -1)'>-</button>
                        <span id='quantity_$menu_id'>$quantity</span>
                        <button class='add' onclick='updateQuantity($menu_id, 1)'>+</button>
                        <button class='delete' onclick='removeItem($menu_id)'>Delete</button>
                    </div>
                </div>";
            }
        }

        echo "
        <div class='total-section'>
            <p><strong>Total Amount: RM<span id='total-amount'>" . number_format($total_amount, 2) . "</span></strong></p>
            <button class='back-to-menu-button' onclick='goBackToMenu()'>Back to Menu</button>
            <button class='checkout-button' onclick='checkout()'>Checkout</button>
        </div>";
    }
    ?>

    <script>
        function updateTotalAmount() {
            let cartItems = document.querySelectorAll('.cart-item');
            let totalAmount = 0;

            cartItems.forEach(item => {
                let price = parseFloat(item.querySelector('p:nth-of-type(1)').textContent.replace('Price: RM', ''));
                let quantity = parseInt(item.querySelector('span').textContent);
                totalAmount += price * quantity;
            });

            document.getElementById('total-amount').textContent = totalAmount.toFixed(2);
        }

        // Send updated cart data to the server (cart.php) on quantity change
function updateQuantity(menu_id, change) {
    const quantityElement = document.getElementById(`quantity_${menu_id}`);
    let currentQuantity = parseInt(quantityElement.textContent);

    currentQuantity += change;
    if (currentQuantity < 0) currentQuantity = 0;

    let cart = JSON.parse(localStorage.getItem("cart")) || {};
    if (currentQuantity === 0) {
        delete cart[menu_id];
        quantityElement.closest('.cart-item').remove();
    } else {
        cart[menu_id] = currentQuantity;
    }

    quantityElement.textContent = currentQuantity;
    localStorage.setItem("cart", JSON.stringify(cart));

    updateTotalAmount();

    // Send updated cart data to the server
    sendCartDataToServer(cart);
}

function sendCartDataToServer(cart) {
    const formData = new FormData();
    formData.append('cart', JSON.stringify(cart));

    fetch('cart.php', {
        method: 'POST',
        body: formData
    });
}

        function removeItem(menu_id) {
            let cart = JSON.parse(localStorage.getItem("cart")) || {};
            delete cart[menu_id];

            document.getElementById(`quantity_${menu_id}`).closest('.cart-item').remove();
            localStorage.setItem("cart", JSON.stringify(cart));

            updateTotalAmount();

            alert("Item removed from cart.");
        }

        function checkout() {
            alert("Proceeding to checkout...");
            window.location.href = "checkout.php";
        }

        function goBackToMenu() {
            window.location.href = "index.php";
        }
    </script>
</body>
</html>
