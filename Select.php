<?php
namespace RomanN44\DML_instructions;

require_once('SqlCondition.php');
require_once('BaseInterface.php');
require_once('SelectFunctionInterface.php');
require_once('SqlQueryLimitable.php');
require_once('SqlQueryOffsetable.php');

class Select implements BaseInterface, SelectFunctionInterface, SqlQueryOffsetable, SqlQueryLimitable
{
    /**
     * @var string
     */
    private $instruction;

    /**
     * @var string
     */
    private $select;

    /**
     * @var string
     */
    private $where;

    /**
     * @var string
     */
    private $tableName;

    /**
     * @var string
     */
    private $limit;

    /**
     * @var string
     */
    private $offset;

    /**
     * @var string
     */
    private $groupBy;

    /**
     * @var string
     */
    private $orderBy;

    /**
     * @var string
     */
    private $join;

    /**
     * собирает sql-команду
     * 
     * @return string
     */
    public function getRaw()
    {
        $this->instruction .= "SELECT ";
        if($this->select)
        {
            $this->instruction .= $this->select;
        } else {
            throw new Exception("Ошибка в конструкции SELECT! SELECT не может быть пустым!");
        }
        $this->instruction .= " FROM ";
        if($this->tableName)
        {
            $this->instruction .= $this->tableName;
        } else {
            throw new Exception("Ошибка в названии таблицы! Название не может быть пустым!");
        }
        if($this->join)
        {
            $this->instruction .= $this->join;
        }
        if($this->where)
        {
            $this->instruction .= " WHERE ". $this->where;
        }
        if($this->groupBy)
        {
            $this->instruction .= " GROUP BY ". $this->groupBy;
        }
        if($this->orderBy)
        {
            $this->instruction .= " ORDER BY ". $this->orderBy;
        }
        if($this->limit)
        {
            $this->instruction .= " LIMIT ". $this->limit;
        }
        if($this->offset)
        {
            $this->instruction .= " OFFSET ". $this->offset;
        }

        return $this->instruction;
    }

    /**
     * TODO
     */
    public function select($columns = "*")
    {
        if (is_array($columns)) {

            foreach ($columns as $column) {

                if (is_array($column)) {
                    list($name, $alias) = $column;
                    $this->select .= "{$name} as {$alias}";
                } else {
                    $this->select .= "{$column}";
                }
                $this->select .= ', ';
            }
        } else {
            
            $this->select = $columns;
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
    public function setWhere(SqlCondition $condition)
    {
        $this->where = $condition->getRaw();
        return $this;
    }

     /**
     * создает by-конструкцию
     * 
     * @param array|string $condition
     * @return $this
     */
    private function by($condition)
    {
        if(is_array($condition))
        {
            $cnt = count($condition);
            $idx = 0;
            $list = "";

            foreach ($condition as $value)
            {
                $list .= $value . (++$idx < $cnt ? "," : "");
            }
            return $list;
        }
        else
        {
            return " ".$condition." ";
        }
    }

     /**
     * создает order by-конструкцию
     * 
     * @param array|string $condition
     * @return $this
     */
    public function orderBy($condition)
    {
        $this->orderBy = $this->by($condition);
        return $this;
    }

    /**
     * создает group by-конструкцию
     * 
     * @param array|string $condition
     * @return $this
     */
    public function groupBy($condition)
    {
        $this->groupBy = $this->by($condition);
        return $this;
    }

     /**
     * присваевает значение переменнной $limit
     * 
     * @param int $limit
     * @return $this
     */
    public function limit(int $limit)
    {
        $this->limit = $limit;
        return $this;
    }

     /**
     * присваевает значение переменнной $offset
     * 
     * @param int $offset
     * @return $this
     */
    public function offset(int $offset)
    {
        $this->offset = $offset;
        return $this;
    }

    public function leftJoin(array $conditionOne, array $conditionTwo)
    {
        $this->join = " LEFT JOIN ";
        $this->join($conditionOne, $conditionTwo);
        return $this;
    }

    public function rightJoin(array $conditionOne, array $conditionTwo)
    {
        $this->join = " RIGHT JOIN ";
        $this->join($conditionOne, $conditionTwo);
        return $this;
    }

    private function join(array $conditionOne, array $conditionTwo)
    {
        $keys = array_keys($conditionOne);
        $this->join .= " {$keys[0]} {$conditionOne[$keys[0]]} ON ";
        $cnt = count($conditionTwo);
        $idx = 0;
        foreach ($conditionTwo as $key => $value)
        {
            $this->join .= " {$key} = {$value}" . (++$idx < $cnt ? "," : " ");
        }
        return $this;
    }
}