<?PHP
# Memanggil fail header_pengurus.php
include ('homepage.php');
# Memanggil fail connection dari folder luaran
include ('../connection.php');

# Menyemak kewujudan data POST
if(!empty($_GET))
{   # mengambil data POST
    $staff_id=$_GET['staff_id'];
    $username=$_GET['username'];
	$passwords=$_GET['passwords'];

    # data validation - adakah data POST yang diambil empty
    if(empty($staff_id) or empty($username) or empty($passwords))
    {
        die("<script>alert('Complete the required information.');
        window.history.back();</script>");
    }
    
    # Arahan untuk menyimpan data ke dalam jadual pengurus
    $sql_keep="insert into staff
    (staff_id,username,passwords)
    values
    ('$staff_id','$username','$passwords')";
    
    # melaksanakan proses menyimpan dalam syarat IF
    if(mysqli_query($condb,$sql_keep))
    {
        # proses menyimpan data berjaya. papar mesej
        echo "<script>alert('Registration Successful');
        window.location.href='staff_details.php';
        </script>";
    }
    else
    {
        # proses menyimpan data gagal. papar mesej
        echo "<script>alert('Registration Failed');
        window.history.back();</script>";
    }
}

    # arahan SQL mencari data pengurus
    $query="select* from staff";
    # melaksanakan arahan sql cari tersebut 
    $result=mysqli_query($condb,$query);
?>

<!-- menyediakan header bagi jadual -->
<!-- selepas header akan diselitkan dengan borang untuk mendaftar pengurus baru -->
<div class='w3-container w3-blue'>
<h5>STAFF LIST</h5>
</div>
<div class='w3-container w3-card-2 w3-margin-bottom'>
<table id='saiz' border='1' class='w3-table-all w3-responsive w3-margin w3-margin-bottom'>
    <tr>
        <td>Bil</td>
        <td>Staff ID</td>
        <td>Username</td>
        <td>Password</td>
        <td></td>
    </tr>
    <tr>
    <!-- menyediakan borang untuk mendaftar pengurus baru -->
    <form action='' method='GET'>
        <td>#</td>
        <td><input class='w3-input w3-border w3-round-xxlarge w3-large' type='text'
name='staff_id'></td>
        <td><input class='w3-input w3-border w3-round-xxlarge w3-large' type='text'
name='username'></td>
        <td><input class='w3-input w3-border w3-round-xxlarge w3-large' type='password'
name='passwords'></td>
        <td><input class='w3-button w3-blue-grey w3-round-xxlarge w3-margin-bottom' type='submit'
value='SAVE'></td>
    </form>
    </tr>
    <?PHP
    $bil=0;
    # pemboleh ubah $rekod mengambil semua data yang ditemui oleh $laksana_sql_cari
    while ($record=mysqli_fetch_array($result))
    {
        # sistem akan memaparkan data $rekod baris demi baris sehingga habis
        echo"
        <tr>
            <td>".++$bil."</td>
            <td>".$record['staff_id']."</td>
            <td>".$record['username']."</td>
            <td>".str_repeat('*', strlen($record['passwords']))."</td>
            
<td>| <a href='remove.php?table=staff&field=staff_id&id=".$record['staff_id']."' onClick=\"return confirm('Are you sure you want to remove this data?')\">Remove</a> | | <a href='staff_update.php?staff_id=".$record['staff_id']."&username=".$record['username']."&passwords=".$record['passwords']."' onClick=\"return confirm('Are you sure you want to modify this data?')\" >Update</a> |</td>

        </tr>";
    }
    ?>
</table>
</div>

<div>
</div>