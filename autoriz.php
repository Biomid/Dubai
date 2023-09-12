<?php

session_start();
require_once "db/functions.php";

define("CONNECT", db_connect());

$logmail = $_POST["Email"];
$password = $_POST['Passworddocument'];

echo $logmail . " " . $password . "<br>";

$insert_query = "SELECT * FROM `users` WHERE `email` = ? AND `password` = ?";
$data = CONNECT->prepare($insert_query);
$data->execute([$logmail, $password]);

$row = $data->rowCount();
if ($row > 0) {
    $res = $data->fetchAll(PDO::FETCH_ASSOC);
    echo "<pre>";
    print_r($res);
    foreach ($res as $val => $key) {
        $_SESSION['user'] = [
            'uid' => $key['uid'],
            'email' => $key['email'],
            'name' => $key['name'],
            'sname' => $key['sname']
        ];
    }
} else {
    echo "No data";
}

header("location: http://localhost/DUBAI_PROJECT_CSV/dubai/downloade.php");
//print_r($_SESSION);
//
//$insert_query = "SELECT `nights_of_rent` FROM `file_data` WHERE `owner` = ?";
//$data = CONNECT->prepare($insert_query);
//$data->execute([$_SESSION['user']['name'] . " " . $_SESSION['user']['sname']]);
//$row = $data->rowCount();
//
//if ($row > 0) {
//    $res = $data->fetchAll(PDO::FETCH_ASSOC);
//    print_r($res);
//} else {
//    echo "No data";
//}