<?php
namespace RomanN44\DML_instructions;

interface UpdateFunctionInterface
{
    /**
     * создает set конструкцию
     * 
     * @param $condition
     * @return $this
     */
    public function set(array $condition);
}