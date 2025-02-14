
<?php
// M-Pesa Credentials
$consumerKey = "lWoFWU3jvZozqb800zyh9Rw8JkMhrpZAcWIsdj8caKIQ5sQZ";
$consumerSecret = "9rdmjhyzaoI7E3K1AxSwuMoocAEYh3W19oRuJ6QZj1rQDjj8BALGpRi7mPsFQmQF";

// Generate Access Token
function generateAccessToken($consumerKey, $consumerSecret) {
    $url = "https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials";
    
    $credentials = base64_encode("$consumerKey:$consumerSecret");
    
    $headers = array(
        "Authorization: Basic " . $credentials
    );

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    
    $response = curl_exec($curl);
    curl_close($curl);
    
    $json = json_decode($response);
    return $json->access_token ?? null;
}

// Get Access Token
$accessToken = generateAccessToken($consumerKey, $consumerSecret);

// Check if access token was generated
if (!$accessToken) {
    die("Error: Unable to generate M-Pesa Access Token");
}

echo "Access Token: " . $accessToken;
?>