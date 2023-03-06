<?php

namespace App\Core;

require_once  __DIR__ . '/../../database/DB.php';

use PDO, DB;

abstract class Models
{
    protected $db;
    protected $table;

    function __construct() {
        $this->db = DB::get_connection($_ENV['DATABASE']);
    }

    //get record by $field filed
    function get($field, $value, $table = null)
    {
        if ($table) {
            $pr = $this->db->prepare('SELECT * FROM ' . $table . ' WHERE ' . $field . ' = ?');
        } else {
            $pr = $this->db->prepare('SELECT * FROM ' . $this->table . ' WHERE ' . $field . ' = ?');
        }
        
        $pr->execute([$value]);
        $data = $pr->fetch(PDO::FETCH_ASSOC);

        return $data;
    }

    //filter records by filters
    function filter(array $filers = [], $table = null)
    {
        $table_name = isset($table) ? $table : $this->table;

        if (empty($filers)) {
            $pr = $this->db->query('SELECT * FROM ' . $table_name);
        } else {
            $query = 'SELECT * FROM ' . $table_name . ' WHERE ';
            foreach($filers as $key => $value) {
                if (gettype($value) == 'string') $value = "'$value'";
                $query .= $key . '=' . $value . ' AND ';
            }
            $query = substr($query, 0, -5);

            $pr = $this->db->query($query);
        }

        return $pr->fetchAll(PDO::FETCH_ASSOC);
    }

    //create record with array $data
    function create(array $data)
    {
        $query = "INSERT INTO $this->table(__fields__) VALUES(__values__)";
        $keys = '';
	    $values = '';
	
        foreach($data as $key => $value) {
            $keys .= $key . ', ';

            if (gettype($value) == 'string') $value = "'$value'";
            $values .= $value . ', ';
        }

        if ($keys) {
            $keys = substr($keys, 0, -2);
            $values = substr($values, 0, -2);
        }

        $query = str_replace("__fields__", $keys, $query);
	    $query = str_replace("__values__", $values, $query);

        $this->db->query($query);
        
        return $this->get('id', $this->raw('SELECT LAST_INSERT_ID() as last_id;')['last_id']);
    }

    //update record by id field
    function update(int $id, array $data)
    {
        $query = 'UPDATE ' . $this->table . ' SET ';
        foreach($data as $field => $value) {
            if (gettype($value) == 'string') $value = "'$value'";
            $query .= $field . ' = ' . $value . ', ';
        }
        $query = substr($query, 0, -2);
        $query .= ' WHERE id = ' . $id;

        $this->db->query($query);

        return static::get('id', $id);
    }

    //delete record by id filed
    function delete($field, $value) {
        if (gettype($value) == 'string') $value = "'$value'";

        $query = "DELETE FROM $this->table WHERE $field = $value";
        $this->db->query($query);
    }

    // execute row sql query
    function raw(string $sql_quary, $many = false)
    {
        $pr = $this->db->query($sql_quary);

        if ($many) {
            return $pr->fetchAll(PDO::FETCH_ASSOC);
        } else {
            return $pr->fetch(PDO::FETCH_ASSOC);
        }
    }
}
