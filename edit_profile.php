<?php

//edit_profile.php
session_start();
if(!isset($_SESSION["type"])){
  header("location:login.php");
}
include('database_config_dashboard.php');

if($_POST['action']=='change_password')
{
	$newPass =$_POST["user_new_password"];
	$conPass = $_POST["user_re_enter_password"];
	if($_POST["user_current_password"]!=''){
		$query = "SELECT user_password FROM user WHERE user_id = '".$_SESSION["user_id"]."' ";
		$statement = $connect->prepare($query);
		$statement->execute();
		$result = $statement->fetch(PDO::FETCH_ASSOC);

		$oldPass=$_POST["user_current_password"];
		
		if(password_verify($oldPass,$result['user_password'])){
			
			if($newPass==$conPass)
	{
		
		$query = "
		UPDATE user SET  
			user_password = '".password_hash($_POST["user_new_password"], PASSWORD_DEFAULT)."' 
			WHERE user_id = '".$_SESSION["user_id"]."'
		";

		//echo $query;
		$statement = $connect->prepare($query);
	

			if($statement->execute())
			{
				echo '<div class="alert alert-success">Password changed </div>';
			}
	}else{
		echo '<div class="alert alert-danger">New password and confirm password not match   </div>';
		}
	}else{
		echo '<div class="alert alert-danger">Please enter correct current password  </div>';
	}

}
}



elseif($_POST['action']=='edit_profile')
{
		if (isset($_FILES['photo'])===true){
			if(empty($_FILES['photo']['name'])=== true){
				echo 'Please choose a file!';
			}else{
				echo 'ok!';
			}
		}
	$query = "
		UPDATE 
		user_profile SET 
		first_name = :first_name,
		last_name = :last_name,address = TRIM(:address),contact_number = TRIM(:contact_number)
		WHERE user_id =:user_id
		";
		//echo $query;
		//,photo = :photo

		$statement = $connect->prepare($query);
		if($statement->execute(
			array(
				':first_name'	=>	$_POST["first_name"],
				':last_name'	=>	$_POST["last_name"],
				':address'	=>	$_POST["address"],
				':contact_number'	=>	$_POST["contact_number"],
				':user_id'		=>$_SESSION["user_id"]
			)
		))

	
		
		{
			echo '<div class="alert alert-success">Profile details changed </div>';
		}
}


?>