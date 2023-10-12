<?php include('header.php'); 

$reconnectAccountMessage = null;

if (isset($_GET['type'])) {
    if ($_GET['type'] == 'imap') 
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];
            $imapHost = $_POST['imap_host'];
            $imapPort = (int)$_POST['imap_port'];
            $smtpHost = $_POST['smtp_host'];
            $smtpPort = (int)$_POST['smtp_port'];

            try {
                $response = $unipileSDK->Account->reconnectToImap($email, $password, $imapHost, $imapPort, $smtpHost, $smtpPort);
                $reconnectAccountMessage = "Reconnection success : $response";
            } catch (UnipileSDKException $e) {
                $reconnectAccountMessage = "Error : " . $e->getMessage();
            }
        }
?>

    <div class="container">
        <h1 class="mt-5">Reconnect un compte IMAP</h1>
        <?php if ($reconnectAccountMessage !== null) : ?>
            <p><?php echo $reconnectAccountMessage; ?></p>
        <?php else : ?>
            <form method="post">
                <label for="email">Email:</label>
                <input type="text" id="email" name="email" required><br>
                
                <label for="password">Mot de passe:</label>
                <input type="password" id="password" name="password" required><br>
                
                <label for="imap_host">Hôte IMAP:</label>
                <input type="text" id="imap_host" name="imap_host" required><br>
                
                <label for="imap_port">Port IMAP:</label>
                <input type="number" id="imap_port" name="imap_port" value="993" required><br>
                
                <label for="smtp_host">Hôte SMTP:</label>
                <input type="text" id="smtp_host" name="smtp_host" required><br>
                
                <label for="smtp_port">Port SMTP:</label>
                <input type="number" id="smtp_port" name="smtp_port" value="587" required><br>
                
                <input type="submit" value="Ajouter le compte">
            </form>
        <?php endif; ?>
    </div>
    <?php }
    elseif ($_GET['type'] == 'linkedin') 
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    

            try {
                if(isset($_POST['username']))
                {
                    $username = $_POST['username'];
                    $password = $_POST['password'];
                    $response = $unipileSDK->Account->reconnectToLinkedin($username, $password);
                }
                else
                {
                    $access_token = $_POST['access_token'];
                    $csrf_token = $_POST['csrf_token'];
                    $response = $unipileSDK->Account->reconnectToLinkedinCookie($access_token, $csrf_token);
                }
                $reconnectAccountMessage = "Reconnexion au compte Linkedin réussie : $response";
            } catch (UnipileSDKException $e) {
                $reconnectAccountMessage = "Erreur d'authentification : " . $e->getMessage();
            }
        }
?>

    <div class="container">
        <h1 class="mt-5">Reconnecter un compte Linkedin</h1>
        <?php if ($reconnectAccountMessage !== null) : ?>
            <p><?php echo $reconnectAccountMessage; ?></p>
        <?php else : ?>
            <form method="post">
                <label for="email">Username:</label>
                <input type="text" id="username" name="username" required><br>
                
                <label for="password">Mot de passe:</label>
                <input type="password" id="password" name="password" required><br>
    
                
                <input type="submit" value="Reconnecter le compte">
            </form>
            ou VIA COOKIE
            <form method="post">
                <label for="access_token"> access_token (li_at):</label>
                <input type="text" id="access_token" name="access_token" required><br>
                
                <label for="csrf_token">csrf_token (JSESSIONID):</label>
                <input type="text" id="csrf_token" name="csrf_token" required><br>
    
                
                <input type="submit" value="Reconnecter le compte">
            </form>
        <?php endif; ?>
    </div>
    <?php }
     elseif ($_GET['type'] == 'WHATSAPP') {
    $whatsappQRCode = null;

    try {
        $whatsappString = $unipileSDK->Account->reconnectToWhatsApp($_GET['id']);
        $whatsappQRCode = '<img src="https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl='.rawurlencode($whatsappString['qrcode']).'&choe=UTF-8" />';
    } catch (UnipileSDKException $e) {
        echo "Erreur lors de la connexion à WhatsApp : " . $e->getMessage();
    }

?>

    <div class="container">
        <h1 class="mt-5">Reconnect to WhatsApp</h1>
        <?php if ($whatsappQRCode !== null) : ?>
            <p>Scan QRcode bellow  :</p>
            <?php echo $whatsappQRCode; ?>
        <?php else : ?>
            <p>Error.</p>
        <?php endif; ?>
    </div>

<?php
     }
}
?>



</body>
</html>