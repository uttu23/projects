<?php
session_start();
if(array_key_exists("content",$_POST)){
$user='root';
$pass='';
$db='starter';

$link=mysqli_connect('localhost',$user,$pass,$db);
$errors=mysqli_connect_error();
if($errors){
	die("connection unsuccessful");
}
 
 $query = "UPDATE `secretdiary` SET `textarea` = '".mysqli_real_escape_string($link, $_POST['content'])."' WHERE id = ".mysqli_real_escape_string($link, $_SESSION['id'])." LIMIT 1";
        
       if( mysqli_query($link, $query)){
		   echo "successful";
		   
	   }
	   else {
		   echo "unseccessful";
	   }
}
?>