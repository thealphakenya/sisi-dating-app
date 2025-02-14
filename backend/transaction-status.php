<?php
require 'mpesa-config.php';

$callbackJSON = file_get_contents('php://input');
$logFile = "mpesa-transactions.log";
file_put_contents($logFile, $callbackJSON . PHP_EOL, FILE_APPEND);

$callbackData = json_decode($callbackJSON, true);

if (isset($callbackData['Body']['stkCallback'])) {
    $resultCode = $callbackData['Body']['stkCallback']['ResultCode'];
    if ($resultCode == 0) {
        $mpesaReceipt = $callbackData['Body']['stkCallback']['CallbackMetadata']['Item'][1]['Value'];
        $amountPaid = $callbackData['Body']['stkCallback']['CallbackMetadata']['Item'][0]['Value'];
        $phoneNumber = $callbackData['Body']['stkCallback']['CallbackMetadata']['Item'][4]['Value'];

        echo json_encode(["success" => "Payment successful", "receipt" => $mpesaReceipt]);
    } else {
        echo json_encode(["error" => "Payment failed"]);
    }
}
?>