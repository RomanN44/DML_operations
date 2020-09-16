<?php
namespace RomanN44\DML_instructions;

interface InsertFunctionInterface
{
    /**
     * отчищает конструкцию value
     * 
     * @return $this;
     */
    public function valueClear();

    /**
     * Присваевает значение переменной $table 
     * 
     * @param string $tableName
     * @param array $condition = array()
     * @return $this;
     */
    public function into(string $tableName, array $condition = array());

     /**
     * присваетвает значение переменной values
     * 
     * @param array $condition
     * @return $this
     */
    public function values(array $condition);

}