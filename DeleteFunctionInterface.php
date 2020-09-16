<?php
namespace RomanN44\DML_instructions;

interface DeleteFunctionInterface
{
    /**
     * Присваевает значение переменной $table 
     * 
     * @param string $tableName параметр функции
     * @return $this;
     */
    public function from(string $tableName);

}