<?PHP
include ('homepage.php');
include ('../connection.php');

# Checking for the existence of POST data
if (!empty($_GET)) {
    $name = $_GET['name'];
    $order_date = $_GET['order_date'];
    $order_type = $_GET['order_type'];
    $status = $_GET['status'];
}

# SQL command to search for staff data
$query = "SELECT * 
          FROM customers 
          JOIN orders 
          ON customers.customer_id = orders.customer_id 
          WHERE orders.status != 'completed'
          AND DATE(orders.order_date) = CURDATE()
          ORDER BY orders.order_date DESC"; 

$result = mysqli_query($condb, $query);
?>

<div class='w3-container w3-blue'>
<h5>CURRENT ORDER</h5>
</div>
<div class='w3-container w3-card-2 w3-margin-bottom'>
<table id='saiz' border='1' class='w3-table-all w3-responsive w3-margin w3-margin-bottom'>
    <tr>
        <td>Bil</td>
        <td>Customer Name</td>
        <td>Time</td>
        <td>Service Mode</td>
        <td>Status</td>
        <td></td>
    </tr>

    <?PHP
    $bil = 0;
    # the $record variable takes all the data found by $result
    while ($record = mysqli_fetch_array($result)) {
        echo "
        <tr>
            <td>" . ++$bil . "</td>
            <td>" . $record['name'] . "</td>
            <td>" . $record['order_date'] . "</td>
            <td>" . $record['order_type'] . "</td>
            <td>" . $record['status'] . "</td>
            <td>| <a href='order_view.php?order_id=" . $record['order_id'] . "' onClick=\"return confirm('Are you sure you want to modify this data?')\">View</a> |</td>
        </tr>";
    }
    ?>
</table>
</div>

<div>
</div>
