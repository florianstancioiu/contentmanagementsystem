<?php

namespace Common;

// TODO: Grab a shovel and dig deep because you yourself wanted to create a CMS from scratch aaaand you've just hit rock bottom
// TODO: Create the freaking query builder and use this class to generate the base Model class
// TODO: Write unit tests for this class
class QueryBuilder
{
    protected $table = "";

    protected $modelClass = "";

    protected $columns = [];

    protected $insertData = [];

    protected $updateData = [];

    protected $whereClauses = [
        /*
        [
            'column' => $column,
            'value' => $value,
            'operator' => $operator,
        ]
        */
    ];

    protected $joins = [];

    protected $leftJoins = [];

    protected $rightJoins = [];

    protected $groupBy = [];

    protected $orderBy = [];

    protected $limit = [
        // 'start' => 0,
        // TODO: Create a settings function to retrieve the default pagination number
        // 'no_rows' => 15
    ];

    protected $fetchType = 'object';

    public function __construct(string $table, string $modelClass)
    {
        $this->table = $table;
        $this->modelClass = $modelClass;

        return $this;
    }

    // generate the SQL string
    public function __toString() : string
    {
        $select_stmnt = "SELECT " . implode(', ', $this->columns) . "\n";
        $from_stmnt = "FROM " . $this->table . "\n";
        $where_stmnt = "";
        $like_stmnt = "";
        $limit_stmnt = "";

        // TODO: Group the where statements to allow the use of AND and OR operators
        if (sizeof($this->whereClauses) > 0) {
            $where_stmnt = "WHERE ";
            foreach ($this->$whereClauses as $clause) {
                // check the $clause array
                if (! is_array($clause)) {
                    throw new Exception("The $clause is not a valid where clause: [ 'column', 'value', 'operator' ]");
                }

                $column = $clause['column'];
                $operator = $clause['operator'];
                $value = $clause['value'];
                $connect_operator = $clause['connect_operator'];
                $like_structure = isset($clause['like_structure']) ? $clause['like_structure'] : "";

                // validate the $operator variable
                $valid_operators = [
                    '=', '!=', '<', '>', '=<', '>=', 'LIKE'
                ];
                if (! in_array($operator, $valid_operators)) {
                    throw new Exception("The given $operator operator is not valid");
                }

                $where_stmnt .= "$column $operator :$column AND \n";

                if ($operator === 'LIKE') {
                    $where_stmnt .= "$column LIKE '$like_structure' \n";
                }
            }
        }

        if (sizeof($this->limit) !== 0) {
            if (isset($this->limit['start']) && isset($this->limit['no_rows'])) {
                $limit_stmnt = "LIMIT " . $this->limit['start'] . ', ' . $this->limit['no_rows'];
            }
        }

        return $select_stmnt . $from_stmnt . $where_stmnt . $limit_stmnt;
    }

    public function select(array $columns) : QueryBuilder
    {
        $this->columns = array_merge($this->columns, $columns);

        return $this;
    }

    public function paginate(int $no_rows = 15, int $start = 0) : QueryBuilder
    {
        $table = $this->table;
        // TODO: Implement selectRaw method
        // TODO: Use selectRaw method
        $this->columns[] = "(SELECT COUNT(*) FROM $table LIMIT 1) as total_rows";
        $this->limit($no_rows, $start);

        return $this;
    }

    public function insert(array $data) : QueryBuilder
    {
        return $this;
    }

    public function update(array $data) : QueryBuilder
    {
        return $this;
    }

    public function delete(string $field, $identifier) : QueryBuilder
    {
        return $this;
    }

    public function join() : QueryBuilder
    {
        return $this;
    }

    public function leftJoin() : QueryBuilder
    {
        return $this;
    }

    public function rightJoin() : QueryBuilder
    {
        return $this;
    }

    public function selectRaw($data) : QueryBuilder
    {
        // append the data don't rewrite it so that it can be reused

        return $this;
    }

    /*
    public function like(string $column, string $like_keyword, string $option = "%:like_keyword%") : QueryBuilder
    {
        $this->$likeClauses[] = [
            'column' => $column,
            'like_keyword' => $like_keyword,
            'option' => $option,
        ];

        return $this;
    }
    */

    public function where($filters) : QueryBuilder
    {
        // append the data don't rewrite it so that it can be reused

        return $this;
    }

    public function whereRaw($filters) : QueryBuilder
    {
        // append the data don't rewrite it so that it can be reused

        return $this;
    }

    public function orderBy() : QueryBuilder
    {
        // append the data don't rewrite it so that it can be reused
        foreach (func_get_args() as $column) {
            if (in_array($column, $existing_columns)) {
                $valid_columns[] = $column;
            }
        }

        return $this;
    }

    public function limit(int $no_rows, int $start) : QueryBuilder
    {
        $this->limit = [
            'start' => $start,
            'no_rows' => $no_rows
        ];

        return $this;
    }

    // Aggregate function
    public function count($fields) : QueryBuilder
    {
        return $this;
    }

    // Aggregate function
    public function sum($fields) : QueryBuilder
    {
        return $this;
    }

    // Aggregate function
    public function max($fields) : QueryBuilder
    {
        return $this;
    }

    // Aggregate function
    public function min($fields) : QueryBuilder
    {
        return $this;
    }
}
