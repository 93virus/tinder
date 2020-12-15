<?php
require '../../connection/config.php';
include '../../classes/loginClass.php';

$get_data = file_get_contents("php://input");

if (isset($get_data) && !empty($get_data)) {

    $request = json_decode($get_data);
    
    $email = $request->email;
    $password = $request->password;

    $login = new Login($con, $email, $password);
    $login->checkLogin();

}

?>