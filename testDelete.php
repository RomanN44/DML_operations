<?php

namespace RomanN44\DML_instructions;

require_once('Delete.php');
$whereCondition = (new SqlCondition(array("true"=>"true")))->or(array("id","=","1"));
$q = (new Delete())->from("table")->setWhere($whereCondition);

echo $q->getRaw();


?>