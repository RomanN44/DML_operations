<?php
namespace RomanN44\DML_instructions;

require_once('Insert.php');

$q = new Insert();
$q -> into("table", array("num1","num2","num3"))->values(array(array(1,2,3),array(4,5,6),array(6,7,8)));
echo $q->getRaw();
$q->clear();
echo "<br>";
$q -> into("table2")->values(array("a","f","h"));

echo $q->getRaw();