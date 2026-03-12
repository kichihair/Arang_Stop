<?PHP 
session_start();
require('fpdf.php'); 
require('connection.php');

// Set the timezone to Malaysia
date_default_timezone_set('Asia/Kuala_Lumpur');

// Extract cart data and order_type from the query string
$cart = isset($_GET['cart']) ? json_decode($_GET['cart'], true) : [];
$total_amount = $_GET['total_amount'] ?? 0;
$order_type = $_GET['order_type'] ?? '';  // Retrieve order type

class PDF extends FPDF
{
    function Header()
    {
        $order_date = date("d/m/Y H:i:s"); 
        $this->setFont('Arial', 'B', 16); 
        $title = "ARANG STOP"; 
        $subtitle = "Your Burger, Your Way - Pick-Up or Dine-In!"; 
        $datetitle = "Printed on: " . $order_date; 
        $this->Cell(100, 5, $title, 0, 1); 
        $this->Ln(1);
        $this->setFont('Arial', 'I', 9); 
        $this->Cell(100, 5, $subtitle, 0, 1); 
        $this->setFont('Arial', '', 9); 
        $this->Cell(100, 5, $datetitle, 0, 1);
    }
}

$pdf = new PDF('P','mm', 'A4');
$pdf->AliasNbPages('{pages}'); 
$pdf->AddPage(); 
$pdf->SetFont('Arial', '', 12);

$pdf->SetFont('Arial', '', 10); 
$pdf->SetDrawColor(50, 50, 100); 
$pdf ->Ln(1);

// Extract table_no from the query string
$table_no = $_GET['table_no'] ?? '';

$pdf->Ln(4);
$pdf->Cell(25, 5, 'Service Mode:', 0, 0, 'R');
$pdf->Cell(0, 5, $order_type == 'Take Out' ? 'Take Out' : 'Dine In', 0, 0, 'L');
$pdf->Ln(4);

if ($order_type == 'Dine In') {
    $pdf->Cell(25, 5, 'Table Number:', 0, 0, 'R');
    $pdf->Cell(0, 5, $table_no, 0, 0, 'L');
    $pdf->Ln(4);
}

// Customer details
$pdf->Ln(4); 
$pdf->SetFillColor(200, 220, 255); 
$pdf->Cell(0, 5, 'Customer Details', 0, 0, 'L', true);
$pdf->Ln(4);

$pdf ->Ln(4);
$pdf->Cell(25, 5, 'Name:', 0, 0, 'R'); 
$pdf->Cell(30, 5, $_SESSION['name'], 0, 0); 
$pdf->Ln(4); 
$pdf->Cell(25, 5, 'Email:', 0, 0, 'R'); 
$pdf->Cell(30, 5, $_SESSION['email'], 0, 0);
$pdf->Ln(4);
$pdf->Cell(25, 5, 'Phone:', 0, 0, 'R');
$pdf->Cell(30, 5, $_SESSION['phone'], 0, 0); 
$pdf->Ln(4);

// Order details
$pdf ->Ln(4);
$pdf->SetFillColor(200, 220, 255);
$pdf->Cell(0, 5, 'Order Details', 0, 0, 'L', true);
$pdf->Ln(4);

// Loop through cart items and print details
foreach ($cart as $menu_id => $quantity) 
{
    $query = "SELECT * FROM menu WHERE menu_id = $menu_id";
    $result = mysqli_query($condb, $query);
    if ($result) 
	{
        $item = mysqli_fetch_assoc($result);
        $item_name = htmlspecialchars($item['item_name']);
        $price = $item['price'];
        $total_price = $price * $quantity;

        // Modify the layout to match the desired format
		$pdf ->Ln(4);
        $pdf->Cell(30, 5, $quantity, 0, 0, 'R'); // Quantity
        $pdf->Cell(80, 5, $item_name, 0, 0); // Item name
        $pdf->Cell(30, 5, 'RM ' . number_format($price, 2), 0, 0, 'R'); // Price
        $pdf->Cell(30, 5, 'RM ' . number_format($total_price, 2), 0, 0, 'R'); // Total Price
        $pdf->Ln(4);
    }
}

// Total Price
$pdf->Ln(4);
$pdf ->Cell(25,5,' ',0,0,'R'); 
$pdf ->Cell(30,5," ",0,0);
$pdf ->Cell(80); 
$pdf->SetFillColor(200, 220, 255);
$pdf->Cell(25, 5, 'Total Price:', 0, 0, 'R'); // Label aligned to the right
$pdf->Cell(0, 5, "RM " . number_format($total_amount, 2), 0, 0, 'L', true); // Total price aligned to the right
$pdf->Ln(5);

// Extract payment_type from the query string
$payment_type = $_GET['payment_type'] ?? '';
$payment_method = ($payment_type === 'Offline') ? 'Pay at the Counter' : 'Card';

// Payment method
$pdf->Cell(25, 5, ' ', 0, 0, 'R');
$pdf->Cell(30, 5, " ", 0, 0);
$pdf->Cell(80);
$pdf->Cell(25, 5, 'Payment Method:', 0, 0, 'R');
$pdf->Cell(0, 5, $payment_method, 0, 0, 'L');
$pdf->Ln(4);


$pdf->Cell(0, 6, '_________________________________________________________________________________________', 0, 1, 'C');
$pdf->Ln(5); 
$pdf->Cell(0, 6, 'Make sure you bring this receipt when picking up your order.', 0, 1, 'C');

$pdf->SetAutoPageBreak(true, 15);
$pdf->Output();
?>
