<?php include('header.php');


$sendMessageResult = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $recipient = $_POST['recipient'] ?? '';
    $messageContent = $_POST['message_content'] ?? '';

    if (empty($recipient) || empty($messageContent)) {
        $sendMessageResult = "Please fill all fields.";
    } else {
        $messageData = [
            'recipient' => $recipient,
            'content' => $messageContent,
        ];

        try {
            $unipileSDK->Messaging->sendMessage($messageData);

            $sendMessageResult = "Message send to $recipient.";
        } catch (Exception $e) {
            $sendMessageResult = "Error: " . $e->getMessage();
        }
    }
}
?>

<div class="container">
    <h1 class="mt-5">New message</h1>
    <?php if ($sendMessageResult !== null) : ?>
        <p><?php echo $sendMessageResult; ?></p>
    <?php else : ?>
        <form method="post">
            <div class="form-group">
                <label for="recipient">To:</label>
                <input type="text" class="form-control" id="recipient" name="recipient" required>
            </div>
            <div class="form-group">
                <label for="message_content">Content</label>
                <textarea class="form-control" id="message_content" name="message_content" rows="4" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Send</button>
        </form>
    <?php endif; ?>
</div>
</body>
</html>
