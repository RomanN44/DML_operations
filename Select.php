<?php
namespace RomanN44\DML_instructions;

require_once('SqlWhere.php');
require_once('BaseInterface.php');
require_once('SelectFunctionInterface.php');
require_once('SqlQueryLimitable.php');
require_once('SqlQueryOffsetable.php');

class Select implements BaseInterface, SqlWhere, SelectFunctionInterface, SqlQueryOffsetable, SqlQueryLimitable
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
        if($this->where)
        {
            $this->instruction .= " WHERE ". $this->where;
        }
        if($this->limit)
        {
            $this->instruction .= " LIMIT ". $this->limit;
        }
        if($this->offset)
        {
            $this->instruction .= " OFFSET ". $this->offset;
        }
        if($this->groupBy)
        {
            $this->instruction .= " GROUP BY ". $this->groupBy;
        }
        if($this->orderBy)
        {
            $this->instruction .= " ORDER BY ". $this->orderBy;
        }
        if($this->join)
        {
            $this->instruction .= $this->join;
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
                    $this->select .= "`{$name}` as `{$alias}`";
                } else {
                    $this->select .= "`{$column}`";
                }
                $this->select .= ',';
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
     * отчищает sql-команду и прочие конскрукции
     * 
     * @return $this
     */
    public function clear()
    {
        $this->instruction = "";
        $this->clearTable();
        $this->clearSelect();
        $this->clearWhere();
        $this->clearLimit();
        $this->clearOffset();
        $this->clearOrderBy();
        $this->clearGroupBy();
        $this->clearJoin();
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
     * отчищает значение переменной $select 
     * 
     * @return $this;
     */
    public function clearSelect()
    {
        $this->select = "";
        return $this;
    }

    /**
     * отчищает значение переменной $limit 
     * 
     * @return $this;
     */
    public function clearLimit()
    {
        $this->limit = "";
        return $this;
    }

    /**
     * отчищает значение переменной $offset 
     * 
     * @return $this;
     */
    public function clearOffset()
    {
        $this->offset = "";
        return $this;
    }

    /**
     * отчищает значение переменной $orderBy 
     * 
     * @return $this;
     */
    public function clearOrderBy()
    {
        $this->orderBy = "";
        return $this;
    }

    /**
     * отчищает значение переменной $groupBy 
     * 
     * @return $this;
     */
    public function clearGroupBy()
    {
        $this->groupBy = "";
        return $this;
    }

    /**
     * отчищает значение переменной $join 
     * 
     * @return $this;
     */
    public function clearJoin()
    {
        $this->join = "";
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

     /**
     * создает by-конструкцию
     * 
     * @param array|string $condition
     * @return $this
     */
    public function join(string $table2, array $columns_table1, string $operator = "")
    {
        switch(mb_strtolower($operator))
        {
            case "inner":
                {
                    $this->join .= " INNER JOIN";
                } break;
            case "left":
                {
                    $this->join .= " LEFT JOIN";
                } break;
            case "right":
                {
                     $this->join .= " RIGHT JOIN";
                } break;
            case "":
                {
                    $this->join .= " INNER JOIN";
                } break;
            default: throw new Exception("Ошибка в конструкции JOIN! Неверно задан оператор join!"); break;
        }

        $this->join .= " {$table2} ON ";
        $cnt = count($columns_table1);
        $idx = 0;


        foreach ($columns_table1 as $key => $value)
        {
            $this->join .= " {$key} = {$value}" . (++$idx < $cnt ? "," : " ");
        }
        return $this;
    }
}