<?php
require_once "db/functions.php";
define("CONNECT", db_connect());
$name = $_POST['Name'];
//$name = "Viacheslav Yuvenko";
//$arr = [12, 19, 3, 5, 2, 3, 88];


$insert_query = "SELECT `month`, `price_for_night` FROM `file_data` WHERE owner = ? AND apart_name = 'DEC Towers T2 P2-09';";
$data = CONNECT->prepare($insert_query);
$data->execute([$name]);

$row = $data->rowCount();

if ($row > 0){
    $result = $data->fetchAll(PDO::FETCH_ASSOC);
    $resp = [
        'month_rent' => [],
        'price_for_night' => []
    ];
    foreach ($result as $key => $value){
        array_push($resp['month_rent'], $value['month']);
        array_push($resp['price_for_night'], $value['price_for_night']);
    }

    echo json_encode($resp);
}



