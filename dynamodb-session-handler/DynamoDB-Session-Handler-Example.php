<?php

require '../vendor/autoload.php';

use Aws\DynamoDb\SessionHandler;

$sessionHandler = SessionHandler::fromClient($dynamoDb, ['table_name' => 'sessions']);
$sessionHandler->register();

// Start the session
session_start();

// Alter the session data
$_SESSION['user.name'] = 'Rodolfo Bandeira';
$_SESSION['user.role'] = 'it';

// Close the session (optional, but recommended)
session_write_close();
