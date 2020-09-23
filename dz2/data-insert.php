<?php
try {
      $dataStr = file_get_contents('data.json');
      $dataArray = json_decode($dataStr, true);
    } catch (Exception $ex) {
      $dataArray = [];
    }
$availableBanknotes = $dataArray;
// рахуємо загальну суму коштів у масиві
function  allCount ($availableBanknotes){
    $sum = 0;
for($i = 0; $i < count($availableBanknotes); $i++){
  $sum = $sum + $availableBanknotes[$i][1]*$availableBanknotes[$i][0];
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
    [0, 1000],
    [0, 500],
    [0, 200],
    [0, 100],
    [0, 50],
    [0, 20],
    [0, 10],
    [0, 5]
];
for($i = 0; $i < count($availableBanknotes); $i++){
    $used = floor($balanceAmount / $availableBanknotes[$i][1]);
    $availableBanknotes[$i][0] = $availableBanknotes[$i][0] - $used;
    $balanceAmountMod = 0;
    if ($availableBanknotes[$i][0] < 0){
      $balanceAmountMod = abs ( $availableBanknotes[$i][0] )*$availableBanknotes[$i][1];
      $used = $used + $availableBanknotes[$i][0];
      $availableBanknotes[$i][0] = 0; 
    };
    $balanceAmount = $balanceAmount % $availableBanknotes[$i][1] + $balanceAmountMod;
    $usedBanknotes[$i][0] = $used;
     if ($usedBanknotes[$i][0]) {
        $message = $message.$usedBanknotes[$i][0]."*".$usedBanknotes[$i][1]." ";
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
