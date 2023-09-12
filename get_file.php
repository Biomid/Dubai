<?php
session_start();
require_once 'next_lvl.php';
require_once 'db/functions.php';
define("CONNECT", db_connect());


$target_dir = __DIR__.'/filies/execel/';
$target_file = $target_dir . str_replace(".","" ,microtime(true) ). "-" . basename($_FILES["file"]["name"]);
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

$ext = "";

switch ($_FILES['file']['type']) {
    case 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet':
        $ext = 'xlsx';
        break;
}

if ($ext) {

    move_uploaded_file($_FILES['file']['tmp_name'], $target_file);
    $response = [
        'status' => true,
        'mess' => "uploaded file " . $target_file
    ];

    read_data($_FILES['file']['name']);

    $insert_query = "INSERT INTO `upload_file`( `path`, `upload_data`, `uid`, `file_name`) VALUES (?,?,?,?)";
    $data = CONNECT->prepare($insert_query);
    $data->execute([$target_file,date("Y-m-d H:i:s"),$_SESSION['user']['uid'],$_FILES['file']['name']]);
    echo json_encode($response);
}
else {
    $response = [
        'status' => false,
        'mess' => "error"
    ];
    echo json_encode($response);
}

