<?php
namespace RomanN44\DML_instructions;

require_once('Select.php');

$q = new Select();
$q->select()->from("table_name")->where(array("food","=","apple"))->limit(200);
echo $q->getRaw();
echo "<br>";
$q->clear();

$q->select()->from("table_name")->where(array("food","=","apple"))->where(array("num",">=","5"),"AND")->orderBy(array("num","name"));
echo $q->getRaw();
echo "<br>";
$q->clear();

$q->select()->from("table_name")->join("table2", array("table1.column" => "table2.column"));
echo $q->getRaw();
echo "<br>";
$q->clear();

$q->select()->from("table_name")->join("table2", array("table1.column" => "table2.column"), "LEFT");
echo $q->getRaw();
echo "<br>";
$q->clear();
