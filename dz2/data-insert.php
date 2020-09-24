<?php
try {
      $dataStr = file_get_contents('data.json');
      $dataArray = json_decode($dataStr, true);
    } catch (Exception $ex) {
      $dataArray = [];
    }
$availableBanknotes = $dataArray;
// рахуємо загальну суму коштів у банкоматі
function  allCount ($availableBanknotes){
  $sum = 0;
  foreach($availableBanknotes as $key => $value){

  $sum = $sum + $key*$value;
}
return $sum;
};
$allCount = allCount ($availableBanknotes);
$desiredAmount = htmlspecialchars($_POST['amount']);
$balanceAmount = $desiredAmount;
$usedBanknotes = [
  1000 => 0,
  500 => 0,
  200 => 0,
  100 => 0,
  50 => 0,
  20 => 0,
  10 => 0,
  5 => 0
];
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
     if ($usedBanknotes[$key]) {
       
        $message = $message.$usedBanknotes[$key]."*".$key." ";
   };
};
// виведення помилки
function echoError ($errorMessage){
    echo "<div>$errorMessage</div>";
    echo "<div><button><a href=\"index.php\">повернення до форми вводу</a></button></div>";
    exit();
};
// перевіряємо наявність виключень
function searchError ($desiredAmount,$allCount, $usedBanknotes){
if ($desiredAmount>$allCount){
  $errorMessage = "Недостатньо коштів";
} else if (!$desiredAmount){
  $errorMessage = "Невірно вказана сума (нуль неможливо видати)";
} else if (gettype($desiredAmount/5)!==integer){
  $errorMessage = "Невірно вказана сума (не кратна 5, неможливо видати)";
} else if (allCount ($usedBanknotes)<$desiredAmount){
  $errorMessage = "Неможливо видати (недостатньо дрібних купюр)";
 } else {
  return false;
}
echoError ($errorMessage);
};
searchError ($desiredAmount, $allCount, $usedBanknotes);
echo "Сума: $desiredAmount </br>";
echo "Число купюр: $message";
echo "<div><button><a href=\"index.php\">повернення до форми вводу</a></button></div>";
$newDataSrt = json_encode($availableBanknotes, JSON_PRETTY_PRINT);
$result = file_put_contents('data.json', $newDataSrt);
?>