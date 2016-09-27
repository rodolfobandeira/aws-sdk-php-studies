<?php

require '../vendor/autoload.php';

use Aws\Sqs\SqsClient;

$client = new SqsClient([
    'version' => 'latest',
    'region'  => 'us-east-1'
]);

$result = $client->createQueue(array('QueueName' => 'my-queue-tests'));
$queueUrl = $result->get('QueueUrl');

$client->sendMessage(array(
    'QueueUrl'    => $queueUrl,
    'MessageBody' => '{"action": "insert_user_to_db", "message": "An awesome message!", "id": "email@example.org" }',
));


$result = $client->receiveMessage(array(
    'QueueUrl' => $queueUrl,
));

foreach ($result['Messages'] as $message) {
    // var_dump($message['Body']);

    $array = json_decode($message['Body'], true);
    print_r($array);
}

/*
    Array                                                                                                                                                                       
    (                                                                                                                                                                           
        [action] => insert_user_to_db                                                                                                                                           
        [message] => An awesome message!                                                                                                                                        
        [id] => email@example.org                                                                                                                                               
    )
*/
