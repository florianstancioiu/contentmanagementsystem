<?php

namespace Common;

use Common\Database;
use Common\SQLStatement;
use \Exception;
use \PDOException;
use \PDO;

// TODO: Generate slug automatically by title
// TODO: Add has_slug static property and generate it automatically given another field
// TODO: Implement destroyed_at datetime column
// TODO: Implement created_at datetime column
// TODO: Mark and handle boolean fields
// TODO: Add accessors and mutators methods
// TODO: Return objects because it's more convenient to handle objects !!!
// TODO: Create an artificial array key for every row to generate the url automatically without giving me headaches (see accessors above)
// TODO: Add filters (where statements)
// TODO: 1 - Rewrite the whole effing thing because I need filters and I need to return objects for every single method (great)
// TODO: 1.1 - Use the SQLStatement class to generate the PDO strings
// TODO: Force a default $identifier field (corelate it with has_slug TODO note)
// TODO: Write unit tests for this class
class DbLayer
{
    protected static $modelObject = null;

    protected static $sqlStatement = null;

    protected static $table = '';

    protected static $columns = [];

    protected static $pdo = null;

    protected static $idField = 'id';

    protected static $searchColumns = [];

    protected static $resetQueryMethods = [
        'get',
        'find',
        'first',
        'update',
        'insert',
        'delete',
        'paginate'
    ];

    public function __construct(string $table = '', array $columns = [])
    {
        // Initialize SQLStatement object
        if ($table !== '') {
            self::$sqlStatement = new SQLStatement($table, $columns);
        } else {
            self::$sqlStatement = new SQLStatement(static::$table, static::$columns);
        }

        // Initialize PDO object
        if (is_null(self::$pdo)) {
            self::$pdo = (new Database())->pdo;
        }
    }

    public static function __callStatic(string $title, $params)
    {
        if (is_null(self::$modelObject) || static::class !== get_class(self::$modelObject)) {
            $class = static::class;
            self::$modelObject = new $class;
            self::$columns = self::$modelObject::$columns;
        }

        // Check existence of $table property
        if (empty(static::$table)) {
            throw new Exception('Set the static $table property');
        }

        // Call the right static method
        if (method_exists(static::class, $title)) {
            $method_result = static::$title(... $params);
        }

        // Reset the SQLStatement object
        if (in_array($title, self::$resetQueryMethods)) {
            $class = static::class;
            self::$modelObject = new $class;
            self::$columns = self::$modelObject::$columns;

            self::$sqlStatement = new SQLStatement(static::$table, static::$columns);
        }

        return $method_result;
    }

    public static function getColumns() : array
    {
        return static::$columns;
    }

    protected static function getSql() : string
    {
        return (string) self::$sqlStatement;
    }

    protected static function dd() : string
    {
        return dd(self::getSql());
    }

