<?php
$word1 = array('Чудесных', 'Суровых', 'Занятных', 'Внезапных');
$word2 = array('слов', 'зим', 'глаз', 'дней', 'лет', 'мир', 'взор');
$word3 = array('прикосновений', 'поползновений', 'судьбы явлений',  'сухие листья', 'морщины смерти', 'долины края', 'замены нету', 'сухая юность', 'навек исчезнув');
$word4 = array('обретаю', 'понимаю', 'начертаю', 'закрываю', 'оставляю',  'вынимаю', 'умираю', 'замерзаю', 'выделяю');
$word5 = array('очертания', 'безысходность', 'начертанья', 'смысл жизни', 'вирус смерти', 'радость мира');
$randWords1 = array_rand($word1, 2);
$randWords2 = array_rand($word2, 2);
$randWords3 = array_rand($word3, 2);
$firstLine = $word1[$randWords1[0]]." ".$word2[$randWords2[0]]." ".$word3[$randWords3[0]];
$secondLine = $word1[$randWords1[1]]." ".$word2[$randWords2[1]]." ".$word3[$randWords3[1]];
$thirdLine = "Я ".$word4[array_rand($word4)]." ".$word5[array_rand($word5)];
echo "$firstLine</br>$secondLine</br>$thirdLine</br>";
?>
