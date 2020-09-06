<?php
namespace RomanN44\DML_instructions;

require_once('Table.php');

abstract class NonWhereClass implements Table
{
    /**
     * @var string
     */
    protected $tableName;
    /**
     * @var string
     */
    protected $instruction;
}
