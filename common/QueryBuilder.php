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

    protected $joins = [];

    protected $leftJoins = [];

    protected $rightJoins = [];

    protected $groupBy = [];

    protected $orderBy = [];

    protected $limit = [0, 0];

    protected $fetchType = 'object';

    public function __construct(string $table, string $modelClass)
    {
        $this->table = $table;
        $this->modelClass = $modelClass;

        return $this;
    }

    public function __toString() : string
    {
           return 'whaaaa';
    }

    public function select(array $columns) : QueryBuilder
    {
        $this->columns = array_merge($this->columns, $columns);

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

    public function like(string $column, string $keyword, string $option = "%REPLACE%") : QueryBuilder
    {
        // append the data don't rewrite it so that it can be reused

        return $this;
    }

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
