<?php
session_start();

require_once "db/functions.php";

define("CONNECT", db_connect());

$response = [
    'total' => [],
    'chartInfo' =>[],
    'price_for_night' => [],
    'month' => []
];

$res = $_POST['sel_val'];
$name = $_POST['Name'];
$res = implode($res);

$sql = "SELECT * FROM `file_total` WHERE `owner` = '{$name}' AND `apart_name` = '{$res}'";
$data = CONNECT->prepare($sql);
$data->execute();

$row = $data->rowCount();

if($row > 0){
    $result = $data->fetchAll(PDO::FETCH_ASSOC);
    $response['total'] = $result;
}

$sql = "SELECT * FROM `file_data` WHERE `owner` = '{$name}' AND `apart_name` = '{$res}'";
$data = CONNECT->prepare($sql);
$data->execute();

$row = $data->rowCount();
if($row > 0){
    $result = $data->fetchAll(PDO::FETCH_ASSOC);
    $response['chartInfo'] = $result;

    $count = count($response['chartInfo']);
    //echo "Array len = ".$count;

        function get_need_price($arr){
            return $arr['price_for_night'];
        }
        function get_need_month($arr){
            return $arr['month'];
        }
        $response['price_for_night'] = array_map('get_need_price',$response['chartInfo']);
        $response['month'] = array_map('get_need_month',$response['chartInfo']);



}
unset($response['chartInfo']);
//echo print_r($response);
echo json_encode($response);