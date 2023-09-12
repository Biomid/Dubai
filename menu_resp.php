<?php
session_start();

require_once "db/functions.php";

define("CONNECT", db_connect());

$formData = $_POST['formData'];
//echo print_r($formData);
function shorten_owner_name($item) {
    $name = $item['owner'];
    $shortened_name = substr($name, 0, 1);
    $last_name = substr($name, strpos($name, " ") + 1);
    $new_name = $shortened_name . ". " . $last_name;
    $item['owner'] = $new_name;
    return $item;
}


$apart_name = array();
$apart_owner = array();
$data_time = [
    'datastart' => '',
    'dataend' => ''
];

foreach ($formData as $item) {
    if ($item['name'] == 'apart') {
        $apart_name[] = $item['value'];
    }
    if ($item['name'] == 'owner'){
        $apart_owner[] = $item['value'];
    }
    if ($item['name'] == 'datastart') {
        $data_time['datastart'] = $item['value'];
    }
    if ($item['name'] == 'dataend'){
        $data_time['dataend'] = $item['value'];
    }
}

//$data_time = array_filter($data_time,function ($value){
//   return !empty($value);
//});

//echo print_r($data_time);
//echo print_r($apart_owner);
//echo print_r($apart_name);

//function convert_date($date) {
//    return date('F:Y', strtotime($date . '-01'));
//}
//
//function convert_date_string($date){
//    return date('M Y', strtotime(str_replace(':', ' ', $date)));
//}
//
//$new_dates = array_map('convert_date', $data_time);
//$new_dates = array_map('convert_date_string', $new_dates);
//$new_dates = str_replace('Sep', 'Sept', $new_dates);
//echo "data = ";print_r($new_dates);
//echo "new date = ".gettype($new_dates['datastart']);

$params = array();
$insert_query = "SELECT `owner`, `apart_name`, `month`, `nights_of_rent`, `price_for_night`, `occupancy`, `rental_amount`,
       `DEWA`, `DU_etisalat`, `empower_cooling_deyaar`, `operation_expenses_maintenance`, `GAZ`, `DTCM`,
     `owner_outstanding_to_company`,`percent`, `amount`, `VAT_5`, `total_commission`, `amount_to_be_paid`  FROM `file_data` WHERE 1=1";
if (!empty($apart_owner)){
    $insert_query .= " AND `owner` IN (" . str_repeat("?,", count($apart_owner) - 1) . "?)";
}
if (!empty($apart_name)){
    $insert_query .= " AND `apart_name` IN (" . str_repeat("?,", count($apart_name) - 1) . "?)";
}
if (!empty($data_time['datastart']) && !empty($data_time['dataend'])) {
    $insert_query .= " AND month BETWEEN ? AND ?";
    $data = CONNECT->prepare($insert_query);
    $data->execute(array_merge($apart_owner, $apart_name, [$data_time['datastart']."-01", $data_time['dataend']."-30"]));
}
elseif  (!empty($data_time['datastart']))  {
    $insert_query .= " AND `month` = ?";
    $data = CONNECT->prepare($insert_query);
    $data->execute(array_merge($apart_owner, $apart_name, [$data_time['datastart']."-01"]));
}
elseif ((!empty($apart_owner) && !empty($apart_name)) && (empty($data_time['datastart']) && empty($data_time['dataend']))){
    $data = CONNECT->prepare($insert_query);
    $data->execute(array_merge($apart_owner, $apart_name));
}
elseif (!empty($apart_owner) && empty($apart_name) && (empty($data_time['datastart']) && empty($data_time['dataend']))){
    $data = CONNECT->prepare($insert_query);
    $data->execute(array_merge($apart_owner));
}
elseif (empty($apart_owner) && !empty($apart_name) && (empty($data_time['datastart']) && empty($data_time['dataend']))){
    $data = CONNECT->prepare($insert_query);
    $data->execute(array_merge($apart_name));
}
else{
    $data = CONNECT->prepare($insert_query);
    $data->execute();
}
$results = $data->fetchAll(PDO::FETCH_ASSOC);

$results = array_map("shorten_owner_name", $results);
echo json_encode($results);