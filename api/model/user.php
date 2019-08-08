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

    // GET INDIVIDUAL User BY EMAIL
    function readByEmail($email){        
        $query = "SELECT * FROM " . $this->table_name . " WHERE email like ? ";        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $email);
        // execute query
        $stmt->execute();        
        return $stmt;
    }

    // GET INDIVIDUAL User BY ID
    function readById($id){        
        $query = "SELECT * FROM " . $this->table_name . " WHERE email id = ? ";        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);
        // execute query
        $stmt->execute();        
        return $stmt;
    }

    // validate number of messages left
    function validateMessagesLeft($userId, $no_messages){
        $stmt = $user->readById($userId);
        $num = $stmt->rowCount(); 
        $messages_left = 0;       
        // check if more than 0 record found
        if($num>0){    
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
                // extract row
                // this will make $row['name'] to
                // just $name only
                extract($row);        
                $messages_left = $row['messagesLeft'];

    }
    return $messages_left >= $no_messages ? true: false;

}
}