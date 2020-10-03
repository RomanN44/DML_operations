<?php
namespace RomanN44\DML_instructions;

class SqlCondition
{
    /**
     * @var string
     */
    var $instruction;

    public function __construct(array $condition)
    {
        $this->createCondition($condition);
    }

    private function createCondition(array $condition)
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

            $this->instruction .= " {$condition[1]} ".strtoupper($condition[0])." ({$list}) ";

        } elseif($operand == 'like' || $operand == 'not like') {

            $this->instruction .= " {$condition[1]} ".strtoupper($condition[0])." '{$condition[2]}' ";
        } elseif($operand == 'between' || $operand == 'not between') {
            $this->instruction .= " {$condition[1]} ".strtoupper($condition[0])." {$condition[2]} ";
        } else {
            $count = count($condition);
            switch($count)
            {
                case 1:
                    {
                        $keys = array_keys($condition);
                        $this->instruction .= " {$keys[0]} = {$condition[$keys[0]]} ";
                    } break;
                case 2:
                    {
                        $this->instruction .= " {$condition[0]} = {$condition[1]} ";
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
                                    $this->instruction .= " {$condition[0]} {$condition[1]} {$condition[2]} ";
                                } break;
                            default: throw new Exception("Ошибка в конструкции! Неверный оператор сравнения!"); break;   

                        }
                        
                    } break;
                default: throw new Exception("Ошибка в конструкции! Неверно задан массив значений!"); break;
            }
        }
        return $this;
    }

    public function or(array $condition)
    {
        if (!is_null($this->instruction)) {
            $this->instruction .= " OR ";
        }
        $this->createCondition($condition);

        return $this;
    }

    public function and(array $condition)
    {
        if (!is_null($this->instruction)) {
            $this->instruction .= " AND ";
        }
        $this->createCondition($condition);

        return $this;
    }

    public function getRaw()
    {
        return "( ".$this->instruction." )";
    }
}