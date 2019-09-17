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

    protected $whereClauses = [];

    protected $validWhereClause = [
        'column',
        'operator',
        'value',
        'connect_operator'
    ];

    protected $joins = [];

    protected $leftJoins = [];

    protected $rightJoins = [];

    protected $groupBy = [];

    protected $orderBy = [];

    // TODO: Create a settings function to retrieve the default pagination number
    protected $limit = [];

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
        $where_stmnt = $this->generateWhereStatement();
        $limit_stmnt = $this->generateLimitStatement();
        $order_stmnt = $this->generateOrderStatement();

        return $select_stmnt . $from_stmnt . $where_stmnt . $limit_stmnt . $order_stmnt;
    }

    protected function generateWhereStatement() : string
    {
        $where_stmnt = "";
        $no_where_clauses = sizeof($this->whereClauses);

        // TODO: Group the where statements to allow the use of AND and OR operators
        if ($no_where_clauses === 0) {
            return $where_stmnt;
        }

        $where_stmnt = "WHERE \n";

        foreach ($this->whereClauses as $key => $clause) {
            // Shallow validation for the $clause array
            if (! is_array($clause)) {
                $valid_where_clause = $this->validWhereClause;
                throw new Exception("The $clause is not a valid where clause: $valid_where_clause");
            }

            $column = $clause['column'];
            $operator = $clause['operator'];
            $value = $clause['value'];
            $connect_operator = $clause['connect_operator'];
            $column_title = $this->whereColumnTitle($column, (int) $key);
            $where_stmnt .= "\t $column $operator $column_title";
            $where_stmnt .= $key < $no_where_clauses - 1 ? " $connect_operator \n" : " \n";
        }

        return $where_stmnt;
    }

    public function whereColumnTitle(string $column, int $key = 0) : string
    {
        return $key > 0 ? ":$column" . "_" . $key : ":$column";
    }

    protected function generateLimitStatement() : string
    {
        $limit_stmnt = "";
        if (sizeof($this->limit) !== 0) {
            if (isset($this->limit['start']) && isset($this->limit['no_rows'])) {
                $limit_stmnt = "LIMIT " . $this->limit['no_rows'] . ', ' . $this->limit['start'];
            }
        }

        return $limit_stmnt;
    }

    // TODO: Implement function
    protected function generateOrderStatement() : string
    {
        return "";
    }

    // TODO: Take in account the table name of each column ...
    public function buildParams() : array
    {
        $params = [];

        foreach ($this->whereClauses as $key => $clause) {
            $column_title = $this->whereColumnTitle($clause['column'], (int) $key);
            $params[$column_title] = $clause['value'];
        }

        return $params;
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
        // TODO: Use the WHERE SQL statement to count the total number of rows
        $where_stmnt = $this->generateWhereStatement();
        $this->columns[] = "(SELECT COUNT(*) FROM $table $where_stmnt LIMIT 1) as total_rows";
        $this->limit($start, $no_rows);

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

    // TODO: Build all where statements through whereFilters to group the conditions easier
    // TODO: Move $connect_operator to the whereFilter method
    // TODO: Remove the $like_structure string, create a separate method for it
    public function where(string $column, string $operator, $value, string $connect_operator) : QueryBuilder
    {
        $this->whereClauses[] = [
            'column' => $column,
            'operator' => $operator,
            'value' => $value,
            'connect_operator' => $connect_operator
        ];

        return $this;
    }

    // TODO: Implement whereFilter method
    public function whereFilter()
    {

    }

    // TODO: Implement whereRaw method
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
