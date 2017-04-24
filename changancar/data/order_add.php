<?php
header('Content-Type:application/json');

@$user_name = $_REQUEST['user_name'];
@$sex = $_REQUEST['sex'];
@$addr = $_REQUEST['addr'];
@$time = $_REQUEST['time'];
@$phone = $_REQUEST['phone'];
@$did = $_REQUEST['did'];

if(empty($user_name) ||empty($time)|| empty($sex) || empty($addr) || empty($phone) || empty($did))
{
    echo '[]';
    return;
}

require('init.php');

session_start();
$_SESSION['phone'] = $phone;

$sql="select * from car_order where phone=$phone and did=$did";
$result=mysqli_query($conn,$sql);
$row=mysqli_fetch_assoc($result);
$output = [];
$arr = [];
if($row){
    $arr['tip']="exist";
    $output[] = $arr;
	echo json_encode($output);
	return;
}else{



$sql = "INSERT INTO car_order VALUES(null,'$user_name','$phone','$time','$addr',$sex,now(),$did)";
$result = mysqli_query($conn,$sql);


if($result)
{
    $arr['msg'] = 'succ';
    $arr['oid'] = mysqli_insert_id($conn);
}
else
{
    $arr['msg'] = 'error';
}

$output[] = $arr;

echo json_encode($output);
}
?>




