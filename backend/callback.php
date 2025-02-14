<?php
// Get M-Pesa response
$data = file_get_contents("php://input");
$logFile = "mpesa_response.log";

// Log response for debugging
file_put_contents($logFile, $data, FILE_APPEND);

// Convert JSON to PHP array
$response = json_decode($data, true);

if ($response["Body"]["stkCallback"]["ResultCode"] == 0) {
    $amount = $response["Body"]["stkCallback"]["CallbackMetadata"]["Item"][0]["Value"];
    $transactionId = $response["Body"]["stkCallback"]["CallbackMetadata"]["Item"][1]["Value"];
    $phoneNumber = $response["Body"]["stkCallback"]["CallbackMetadata"]["Item"][4]["Value"];

    // Store in database
    require "database.php";
    $stmt = $conn->prepare("INSERT INTO payments (phone, amount, transaction_id) VALUES (?, ?, ?)");
    $stmt->bind_param("sis", $phoneNumber, $amount, $transactionId);
    $stmt->execute();
}

echo json_encode(["status" => "success"]);
?>