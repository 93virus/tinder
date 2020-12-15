<?php
require '../../connection/config.php';
include '../../classes/registerClass.php';

$post_data = file_get_contents("php://input");

if(isset($post_data) && !empty($post_data)) {
    $request = json_decode($post_data);
    
    $name = $request->name;
    $email = $request->email;
    $password = $request->password;
   
    $register = new Register($con, $name, $email, $password);
    $register->insert(); 
   
}
