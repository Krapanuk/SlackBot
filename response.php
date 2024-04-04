<?php
require_once '\SECRET PATH\secrets.php';
$code = $_GET['code']; // The authorization code Slack sends as query parameter

// Exchange the authorization code for an access token
$url = 'https://slack.com/api/oauth.v2.access';
$data = http_build_query([
    'client_id' => $clientId,           #Your Apps Client ID 
    'client_secret' => $clientSecret,   #Your Apps Client Secret 
    'code' => $code
]);

$context = stream_context_create([
    'http' => [
        'method' => 'POST',
        'header' => "Content-Type: application/x-www-form-urlencoded\r\n",
        'content' => $data
    ]
]);

$response = file_get_contents($url, false, $context);
if ($response === false) {
    echo "Error during the OAuth process";
} else {
    $responseArray = json_decode($response, true);
    if (isset($responseArray['access_token'])) {
        echo "Authorization successful";
    } else {
        echo "Authorization failed";
    }
}
?>
