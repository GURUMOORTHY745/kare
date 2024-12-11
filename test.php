<?php
require 'vendor/autoload.php'; // Ensure Composer's autoloader is included

use Twilio\Rest\Client;

// Twilio credentials
$sid = 'AC61e828fb385db3a170614caa89f9c7dd'; // Your Twilio Account SID
$token = '21a8849f5493d62d1085d252b9a8de80'; // Your Twilio Auth Token
$twilio_number = '+19293252229'; // Your Twilio phone number

$client = new Client($sid, $token);

try {
    $message = $client->messages->create(
        '+917305175810', // Replace with a valid phone number to test
        [
            'from' => $twilio_number,
            'body' => 'This is a test message.'
        ]
    );
    echo "Message sent successfully! SID: " . $message->sid;
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}