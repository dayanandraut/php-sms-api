<?php
// include api header configuration
include_once '../config/apiHeaderConfig.php';

// get database connection
include_once '../config/database.php';
 
// instantiate message object
include_once '../model/message.php';
include_once '../model/user.php';

$database = new Database();
$db = $database->getConnection(); 
$msg = new Message($db);
$user = new User($db);

// function to call external api to send sms
function sendSMS($data, $firmName){
    $args = http_build_query(array(
        'token' => '',
        'from'  => $firmName,
        'to'    => $data->contacts,
        'text'  => $data->message));

    $url = "http://api.sparrowsms.com/v2/sms/";

    # Make the call using API.
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS,$args);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    // Response
    $response = curl_exec($ch);
    $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    return array("response"=>$response, "status_code"=>$status_code);
}

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
     
     return $invalidContacts;
     
 }
 
 //-------------------------------------------

// get posted data
$data = json_decode(file_get_contents("php://input"));
 
// make sure data is not empty
if(!empty($data->date) && !empty($data->contacts) && !empty($data->message) &&  !empty($data->tbUserId) && !empty($data->purpose)){ 
    // get user
    $sender = $user->getUserDetails($data->tbUserId);
    
    // validate contacts
    $invalidContacts = validateContacts($data->contacts);
    $num_contacts = sizeof(explode(",",trim($data->contacts)));
    if(sizeof($invalidContacts)!=0){
         // set response code - 400 bad request
        http_response_code(400); 
        // tell the user
        echo json_encode(array("message" => "Bad Request. Some contacts are not valid.", "invalidContacts"=>$invalidContacts));
    }
    else if($sender['messagesLeft']<$num_contacts){
        http_response_code(400);
        echo json_encode(array("message"=> "Bad Request. Insufficient number of messages remaining. Please refill."));
    }
    else {
        // write script to call api here
        $res = sendSMS($data, $sender['firmName'] );
        http_response_code($res['status_code']);
        echo json_encode(array("message" => $res['response']));         
        if($res['status_code']==200){
            // write the msg into database
            //echo "writing msg into db.";
            $msg->date = $data->date;
            $msg->contacts = $data->contacts;
            $msg->message = $data->message;
            $msg->tbUserId = $data->tbUserId;
            $msg->purpose = $data->purpose;
            $msg->create();
            // update the user in the database
            //echo "updating user.";
            $user->update($num_contacts, $msg->tbUserId);
        }
    }
} 
// tell the user data is incomplete
else{ 
    // set response code - 400 bad request
    http_response_code(400);     
    echo json_encode(array("message" => "Incomplete Request"));
}
?>