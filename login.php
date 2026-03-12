<!--Calling the header file-->
<?PHP include('header.php'); ?>

<!--Preparing a form for user login-->
<div class='w3-row w3-margin'>
    <div class='w3-third w3-container'></div>
    <div class='w3-third w3-container'>
        <div class='w3-container w3-blue'>
            <h4>Login</h4>
        </div>
        <div class='w3-container w3-card-2'>
            <form action='' method='POST'>
            <label>Email</label>
            <input class='w3-input w3-border w3-round-xxlarge w3-large' type='text' name='email'>
            <label>Password</label>
            <input class='w3-input w3-border w3-round-xxlarge w3-large' type='password' name='password'>
<input class='w3-button w3-blue-grey w3-round-xlarge w3-margin-top w3-margin-bottom'
type='submit' value='Login'>
            </form>
        </div>
    </div>
    <div class='w3-third w3-container'></div>
</div>

<?PHP 
# checking for the existence of POST data
if (!empty($_POST))
{
    # calling the connection.php file
    include ('connection.php');
    
    # retrieve POST data
    $email=$_POST['email'];
    $password=$_POST['password'];
    
    # SQL command to search data from customers table
    $query = "SELECT * FROM customers 
	WHERE email='$email' and password='$password' 
	limit 1";
    
    # carry out the search process
    $result=mysqli_query($condb,$query);
    
    if(mysqli_num_rows($result)==1)
    {
        # the $record variable retrieves the data found during the search process
        $record=mysqli_fetch_array($result);
        # assign to session variables
        $_SESSION['customer_id']=$record['customer_id'];
        $_SESSION['name']=$record['name'];
        $_SESSION['email']=$record['email'];
        $_SESSION['phone']=$record['phone'];
		$_SESSION['password']=$record['password'];
        # directs the index.php file to be opened
        echo "<script>window.location.href='index.php';</script>";
    }
    else
    {
        # Login failed. Return to the previous page.
        echo "<script>alert('Login Failed!');
        window.history.back();</script>";
    }
}
?>