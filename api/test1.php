<?php
// include api header configuration
include_once 'config/apiHeaderConfig.php';
 
// include database and object files
include_once 'config/database.php';
include_once 'model/user.php';
include_once 'model/message.php';
// instantiate database and news object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$msg = new Message($db);

$data = json_decode(file_get_contents("php://input"));

$msg->date = $data->date;
$msg->contacts = $data->contacts;
$msg->message = $data->message;
$msg->tbUserId = $data->tbUserId;
$msg->purpose = $data->purpose;
print_r($msg);
if($msg->create()) echo "new message created";
else echo "message not created";
?>