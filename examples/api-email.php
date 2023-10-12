<?php
include('common.php');

if ($_GET['action'] === 'listMails') {
    try {
        $mails = $unipileSDK->Email->listMails();
        echo json_encode($mails);
    } catch (UnipileSDKException $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Error fetching mails']);
    }
}

if ($_GET['action'] === 'sendMail') {
    $postData = json_decode(file_get_contents("php://input"), true);

    try {
        $response = $unipileSDK->Email->sendMail($postData);
        echo json_encode(['success' => true]);
    } catch (UnipileSDKException $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Error sending mail']);
    }
}

if ($_GET['action'] === 'deleteMail') {
    $postData = json_decode(file_get_contents("php://input"), true);

    try {
        $response = $unipileSDK->Email->deleteMail($postData['mailId']);
        echo json_encode(['success' => true]);
    } catch (UnipileSDKException $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Error deleting mail']);
    }
}

if ($_GET['action'] === 'moveMail') {
    $postData = json_decode(file_get_contents("php://input"), true);

    try {
        $response = $unipileSDK->Email->moveMail($postData['mailId'], $postData['folderId']);
        echo json_encode(['success' => true]);
    } catch (UnipileSDKException $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Error moving mail']);
    }
}

if ($_GET['action'] === 'getMail') {
    $postData = json_decode(file_get_contents("php://input"), true);

    try {
        $mail = $unipileSDK->Email->getMail($postData['mailId']);
        echo json_encode($mail);
    } catch (UnipileSDKException $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Error getting mail']);
    }
}

if ($_GET['action'] === 'listFolders') {
    try {
        $folders = $unipileSDK->Email->listFolders();
        echo json_encode($folders);
    } catch (UnipileSDKException $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Error fetching folders']);
    }
}

if ($_GET['action'] === 'getFolder') {
    $postData = json_decode(file_get_contents("php://input"), true);

    try {
        $folder = $unipileSDK->Email->getFolder($postData['folderId']);
        echo json_encode($folder);
    } catch (UnipileSDKException $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Error getting folder']);
    }
}

if ($_GET['action'] === 'listDrafts') {
    try {
        $drafts = $unipileSDK->Email->listDrafts();
        echo json_encode($drafts);
    } catch (UnipileSDKException $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Error fetching drafts']);
    }
}

if ($_GET['action'] === 'createDraft') {
    $postData = json_decode(file_get_contents("php://input"), true);

    try {
        $response = $unipileSDK->Email->createDraft($postData);
        echo json_encode(['success' => true]);
    } catch (UnipileSDKException $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Error creating draft']);
    }
}

if ($_GET['action'] === 'getDraft') {
    $postData = json_decode(file_get_contents("php://input"), true);

    try {
        $draft = $unipileSDK->Email->getDraft($postData['draftId']);
        echo json_encode($draft);
    } catch (UnipileSDKException $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Error getting draft']);
    }
}

if ($_GET['action'] === 'editDraft') {
    $postData = json_decode(file_get_contents("php://input"), true);

    try {
        $response = $unipileSDK->Email->editDraft($postData['draftId'], $postData);
        echo json_encode(['success' => true]);
    } catch (UnipileSDKException $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Error editing draft']);
    }
}

if ($_GET['action'] === 'deleteDraft') {
    $postData = json_decode(file_get_contents("php://input"), true);

    try {
        $response = $unipileSDK->Email->deleteDraft($postData['draftId']);
        echo json_encode(['success' => true]);
    } catch (UnipileSDKException $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Error deleting draft']);
    }
}