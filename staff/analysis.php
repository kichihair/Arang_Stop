<?php
include('homepage.php');
include('../connection.php');

# Initialize the $additional filter
$additional = "";

# Check if form is submitted
if (!empty($_POST)) {
    if (!empty($_POST['month'])) {
        $month = $_POST['month'];
        $additional .= "AND MONTH(order_date) = '$month' ";
    }
    if (!empty($_POST['year'])) {
        $year = $_POST['year'];
        $additional .= "AND YEAR(order_date) = '$year' ";
    }
}

# SQL command to search for data based on month and/or year
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

<!-- Provide form to select month and year -->
<div class='w3-container w3-blue'>
    <h5>ORDER HISTORY</h5>
</div>
<div class='w3-container w3-card-2 w3-margin-bottom'>
    <form class='w3-form w3-margin' action='' method='POST'>
        <table class='w3-table-all w3-centered'>
            <tr>
                <td>
                    <select class='w3-select w3-border' name='month'>
                        <option value='' selected>Choose Month</option>
                        <option value='01'>January</option>
                        <option value='02'>February</option>
                        <option value='03'>March</option>
                        <option value='04'>April</option>
                        <option value='05'>May</option>
                        <option value='06'>June</option>
                        <option value='07'>July</option>
                        <option value='08'>August</option>
                        <option value='09'>September</option>
                        <option value='10'>October</option>
                        <option value='11'>November</option>
                        <option value='12'>December</option>
                    </select>
                </td>
                <td>
                    <select class='w3-select w3-border' name='year'>
                        <option value='' selected>Choose Year</option>
                        <?php
                        // Generate dynamic year options
                        $currentYear = date('Y');
                        for ($i = $currentYear; $i >= $currentYear - 10; $i--) {
                            echo "<option value='$i'>$i</option>";
                        }
                        ?>
                    </select>
                </td>
                <td>
                    <input class='w3-button w3-block w3-blue-grey' type='submit' value='FIND'>
                </td>
            </tr>
        </table>
    </form>
</div>

<div>
    <?PHP
    $bil = 0;
    $Income = 0;

    if (mysqli_num_rows($result) >= 1) {
        echo "
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
            </tr>";
        
        # The $record variable retrieves the searched data
        while ($record = mysqli_fetch_array($result)) {
            $Income += $record['total_amount'];
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
        echo "</table>";
        echo "<h4><b>Income : RM " . $Income . "0</b></h4>";
    } else {
        echo "Sorry. There is no booking information for the selected criteria.";
    }
    ?>
</div>
