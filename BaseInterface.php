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
     * Присваевает значение переменной $table 
     * 
     * @param string $tableName параметр функции
     * @return $this;
     */
    public function table(string $tableName);

}