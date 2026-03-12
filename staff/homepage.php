<?PHP
# Memulakan fungsi session
session_start();
date_default_timezone_set("Asia/Kuala_Lumpur");
# Menyemak nama fail semasa
$namafail = basename($_SERVER['PHP_SELF']);
# Menguji adakah fail semasa bukan index.php dan pembolehubah session tidak mempunyai nilai
if(empty($_SESSION['username']))
{
    die("<script>alert('Pleas Login First.');
    window.location.href='../logout.php?id=pengurus'</script>");
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
</head>
<body>
<!-- Tajuk Utama -->
<div class='w3-row w3-container w3-indigo'>
    <h2 class=' '><b>ARANG STOP</b></h2>
    <p class=' '>Your Burger, Your Way – Pick-Up or Dine-In!</p>
</div>
<!-- container untuk memaparkan butang untuk membesarkan saiz tulisan dalam jadual -->
<div class='w3-container w3-dark-grey'>
<?PHP 
if($_SESSION["username"]) {
    echo "
<a href='account.php' class='w3-bar-item w3-button w3-left w3-margin-left'>".$_SESSION['username']."</a>";
}
?>

    <a href= 'staff.php' class= 'w3-bar-item w3-button w3-right w3-margin-right w3-light-blue'>Logout</a>
</div>
<!--row bahagian tengah ada 2 column quarter dan three quarter -->
<div class='w3-row w3-margin-top'>
<!--column pertama (quarter) untuk memaparkan menu utama -->
    <div class='w3-quarter w3-container w3-margin-bottom'>
        <div class='w3-container w3-blue'>
        <h5>HOMEPAGE</h5>
        </div>
    
        <div class='w3-card w3-round'>
<a href= 'current_order.php' class= ' w3-button w3-border-bottom w3-mobile w3-left-align'
style= 'width:100% '>
<i class='fa fa-home fa-fw w3-margin-right'></i>Current Order</a>
        
<a href= 'order_history.php' class= 'w3-button w3-border-bottom w3-mobile
w3-left-align' style= 'width:100% '>
<i class='fa fa-bed fa-fw w3-margin-right'></i>Order History</a>
        
<a href= 'menu_details.php' class= 'w3-button w3-border-bottom w3-mobile
w3-left-align' style= 'width:100% '>
<i class='fa fa-calender-check-o fa-fw w3-margin-right'></i>Menu Details</a>
        
<a href='customer_details.php' class= 'w3-button w3-border-bottom w3-mobile
w3-left-align' style= 'width:100% '>
<i class='fa fa-users fa-fw w3-margin-right'></i>Customer Details</a>
        
<a href= 'staff_details.php' class= 'w3-button w3-mobile w3-border-bottom
w3-left-align' style= 'width:100% '>
<i class='fa fa-users fa-fw w3-margin-right'></i>Staff Details</a>
        
<a href= 'analysis.php' class= 'w3-button w3-mobile w3-border-bottom w3-left-align'
 style= 'width:100% '>
<i class="fa fa-line-chart w3-margin-right" aria-hidden="true"></i>Monthly and Annual Analysis</a>
        
       </div>
    </div>
    

    <div class='w3-threequarter w3-container w3-margin-bottom'>
    
