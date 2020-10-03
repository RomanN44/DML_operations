<?php
namespace RomanN44\DML_instructions;

interface SelectFunctionInterface
{
     /**
     * Присваевает значение переменной $select 
     * 
     * @param array|string $columns
     * @return $this;
     */
    public function select($columns = array("*"));

     /**
     * Присваевает значение переменной $table 
     * 
     * @param string $tableName параметр функции
     * @return $this;
     */
    public function from(string $tableName);

    /**
     * Создает order by конструкцию
     * 
     * @param array|string $condition
     * @return $this;
     */
    public function orderBy ($condition);

    /**
     * Создает group by конструкцию
     * 
     * @param array|string $condition
     * @return $this;
     */
    public function groupBy ($condition);


    /**
     * Создает join конструкцию
     * 
     * @param string $tableName
     * @return $this;
     */

    public function leftJoin(array $conditionOne, array $conditionTwo);

    public function rightJoin(array $conditionOne, array $conditionTwo);

    public function limit(int $limit);

    public function offset(int $offset);


}