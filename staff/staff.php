<?PHP
# Starting the Session function
session_start();
?>

<!DOCTYPE html>
<html>
<head>
	<title>Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
</head>
<body>
	<div class='w3-row w3-container w3-indigo'>
		<h2 class=''><b>ARANG STOP</b></h2>
		<p class=''>Your Burger, Your Way – Pick-Up or Dine-In!</p>
	</div>
	<div class='w3-container w3-dark-grey'>
		<h5 class='w3-center '>Admin Page</h5>
	</div>
    
	<div class='w3-row w3-margin'>
		<div class='w3-third w3-container'></div>
			<div class='w3-third w3-container'>
				<div class='w3-container w3-blue'>
					<h4>Login</h4>
				</div>
				<div class='w3-container w3-card-2'>
					<form action='' method='POST'>
						<label>Username</label>
						<input class='w3-input w3-border ' type='text' name='username'>
						<label>Password</label>
						<input class='w3-input w3-border ' type='password' name='passwords'>
						<input class='w3-button w3-blue-grey w3-round-xlarge w3-margin-top w3-margin-bottom' type='submit' value='Login'>
					</form>
					<a href="../index.php">
						<button class='w3-button w3-grey w3-round-xlarge w3-margin-bottom'>Back</button>
					</a>
				</div>
			</div>
		<div class='w3-third w3-container'></div>
	</div>
    
<?PHP
# checking for the existence of POST data
if(!empty($_POST))
{
    # calling the connection.php file from an external folder
    include ('../connection.php');
    
    # retrieve POST data
    $username=$_POST['username'];
    $passwords=$_POST['passwords'];
	
	# Instructions for selecting records in the database that match the POST data
	$query="select * from staff where username='$username' and passwords='$passwords' limit 1";
    $result=mysqli_query($condb,$query);
	
    if(mysqli_num_rows($result)==1)
    {
        # Login successful. Retrieve data from found records.
        $record=mysqli_fetch_array($result);
        # assign to session variables
		$_SESSION['staff_id']=$record['staff_id'];
        $_SESSION['username']=$record['username'];
        $_SESSION['passwords']=$record['passwords'];
        # directs the homepage.php file to be opened
        header("location:current_order.php");
    }
    else
    {
        # Login failed. Return to the previous page.
        echo "<script>alert('Login Failed!'); window.history.back();</script>";
    }
}
?>
