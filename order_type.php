<?php
include('header.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Order Type</title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <script>
        function handleOrderTypeSelection(type) {
            const tableInput = document.getElementById('table-input');
            const submitButton = document.getElementById('submit-button');
            const hiddenInput = document.getElementById('selected_order_type');
            hiddenInput.value = type;

            if (type === "Dine In") {
                tableInput.style.display = 'block';
                submitButton.style.display = 'inline-block';
            } else {
                tableInput.style.display = 'none';
                submitButton.style.display = 'none';
                document.getElementById('form').submit(); // Automatically submit for "Take Out"
            }
        }
    </script>
</head>
<body>
<div class="w3-container w3-center w3-padding-64">
    <h2>Select Service Type</h2>
    <p>Please choose how you want to receive your order:</p>
    <div class="w3-margin-top">
        <form method="POST" action="checkout.php" id="form">
    <button type="button" onclick="handleOrderTypeSelection('Take Out')" class="w3-button w3-green w3-round-large w3-margin">Take Out</button>
    <button type="button" onclick="handleOrderTypeSelection('Dine In')" class="w3-button w3-blue w3-round-large w3-margin">Dine In</button>
    <div id="table-input" style="display:none; margin-top: 20px;">
        <label for="table_no">Enter your table number (1-20):</label>
        <input type="number" id="table_no" name="table_no" min="1" max="20" class="w3-input w3-border w3-round" required>
    </div>
    <input type="hidden" id="selected_order_type" name="order_type">
    <button type="submit" id="submit-button" class="w3-button w3-yellow w3-round-large w3-margin-top" style="display:none;">Submit</button>
</form>

    </div>
</div>
</body>
</html>
