<?php
require_once 'db-config.php';
$queryGet = "SELECT `value`, `quantly` FROM `amounts`";
$dataStr = mysqli_query($dbConnection, $queryGet);
$availableBanknotes = [];
$usedBanknotes = [];
// рахуємо загальну суму коштів;    
function findMoneySumm($dataArray){
    $sum = array_reduce(array_keys($dataArray), function($carry, $key) use ($dataArray) {
    $carry += $dataArray[$key]*$key;
    return $carry;
}, 0);
return $sum;
};
// перевіряємо наявність виключень
function searchError ($desiredAmount,$findMoneySumm, $usedBanknotes){
if ($desiredAmount>$findMoneySumm){
  $errorMessage = "Недостатньо коштів";
} else if (!$desiredAmount){
  $errorMessage = "Невірно вказана сума (нуль неможливо видати)";
} else if ($desiredAmount%5!==0){
  $errorMessage = "Невірно вказана сума (не кратна 5, неможливо видати)";
} else if (findMoneySumm ($usedBanknotes)<$desiredAmount){
  $errorMessage = "Неможливо видати (недостатньо дрібних купюр)";
 };
 return $errorMessage;
};
// формуємо повідомлення для відображення числа виданих купюр
function messageGenerator ($usedBanknotes) {
  foreach($usedBanknotes as $key => $value){
    if ($usedBanknotes[$key]) {
      $message = $message.$usedBanknotes[$key]."*".$key." ";
    }
   }
   return $message;
};
while ( ($availableBanknote = mysqli_fetch_assoc($dataStr))  ) {
    $availableBanknotes[$availableBanknote[value]] = $availableBanknote[quantly];
    }     
$desiredAmount = htmlspecialchars($_POST['amount']);
$balanceAmount = $desiredAmount;
// $desired = $desiredAmount;
foreach($availableBanknotes as $key => $value){
    $used = floor($balanceAmount/$key);
    $availableBanknotes[$key] = $availableBanknotes[$key] - $used;
    $balanceAmountMod = 0;
    if ($availableBanknotes[$key] < 0){
      $balanceAmountMod = abs ( $availableBanknotes[$key] )*$key;
      $used = $used + $availableBanknotes[$key];
      $availableBanknotes[$key] = 0; 
     };
    $balanceAmount = $balanceAmount % $key + $balanceAmountMod;
    $usedBanknotes[$key] = $used;
    };
$message = messageGenerator ($usedBanknotes); 
$errorMessage = searchError ($desiredAmount, $findMoneySumm, $usedBanknotes);
if ($errorMessage){
echo "<div>$errorMessage</div>";
$desiredAmount = 0;
 } else {
echo "Сума: $desiredAmount </br>";
echo "Число купюр: $message";
foreach($availableBanknotes as $key => $value){
    $queryUpdate = "UPDATE `amounts` SET `quantly` = '{$value}' WHERE `value` = '{$key}'";
    $result = mysqli_query($dbConnection, $queryUpdate);
    };
 };
if (htmlspecialchars($_POST['name'])) {
$customerName = htmlspecialchars($_POST['name']);
} else {
$customerName = "anonymous";
};
$date = date("Y-m-d H:i:s");
$balanceAfter = $findMoneySumm - $desiredAmount; 
$queryInsert = "INSERT INTO `logs` (`name`, `date`, `amount`, `balance_before`, `balance_after`, `note`) VALUES ('{$customerName}', '{$date}', '{$desiredAmount}', '{$findMoneySumm}', '{$balanceAfter}', '{$errorMessage}')"; 
$logResult = mysqli_query($dbConnection, $queryInsert);
echo "<div><button><a href=\"index.php\">повернення до форми вводу</a></button></div>";
?>