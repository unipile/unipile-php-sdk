<?php include('header.php'); 

$addedAccountMessage = null;

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
                $response = $unipileSDK->Account->connectToImap($email, $password, $imapHost, $imapPort, $smtpHost, $smtpPort);
                $addedAccountMessage = "Connection success : $response";
            } catch (UnipileSDKException $e) {
                $addedAccountMessage = "Error : " . $e->getMessage();
            }
        }
?>

    <div class="container">
        <h1 class="mt-5">Add imap account</h1>
        <?php if ($addedAccountMessage !== null) : ?>
            <p><?php echo $addedAccountMessage; ?></p>
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
                    $response = $unipileSDK->Account->connectToLinkedin($username, $password);
                }
                else
                {
                    $access_token = $_POST['access_token'];
                    $response = $unipileSDK->Account->connectToLinkedinCookie($access_token);
                }
                $addedAccountMessage = "Connection Linkedin account success : $response";
            } catch (UnipileSDKException $e) {
                $addedAccountMessage = "Error : " . $e->getMessage();
            }
        }
?>

    <div class="container">
        <h1 class="mt-5">Add Linkedin account</h1>
        <?php if ($addedAccountMessage !== null) : ?>
            <p><?php echo $addedAccountMessage; ?></p>
        <?php else : ?>
            <form method="post">
                <label for="email">Username:</label>
                <input type="text" id="username" name="username" required><br>
                
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required><br>
    
                
                <input type="submit" value="Ajouter le compte">
            </form>
            ou VIA COOKIE
            <form method="post">
                <label for="access_token"> access_token (li_at):</label>
                <input type="text" id="access_token" name="access_token" required><br>
                
                
                <input type="submit" value="Ajouter le compte">
            </form>
        <?php endif; ?>
    </div>
    <?php }
     elseif ($_GET['type'] == 'whatsapp') {
    $whatsappQRCode = null;

    try {
        $whatsappString = $unipileSDK->Account->connectToWhatsApp();
        $whatsappQRCode = '<img src="https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl='.rawurlencode($whatsappString['checkpoint']['qrcode']).'&choe=UTF-8" />';
    } catch (UnipileSDKException $e) {
        echo "Erreur lors de la connexion à WhatsApp : " . $e->getMessage();
    }

?>

    <div class="container">
        <h1 class="mt-5">Add WhatsApp account</h1>
        <?php if ($whatsappQRCode !== null) : ?>
            <p>Scan QRcode to connect your WhatsApp account:</p>
            <?php echo $whatsappQRCode; ?>
        <?php else : ?>
            <p>Error. Please try again</p>
        <?php endif; ?>
    </div>

<?php
     }
}
else
{
    ?>
        <div class="container mt-5">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <div class="btn-block p-4 border rounded text-center">
                    <h2>Choose account type</h2>
                    <a href="?type=imap" class="btn btn-secondary btn-lg mt-3">IMAP</a>
                    <a href="?type=whatsapp" class="btn btn-success btn-lg mt-3">WhatsApp</a>
                    <a href="?type=linkedin" class="btn btn-primary btn-lg mt-3">Linkedin</a>
 
                </div>
            </div>
        </div>
    </div>
    <?php
}
?>



</body>
</html>