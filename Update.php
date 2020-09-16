<?php
namespace RomanN44\DML_instructions;

require_once('SqlWhere.php');
require_once('BaseInterface.php');
require_once('UpdateFunctionInterface.php');

class Update implements BaseInterface, SqlWhere, UpdateFunctionInterface
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
     * отчищает sql-команду и прочие конскрукции
     * 
     * @return $this
     */
    public function clear()
    {
        $this->instruction = "";
        $this->clearTable();
        $this->clearWhere();
        $this->clearSet();
        return $this;
    }

     /**
     * отчищает значение переменной tableName
     * 
     * @return $this
     */
    public function clearTable()
    {
        $this->tableName = "";
        return $this;
    }

    /**
     * отчищает значение where
     * 
     * @return $this
     */
    public function clearWhere()
    {
        $this->where = "";
        return $this;
    }

    /**
     * отчищает значение set
     * 
     * @return $this
     */
    public function clearSet()
    {
        $this->set = "";
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
     * @param string $operator 
     * @return $this
     */
    public function where(array $condition, string $operator = "")
    {
        if($operator != "")
        {
            switch(mb_strtolower($operator))
            {
                case "and":{
                    $this->where .= " AND ";
                } break;
                case "or":{
                    $this->where .= " OR ";
                } break;
                case "xor":{
                    $this->where .= " XOR ";
                } break;
                case "not":{
                    $this->where .= " NOT ";
                } break;
                default:{
                    throw new Exception("Ошибка в конструкции Where! Неизвестный оператор!");
                } break;
            }
        }

        $operand = mb_strtolower($condition[0], 'UTF-8');

        if($operand == 'in' || $operand == 'not in')
        {
            $cnt = count($condition[2]);
            $idx = 0;
            $list = "";

            foreach ($condition[2] as $value)
            {
                $list .= $value . (++$idx < $cnt ? "," : "");
            }

            $this->where .= " {$condition[1]} ".strtoupper($condition[0])." ({$list}) ";

        } elseif($operand == 'like' || $operand == 'not like') {

            $this->where .= " {$condition[1]} ".strtoupper($condition[0])." '{$condition[2]}' ";
        } elseif($operand == 'between' || $operand == 'not between') {
            $this->where .= " {$condition[1]} ".strtoupper($condition[0])." {$condition[2]} ";
        } else {
            $count = count($condition);
            switch($count)
            {
                case 1:
                    {
                        $keys = array_keys($condition);
                        $this->where .= " {$keys[0]} = {$condition[$keys[0]]} ";
                    } break;
                case 2:
                    {
                        $this->where .= " {$condition[0]} = {$condition[1]} ";
                    } break;
                case 3:
                    {
                        switch($condition[1])
                        {
                            case ">":
                            case "<":
                            case ">=":
                            case "<=":
                            case "<>":
                            case "=":
                            case "!=":
                                {
                                    $this->where .= " {$condition[0]} {$condition[1]} {$condition[2]} ";
                                } break;
                            default: throw new Exception("Ошибка в конструкции WHERE! Неверный оператор сравнения!"); break;   

                        }
                        
                    } break;
                default: throw new Exception("Ошибка в конструкции WHERE! Неверно задан массив значений!"); break;
            }
        }
        return $this;    
    }
}
