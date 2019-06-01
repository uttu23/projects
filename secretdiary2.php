<?php

session_start();	
$error="";
if(array_key_exists("logout",$_GET)){
	unset($_SESSION);
	setcookie("id","",time()-60*60);
	$_COOKIE['id']="";
}
else if ((array_key_exists("id", $_SESSION) AND $_SESSION['id']) OR (array_key_exists("id", $_COOKIE) AND $_COOKIE['id'])) {
        
        header("Location: loggedinpage.php");
        
    }
if(array_key_exists("submit",$_POST)){

$newemail=$_POST['email'];
$newpass=$_POST['password'];	
$user='root';
$pass='';
$db='starter';

$link=mysqli_connect('localhost',$user,$pass,$db);
$errors=mysqli_connect_error();
if($errors){
	die("connection unsuccessful");
}
if(!$newemail){
	$error=$error."email field is required <br>";
}
 if(!$newpass){
	$error=$error."password field is required <br>";
}

 if ($error != "") {
             $error = "<p>There were error(s) in your form:</p>".$error;
            }
else {
	 if($_POST['signUp'] == '1'){
     $query = "SELECT `id` FROM secretdiary WHERE Email='".mysqli_real_escape_string($link,$newemail)."'";
     $result=mysqli_query($link,$query);
     if(mysqli_num_rows($result)>0){
	 $error = "This email address is taken.";
    }
else {
	$query = "INSERT INTO `secretdiary`(`Email`,`Password`) VALUES('$newemail','$newpass')";
        if(mysqli_query($link,$query)){
			$query = "UPDATE `secretdiary` SET Password = '".md5(md5(mysqli_insert_id($link)).$_POST['password'])."' WHERE id = ".mysqli_insert_id($link)." LIMIT 1";
			mysqli_query($link,$query);
			$_SESSION['id']=mysqli_insert_id($link);
			if($_POST['stayloggedin']=='1'){
				setcookie("id",mysqli_insert_id($link),time()+ 60*60*24*365);
				 }
				header("location:loggedinpage.php");
		}
		else {
			$error=$error."There is some problem in signing up";
		}
    }
  
} 
 else {
                    
                    $query = "SELECT * FROM `secretdiary` WHERE Email = '".mysqli_real_escape_string($link, $_POST['email'])."'";
                
                    $result = mysqli_query($link, $query);
                
                    $row = mysqli_fetch_array($result);
                
                    if (isset($row)) {
                        
                        $hashedPassword = md5(md5($row['id']).$_POST['password']);
                        
                        if ($hashedPassword == $row['Password']) {
                            
                            $_SESSION['id'] = $row['id'];
                            
                            if ($_POST['stayloggedIn'] == '1') {

                                setcookie("id", $row['id'], time() + 60*60*24*365);

                            } 

                            header("Location: loggedinpage.php");
                                
                        } else {
                            
                            $error = "That email/password combination could not be found.";
                            
                        }
                        
                    } else {
                        
                        $error = "That email/password combination could not be found.";
                        
                    }
                    
                }
            
        }
        
        
    }	
?>

	<?php include("header.php"); ?>
	
	<div class="container" id="fontcontrol">
	
	<h1 class="head">SECRET DIARY</h1>
	

	
    <form method="post" id="signupform">
	
	<p class="head"> Store your thoughts permanently and securely</p>
	
		 <div id="error"><?php if ($error!="") {
    echo '<div class="alert alert-danger" role="alert">'.$error.'</div>';
    
} ?></div>
	
	<p class="head"> Interested in? Sign up now!</p>

	<fieldset class="form-group">
	
    <input class="form-control" type="email" name="email" placeholder="Your Email">
	
	</fieldset>
    
	<fieldset class="form-group">
	
    <input class="form-control" type="password" name="password" placeholder="Password">
	
	</fieldset>
	
	<div class="form-group form-check">
	
    <input type="checkbox" class="form-check-input" name = "stayloggedin" id="exampleCheck1">
	
    <label class="form-check-label"  for="exampleCheck1"><div class="head">Stay logged in</div></label>
	
   </div>
    
	<fieldset class="form-group">
    
    <input class="form-control" type="hidden" name="signUp" value="1">
        
    <input class="btn btn-success"  type="submit" name="submit" value="Sign Up!">
	
	</fieldset>
	
	<p 
	><a class="toggleforms">log in</a></p>

</form>



<form method="post" id="loginform">

     <p class="head"> Store your thoughts permanently and securely</p>
	 
	 <p class="head"> Login using your username and password</p>

     <fieldset class="form-group">

    <input class="form-control" type="email" name="email" placeholder="Your Email">
	
	</fieldset>
    
	<fieldset class="form-group">
    
    <input class="form-control" type="password" name="password" placeholder="Password">
	
	</fieldset>
    
	<div class="form-group form-check">
	
    <input type="checkbox" class="form-check-input" name = "stayloggedin" id="exampleCheck1">
	
    <label class="form-check-label"  for="exampleCheck1"><div class="head">Stay logged in</div></label>
	
   </div>
    
	<fieldset class="form-group">
    
    <input class="form-control" type="hidden" name="signUp" value="0">
        
    <input  class="btn btn-success" type="submit" name="submit" value="Log In!">
	
	</fieldset>
	
	<p ><a class="toggleforms">Sign up</a></p>

</form>
		
		</div>
		
	<?php include("footer.php"); ?>