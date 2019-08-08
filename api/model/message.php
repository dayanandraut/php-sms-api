<?php
class Message{
 
    // database connection and table name
    private $conn;
    private $table_name = "tb_message";
    
    // object properties
    public $id;
    public $date;
    public $contacts;
    public $message;
    public $tbUserId;
    public $purpose;
 
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }
}