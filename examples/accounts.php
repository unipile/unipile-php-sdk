<?php include('header.php'); 

if($_GET["delete"])
{

try {
    $result = $unipileSDK->Account->delete($_GET["delete"]);

    if ($result) {
        echo "Account with ID {$_GET["delete"]} has been successfully deleted.";
    } else {
        echo "Failed to delete account with ID {$_GET["delete"]}.";
    }
} catch (UnipileSDKException $e) {
    echo "Error: " . $e->getMessage();
}
}

$actual_link = (empty($_SERVER['HTTPS']) ? 'http' : 'https') . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$hostedLink =  "#";
try {
    $result =  $unipileSDK->Account->createHostedLink(
        'PT1H',
        'My User ID',
        $actual_link.'?status=success',
        $actual_link.'?status=fail',
        $actual_link.'/examples/callback.php',
        '',
        '*'
    );
    $hostedLink = $result['url'];
} catch (UnipileSDKException $e) {
    echo "Error: " . $e->getMessage();
}

$accounts = [];
    try {
        $accounts = $unipileSDK->Account->list()['items'];
    } catch (UnipileSDKException $e) {
        echo "Error: " . $e->getMessage();
    }
?>
<div class="container">
    <h1 class="mt-5">Accounts</h1>
    <a href="add-account.php" class="btn btn-primary mr-2">Add Account (Native Auth)</a>
    <a href="<?=$hostedLink?>" id="hostedlink" class="btn btn-primary mr-2">Add Account (Hosted Auth)</a>

    <?php if (empty($accounts)) : ?>
        <p>No account</p>
    <?php else : ?>
        <table class="table">
            <thead>
                <tr>
                    <th>Provider</th>
                    <th>Account</th>
                    <th>Created At</th>
                    <th>ID</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($accounts as $account) : ?>
                    <tr>
                        <td><img src="icons/<?php echo $account['type']; ?>.png" alt="<?php echo $account['type']; ?>"></td>
                        <td><?php echo $account['name']; ?></td>
                        <td><?php echo $account['created_at']; ?></td>
                        <td><?php echo $account['id']; ?></td>
                        <td><pre><?php echo json_encode($account['sources']); ?></pre></td>
                        <td>
                            <a href="?delete=<?php echo $account['id']; ?>" class="btn btn-danger">
                                <i class="bi bi-trash"></i> Delete
                            </a>
                            <a href="reconnect-account.php?id=<?php echo $account['id']; ?>&type=<?php echo $account['type']; ?>" class="btn btn-primary">
                                <i class="bi bi-trash"></i> Reconnect
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>
</body>
</html>