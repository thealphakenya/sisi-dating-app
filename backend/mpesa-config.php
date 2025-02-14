<?php
define("MPESA_CONSUMER_KEY", "lWoFWU3jvZozqb800zyh9Rw8JkMhrpZAcWIsdj8caKIQ5sQZ");
define("MPESA_CONSUMER_SECRET", "9rdmjhyzaoI7E3K1AxSwuMoocAEYh3W19oRuJ6QZj1rQDjj8BALGpRi7mPsFQmQF");
define("MPESA_SHORTCODE", "600987"); // Change to your Paybill/Till Number
define("MPESA_PASSKEY", "your_passkey_here"); // Get from Safaricom portal
define("MPESA_CALLBACK_URL", "https://yourdomain.com/backend/transaction-status.php");

function getMpesaAccessToken() {
    $url = "https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials";
    $credentials = base64_encode(MPESA_CONSUMER_KEY . ":" . MPESA_CONSUMER_SECRET);

    $headers = [
        "Authorization: Basic $credentials"
    ];

    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($curl);
    curl_close($curl);

    $jsonResponse = json_decode($response, true);
    return $jsonResponse['access_token'] ?? null;
}
?>