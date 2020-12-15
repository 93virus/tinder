<?php

define("SERVER_NAME", "sql12.freemysqlhosting.net");
define("USERNAME", "sql12382049");
define("PASSWORD", "mms4A7fBgl");
define("DB_NAME", "sql12382049");

$con = mysqli_connect(SERVER_NAME, USERNAME, PASSWORD, DB_NAME);

if(!$con) {
    echo "DATABASE CONNECTION FAILURE";
}

?>