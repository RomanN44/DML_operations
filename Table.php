<?php
namespace RomanN44\DML_instructions;

require_once('DmlCreator.php');

interface Table extends DmlCreator
{
    /**
     * Присваевает значение переменной $table 
     * 
     * @param string $tableName параметр функции
     * @return $this;
     */
    public function table(string $tableName);

    /**
     * отчищает значение переменной tableName
     * 
     * @return $this
     */
    public function clearTable();
}