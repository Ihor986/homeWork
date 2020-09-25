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
  // масив банків  
    $banks = [
        "homoCredit" => [
            "name" => 'HomoCredit',
            "interest" => 0.04,
            "monthCommission" => 500,
            "accountFee" => 0
        ], 
        "softbank" => [
            "name" => 'Softbank',
            "interest" => 0.03,
            "monthCommission" => 1000,
            "accountFee" => 0
        ], 
        "strawberryBank" => [
            "name" => 'StrawberryBank',
            "interest" => 0.02,
            "monthCommission" => 0,
            "accountFee" => 6666
            ]
        ];
        // повертаємо значення загальної вартості товару з урахуванням кредиту від банку та загальний термін
    function totalCreditAmount($bankName, $creditAmount, $maxMonthlyPayment){
     $cost = $creditAmount + $bankName[accountFee];
     $creditTermValue = 1;
     $outstandingAmount = $cost - $maxMonthlyPayment;
     $totalCreditAmount = $cost;
     while ($outstandingAmount > 0) {
             $interest = round($outstandingAmount*$bankName[interest], 2);
             $monthCommission = $bankName[monthCommission];
           $outstandingAmount = $outstandingAmount + $interest + $monthCommission - $maxMonthlyPayment;
           $creditTermValue++;
           $totalCreditAmount = $totalCreditAmount + $interest + $monthCommission;
         } 
     $totalCreditAmountAndTerm = [
         "amount" => $totalCreditAmount,
         "term" => $creditTermValue
        ];
    //  echo "Загальна вартість товару з урахуванням кредиту від банку $bankName[name] становить:  $totalCreditAmountAndTerm[amount] грн!<br/>";
    //  echo "Кредит буде погашено за $totalCreditAmountAndTerm[term] міс.<hr><br/>";   
     return $totalCreditAmountAndTerm;
    };
// виводимо результат



    // totalCreditAmount($banks[homoCredit], $creditAmount, $maxMonthlyPayment);
    
    // // присвоюємо значення вартості та термінів змінним
    // $totalCreditAmountAndTermHomoCredit = totalCreditAmount($banks[homoCredit], $creditAmount, $maxMonthlyPayment);
    // // $totalCreditTermHomoCredit = creditTerm($banks[homoCredit], $creditAmount, $maxMonthlyPayment);
    // $totalCreditAmountAndTermSoftbank = totalCreditAmount($banks[softbank], $creditAmount, $maxMonthlyPayment);
    // // $totalCreditTermSoftbank = creditTerm($banks[softbank], $creditAmount, $maxMonthlyPayment);
    // $totalCreditAmountAndTermStrawberryBank = totalCreditAmount($banks[strawberryBank], $creditAmount, $maxMonthlyPayment);
    // // $totalCreditTermStrawberryBank = creditTerm($banks[strawberryBank], $creditAmount, $maxMonthlyPayment);
?>
    
</body>
</html>