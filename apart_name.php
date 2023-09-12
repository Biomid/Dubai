<?php
session_start();

require_once "db/functions.php";

define("CONNECT", db_connect());

$insert_query = "SELECT DISTINCT `owner`, `apart_name` FROM `file_data`";
$data = CONNECT->prepare($insert_query);
$data->execute();
$row = $data->rowCount();
if ($row > 0){
    $result = $data->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($result);
}
else echo json_encode("Error apar data");