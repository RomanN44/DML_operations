<?php
namespace RomanN44\DML_instructions;

require_once('Select.php');
$whereCondition = (new SqlCondition(array("food","=","apple")))->or(array("id","=","1"));
$q = new Select();
$q->select()->from("table_name")->leftJoin(array("profile"=>"t1"),array("t.id"=>"t1.user"))->setWhere($whereCondition)->limit(200);
echo $q->getRaw();

