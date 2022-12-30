<?php

class DBController
{
    # This is going to be database controller providing select, where, delete and
    # insert functionality
    private $stmt;
    private $db;
    private $data;
    private $query = '';

    public function __construct($host, $password, $username, $dbName)
    {
        $this->db = new PDO("mysql:host=localhost;dbname=scandiweb", "khaled", "1999");   
        // $this->db = new PDO("mysql:host=$host;dbname=$dbName", $username, $password);        
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  // for php versions before PHP8
    }

    # No need to protect against sql injection attacks since values are not 
    # user driven
    public function select($tableName, array $columns)
    {
        $this->data = array();
        $this->query = 'SELECT '.implode(',', $columns).' FROM '.$tableName;
        return $this;
    }


    public function where(string $column, string $operator, string $value)
    {        
        $this->query .= ' WHERE '.$column.' '.$operator.' ?';
        $this->data = array($value);
        return $this;
    }

    # delete a record we must call where to prevent all records deletion
    public function delete($tableName, string $column, string $value)
    {
        $this->query = 'DELETE FROM '.$tableName;
        $this->where($column, '=', $value);
        return $this;
    }

    # insert a new recorde
    public function insert($tableName, array $columns, array $data)
    {
        $this->data = $data;
        $temp = array_fill(0, count($data), '?');
        $temp = implode(',', $temp);
        $this->query = 'INSERT INTO ' . $tableName . ' ( '.implode(',', $columns) . ' ) ' ." VALUES ($temp)";
        return $this;
    }

    public function execute()
    {
        $this->stmt = $this->db->prepare($this->query);        
        $this->stmt->execute($this->data);
        $this->data = array();
        return $this;
    }

    # if we need to get results back from select.
    public function get()
    {   
        $products = $this->stmt->fetchAll(PDO::FETCH_ASSOC);
        $res = [];
        foreach($products as $product){
            $res[] = $product;
        }        
        return $res;
    }

};


