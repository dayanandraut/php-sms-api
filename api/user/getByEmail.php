<?php
// include api header configuration
include_once '../config/apiHeaderConfig.php';
 
// include database and object files
include_once '../config/database.php';
include_once '../model/user.php';
// instantiate database and news object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$user = new User($db);

// check parameter is set or not. If not, send bad request
if(!isset($_GET['email'])){
    http_response_code(400); 
    echo json_encode(
        array("message"=>"Incomplete Request")
    );
}
else{
        $searchEmail = $_GET['email'];
        // query news
        $stmt = $user->readByEmail($searchEmail);
        $num = $stmt->rowCount();        
        // check if more than 0 record found
        if($num>0){    
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
                // extract row
                // this will make $row['name'] to
                // just $name only
                extract($row);        
                $individual_user=array(
                    "id"=>$id,
                    "firmName"=>$firmName,
                    "email"=>$email,
                    "messagesLeft"=>$messagesLeft,
                    "messagesSent"=>$messagesSent,
                    "daysRemaining"=>$daysRemaining,
                    "renewalDate"=>$renewalDate
                );
        
            // set response code - 200 OK
            http_response_code(200);
        
            // show news data in json format
            echo json_encode($individual_user);
            }   
        // no records found    
        else{  
            
            http_response_code(200);        
            echo json_encode(
                array()
            );
        }
}
?>