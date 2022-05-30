<?php


$con=mysqli_connect("localhost:3307","root","","myhmsdb");
global $con;
if(isset($_POST['pid'])){
    $pid = $_POST['pid'];
    mysqli_query($con,"update appointmenttb set paymentStatus='1' WHERE id='".$pid."'");
}

?>