<?php

require 'vendor/autoload.php';

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

function validateEmail(string $email, string $apiKey): bool
{
    $client = new Client();

    try {
        $response = $client->request('GET', 'https://emailvalidation.io/api/v1?apikey=' . $apiKey . '&email=' . urlencode($email));
        $data = json_decode($response->getBody(), true);

        return $data['status'] === 'valid';
    } catch (RequestException $e) {
        echo 'Error validating email: ' . $e->getMessage() . "\n";
        if ($e->hasResponse()) {
            echo 'Response: ' . $e->getResponse()->getBody() . "\n";
        }
        return false;
    }
}

function promptEmail(): string
{
    return readline("Enter the email address to validate: ");
}
function promptApiKey(): string
{
    return readline("Enter your emailvalidation.io API key: ");
}

$email = promptEmail();
$apiKey = promptApiKey();

if (validateEmail($email, $apiKey)) {
    echo "Valid email address.";
} else {
    echo "Invalid email address.";
}
