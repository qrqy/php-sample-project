<?php

include_once('db.php');
include_once('model.php');
include_once('test.php');

$conn = get_connect();


  
$month_names = [
    '01' => 'January',
    '02' => 'Februarry',
    '03' => 'March'
]
?>
    
<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>User transactions information</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <?php
  // Uncomment to see data in db
  // echo "<pre>";
  // get_info_by_userid($conn, 10);
  // echo "</pre>";
  ?>
  <h1>User transactions information</h1>
  <form action="data.php" method="get">
    <label for="user">Select user:</label>
    <select name="user" id="user">
    <?php
    $users = get_users($conn);
    foreach ($users as $id => $name) {
        echo "<option value=\"$id\">".$name."</option>";
    }
    ?>
    </select>
    <input id="submit" type="submit" value="Show">
  </form>

  <div id="data">
      <h2>Transactions of `User name`</h2>
      <table>
          <tr><th>Mounth</th><th>Amount</th></tr>
          <tr><td>...</td><td>...</td>
       </table>
  </div>  
<script src="script.js"></script>
</body>
</html>
