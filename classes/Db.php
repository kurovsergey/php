<?php

class Db{

    private $db = null;

    public function __construct($config = []){
        $this->db = new mysqli($config['host'], $config['username'], $config['password'], $config['dbname'], $config['port']);
    }

    public function execute($query){
        return $this->db->query($query);
    }

    public function getLastId(){
        return $this->db->insert_id;
    }

    public function fetch($query){
        if ($result = $this->db->query($query)) {
            $res = [];
            while ($row = $result->fetch_assoc()){
                $res[] = $row;
            }
            return $res;
        }
        return null;
    }
}