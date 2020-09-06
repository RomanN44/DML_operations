<?php
namespace RomanN44\DML_instructions;

interface SqlWhere
{
    /**
     * создает where-конструкцию
     * 
     * @param array $condition 
     * @return $this
     */
    public function where(array $condition);

    /**
     * добавляет and к where-конструкци
     * 
     * @param array $condition 
     * @return $this
     */
    public function andWhere(array $condition);

    /**
     * добавляет or к where-конструкци
     * 
     * @param array $condition
     * @return $this 
     */
    public function orWhere(array $condition);

    /**
     * добавляет xor к where-конструкци
     * 
     * @param array $condition 
     * @return $this
     */
    public function xorWhere(array $condition);

    /**
     * добавляет not к where-конструкци
     * 
     * @param array $condition 
     * @return $this
     */
    public function notWhere(array $condition);

    /**
     * отчищает значение where
     * 
     * @return $this
     */
    public function clearWhere();
}