    // TODO: Update method to use the SQLStatement class
    protected static function get(array $columns = []) : array
    {
        if (sizeof($columns) === 0) {
            $columns = static::$columns;
        }

        $columns_string = implode(', ', $columns);
        $table = static::$table;

        try {
            $statement = self::$pdo->prepare("SELECT $columns_string FROM $table");
            $statement->execute();
        } catch (PDOException $exception) {
            dd($exception->getMessage());
        }

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    protected static function first() : array
    {
        self::$sqlStatement->select(self::$columns);

        try {
            $statement = self::$pdo->prepare(self::$sqlStatement);
            $statement->execute(self::$sqlStatement->buildParams());
            $results = $statement->fetchAll(PDO::FETCH_ASSOC);

            return is_array($results) && sizeof($results) > 0 ? $results[0] : [];
        } catch (PDOException $exception) {
            dd($exception->getMessage());
        }

        return [];
    }

    protected static function select() : DbLayer
    {
        $existing_columns = static::getColumns();
        $valid_columns = [];

        foreach (func_get_args() as $column) {
            if (in_array($column, $existing_columns)) {
                $valid_columns[] = $column;
            }
        }

        self::$columns = $valid_columns;
        self::$sqlStatement->select(self::$columns);

        return self::$modelObject;
    }

    protected static function where(string $column, string $operator, $value, string $connect_operator = 'AND') : DbLayer
    {
        // Validate the $operator variable
        $valid_operators = [
            '=', '!=', '<>', '<', '>', '=<', '>=', 'LIKE'
        ];
        if (! in_array($operator, $valid_operators)) {
            throw new Exception("The given $operator operator is not valid");
        }

        // Validate the $connect_operator variable
        $valid_connect_operators = ['AND', 'OR'];
        $connect_operator = strtoupper($connect_operator);
        $connect_operator = in_array($connect_operator, $valid_connect_operators) ? $connect_operator : "AND";

        self::$sqlStatement->where($column, $operator, $value, $connect_operator);

        return self::$modelObject;
    }

    protected static function paginate(int $no_rows = 15, int $start = 0) : array
    {
        // Move the start location using the page variable from $_GET
        if ($start === 0 && isset($_GET['page'])) {
            $start = (int) $_GET['page'];
        }

        self::$sqlStatement->select(self::$columns);

        // Inject search columns automatically
        $search_keyword = isset($_GET['search_keyword']) ? $_GET['search_keyword'] : null;
        if ($search_keyword) {
            foreach (static::$searchColumns as $column) {
                self::$sqlStatement->where($column, 'LIKE', "%$search_keyword%", "OR");
            }
        }

        self::$sqlStatement->paginate($no_rows, (int) $start * $no_rows);

        try {
            $statement = self::$pdo->prepare(self::$sqlStatement);
            $statement->execute(self::$sqlStatement->buildParams());
        } catch (PDOException $exception) {
            dd($exception->getMessage());
        }

        $rows = $statement->fetchAll(PDO::FETCH_ASSOC);

        foreach ($rows as &$row) {
            $row['pagination_rows'] = $no_rows;
        }

        return $rows;
    }

    // TODO: Update method to use the SQLStatement class
    protected static function store(array $data = []) : bool
    {
        $processed_data = self::processData($data);
        $keys_string = $processed_data['keys_string'];
        $values_string = $processed_data['values_string'];
        $table = static::$table;

        try {
            $statement = self::$pdo->prepare("INSERT INTO $table ($keys_string) VALUES ($values_string)");
            $statement->execute($data);

            return true;
        } catch (PDOException $exception) {
            dd('Exception message: ' . $exception->getMessage());

            return false;
        }

        return false;
    }

    protected static function update(array $data = []) : bool
    {
        self::$sqlStatement->update($data);

        try {
            $statement = self::$pdo->prepare(self::$sqlStatement);
            $statement->execute(self::$sqlStatement->buildParams());

            return true;
        } catch (PDOException $exception) {
            dd('Exception message: ' . $exception->getMessage());
        }

        return false;
    }

    // TODO: Simplify method
    // TODO: Make the method dynamic, so it can work with multiple tables
    // TODO: Update method to use the SQLStatement class
    protected static function find($identifier, array $columns = []) : array
    {
        if (sizeof($columns) === 0) {
            $columns = static::$columns;
        }

        $columns_string = implode(', ', $columns);
        $table = static::$table;

        // retrieve the row using the slug string
        $statement = self::$pdo->prepare("
            SELECT $columns_string
            FROM $table
            WHERE slug = :slug
        ");
        $data = [ ':slug' => $identifier ];

        if (is_numeric($identifier)) {
            // retrieve the row using the id integer
            $statement = self::$pdo->prepare("
                SELECT $columns_string
                FROM $table
                WHERE id = :id
            ");
            $data = [ ':id' => $identifier ];
        }

        try {
            $statement->execute($data);
        } catch (PDOException $exception) {
            dd('Exception message: ' . $exception->getMessage());
        }

        $row = $statement->fetch(PDO::FETCH_ASSOC);

        return is_array($row) ? $row : [];
    }

    // TODO: Remove processData method from DbLayer (exists in SQLStatement)
    protected static function processData(array $data) : array
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

    protected function resetSQLStatement()
    {
        self::$sqlStatement = new SQLStatement(static::$table, static::$columns, static::class);
    }

    // TODO: Update method to use the SQLStatement class
    protected static function destroy(int $id) : bool
    {
        try {
            $table = static::$table;
            $statement = self::$pdo->prepare("DELETE FROM $table WHERE id = :id");
            $statement->execute([
                ':id' => $id
            ]);

            return true;
        } catch (PDOException $exception) {
            dd('Exception message: ' . $exception->getMessage());

            return false;
        }

        return false;
    }
}
