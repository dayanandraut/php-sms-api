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

$user = new User($db);

$uid = $_GET['uid'];
$msgSent = $_GET['msgsent'];

$status = $user->update($msgSent, $uid);
if($status==1) echo "Updated successfully";
else echo "Not updated successfully";
?>