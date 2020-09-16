<?php
namespace RomanN44\DML_instructions;

interface SqlWhere
{
    /**
     * создает where-конструкцию
     * 
     * @param array $condition
     * @param string $operator 
     * @return $this
     */
    public function where(array $condition, string $operator = "");

    /**
     * отчищает значение where
     * 
     * @return $this
     */
    public function clearWhere();
}