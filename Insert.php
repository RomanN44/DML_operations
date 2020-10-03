<?php
namespace RomanN44\DML_instructions;

require_once('BaseInterface.php');
require_once('InsertFunctionInterface.php');

class Insert implements BaseInterface, InsertFunctionInterface
{

    /**
     * @var string
     */
    private $values;

    /**
     * @var string
     */
    private $columns;

    /**
     * @var int
     */
    private $countColumns;

    /**
     * @var string
     */
    private $tableName;
    
    /**
     * @var string
     */
    private $instruction;

    /**
     * собирает sql-команду
     * 
     * @return string
     */
    public function getRaw()
    {
        $this->instruction .= " INSERT INTO ";
        if($this->tableName)
        {
            $this->instruction .= $this->tableName;
        } else {
            throw new Exception("Ошибка в названии таблицы! Название не может быть пустым!");
        }
        if($this->columns)
        {
            $this->instruction .= $this->columns;
        }
        if($this->values)
        {
            $this->instruction .= " VALUES ". $this->values;
        } else {
            throw new Exception("Ошибка в конструкции value! Value нет!");
        }

        return $this->instruction;
    }

    /**
     * Присваевает значение переменной $table 
     * 
     * @param string $tableName параметр функции
     *  @return $this;
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
     * @param string $tableName
     * @param array $condition = array()
     * @return $this;
     */
    public function into(string $tableName, array $condition = array())
    {
        $this->table($tableName);
        if(!empty($condition))
        {
            $this->countColumns = count($condition);
            $this->columns($condition);
        }
        return $this;
    }

    /**
     * Присваевает значение переменной $columns
     * 
     * @param array $condition = array()
     * @return $this;
     */
    private function columns(array $condition)
    {
        if(!empty($condition))
        {
            $count = count($condition);
            $idx = 0;
            $list = " (";

            foreach($condition as $arg)
            {
                $list .= $arg . (++$idx < $count ? "," : ") ");
            }
            $this->columns = $list;
        }
        return $this;
    }

    /**
     * присваетвает значение переменной values
     * 
     * @param array $condition
     * @return $this
     */
    public function values(array $condition)
    {
        if(!is_array($condition[0]))
        {
            if($this->columns && $this->countColumns != count($condition))
            {
                throw new Exception("Ошибка в конструкции values! Количество переданных аргументов, не совпадает с количеством заданных столбцов!");
            }
            $this->values = $this->createValues($condition);
        } else {
            $count = count($condition);
            $idx=0;
            foreach($condition as $array)
            {
                if($this->columns && $this->countColumns != count($array))
                {
                    throw new Exception("Ошибка в конструкции values! Количество переданных аргументов, не совпадает с количеством заданных столбцов!");
                }
                $this->values .= $this->createValues($array) . (++$idx < $count ? "," : "");
            }
        }
    }

    /**
     * создает value конструкцию
     * 
     * @param array $array
     * @return string
     */
    private function createValues(array $array)
    {
        $count = count($array);
        $idx = 0;
        $list = " (";

        foreach($array as $arg)
        {
            $list .= $arg . (++$idx < $count ? "," : ") ");
        }
        return $list;
    }

}