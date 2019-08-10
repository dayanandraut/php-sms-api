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

    // create message
    function create(){    
    //query to insert record
    // $query = "INSERT INTO ".$this->table_name."
    // (`id`, `date`, `contacts`, `message`, `tb_user_id`, `purpose`)
    //  VALUES 
    //  (NULL, :date, :contacts, :message, :tb_user_id, :purpose)" ;           
    $query = "INSERT INTO " . $this->table_name . "
                    SET
                    date=:date, contacts=:contacts, message=:message, 
                    tb_user_id=:tbUserId, purpose=:purpose";
        
            // prepare query
            $stmt = $this->conn->prepare($query);                
            // bind values
            $stmt->bindParam(":date", $this->date);
            $stmt->bindParam(":contacts", $this->contacts);
            $stmt->bindParam(":message", $this->message);
            $stmt->bindParam(":tbUserId", $this->tbUserId);
            $stmt->bindParam(":purpose", $this->purpose);
            
            //print_r($query);
            // execute query
            if($stmt->execute()){
                return true;
            }        
            return false;
            
        }
}