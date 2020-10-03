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
    public function where(array $condition);

    public function andWhere(array $condition);

    public function orWhere(array $condition);

}