<?php
class Database {
    private $conn;
    private $configs;
    private $result;
    private $statement;
    private $column = [];
    private $value = [];
    private $insertValue = '';
    private $insertColumn = '';
    private $whereCondition = '';
    private $condition = 'AND';

    public function __construct($configs) {
        $this->configs = $configs;
    }

    public function connect() {
        if (is_null($this->configs)) {
            echo "Configuration is not set.";
        } else if (is_null($this->conn)) {
            $configStatement = sprintf("mysql:host=%s;dbname=%s", $this->configs['host'], $this->configs['name']);
            $this->conn = new PDO($configStatement, $this->configs['username'], $this->configs['password']);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $this;
        } else {
            echo "Connection is already running.";
        }
    }

    public function disconnect() {
        $this->conn = null;
    }

    public function query($sql, $options = []) {
        try {
            if (!$this->isConnected())
                $this->connect();

            $this->statement = $this->conn->prepare($sql, $options);
        } catch (PDOException $e) {
            echo "Connection failed: {$e->getMessage()}";
        }

        return $this;
    }

    public function fetchAll($sql, $data = [], $options = null) {
        $this->query($sql);
        $this->getStatement()->execute($data);
        return $this->getStatement()->fetchAll($options);
    }

    public function fetch($sql, $data = [], $options = null) {
        $this->query($sql);
        $this->getStatement()->execute($data);
        return $this->getStatement()->fetch($options);
    }

    public function update($sql, $data = []) {
        $this->query($sql);
        $this->getStatement()->execute($data);
        return $this;
    }

    /**
     * Store a new record in the table
     * @param  String $table
     * @param  String $column
     * @param  Object $value
     * @return Object         returns the instance
     */
    public function insert($table, $column, $value) {
        $this->prepareColumnValue($column, $value);
        $sql = "INSERT INTO {$table} ({$this->insertColumn}) VALUES ({$this->insertValue})";
        $this->query($sql)->getStatement()->execute($this->value);
        return $this;
    }

    public function getLastInsertedId() {
        if ($this->getConnection())
            return $this->getConnection()->lastInsertId();
    }

    /**
     * Deletes a record from the table
     * @param  String $table
     * @param  String $column
     * @param  Object $value
     * @return Object         returns the instance
     */
    public function delete($table, $column, $value) {
        $this->prepareColumnValue($column, $value);
        $sql = "DELETE FROM {$table} WHERE {$this->whereCondition}";
        $this->query($sql)
            ->getStatement()
            ->execute($this->value);

        return $this;
    }

    /**
     * Inserts a new record if it doesn't exists yet
     * @param  String            $table  The table to look into
     * @param  String            $column The key column of the table
     * @param  Object            $value  The value of the column
     * @return Integer                   Returns the id of the new record or existing record
     */
    public function insertIfNotExists($table, $column, $value) {
        if (!$this->isExists($table, $column, $value)) {
            $this->insert($table, $column, $value);
            return $this->getLastInsertedId();
        } else {
            return $this->getStatement()->fetch()[0];
        }
    }

    /**
     * Checks if the record does exists
     * @param  String  $table  [description]
     * @param  String  $column [description]
     * @param  Object  $value  [description]
     * @return boolean         Returns true if it does exsits and false otherwise
     */
    public function isExists($table, $column, $value, $exceptID = null) {
        $this->condition = 'AND';
        $this->prepareColumnValue($column, $value);
        $sql = "SELECT * FROM {$table} WHERE $this->whereCondition";

        if (!is_null($exceptID) && is_array($exceptID)) {
            $sql .= " AND {$exceptID[0]} != ?";
            $this->value[] = $exceptID[1];
        }

        $stmt = $this->query($sql)->getStatement();
        $stmt->execute($this->value);
        return $stmt->rowCount() > 0 ? true : false;
    }

    public function isOrExists($table, $column, $value) {
        $this->condition = 'OR';
        $this->isExists($table, $column, $value);
    }

    public function notify($target, $subject, $message) {
        if (is_array($target)) {
            foreach ($target as $id) {
                $this->insert('tbl_notifications',
                        ['fld_subject', 'fld_user_id', 'fld_message'],
                        [$subject, $id, $message]);
            }
        } else {
            $this->insert('tbl_notifications',
                    ['fld_subject', 'fld_user_id', 'fld_message'],
                    [$subject, $target, $message]);
        }
    }

    private function setupColumn($column) {
        $count = 1;

        if (is_array($column)) {
            $count = count($column);
            $this->insertColumn = implode(',', $column);
        }

        $this->whereCondition = '';
        for ($i = 0; $i < $count; $i++) {
            if (is_array($column))
                $this->whereCondition .= "{$column[$i]} = ? {$this->condition} ";
            else
                $this->whereCondition = "{$column} = ? {$this->condition} ";
        }

        $this->whereCondition = substr($this->whereCondition, 0, strlen($this->whereCondition)-(strlen($this->condition)+2));
    }

    private function setupValue($value) {
        $valueStr = '';
        if (is_array($value)) {
            for ($i = 0; $i < count($value); $i++)
                $valueStr .= '?,';

            $valueStr = substr($valueStr, 0, strlen($valueStr)-1);
        } else {
            $valueStr = '?';
        }

        if (!is_array($value))
            $value = [$value];

        $this->value = $value;
        $this->insertValue = $valueStr;
    }

    private function prepareColumnValue($column, $value) {
        $this->setupColumn($column);
        $this->setupValue($value);
    }

    public function isConnected() {
        return !is_null($this->conn);
    }

    public function getConnection() {
        return $this->conn;
    }

    public function getResult() {
        return $this->result;
    }

    public function getStatement() {
        return $this->statement;
    }

    public function __destruct() {
        $this->disconnect();
    }

}
