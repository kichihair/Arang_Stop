<!-- Memanggil fail header_pengurus.php -->
<?PHP include ('homepage.php'); ?>
<!-- menyediakan borang untuk mengemaskini data pengurus-->
<div class='w3-container w3-deep-orange'>
<h5>Update Staff Details</h5>
</div>
<div class='w3-container w3-card-2 w3-margin-bottom'>
<form class='w3-margin' action='' method='POST'>
    
<label><b>Staff ID</b></label>
<input class='w3-input w3-border w3-round-xxlarge w3-large' type='text' name='new_staff_id' value='<?PHP echo $_GET['staff_id']; ?>'><br>
    
<label><b>Username</b></label>
<input class='w3-input w3-border w3-round-xxlarge w3-large' type='text' name='new_username' value='<?PHP echo $_GET['username']; ?>'><br>
    
<label><b>Password</b></label>
<input class='w3-input w3-border w3-round-xxlarge w3-large' type='password' name='new_passwords' value='<?PHP echo $_GET['passwords']; ?>'><br>
    
<input class='w3-button w3-yellow w3-round-xxlarge w3-margin-bottom' type='submit' value='UPDATE'>
</form>
</div>
<div>
</div>
<?PHP
# menyemak kewujudan data POST
if(!empty($_POST))
{
    # Memanggil fail connection dari folder luaran
    include ('../connection.php');
    
    # mengambil data POST
    $new_staff_id=$_POST['new_staff_id'];
    $new_username=$_POST['new_username'];
    $new_passwords=$_POST['new_passwords'];
    $old_staff_id=$_GET['staff_id'];
    
    # Arahan untuk mengemaskini data ke dalam jadual pengurus
    $sql_update="update staff set
    staff_id='$new_staff_id',
    username='$new_username',
    passwords='$new_passwords'
    where
    staff_id='$old_staff_id'";
    
    # melaksanakan proses mengemaskini dalam syarat IF
    if(mysqli_query($condb,$sql_update))
    {
        # proses mengemaskini berjaya.
        echo "<script>alert('Update Succesful');
        window.location.href='staff_details.php';
        </script>";
    }
    else
    {
        # proses mengemaskini gagal
        echo "<script>alert('Update Failed');
        window.history.back();</script>";
    }
}

?>