<?php

class Login
{
    private $con;
    private $email;
    private $password;
    private $response;

    function __construct($con, $email, $password)
    {
        $this->con = $con;
        $this->email = $email;
        $this->password = $password;
        $this->response = array();
    }

    function filter_email()
    {
        if (filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            return 1;
        } else {
            return 0;
        }
    }

    function cleanData($data)
    {
        $data = htmlspecialchars($data);
        return $data;
    }

    function checkLogin()
    {
        $password = $this->cleanData($this->password);
        if ($this->filter_email()) {
            $checkLogin = $this->con->prepare("SELECT email,password FROM users WHERE email=? AND password=? LIMIT 1");
            $checkLogin->bind_param('ss', $this->email, $password);
            $checkLogin->execute();
            $checkLogin->store_result();
            if ($checkLogin->num_rows == 1) {
                array_push($this->response, 1);
            } else {
                array_push($this->response, 2);
            }
        } 
        else 
        {
            array_push($this->response, 3);
        }

        echo json_encode($this->response);
    }
}
