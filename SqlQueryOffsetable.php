<?php
namespace RomanN44\DML_instructions;

interface SqlQueryOffsetable
{
    /**
     * создает OFFSET конструкцию
     * 
     * @param int $offset
     * @return $this;
     */
    public function offset(int $offset);
}