<?php

namespace RomanN44\DML_instructions;

require_once('Update.php');

$q = (new Update())->table("table")->set(array("a" => 10, "b" => 22, "v" => 0));
echo $q->getRaw();
echo "<br>";
$q->clear();

$q->table("table")->set(array("a" => 10, "b" => 22, "v" => 0))->where(array("meter","<=",10));
echo $q->getRaw();
echo "<br>";
$q->clear();