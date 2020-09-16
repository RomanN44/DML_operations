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
     * отчищает значение переменной $select 
     * 
     * @return $this;
     */
    public function clearSelect();

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
     * отчищает значение переменной $orderBy 
     * 
     * @return $this;
     */
    public function clearOrderBy();

    /**
     * Создает group by конструкцию
     * 
     * @param array|string $condition
     * @return $this;
     */
    public function groupBy ($condition);

    /**
     * отчищает значение переменной $groupBy 
     * 
     * @return $this;
     */
    public function clearGroupBy();


    /**
     * Создает join конструкцию
     * 
     * @param string $tableName
     * @return $this;
     */
    public function join(string $table2, array $columns_table1, string $operator = "");

    /**
     * отчищает значение переменной $join 
     * 
     * @return $this;
     */
    public function clearJoin();

    /**
     * отчищает значение переменной $limit 
     * 
     * @return $this;
     */
    public function clearLimit();

    /**
     * отчищает значение переменной $offset 
     * 
     * @return $this;
     */
    public function clearOffset();

    public function limit(int $limit);

    public function offset(int $offset);


}