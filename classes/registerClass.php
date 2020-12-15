<?php

class Register
{
    private $con;
    private $name;
    private $email;
    private $password;
    private $response;

    function __construct($con, $name, $email, $password)
    {
        $this->con = $con;
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->response = array();
        $this->response[0]['insert'] = 0;
        $this->response[1]['failed'] = 0;
        $this->response[2]['invalid_email'] = 0;
        $this->response[3]['user_exists'] = 0;
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
        $data = str_replace(" ", "", $data);
        $data = htmlspecialchars($data);
        return $data;
    }

    function checkUserExists() {
        $email = $this->cleanData($this->email);
        $check = $this->con->prepare("SELECT email from users where email = ?");
        $check->bind_param('s', $email);
        $check->execute();
        $check->store_result();
        if ($check->num_rows > 0) {
            return false;
        }else {
            return true;
        }
    }

    function insert()
    {
        $email = $this->cleanData($this->email);
        if ($this->filter_email()) {
            if($this->checkUserExists()) {
            $insert_data = $this->con->prepare("INSERT INTO users (name, email, password) VALUES(?,?,?)");
            $insert_data->bind_param('sss', $this->name, $email, $this->password);
            if ($insert_data->execute()) {
                http_response_code(201);
                $this->response[0]['insert'] = 1;
                $insert_data->close();
            } else {
                http_response_code(422);
                $this->response[1]['failed'] = 1;
                $insert_data->close();
            }
        }
        else {
            $this->response[3]['user_exists'] = 1;
            $this->response[1]['failed'] = 1;
        } 
    }
        else {
            $this->response[2]['invalid_email'] = 1;
            $this->response[1]['failed'] = 1;
        }

        echo json_encode($this->response);
    }
}
