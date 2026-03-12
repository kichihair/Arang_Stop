<!--Calling header file-->
<?PHP include('header.php'); ?>

<!--Provide a form for new user registration-->
<div class='w3-row w3-margin'>
	<div class='w3-third w3-container'>
		<div class='w3-container w3-blue'>
			<h4>Register</h4>
		</div>
			<div class='w3-container w3-card-2'>
				<form action='' method='POST'>
					<label>Name</label>
					<input class='w3-input w3-border' type='text' name='name'>
            
					<label>Email</label>
					<input class='w3-input w3-border' type='text' name='email'>
            
					<label>Phone</label>
					<input class='w3-input w3-border' type='text' name='phone'>
            
					<label>Password</label>
					<input class='w3-input w3-border'type='password'name='password'><br>

					<input class='w3-button w3-blue-grey w3-round-xxlarge w3-margin-top w3-margin-bottom' type='submit' value='Register'>
				</form>
			</div>
	</div>
	<div class='w3-third w3-container'></div>
</div>

<?PHP
# checking for the existence of POST data
if (!empty($_POST))
{
    # call connection file
    include ('connection.php');
    
    # retrieve POST data
    $customer_id=$_POST['customer_id'];
    $name=$_POST['name'];
    $email=$_POST['email'];
    $phone=$_POST['phone'];
    $password=$_POST['password'];
    
    # -- data validation --
    if(empty($name) or empty($email) or empty($phone) or empty($password))
    {
        die("<script>alert('Complete the required information.');
        window.history.back();</script>");
    }
    
    # SQL commands to store data
    $sql_keep="INSERT INTO customers (customer_id,name,email,phone,password)
    values ('$customer_id','$name','$email','$phone','$password')";
    
    # execute the save process in the IF condition
    if(mysqli_query($condb,$sql_keep))
    {
        # if the save process is successful, display info and open the login.php page
        echo "<script>alert('Registration Successful.');
        window.location.href='login.php';</script>";
    }
    else
    {
        # if the save process fails, return to the previous page
        echo "<script>alert('Registration Failed!');
        window.history.back();</script>";
    }
}
?>