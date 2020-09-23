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
        homoCredit => [
            name => 'HomoCredit',
            interest => 0.04,
            monthCommission => 500,
            accountFee => 0
        ], 
        softbank => [
            name => 'Softbank',
            interest => 0.03,
            monthCommission => 1000,
            accountFee => 0
        ], 
        strawberryBank => [
            name => 'StrawberryBank',
            interest => 0.02,
            monthCommission => 0,
            accountFee => 6666
            ]
        ];
        // повертаємо значення загальної вартості товару з урахуванням кредиту від банку(можливо обрахувати загальний термін)
    function totalCreditAmount($bankName, $creditAmount, $maxMonthlyPayment){
     $cost = $creditAmount + $bankName[accountFee];
    //  $creditTermValue = 1;
     $i = $cost - $maxMonthlyPayment;
     $totalCreditAmount = $cost;
     while ($i > 0) {
             $interest = round($i*$bankName[interest], 2);
             $monthCommission = $bankName[monthCommission];
           $i = $i + $interest + $monthCommission - $maxMonthlyPayment;
        //    $creditTermValue++;
           $totalCreditAmount = $totalCreditAmount + $interest + $monthCommission;
         } 
     echo "Загальна вартість товару з урахуванням кредиту від банку \"$bankName[name]\" становить:  $totalCreditAmount грн!<br/>";
    //  echo "Кредит буде погашено за $creditTermValue міс.<hr><br/>";
     return $totalCreditAmount;
    }
    // повертаємо термін погашення кредиту(можливо обрахувати загальну вартість товару з урахуванням кредиту від банку)
    function creditTerm($bankName, $creditAmount, $maxMonthlyPayment){
     $cost = $creditAmount + $bankName[accountFee];
     $creditTermValue = 1;
     $i = $cost - $maxMonthlyPayment;
    //  $totalCreditAmount = $cost;
      while ($i > 0) {
             $interest = round($i*$bankName[interest], 2);
             $monthCommission = $bankName[monthCommission];
           $i = $i + $interest + $monthCommission - $maxMonthlyPayment;
           $creditTermValue++;
        //    $totalCreditAmount = $totalCreditAmount + $interest + $monthCommission;
         } 
         //  echo "Загальна вартість товару з урахуванням кредиту від банку \"$bankName[name]\" становить:  $totalCreditAmount грн!<br/>";
     echo "Кредит буде погашено за $creditTermValue міс.<hr><br/>";
     return $creditTerm;
    }
    // присвоюємо значення вартості та термінів змінним
    $totalCreditAmountHomoCredit = totalCreditAmount($banks[homoCredit], $creditAmount, $maxMonthlyPayment);
    $totalCreditTermHomoCredit = creditTerm($banks[homoCredit], $creditAmount, $maxMonthlyPayment);
    $totalCreditAmountSoftbank = totalCreditAmount($banks[softbank], $creditAmount, $maxMonthlyPayment);
    $totalCreditTermSoftbank = creditTerm($banks[softbank], $creditAmount, $maxMonthlyPayment);
    $totalCreditAmountStrawberryBank = totalCreditAmount($banks[strawberryBank], $creditAmount, $maxMonthlyPayment);
    $totalCreditTermStrawberryBank = creditTerm($banks[strawberryBank], $creditAmount, $maxMonthlyPayment);
?>
    
</body>
</html>