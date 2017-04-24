<?php
header('Content-Type:application/json');

@$start = $_REQUEST['start'];

if(empty($start))
{
    $start = 0;
}

$count = 5;

require('init.php');

$sql = "SELECT did,name,type,price,car_img,surface_description,trim_description FROM car_list LIMIT $start,$count";
$result = mysqli_query($conn,$sql);


$output = [];
$row = mysqli_fetch_all($result,MYSQLI_ASSOC);
$output[] = $row;



echo json_encode($output);

?>




