<?php
# Start session function
session_start();

# Clear the cart data from the session
if (isset($_SESSION['cart'])) 
{
    unset($_SESSION['cart']);
}

# Delete all session variable values
session_unset();

# Destroy the session
session_destroy();

# Redirect to the index page with a script to clear localStorage
echo "
    <script>
        localStorage.removeItem('cart'); // Clear the cart from localStorage
        window.location.href = 'index.php'; // Redirect to the index page
    </script>";
	
exit;
?>