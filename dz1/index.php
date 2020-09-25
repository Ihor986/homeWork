<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php
    $maxMonthlyPayment = 5000;
    $creditAmount = 34499;
    // повертаємо значення загальної вартості товару з урахуванням кредиту від банку та загальний термін
    function totalCreditAmount($bankName, $creditAmount, $maxMonthlyPayment){
     $cost = $creditAmount + $bankName["accountFee"];
     $creditTermValue = 1;
     $outstandingAmount = $cost - $maxMonthlyPayment;
     $totalCreditAmount = $cost;
     while ($outstandingAmount > 0) {
             $interest = round($outstandingAmount*$bankName["interest"], 2);
             $monthCommission = $bankName["monthCommission"];
           $outstandingAmount = $outstandingAmount + $interest + $monthCommission - $maxMonthlyPayment;
           $creditTermValue++;
           $totalCreditAmount = $totalCreditAmount + $interest + $monthCommission;
         };
     $totalCreditAmountAndTerm = [
         "amount" => $totalCreditAmount,
         "term" => $creditTermValue
        ];
     return $totalCreditAmountAndTerm;
    };
    // виводимо результат
    function outputTheResult ($banks, $creditAmount, $maxMonthlyPayment){
       foreach($banks as $bank => $value) {
       $totalCreditAmountAndTermInBank = totalCreditAmount($value, $creditAmount, $maxMonthlyPayment);
       echo "Загальна вартість товару з урахуванням кредиту від банку \"$bank\" становить: $totalCreditAmountAndTermInBank[amount] грн!<br/>";
       echo "Кредит буде погашено за $totalCreditAmountAndTermInBank[term] міс.<hr><br/>"; 
    };
    };
    // масив банків  
    $banks = [
        "HomoCredit" => [
            "name" => 'HomoCredit',
            "interest" => 0.04,
            "monthCommission" => 500,
            "accountFee" => 0
        ], 
        "Softbank" => [
            "name" => 'Softbank',
            "interest" => 0.03,
            "monthCommission" => 1000,
            "accountFee" => 0
        ], 
        "StrawberryBank" => [
            "name" => 'StrawberryBank',
            "interest" => 0.02,
            "monthCommission" => 0,
            "accountFee" => 6666
            ]
        ];
    outputTheResult ($banks, $creditAmount, $maxMonthlyPayment);
?>
</body>
</html>