<?php

namespace RomanN44\DML_instructions;

require_once('Delete.php');

$q = (new Delete())->from("table")->where(array("tab","r"));
echo $q->getRaw();
echo "<br>";
$q->clear();
$q->from("pap");
echo $q->getRaw();
echo "<br>";
$q->clear();
$q->from("hah")->where(array("job"=>"teacher"))->andWhere(array("apple",">=",200));
echo $q->getRaw();
echo "<br>";
$q->clear();
$q->from("hah")->where(array("job"=>"teacher"))->orWhere(array("apple",">=",200));
echo $q->getRaw();
echo "<br>";
$q->clear();
$q->from("hah")->notWhere(array("apple",">=",200));
echo $q->getRaw();
echo "<br>";

?>