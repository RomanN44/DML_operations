<?php
namespace RomanN44\DML_instructions;

require_once('BaseInterface.php');
require_once('UpdateFunctionInterface.php');
require_once('SqlCondition.php');

class Update implements BaseInterface, UpdateFunctionInterface
{
    /**
     * @var string
     */
    private $set;

    /**
     * @var string
     */
    private $instruction;

    /**
     * @var string
     */
    private $where;

    /**
     * @var string
     */
    private $tableName;

    /**
     * создает set конструкцию
     * 
     * @param $condition
     * @return $this
     */
    public function set(array $condition)
    {
        $list = " SET";
        $idx = 0;
        $count = count($condition);

        foreach($condition as $key=>$value)
        {
            $list .= " {$key} = {$value}".(++$idx < $count ? "," : " ");
        }

        $this->set = $list;

        return $this;
    }

    /**
     * собирает sql-команду
     * 
     * @return string
     */
    public function getRaw()
    {
        $this->instruction .= "UPDATE ";
        if($this->tableName)
        {
            $this->instruction .= $this->tableName;
        } else {
            throw new Exception("Ошибка в названии таблицы! Название не может быть пустым!");
        }
        if($this->set)
        {
            $this->instruction .= $this->set;
        } else {
            throw new Exception("Ошибка в конструкции set! Set не может быть пустым!");
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
