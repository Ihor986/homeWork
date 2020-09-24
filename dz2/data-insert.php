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
// перевіряємо чи є у банкоматі необхідна сума
if ($desiredAmount>$allCount){
    echo "<div>Недостатньо коштів</div>";
    echo "<div><button><a href=\"index.php\">повернення до форми вводу</a></button></div>";
    exit();
};
// перевіряємо чи не є введена сума рівною нулю
if (!$desiredAmount){
    echo "<div>Невірно вказана сума (нуль неможливо видати)</div>";
    echo "<div><button><a href=\"index.php\">повернення до форми вводу</a></button></div>";
    exit();
};
// перевіряємо чи введена сума кратна 5
if (gettype($desiredAmount/5)!==integer){
    echo "<div>Невірно вказана сума (не кратна 5, неможливо видати)</div>";
    echo "<div><button><a href=\"index.php\">повернення до форми вводу</a></button></div>";
    exit();
};
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
// перевіряємо чи є у банкоматі необхідні купюри
if (allCount ($usedBanknotes)<$desiredAmount){
    echo "<div>Неможливо видати (недостатньо дрібних купюр)</div>";
    echo "<div><button><a href=\"index.php\">повернення до форми вводу</a></button></div>";
    exit();
 };
echo "Сума: $desiredAmount </br>";
echo "Число купюр: $message";
echo "<div><button><a href=\"index.php\">повернення до форми вводу</a></button></div>";
$newDataSrt = json_encode($availableBanknotes, JSON_PRETTY_PRINT);
$result = file_put_contents('data.json', $newDataSrt);

?>