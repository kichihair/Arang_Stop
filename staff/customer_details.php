<?PHP
# Memanggil fail header_pengurus.php
include ('homepage.php');
# Memanggil fail connection dari folder luaran 
include ('../connection.php');

# arahan SQL mencari pelanggan berdaftar
$query="select * from customers";
# Melaksanakan arahan SQL mencari pelanggan berdaftar
$result=mysqli_query($condb,$query);
?>
<!-- menyediakan header bagi jadual -->
<div class='w3-container w3-blue'>
<h5>REGISTERED CUSTOMER LIST</h5>
</div>
<div class='w3-container w3-card-2 w3-margin-bottom'>
<table id='saiz' border='1' class='w3-table-all w3-responsive w3-margin w3-margin-bottom'>
    <tr>
        <td>Bil</td>
        <td>Name</td>
        <td>Email</td>
        <td>Phone</td>
        <td></td>
    </tr>
    <?PHP
    $bil=0;
    # pemboleh ubah $rekod mengambil semua data yang ditemui oleh $laksana_sql_cari
    while ($record=mysqli_fetch_array($result))
    {
        # sistem akan memaparkan data $rekod baris demi baris sehinggan habis
        echo "
        <tr>
            <td>".++$bil."</td>
            <td>".$record['name']."</td>
            <td>".$record['email']."</td>
            <td>".$record['phone']."</td>
            <td><a class='w3-button w3-red w3-round-xxlarge w3-margin-bottom'
href='remove.php?table=customers&field=customer_id&id=".$record['customer_id']."'
onClick=\"return confirm('Are you sure you want to remove this data?')\">REMOVE</a></td>
        </tr>";
    }
    ?>
</table>
</div>
