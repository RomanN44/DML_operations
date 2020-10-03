<?php

namespace RomanN44\DML_instructions;

require_once('Update.php');
$whereCondition = (new SqlCondition(array("name"=>"roma")))->and(array("home","rostov"));
$q = (new Update())->table("table")->set(array("a" => 10, "b" => 22, "v" => 0))->setWhere($whereCondition);
echo $q->getRaw();
echo "<br>";