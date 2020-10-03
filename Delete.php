<?php
namespace RomanN44\DML_instructions;

require_once('DeleteFunctionInterface.php');
require_once('BaseInterface.php');
require_once('SqlCondition.php');

class Delete implements DeleteFunctionInterface, BaseInterface
{

        /**
     * @var string
     */
    private $tableName;
    
    /**
     * @var string
     */
    private $instruction;

     /**
     * @var string
     */
    private $where;

    /**
     * собирает sql-команду
     * 
     * @return string
     */
    public function getRaw()
    {
        $this->instruction .= "DELETE FROM ";
        if($this->tableName)
        {
            $this->instruction .= $this->tableName;
        } else {
            throw new Exception("Ошибка в названии таблицы! Название не может быть пустым!");
        }
        if($this->where)
        {
            $this->instruction .= " WHERE ". $this->where;
        }

        return $this->instruction;
    }

    /**
     * Присваевает значение переменной $table 
     * 
     * @param string $tableName параметр функции
     * @return $this;
     */
    public function table(string $tableName)
    {
        if($tableName)
        {
            $this->tableName = $tableName;
        } else {
            throw new Exception("Ошибка в названии таблицы! Название не может быть пустым!");
        }
        return $this;
    }

    /**
     * Присваевает значение переменной $table 
     * 
     * @param string $tableName параметр функции
     * @return $this;
     */
    public function from(string $tableName)
    {
        $this->table($tableName);
        return $this;
    }

    /**
     * создает where-конструкцию
     * 
     * @param array $condition
     * @return $this
     */
    public function setWhere(SqlCondition $condition)
    {
        $this->where = $condition->getRaw();
        return $this;
    }
}
