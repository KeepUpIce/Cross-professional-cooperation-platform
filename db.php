<?php
$servername = "localhost";
$username = "project_management";
$password = "project_management";
$dbname = "project_management";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error){
    die("连接失败: ".$conn->connect_error);
}
?>