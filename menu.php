<?php
include('connection.php');
$cart = $_SESSION['cart'] ?? []; // Retrieve cart data from session
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Ordering System</title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <style>
        .shop 
		{
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            padding: 10px;
            margin: 0 auto;
        }

        .item 
		{
            text-align: center;
            border: 1px solid #ccc;
            padding: 10px;
            border-radius: 8px;
            box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.1);
        }

        .item img 
		{
            width: 150px;
            height: 100px;
            border-radius: 8px;
            margin-bottom: 10px;
        }

        .quantity 
		{
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
            margin-top: 10px;
        }

        .tablink 
		{
            cursor: pointer;
        }

        button 
		{
            padding: 5px 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .increment, .decrement 
		{
            background-color: #007BFF;
            color: #fff;
        }

        .increment:hover, .decrement:hover 
		{
            background-color: #0056b3;
        }

        .quantity-value
		{
            font-size: 18px;
        }

        .add-to-cart 
		{
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color: #28a745;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 18px;
            cursor: pointer;
        }

        .add-to-cart:hover 
		{
            background-color: #218838;
        }
    </style>
</head>
<body>
    <div class="w3-bar w3-blue w3-mobile">
        <button class="w3-bar-item w3-button tablink w3-blue" onclick="opentab(event, 'Burger')">Burger</button>
        <button class="w3-bar-item w3-button tablink" onclick="opentab(event, 'Drink')">Drink</button>
        <button class="w3-bar-item w3-button tablink" onclick="opentab(event, 'Fries')">Fries</button>
    </div>

    <!-- Display Burger Menu -->
    <div id="Burger" class="w3-container w3-border shop w3-center">
        <?php
        $query = "SELECT * FROM menu WHERE category = 'Burger'";
        $result = mysqli_query($condb, $query);

        while ($record = mysqli_fetch_assoc($result)) 
		{
            $menu_id = $record['menu_id'];
            $quantityInCart = isset($cart[$menu_id]) ? $cart[$menu_id] : 0;
            echo "<div class='item'>";
            echo "<img src='images/" . htmlspecialchars($record['pic']) . "' alt='" . htmlspecialchars($record['item_name']) . "'>";
            echo "<p>" . htmlspecialchars($record['item_name']) . "</p>";
            echo "<p>RM" . number_format($record['price'], 2) . "</p>";
            echo "<div class='quantity'>";
            echo "<button class='decrement' onclick='updateOrder(" . $menu_id . ", -1)'>-</button>";
            echo "<span class='quantity-value' id='quantity_" . $menu_id . "'>" . $quantityInCart . "</span>";
            echo "<button class='increment' onclick='updateOrder(" . $menu_id . ", 1)'>+</button>";
            echo "</div>";
            echo "</div>";
        }
        ?>
    </div>

	<!-- Display Drink Menu -->
    <div id="Drink" class="w3-container w3-border shop w3-center">
        <?php
        $query = "SELECT * FROM menu WHERE category = 'Drink'";
        $result = mysqli_query($condb, $query);

        while ($record = mysqli_fetch_assoc($result)) 
		{
            $menu_id = $record['menu_id'];
            $quantityInCart = isset($cart[$menu_id]) ? $cart[$menu_id] : 0;
            echo "<div class='item'>";
            echo "<img src='images/" . htmlspecialchars($record['pic']) . "' alt='" . htmlspecialchars($record['item_name']) . "'>";
            echo "<p>" . htmlspecialchars($record['item_name']) . "</p>";
            echo "<p>RM" . number_format($record['price'], 2) . "</p>";
            echo "<div class='quantity'>";
            echo "<button class='decrement' onclick='updateOrder(" . $menu_id . ", -1)'>-</button>";
            echo "<span class='quantity-value' id='quantity_" . $menu_id . "'>" . $quantityInCart . "</span>";
            echo "<button class='increment' onclick='updateOrder(" . $menu_id . ", 1)'>+</button>";
            echo "</div>";
            echo "</div>";
        }
        ?>
    </div>
	
	<!-- Display Fries Menu -->
    <div id="Fries" class="w3-container w3-border shop w3-center">
        <?php
        $query = "SELECT * FROM menu WHERE category = 'Fries'";
        $result = mysqli_query($condb, $query);

        while ($record = mysqli_fetch_assoc($result)) 
		{
            $menu_id = $record['menu_id'];
            $quantityInCart = isset($cart[$menu_id]) ? $cart[$menu_id] : 0;
            echo "<div class='item'>";
            echo "<img src='images/" . htmlspecialchars($record['pic']) . "' alt='" . htmlspecialchars($record['item_name']) . "'>";
            echo "<p>" . htmlspecialchars($record['item_name']) . "</p>";
            echo "<p>RM" . number_format($record['price'], 2) . "</p>";
            echo "<div class='quantity'>";
            echo "<button class='decrement' onclick='updateOrder(" . $menu_id . ", -1)'>-</button>";
            echo "<span class='quantity-value' id='quantity_" . $menu_id . "'>" . $quantityInCart . "</span>";
            echo "<button class='increment' onclick='updateOrder(" . $menu_id . ", 1)'>+</button>";
            echo "</div>";
            echo "</div>";
        }
        ?>
    </div>
	
    <button class="add-to-cart" onclick="submitOrder()">Add to Cart</button>

    <script>
        let cart = JSON.parse(localStorage.getItem("cart")) || {};

        function opentab(evt, category)
		{
            var i, x, tablinks;
            x = document.getElementsByClassName("shop");
            for (i = 0; i < x.length; i++) 
			{
                x[i].style.display = "none";
            }
            tablinks = document.getElementsByClassName("tablink");
            for (i = 0; i < tablinks.length; i++) 
			{
                tablinks[i].className = tablinks[i].className.replace(" w3-blue", "");
            }
            document.getElementById(category).style.display = "grid";
            evt.currentTarget.className += " w3-blue";
        }

        function updateOrder(menu_id, change) 
		{
            const quantityElement = document.getElementById(`quantity_${menu_id}`);
            let currentQuantity = cart[menu_id] || 0;

            currentQuantity += change;
            if (currentQuantity < 0) currentQuantity = 0;

            if (currentQuantity === 0) 
			{
                delete cart[menu_id];
            } 
			else 
			{
                cart[menu_id] = currentQuantity;
            }

            quantityElement.textContent = currentQuantity;
            localStorage.setItem("cart", JSON.stringify(cart)); // Save cart to localStorage
        }

        function submitOrder() 
		{
			// Check if the user is logged in by checking the session value
			<?php if (empty($_SESSION['email'])): ?>
			alert("Please Login First");
			window.location.href = "login.php";
			<?php else: ?>
        
			const xhr = new XMLHttpRequest();
			xhr.open("POST", "cart.php", true);
			xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

			xhr.onload = function () 
			{
				if (xhr.status === 200) 
				{
					window.location.href = "cart.php";
				} 
				else 
				{
					alert("Failed to add items to cart. Please try again.");
				}
			};

			const cartData = "cart=" + JSON.stringify(cart);
			xhr.send(cartData);
			<?php endif; ?>
		}
    </script>
</body>
</html>