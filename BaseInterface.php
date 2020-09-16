<?php
namespace RomanN44\DML_instructions;

interface BaseInterface
{
    /**
     * собирает и возвращает сырую sql-команду
     * 
     * @return string
     */
    public function getRaw();


    /**
     * отчищает sql-команду и прочие конскрукции
     * 
     * @return $this
     */
    public function clear();

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