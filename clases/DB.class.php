<?php

/**
 * User: Hansz
 * Date: 7/5/2016
 * Time: 2:10
 */
 
class DB {
    private static $_instance = null;
    private $_pdo, $_query, $_error = false, $_errorInfo = null, $_results, $_count = 0, $_fetch = true;

    private function __construct() {
        try {
            $this->_pdo = new PDO('mysql:host='.Config::get('mysql/host').';dbname='.Config::get('mysql/db'),Config::get('mysql/user'),Config::get('mysql/password'), array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
            if(Config::get("debug"))
                $this->_pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            die($e->getMessage());
        }
    }
    public static function getInstance() {
        if(!isset(self::$_instance)) {
            self::$_instance = new DB();
        }
        return self::$_instance;
    }
	
    public function query($sql, $params = array()) {
        $this->_error = false;
        if($this->_query = $this->_pdo->prepare($sql)) {
            $i = 1;
            if(count($params) > 0) {
                foreach($params as $param) {
                    $this->_query->bindValue($i, $param);
                    $i++;
                }
            }
            if($this->_query->execute()) {
                $deny = array('insert', 'update', 'delete', 'alter');
                $allow = true;
                foreach ($deny as $d){
                    if(strpos(strtolower(substr($sql,0,10)), $d)!==false)
                        $allow = false;
                }
                if($allow)
                    $this->_results = $this->_query->fetchAll(PDO::FETCH_ASSOC);
                $this->_count = $this->_query->rowCount();
            } else {$this->_error = true; $this->_errorInfo = $this->_pdo->errorInfo(); echo '<div class="alert alert-danger text-center"><h3><b>¡ATTENTION fepal clases!</b><br>An error has occurred, contact the administrator.<br>Your data has been lost.</h3></div>';}
        }
        return $this;
    }
    public function action($action, $table, $where = array()) {
        if (count($where) == 3) {
            $operators = array('=','>','<','>=','<=',);
            $field    = $where[0];
            $operator = $where[1];
            $value    = $where[2];
            //check that operator is valid then contstruct the query
            if (in_array($operator, $operators)){
                $sql = "{$action} FROM {$table} WHERE {$field} {$operator} ?";
                //bind data if there is no errors with the query
                if (!$this->query($sql, array($value))->error()) {return $this;}
            }
        }else
        {
            $sql = "{$action} FROM {$table}";
            //bind data if there is no errors with the query
            if (!$this->query($sql, array($value))->error()) {return $this;}
        }
        return false;
    }
    public function get($table, $where = array()){
        $this->_fetch = true;
        return $this->action('SELECT *', $table, $where);
    }
    public function delete($table, $where){
        $this->_fetch = false;
        return $this->action('DELETE', $table, $where);
    }
    public function insert($table, $fields = array()) {
        $this->_fetch = false;
        $keys = array_keys($fields);
        $values = '';
        $i = 1;
        foreach ($fields as $field) {
            $values .= "?";
            if ($i < count($fields)) {$values .= ", ";}
            $i++;
        }
        $sql = "INSERT INTO {$table} (`".implode('`, `', $keys)."`) VALUES ({$values}) ";
        if (!$this->query($sql, $fields)->error()) {return true;}

        return false;
    }
    public function update($table, $id, $fields) {
        $set = '';
        $i = 1;
        foreach ($fields as $name => $value) {
            $set .= "{$name} = ?";
            if ($i < count($fields)) {$set .= ', ';}
            $i++;
        }
        $sql = "UPDATE {$table} SET {$set} WHERE {$id}";
        if(!$this->query($sql, $fields)->_error) {return true;}
        return false;
    }
    public function results(){
        return $this->_results;
    }
    public function count() {
        return $this->_count;
    }
    public function first() {
        $results = $this->results();
        return $results[0];
    }
    public function lastID(){
        return $this->_pdo->lastInsertId();
    }
    public function error() {
        return $this->_error;
    }

    public function errorInfo(){
        var_dump($this->_errorInfo);
    }

    public function beginTransaction(){
        return $this->_pdo->beginTransaction();
    }

    public function commit(){
        return $this->_pdo->commit();
    }

    public function rollback(){
        return $this->_pdo->rollBack();
    }
}