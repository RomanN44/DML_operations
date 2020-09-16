<?php
namespace RomanN44\DML_instructions;

interface SqlQueryLimitable
{
    /**
     * создает LIMIT конструкцию
     * 
     * @param int $limit
     * @return $this;
     */
    public function limit(int $limit);
}