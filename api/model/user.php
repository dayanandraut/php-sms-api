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
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = ? ";        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);
        $stmt->execute();        
        return $stmt;
    }

    function getUserDetails($userId){   
        $stmt = $this->readById($userId);
        $num = $stmt->rowCount();               
        // check if more than 0 record found
        if($num>0){    
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
                // extract row
                // this will make $row['name'] to
                // just $name only
                //print_r($row);
                extract($row); 
                return array('firmName'=>$firmName,'messagesLeft'=>$messagesLeft);    
                
    
    }
    return array();
    }
//-----------------------------------------------------------------------
    // update user
    function update($msgSent, $userId){ 
        // update query
                   
        $query = "UPDATE ".$this->table_name." 
         SET messagesLeft=messagesLeft- :msg_no, messagesSent=messagesSent+ :msg_no WHERE id = :id";
        // prepare query statement
        $stmt = $this->conn->prepare($query);
     
        // bind values
        $stmt->bindParam(":id", $userId);
        $stmt->bindParam(":msg_no", $msgSent);

        // execute the query
        //print_r($stmt);
        if($stmt->execute()){
            $affected_rows = $stmt->rowCount();
            //echo 'affected rows: '.$affected_rows;
            if($affected_rows>0) return 1; // updated successfully
            return 0; // executed but not updated
        }
     
        return -1; // didn't execute
    }
//------------------------------------------------------------------------------
}