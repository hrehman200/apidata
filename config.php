<?php

use Dotenv\Dotenv;
use Medoo\Medoo;

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/constants.php';

try {
    $dotenv = Dotenv::createImmutable(__DIR__);
    $dotenv->load();
    $dotenv->required(['DB_HOST', 'DB_NAME', 'DB_USER', 'DB_PASS'])->notEmpty();
    $dotenv->required('API_KEY')->notEmpty();

    $db = new Medoo([
        'type' => 'mysql',
        'host' => $_ENV['DB_HOST'],
        'database' => $_ENV['DB_NAME'],
        'username' => $_ENV['DB_USER'],
        'password' => $_ENV['DB_PASS']
    ]);
} catch (Exception $e) {
    echo $e->getMessage();
    exit();
}

/**
 * Utility function to make curl requests
 * 
 * @param string $url
 * @param array $data
 * @return array
 */
function makeRequest($url, $data = [])
{
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HEADER, false);

    $response = curl_exec($curl);
    return json_decode($response, true);
}