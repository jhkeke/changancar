<?php
header('Content-Type:application/json');

@$id = $_REQUEST['id'];

if(empty($id))
{
    echo '[]';
    return;
}

require('init.php');

$sql  ="SELECT did,img_logo,img_overview,img_surface,img_trim,surface_description,trim_description";
$sql .=" FROM car_list WHERE did=$id";
$result = mysqli_query($conn,$sql);
$output = [];
$row = mysqli_fetch_all($result,MYSQLI_ASSOC);
$output[] = $row;




$sql  ="SELECT img_surface_part,img_surface_part_title,img_surface_part_content";
$sql .=" FROM car_surface WHERE did=$id";
$result = mysqli_query($conn,$sql);
$row = mysqli_fetch_all($result,MYSQLI_ASSOC);
$output[] = $row;



$sql  ="SELECT img_trim_part,img_trim_part_title,img_trim_part_content";
$sql .=" FROM car_trim WHERE did=$id";
$result = mysqli_query($conn,$sql);
$row = mysqli_fetch_all($result,MYSQLI_ASSOC);
$output[] = $row;


echo json_encode($output);





?>




