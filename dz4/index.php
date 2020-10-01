<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php
require_once 'db-config.php';
echo "Поточний баланс: $findMoneySumm UAH";
echo "</br>"; 
?>
<form action="data-insert.php" method="post">
    <div><input type="number" min="0" required name="amount" placeholder="вкажіть бажану суму"></div>
    <div><input type="text" name="name" placeholder="вкажіть ім'я"></div>
    <input type="submit">
</form>

</body>
</html>