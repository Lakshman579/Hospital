<?php
require_once('composer.json');

// Add firewall rules to allow only necessary traffic

// Whitelist Stripe IP addresses
$allowed_ips = [
    '192.168.43.160',
    'stripe_ip_2',
    // Add more IP addresses as necessary
];

// Get the client's IP address
$client_ip = $_SERVER['REMOTE_ADDR'];

// Check if the client's IP address is in the allowed IPs list
if (!in_array($client_ip, $allowed_ips)) {
    // IP address is not allowed, block the request
    http_response_code(403);
    die("Access denied");
}


$stripe = array(
  "secret_key"      => "sk_live_...l19U",
  "publishable_key" => "pk_live_51Jb4eQL7etdk2nWmCjgH59t8HQSfe7bMuwu21gNCw8XuX9tgMTmMSvSQGn5Vi37Ic7KsJnEIoQulM8CZUI3n0gZT00wBc9L2Jj"
);

\Stripe\Stripe::setApiKey($stripe['secret_key']);

$token  = $_POST['stripeToken'];
$ID = $_POST['ID'];

$charge = \Stripe\Charge::create(array(
  'amount'      => "<?php echo $row['ID']?>",
  'currency'    => 'usd',
  'description' => 'Payment for Prescription',
  'source'      => $token,
));


$amount = "<?php echo $row['ID']?>"; 
$currency = 'usd';
$description = 'Payment for appointment';
$stripe_charge_id = $charge->id; // retrieve the Stripe charge ID from the Charge object
$con=mysqli_connect("localhost","root","","myhmsdb");
// connect to the database
$con=mysqli_connect("localhost","root","","myhmsdb");
// check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// prepare and execute the SQL statement to insert the payment information into the database
$sql = "INSERT INTO payments (appointmentsid, amount, currency, description, stripe_charge_id)
        VALUES ('$ID', '$amount', '$currency', '$description', '$stripe_charge_id')";
if (mysqli_query($conn, $sql)) {
    echo "Payment information inserted into database successfully";
} else {
    echo "Error inserting payment information: " . mysqli_error($conn);
}

// close database connection
mysqli_close($conn);



echo '<h1>Payment successful</h1>';
?>
