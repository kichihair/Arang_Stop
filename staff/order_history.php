<?php
include('homepage.php');
include('../connection.php');

# Initialize the $additional filter
$additional = "";

# Check if form is submitted
if (!empty($_POST)) {
    if (!empty($_POST['customer_name'])) {
        $customer_name = $_POST['customer_name'];
        $additional .= "AND customers.name LIKE '%$customer_name%' ";
    }
    if (!empty($_POST['status'])) {
        $status = $_POST['status'];
        $additional .= "AND orders.status = '$status' ";
    }
    if (!empty($_POST['order_type'])) {
        $order_type = $_POST['order_type'];
        $additional .= "AND orders.order_type = '$order_type' ";
    }
}

$query = "
    SELECT 
        customers.name, 
        customers.email, 
        customers.phone, 
        orders.order_date, 
        orders.order_type, 
        orders.status, 
        orders.total_amount
    FROM 
        customers
    JOIN 
        orders 
    ON 
        customers.customer_id = orders.customer_id
    WHERE 1=1 $additional
    ORDER BY orders.order_date DESC"; 


$result = mysqli_query($condb, $query);
?>

<div class='w3-container w3-blue'>
    <h5>ORDER HISTORY</h5>
</div>
<div class='w3-container w3-card-2 w3-margin-bottom'>
    <form class='w3-form w3-margin' action='' method='POST'>
        <table class='w3-table-all w3-centered'>
            <tr>
                <td>
                    <input class='w3-input w3-border' type='text' name='customer_name' placeholder='Customer Name'>
                </td>
                <td>
                    <select class='w3-select w3-border' name='status'>
                        <option value='' selected>Choose Status</option>
                        <option value='Pending'>Pending</option>
                        <option value='In Progress'>In Progress</option>
                        <option value='Ready'>Ready</option>
                        <option value='Completed'>Completed</option>
                    </select>
                </td>
                <td>
                    <select class='w3-select w3-border' name='order_type'>
                        <option value='' selected>Choose Service Mode</option>
                        <option value='Take Out'>Take Out</option>
                        <option value='Dine In'>Dine In</option>
                    </select>
                </td>
                <td>
                    <input class='w3-button w3-block w3-blue-grey' type='submit' value='SEARCH'>
                </td>
            </tr>
        </table>
    </form>
</div>

<div class='w3-container w3-card-2 w3-margin-bottom'>
    <table id='size' border='1' class='w3-table-all w3-responsive w3-margin w3-margin-bottom'>
        <tr>
            <td>Bil</td>
            <td>Name</td>
            <td>Email</td>
            <td>Phone</td>
            <td>Date</td>
            <td>Service Mode</td>
            <td>Status</td>
            <td>Total Price</td>
        </tr>
        <?PHP
        $bil = 0;
        # The $record variable takes all the data found by $result
        while ($record = mysqli_fetch_array($result)) {
            echo "
            <tr>
                <td>" . ++$bil . "</td>
                <td>" . $record['name'] . "</td>
                <td>" . $record['email'] . "</td>
                <td>" . $record['phone'] . "</td>
                <td>" . $record['order_date'] . "</td>
                <td>" . $record['order_type'] . "</td>
                <td>" . $record['status'] . "</td>
                <td>RM " . $record['total_amount'] . "</td>
            </tr>";
        }
        ?>
    </table>
</div>
