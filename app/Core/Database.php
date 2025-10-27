<?php

namespace Core;

class Database
{

    public $connection;
    public $statement;

    public function __construct($config)
    {
        $this->connection = new \mysqli($config['host'], $config['user'], $config['password'], $config['db_name'],);
    }

    public function query($query, $param_types = '', $params = [])
    {
        $this->statement = $this->connection->prepare($query);
        if ($param_types !== '' && count($params) > 0) $this->statement->bind_param($param_types, ...$params); // param_types may be one of four types: i - integer, d - double, s - string, b - BLOB
        $this->statement->execute();
        return $this;
    }

    public function find()
    {
        $items = [];
        $result = $this->statement->get_result();
        while ($row = $result->fetch_assoc()) {
            array_push($items, $row);
        }
        return $items;
    }

    public function affected_rows()
    {
        return $this->statement->affected_rows;
    }

    public function insert_id()
    {
        return $this->statement->insert_id;
    }
}
