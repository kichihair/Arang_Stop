<?PHP
# Memanggil fail header_pengurus.php
include ('homepage.php');
# Memanggil fail connection dari folder luaran
include ('../connection.php');

# Menyemak kewujudan data POST
if (!empty($_POST)) {
    # mengambil data POST
    $item_name = $_POST['item_name'];
    $category = $_POST['category'];
    $price = $_POST['price'];
    $pic = $_FILES['pic']['name'];
    $location = $_FILES['pic']['tmp_name'];
    $folder = "../images/" . $pic;

    # Arahan untuk menyimpan data ke dalam jadual menu
    $sql_keep = "INSERT INTO menu (item_name, category, price, pic)
    VALUES ('$item_name', '$category', '$price', '$pic')";
    
    # melaksanakan proses menyimpan dalam syarat IF
    if (mysqli_query($condb, $sql_keep)) {
        move_uploaded_file($location, $folder);
        # proses menyimpan data berjaya. papar mesej
        echo "<script>alert('Registration Successful');</script>";
    } else {
        # proses menyimpan data gagal. papar mesej
        echo "<script>alert('Registration Failed');
        window.history.back();</script>";
    }
}

# arahan SQL mencari data menu
$query = "SELECT * FROM menu";
$result = mysqli_query($condb, $query);

# arahan SQL untuk mendapatkan kategori
$category_query = "SELECT DISTINCT category FROM menu";
$category_result = mysqli_query($condb, $category_query);
?>

<!-- menyediakan header bagi jadual -->
<div class='w3-container w3-blue'>
<h5>MENU LIST</h5>
</div>
<div class='w3-container w3-card-2 w3-margin-bottom'>
<table id='saiz' border='1' class='w3-table-all w3-responsive w3-margin w3-margin-bottom'>
    <tr>
        <td>Bil</td>
        <td>Menu</td>
        <td>Category</td>
        <td>Price</td>
        <td>Picture</td>
        <td></td>
    </tr>
    <tr>
    <!-- menyediakan borang untuk mendaftar rumah baru -->
    <form action='' method='POST' enctype='multipart/form-data'>
        <td>#</td>
        <td><input class='w3-input w3-border w3-round-xxlarge w3-large' size='5' type='text' name='item_name' required></td>
        <td>
        <!-- menghasilkan drop down yang dinamik -->
        <select class='w3-select w3-border w3-round-large' name='category' required>
            <option disabled selected value>Choose Category</option>
            <?PHP
            # Populate categories from the database
            while ($category_record = mysqli_fetch_array($category_result)) {
                echo "<option value='" . $category_record['category'] . "'>" . $category_record['category'] . "</option>";
            }
            ?>
        </select>
        </td>
        <td><input class='w3-input w3-border w3-round-xxlarge ' type='text' name='price' required></td>
        <td><input class='w3-input w3-border w3-round-xxlarge ' size='5' type='file' name='pic' required></td>
        <td><input class='w3-button w3-blue-grey w3-round-xxlarge w3-margin-bottom' type='submit' value='SAVE'></td>
    </form>
    </tr>
    
    <?PHP
    $bil = 0;
    # sistem akan memaparkan data baris demi baris sehingga habis
    while ($record = mysqli_fetch_array($result)) {
        echo "
        <tr>
            <td>" . ++$bil . "</td>
            <td>" . $record['item_name'] . "</td>
            <td>" . $record['category'] . "</td>
            <td>" . $record['price'] . "</td>
            <td><img src='../images/" . $record['pic'] . "' width='10%'></td>
            <td><a class='w3-button w3-red w3-round-xxlarge w3-margin-bottom'
            href='remove.php?table=menu&field=menu_id&id=" . $record['menu_id'] . "'
            onClick=\"return confirm('Are you sure you want to remove this data?')\">REMOVE</a></td>
        </tr>";
    }
    ?>
</table>
</div>