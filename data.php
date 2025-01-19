<?php
include_once('db.php');
include_once('model.php');

$conn = get_connect();

$user_id = isset($_GET['user'])
    ? (int)$_GET['user']
    : null;

if ($user_id) {
    // Get transactions balances
    $transactions = get_user_transactions_balances($user_id, $conn);
    ?>
    <h2>Transactions of `<?php echo get_user($user_id, $conn);?>`</h2>
    <table>
        <tr><th>Mounth</th><th>Amount</th></tr>
        <?php 
        foreach ($transactions as $key => $value) {
        ?>
        <tr><td><?php echo $key;?></td><td><?php echo $value;?></td>
        <?php 
        }
        ?>
    </table>
    <?php
}
?>