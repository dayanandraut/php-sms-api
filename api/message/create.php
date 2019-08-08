<?php
// include api header configuration
include_once '../config/apiHeaderConfig.php';

// get database connection
include_once '../config/database.php';
 
// instantiate message object
include_once '../model/message.php';

// function to validate all the contacts
function validateIndividualContact($c){
    return preg_match("/^[1-9]{1}[0-9]{9}$/", trim($c));
 }
 
 function validateContacts($c){
     $contacts = explode(",",trim($c));
     $invalidContacts = array();
     foreach ($contacts as $con) {
         if(!validateIndividualContact($con)){
             array_push($invalidContacts, $con);
         }
     }
     //print_r($contacts);
     return $invalidContacts;
     
 }
 
 //-------------------------------------------

$database = new Database();
$db = $database->getConnection();
 
$message = new Message($db);
$user = new User($db);
// get posted data
$data = json_decode(file_get_contents("php://input"));
 
// make sure data is not empty
if(
    !empty($data->date) &&
    !empty($data->contacts) &&
    !empty($data->message) &&    
    !empty($data->tbUserId) &&
    !empty($data->purpose)
){ 
    // set message property values
    $message->date = $data->date;
    $message->contacts = $data->contacts;
    $message->message = $data->message;
    $message->tbUserId = $data->tbUserId;
    $message->purpose = $data->purpose;    

    // validate contacts
    $invalidContacts = validateContacts($data->contats);
    $num_contacts = sizeof(explode(",",trim($c)));
    if(sizeof($invalidContacts)!=0){
         // set response code - 400 bad request
        http_response_code(400); 
        // tell the user
        echo json_encode(array("message" => "Bad Request. Some contacts are not valid.", "invalidContacts"=>$invalidContacts));
    }

    else if(!user->validateMessagesLeft($data->tbUserId),$num_contacts){
        http_response_code(400);
        echo json_encode(array("message"=> "Bad Request. Insufficient number of messages remaining. Please refill."))
    }

    else if($message->create()){
 
        // set response code - 201 created
        http_response_code(201);
 
        // tell the user
        echo json_encode(array("message" => "All messages are sent"));
    }
 
    // if unable to create the news, tell the user
    else{
 
        // set response code - 503 service unavailable
        http_response_code(503);
 
        // tell the user
        echo json_encode(array("message" => "Unable to complete request."));
    }
}
 
// tell the user data is incomplete
else{
 
    // set response code - 400 bad request
    http_response_code(400);
 
    // tell the user
    echo json_encode(array("message" => "Bad Request"));
}
?>