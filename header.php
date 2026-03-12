<?PHP 
# Starting the Session function
session_start();
?>

<!DOCTYPE html>
<html>
<head>
	<title>Arang Stop</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
	<link rel="stylesheet" href="style/w3.css">
</head>
<body>
<div class='w3-row w3-container w3-indigo'>
    <h2><b>ARANG STOP</b></h2>
    <p>Your Burger, Your Way – Pick-Up or Dine-In!</p>
</div>

<?PHP
# Link to Homepage
echo "
<div class='w3-bar w3-dark-grey w3-mobile'>
<a href='index.php' class='w3-bar-item w3-button w3-mobile'>Menu</a>";
# check the existence of the customer email session (if logged in, then this session will have a value)
if(empty($_SESSION["email"])) 
{
    # display the link to login and register a new user if the user has not yet logged in
    echo "
	<div class='w3-dropdown-hover'>
		<a href class='w3-button w3-dark-grey'>Account</a>
		<div class='w3-dropdown-content w3-bar-block w3-border'>
			<a href='register.php' class='w3-bar-item w3-sand w3-button'>Register</a>
			<a href='login.php' class='w3-bar-item w3-sand w3-button'>Login</a>
			<a href='staff/staff.php' class='w3-bar-item w3-sand w3-button'>Staff</a>
		</div>
	</div>";
}
else
{
	# display logout link & menu link if user is logged in
    echo "
	<a href='cart.php' class='w3-bar-item w3-button w3-left w3-margin-left'>Add to Cart</a>
	<a href='order_status.php' class='w3-bar-item w3-button w3-left w3-margin-left'>Order Status</a>
    <a href='logout.php' class='w3-bar-item w3-button w3-right w3-margin-right w3-light-blue'>Logout</a>
    <a href='profile.php' class='w3-bar-item w3-button w3-right w3-margin-right'>".$_SESSION['name']."</a>";
}
echo "</div>";
?>


