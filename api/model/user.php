<?php
class User{
 
    // database connection and table name
    private $conn;
    private $table_name = "tb_user";
 
    // object properties
    public $id;
    public $firmName;
    public $email;
    public $messagesLeft;
    public $messagesSent;
    public $daysRemaining;
    public $renewalDate;

 
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }
}