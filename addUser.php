<?php
require_once "db/functions.php";
session_start();
define("CONNECT",db_connect());

//Get data from client
$name = $_POST['Name'];
$sName = $_POST['sName'];
$email = $_POST['Email'];

//Check email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $response = [
        'email_status' => false
    ];
    echo json_encode($response);
    die();
}
elseif ($name == ""){
    $response = [
        'name_status' => false
    ];
    echo json_encode($response);
    die();
}
elseif ($sName == ""){
    $response = [
        'Sname_status' => false
    ];
    echo json_encode($response);
    die();
}

//Create uid
$uid = base_convert(sha1(uniqid(mt_rand(), true)), 16, 36);
$uid = preg_replace('~\D+~', '', $uid);

//Create password
function random_password(){
    $random_characters = 2;

    $lower_case = "abcdefghijklmnopqrstuvwxyz";
    $upper_case = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $numbers = "1234567890";
    $symbols = "!@#$%^&*";

    $lower_case = str_shuffle($lower_case);
    $upper_case = str_shuffle($upper_case);
    $numbers = str_shuffle($numbers);
    $symbols = str_shuffle($symbols);

    $random_password = substr($lower_case, 0, $random_characters);
    $random_password .= substr($upper_case, 0, $random_characters);
    $random_password .= substr($numbers, 0, $random_characters);
    $random_password .= substr($symbols, 0, $random_characters);

    return  str_shuffle($random_password);
}

//Hash password
$pre_str = "o.Zjj-URG6tW";
$post_str = "F-*W7TEAX6..";
$random = random_password();

$options = [
    'cost' => 10,
];
$password = $pre_str.password_hash($random, PASSWORD_BCRYPT, $options).$post_str;

//Send mail with data
$message = file_get_contents("mail_templ.html");
// На случай если какая-то строка письма длиннее 70 символов мы используем wordwrap()
//$message = wordwrap($message, 70, "\r\n");
// Отправляем
$headers = 'From: maks_zmp@mail.ru' . "\r\n" .
    'Reply-To: max@gmail.com' . "\r\n" .
    "Content-type:text/html;charset=UTF-8" .
    'X-Mailer: PHP/' . phpversion();
if (mail('biomid22@gmail.com', 'My Subject', $message, $headers)) {
    $insert_query = "INSERT INTO `users`(`uid`, `email`, `password`, `name`, `sname`) VALUES (?,?,?,?,?)";
    $date = CONNECT->prepare($insert_query);
    $date->execute([$uid, $email, $password, $name, $sName]);
    $response = ['mail_status' => true];

    echo json_encode($response);
}
else {
    $response = ['mail_status' => false];
    echo json_encode($response);
}
