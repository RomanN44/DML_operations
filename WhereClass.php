<?php
namespace RomanN44\DML_instructions;

require_once('Table.php');
require_once('SqlWhere.php');

abstract class WhereClass implements Table, SqlWhere
{
    /**
     * @var string
     */
    protected $tableName;
    /**
     * @var string
     */
    protected $where;
    /**
     * @var string
     */
    protected $instruction;
}

