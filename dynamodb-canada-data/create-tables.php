<?php

require '../vendor/autoload.php';

use Aws\Sdk;

$sdk = new Sdk([
    'region' => 'us-east-1',
    'version' => 'latest'
]);

$dynamodb = $sdk->createDynamoDb();



$result = $dynamodb->createTable([
    'TableName' => 'canada-provinces',
    'AttributeDefinitions' => [
        [ 'AttributeName' => 'Province', 'AttributeType' => 'S' ],
        [ 'AttributeName' => 'ProvinceAbbreviation', 'AttributeType' => 'S' ]
    ],
    'KeySchema' => [
        [ 'AttributeName' => 'Province', 'KeyType' => 'HASH' ],
        [ 'AttributeName' => 'ProvinceAbbreviation', 'KeyType' => 'RANGE' ]
    ],
    'ProvisionedThroughput' => [
        'ReadCapacityUnits' => 1,
        'WriteCapacityUnits' => 1
    ]
]);
print_r($result->getPath('TableDescription'));
$dynamodb->waitUntil('TableExists', [
    'TableName' => 'canada-provinces',
    '@waiter' => [
        'delay' => 5,
        'maxAttempts' => 20
    ]
]);



$result = $dynamodb->createTable([
    'TableName' => 'canada-territories',
    'AttributeDefinitions' => [
        [ 'AttributeName' => 'Territory', 'AttributeType' => 'S' ],
        [ 'AttributeName' => 'TerritoryAbbreviation', 'AttributeType' => 'S' ]
    ],
    'KeySchema' => [
        [ 'AttributeName' => 'Territory', 'KeyType' => 'HASH' ],
        [ 'AttributeName' => 'TerritoryAbbreviation', 'KeyType' => 'RANGE' ]
    ],
    'ProvisionedThroughput' => [
        'ReadCapacityUnits' => 1,
        'WriteCapacityUnits' => 1
    ]
]);
print_r($result->getPath('TableDescription'));
$dynamodb->waitUntil('TableExists', [
    'TableName' => 'canada-territories',
    '@waiter' => [
        'delay' => 5,
        'maxAttempts' => 20
    ]
]);




$result = $dynamodb->createTable([
    'TableName' => 'canada-cities',
    'AttributeDefinitions' => [
        [ 'AttributeName' => 'City', 'AttributeType' => 'S' ],
        [ 'AttributeName' => 'CityProvinceOrTerritory', 'AttributeType' => 'S' ]
    ],
    'KeySchema' => [
        [ 'AttributeName' => 'City', 'KeyType' => 'HASH' ],
        [ 'AttributeName' => 'CityProvinceOrTerritory', 'KeyType' => 'RANGE' ]
    ],
    'ProvisionedThroughput' => [
        'ReadCapacityUnits' => 10,
        'WriteCapacityUnits' => 100
    ]
]);
$dynamodb->waitUntil('TableExists', [
    'TableName' => 'canada-cities',
    '@waiter' => [
        'delay' => 5,
        'maxAttempts' => 20
    ]
]);
print_r($result->getPath('TableDescription'));