<?php
require 'mpesa-config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $phone = $_POST['phone'];
    $amount = $_POST['amount'];

    $accessToken = getMpesaAccessToken();
    if (!$accessToken) {
        echo json_encode(["error" => "Failed to get access token"]);
        exit;
    }

    $timestamp = date("YmdHis");
    $password = base64_encode(MPESA_SHORTCODE . MPESA_PASSKEY . $timestamp);

    $stkPushUrl = "https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest";
    $headers = [
        "Authorization: Bearer $accessToken",
        "Content-Type: application/json"
    ];

    $data = [
        "BusinessShortCode" => MPESA_SHORTCODE,
        "Password" => $password,
        "Timestamp" => $timestamp,
        "TransactionType" => "CustomerPayBillOnline",
        "Amount" => $amount,
        "PartyA" => $phone,
        "PartyB" => MPESA_SHORTCODE,
        "PhoneNumber" => $phone,
        "CallBackURL" => MPESA_CALLBACK_URL,
        "AccountReference" => "Sisi Dating App",
        "TransactionDesc" => "Payment for subscription"
    ];

    $curl = curl_init($stkPushUrl);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($curl);
    curl_close($curl);

    echo $response;
}
?>