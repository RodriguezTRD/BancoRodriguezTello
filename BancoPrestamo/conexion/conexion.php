<?php
$conn=new mysqli("localhost","root","","banco");

if($conn->connect_errno){
    die('Lo siento se presento un problema en el servidor...');
}else{
    echo " ";
}
?>