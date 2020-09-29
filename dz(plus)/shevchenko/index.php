<?php 
try {
      $dataArr = file('shevchenko.txt');
    } catch (Exception $ex) {
      $dataArr = [];
    }
// дізнаємося довжину найдовшого рядка    
$countLine = 0;
foreach ($dataArr as $line) {
    $countL = mb_strlen($line);
if ($countL > $countLine){
     $countLine = $countL;
 };
};  
// дізнаємося кількість рядеків
$countArr = count ($dataArr);
// виводимо результат
function printLine($dataArr, $countLine){
$countArr = count ($dataArr);
for ($i=0; $i<$countLine; $i++) {
    $line ="";
   for ($q=0; $q<$countArr; $q++){
     if ($dataArr[$q] == $dataArr[0]){
       $arrDataStr = preg_split('/(?<!^)(?!$)/u', $dataArr[$q]);
       array_splice($arrDataStr, 0, 1);
     } else {
       $arrDataStr = preg_split('/(?<!^)(?!$)/u', $dataArr[$q]);
     };
     array_pop($arrDataStr);
     if (!$arrDataStr[$i]){
         $arrDataStr[$i] = " ";
     };
     $line = $line.$arrDataStr[$i]."      ";
     
 }
echo "<pre>$line </br></pre>";
};
}
printLine($dataArr, $countLine);
?>