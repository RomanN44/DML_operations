<?php

namespace RomanN44\DML_instructions\Task_3;

require_once('SqlCondition.php');

$whereCondition = (new SqlCondition(array("true"=>"true")))->or(array("id","=","1"));

echo $whereCondition->getRaw();
