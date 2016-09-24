<?php

require '../vendor/autoload.php';

use Aws\Sdk;

$sdk = new Sdk([
    'region' => 'us-east-1',
    'version' => 'latest'
]);



function insertData($sdk, $jsonFile, $tableName, $primary, $secondary) {
    $dynamodb = $sdk->createDynamoDb();

    $file = file_get_contents($jsonFile);
    $array = json_decode($file, true);

    foreach($array as $key => $value) {

        $response = $dynamodb->putItem([
            'TableName' => $tableName,
            'Item' => [
                $primary => ['S' => strtoupper($key)],
                $secondary => ['S' => strtoupper($value)]
            ]
        ]);

        printf("[%s:%s] - %s %s", $key, $value, $response['@metadata']['statusCode'], PHP_EOL);
    }
}


insertData($sdk, 'json/provinces.json', 'canada-provinces', 'ProvinceAbbreviation', 'Province');
insertData($sdk, 'json/territories.json', 'canada-territories', 'TerritoryAbbreviation', 'Territory');
insertData($sdk, 'json/cities.json', 'canada-cities', 'City', 'CityProvinceOrTerritory');
