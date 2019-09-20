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

    protected $queryType = 'select';

    protected $validQueryTypes = [
        'select',
        'insert',
        'update',
        'delete'
    ];

    public function __construct(string $table, array $columns, string $modelClass)
    {
        $this->table = $table;
        $this->columns = $columns;
        $this->modelClass = $modelClass;

        return $this;
    }

    // generate the SQL string
    public function __toString() : string
    {
        return $this->getMainStatement() .
                $this->getFromStatement() .
                $this->getWhereStatement() .
                $this->getLimitStatement() .
                $this->getOrderStatement();
    }

    protected function getMainStatement() : string
    {
        switch ($this->queryType) {
            case 'select':
                return $this->getSelectStatement();
                break;
            case 'insert':
                return $this->getInsertStatement();
                break;
            case 'update':
                return $this->getUpdateStatement();
                break;
            case 'delete':
                return $this->getDeleteStatement();
                break;
            default:
                return $this->getSelectStatement();
                break;
        }
    }

    protected function getSelectStatement() : string
    {
        return "SELECT " . implode(', ', $this->columns) . "\n";
    }

    protected function getFromStatement() : string
    {
        $show_from = ['select', 'delete'];

        return in_array($this->queryType, $show_from) ? "FROM " . $this->table . "\n" : "";
    }

    protected function getWhereStatement() : string
    {
        $where_stmnt = "";
        $no_where_clauses = sizeof($this->whereClauses);

        // TODO: Group the where statements to allow the use of AND and OR operators
        if ($no_where_clauses === 0) {
            return $where_stmnt;
        }

        $where_stmnt = "WHERE ";

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
            $column_value = $this->whereColumnTitle($column, (int) $key);
            $column_title = substr($column_value, 1);
            $where_stmnt .= $key > 1 ? "\t " : "";
            $where_stmnt .= "$column_title $operator $column_value";
            $where_stmnt .= $key < $no_where_clauses - 1 ? " $connect_operator \n" : " \n";
        }

        return $where_stmnt;
    }

    public function whereColumnTitle(string $column, int $key = 0) : string
    {
        $column = (int) strpos($column, ':') === 0 ? substr($column, 0) : $column;

        return $key > 0 ? ":$column" . "_" . $key : ":$column";
    }

    protected function getLimitStatement() : string
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
    protected function getOrderStatement() : string
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

        $update_data_keys = array_keys($this->updateData);

        for ($i = 0; $i < sizeof($this->updateData); $i++) {
            $key = strpos($update_data_keys[$i], ':') === 0 ? substr($update_data_keys[$i], 1) : $update_data_keys[$i];
            $value = $this->updateData[$update_data_keys[$i]];
            $column_title = $this->whereColumnTitle($key, $i);
            $params[$column_title] = $value;
        }

        return $params;
    }

    public function select(array $columns) : QueryBuilder
    {
        $this->queryType = 'select';
        $this->columns = array_merge($this->columns, $columns);

        return $this;
    }

    public function paginate(int $no_rows = 15, int $start = 0) : QueryBuilder
    {
        $this->queryType = 'select';
        $table = $this->table;
        // TODO: Implement selectRaw method
        // TODO: Use selectRaw method
        // TODO: Use the WHERE SQL statement to count the total number of rows
        $where_stmnt = $this->getWhereStatement();
        $this->columns[] = "(SELECT COUNT(*) FROM $table $where_stmnt LIMIT 1) as total_rows";
        $this->limit($start, $no_rows);

        return $this;
    }

    public function insert(array $data) : QueryBuilder
    {
        $this->queryType = 'insert';

        return $this;
    }

    public function update(array $data) : QueryBuilder
    {
        $this->queryType = 'update';

        // Validate update data
        $data_keys = array_keys($data);
        for ($i = 0; $i < sizeof($data); $i++) {
            $column = $data_keys[$i];
            $value = $data[$column];

            if (! in_array($column, $this->columns)) {
                throw new \Exception("The $column column doesn't exist in the valid columns array");
            }

            $column_title = $this->whereColumnTitle($column, $i);
            $this->updateData[$column_title] = $value;
        }

        return $this;
    }

    protected function getUpdateStatement()
    {
        $processed_data = $this->processData($this->updateData);
        $array_keys = $processed_data['keys'];
        $array_values = $processed_data['values'];

        $update_string = "UPDATE " . $this->table . " \n\t". "SET ";
        $array_length = sizeof($array_keys);

        for ($i = 0; $i < $array_length; $i++) {
            $array_key = $array_keys[$i];

            $update_string .= $array_key . " = " . $this->whereColumnTitle($array_key, $i);

            if ($i !== $array_length - 1) {
                $update_string .= ', ';
            }
        }

        return $update_string . "\n\t";
    }

    protected function processData(array $data) : array
    {
        $array_values = array_values($data);
        $array_keys_string = '';
        $array_length = sizeof($data);
        $array_keys = [];

        for ($i = 0; $i < $array_length; $i++) {
            $array_key = array_keys($data)[$i];
            $key_string = str_replace(':', '', $array_key);
            $array_keys[] = $key_string;
            $array_keys_string .= $key_string;

            if ($i !== $array_length - 1) {
                $array_keys_string .= ', ';
            }
        }

        return [
            'keys' => $array_keys,
            'values' => $array_values,
            'keys_string' => $array_keys_string,
            'values_string' => "'" . implode("', '", $array_values) . "'"
        ];
    }

    public function delete(string $field, $identifier) : QueryBuilder
    {
        $this->queryType = 'delete';

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
