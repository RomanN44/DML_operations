<?php
namespace RomanN44\DML_instructions;

require_once('WhereClass.php');

class Delete extends WhereClass
{
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
     * собирает sql-команду
     * 
     * @return string
     */
    public function buildInstruction()
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
     * возвращает sql-команду
     * 
     * @return string
     */
    public function getInstruction()
    {
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
    public function where(array $condition)
    {
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
     * добавляет and к where-конструкци
     * 
     * @param array $condition 
     * @return $this
     */
    public function andWhere(array $condition)
    {
        $this->where .= " AND ";
        $this->where($condition);
        return $this;
    }

    /**
     * добавляет or к where-конструкци
     * 
     * @param array $condition
     * @return $this 
     */
    public function orWhere(array $condition)
    {
        $this->where .= " OR ";
        $this->where($condition);
        return $this;
    }

     /**
     * добавляет xor к where-конструкци
     * 
     * @param array $condition 
     * @return $this
     */
    public function xorWhere(array $condition)
    {
        $this->where .= " XOR ";
        $this->where($condition);
        return $this;
    }

     /**
     * добавляет not к where-конструкци
     * 
     * @param array $condition 
     * @return $this
     */
    public function notWhere(array $condition)
    {
        $this->where .= " NOT ";
        $this->where($condition);
        return $this;
    }
}
