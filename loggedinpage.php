<?php
session_start();
$diarycontent="";
if(array_key_exists("id",$_COOKIE)){
	$_SESSION['id']=$_COOKIE['id'];
}
if(array_key_exists("id",$_SESSION)){
	 echo "<p>Logged In! <a href='secretdiary2.php?logout=1'>Log out</a></p>";
$user='root';
$pass='';
$db='starter';

$link=mysqli_connect('localhost',$user,$pass,$db);
$errors=mysqli_connect_error();
if($errors){
	die("connection unsuccessful");
}
$query="SELECT `textarea` FROM `secretdiary` WHERE id = ".mysqli_real_escape_string($link, $_SESSION['id'])." LIMIT 1";
	 $row=mysqli_fetch_array(mysqli_query($link,$query));
	 $diarycontent=$row['textarea'];

     
}
else {
	header("location:secretdiary2.php");
}


 include("header.php");

 ?>
<nav class="navbar navbar-light bg-faded navbar-fixed-top">
  

  <a class="navbar-brand" href="#">Secret Diary</a>

    <div class="pull-xs-right">
      <a href ='secretdiary2.php?logout=1'>
        <button class="btn btn-success-outline" type="submit">Logout</button></a>
    </div>

</nav>
<div class="container">

<textarea id="diary"><?php echo $diarycontent;?> </textarea>

</div>
 
<?php

 include("footer.php");

?>