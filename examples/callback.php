<?php
include('common.php');

$logFile = 'webhook.log';

$data = json_decode(file_get_contents("php://input"), true);

$logData = date('Y-m-d H:i:s') . " - Webhook Data Received:\n" . print_r($data, true) . "\n\n";
file_put_contents($logFile, $logData, FILE_APPEND);
//mail('yourmail@localhost', 'Webhook Received', $logData, "From: test@localhost");

if (!empty($data)) {
// TODO HANDLE account_status et messaging webhook
} 
?>
