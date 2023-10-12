<?php include('header.php');


$sendMessageResult = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $recipient = $_POST['recipient'] ?? '';
    $messageContent = $_POST['message_content'] ?? '';

    // Vérifiez si les champs sont vides
    if (empty($recipient) || empty($messageContent)) {
        $sendMessageResult = "Veuillez remplir tous les champs.";
    } else {
        // Préparez les données pour l'envoi du message à l'API
        $messageData = [
            'recipient' => $recipient,
            'content' => $messageContent,
        ];

        try {
            // Appelez la méthode d'envoi de message de votre API
            $unipileSDK->Messaging->sendMessage($messageData);

            // Message envoyé avec succès
            $sendMessageResult = "Message envoyé avec succès à $recipient.";
        } catch (Exception $e) {
            // Erreur lors de l'envoi du message
            $sendMessageResult = "Erreur lors de l'envoi du message : " . $e->getMessage();
        }
    }
}
?>

<div class="container">
    <h1 class="mt-5">Nouveau Message</h1>
    <?php if ($sendMessageResult !== null) : ?>
        <p><?php echo $sendMessageResult; ?></p>
    <?php else : ?>
        <form method="post">
            <div class="form-group">
                <label for="recipient">Destinataire:</label>
                <input type="text" class="form-control" id="recipient" name="recipient" required>
            </div>
            <div class="form-group">
                <label for="message_content">Contenu du Message:</label>
                <textarea class="form-control" id="message_content" name="message_content" rows="4" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Envoyer</button>
        </form>
    <?php endif; ?>
</div>
</body>
</html>
