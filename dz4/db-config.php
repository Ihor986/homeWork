<?php
$dbConnection = mysqli_connect('127.0.0.1', 'root', 'root', 'atm');


if (!$dbConnection) {
    echo 'Cannot connect to DB </br>';
    echo mysqli_connect_error();
    exit();
}
$findMoneySumm = mysqli_fetch_assoc(mysqli_query($dbConnection, "SELECT sum(value*quantly) AS findMoneySumm FROM `amounts`"))[findMoneySumm]; 