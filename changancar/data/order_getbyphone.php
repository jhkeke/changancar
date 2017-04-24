<?php
header('Content-Type:application/json');
session_start();
@$phone=$_SESSION['phone'];

if(empty($phone))
{
    echo '[]';
    return;
}

require('init.php');



$sql = "SELECT car_order.oid,car_order.book_time,car_order.user_name,car_list.name,car_list.car_img FROM car_order,car_list WHERE car_order.phone = $phone
 AND car_order.did=car_list.did";
$result = mysqli_query($conn,$sql);

$output = [];
while(true){
    $row = mysqli_fetch_assoc($result);
    if(!$row)
    {
        break;
    }
    $output[] = $row;
}

echo json_encode($output);

?>




