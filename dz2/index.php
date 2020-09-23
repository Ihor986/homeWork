<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<form action="data-insert.php" method="post">
    <div><input type="number" min="0" required name="amount" placeholder="вкажіть бажану суму"></div>
    <input type="submit">
</form>
<?php
// [
//   [5, 1000],
//   [5, 500],
//   [5, 200],
//   [3, 100],
//   [3, 50],
//   [1, 20],
//   [2, 10],
//   [2, 5]
// ]
?>
</body>
</html>