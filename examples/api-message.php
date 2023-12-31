<?php
include('common.php');

if ($_GET['action'] === 'listChats') {
    try {
        $chats = $unipileSDK->Messaging->listChats();
        echo json_encode($chats);
    } catch (UnipileSDKException $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Error fetching chats']);
    }
}

if ($_GET['action'] === 'listChatMessages') {
    $postData = json_decode(file_get_contents("php://input"), true);

    try {
        $messages = $unipileSDK->Messaging->listChatMessages($postData['chatId']);
        echo json_encode($messages);
    } catch (UnipileSDKException $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Error fetching chat messages']);
    }
}

if ($_GET['action'] === 'listMessages') {
    $postData = json_decode(file_get_contents("php://input"), true);

    try {
        $messages = $unipileSDK->Messaging->listMessages();
        echo json_encode($messages);
    } catch (UnipileSDKException $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Error fetching chat messages']);
    }
}

if ($_GET['action'] === 'getChat') {
    $postData = json_decode(file_get_contents("php://input"), true);

    try {
        $chat = $unipileSDK->Messaging->getChat($postData['chatId']);
        echo json_encode($chat);
    } catch (UnipileSDKException $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Error fetching chat messages']);
    }
}


if ($_GET['action'] === 'getChatAttendees') {
    $postData = json_decode(file_get_contents("php://input"), true);

    try {
        $chat = $unipileSDK->Messaging->getChatAttendees($postData['chatId']);
        echo json_encode($chat);
    } catch (UnipileSDKException $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Error fetching chat messages']);
    }
}

if ($_GET['action'] === 'getChatsAttendees') {
    $postData = json_decode(file_get_contents("php://input"), true);

    try {
        $attendees = $unipileSDK->Messaging->getChatsAttendees();
        echo json_encode($attendees);
    } catch (UnipileSDKException $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Error fetching chats attendees']);
    }
}


if ($_GET['action'] === 'getAttachments') {
    if (isset($_GET['messageId']) && isset($_GET['attachmentId'])) {
        try {
            $messageId = $_GET['messageId'];
            $attachmentId = $_GET['attachmentId'];

            $attachmentContent = $unipileSDK->Messaging->getAttachments($messageId, $attachmentId);

            $contentType = $attachmentContent->getHeader('Content-Type')[0];
            preg_match('/filename="(.+)"/', $attachmentContent->getHeader('Content-Disposition')[0], $contentName);

            header('Content-Type: ' . $contentType);
            if ($contentType !== 'video/mp4' && $contentType !== 'image/jpeg') {
                header('Content-Disposition: attachment; filename="' . $contentName[1] . '"');
            }

            echo $attachmentContent->getBody();
        } catch (UnipileSDKException $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Error fetching attachment']);
        }
    } else {
        http_response_code(400);
        echo json_encode(['error' => 'Missing messageId or attachmentId']);
    }
}
if ($_REQUEST['action'] === 'sendMessage') {
    $chatId = $_GET['chatId'];
    $message = $_POST['message'];
    $attachments = $_FILES['attachments'];
    try {
        $response = $unipileSDK->Messaging->sendMessage($chatId, $message, $attachments);
        echo json_encode(['success' => true]);
    } catch (UnipileSDKException $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Error sending message']);
    }
}
