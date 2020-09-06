<?php
namespace RomanN44\DML_instructions;

interface DmlCreator
{
    /**
     * возвращает sql-команду
     * 
     * @return string
     */
    public function getInstruction();

    /**
     * собирает sql-команду
     * 
     * @return string
     */
    public function buildInstruction();

    /**
     * отчищает sql-команду и прочие конскрукции
     * 
     * @return $this
     */
    public function clear();

}