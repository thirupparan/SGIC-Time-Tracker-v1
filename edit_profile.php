<?php

//edit_profile.php
session_start();
if(!isset($_SESSION["type"])){
  header("location:login.php");
}
include('database_config_dashboard.php');

if($_POST['action']=='change_password')
{
	try{
	if($_POST["user_new_password"] != '')
	{
		$query = "
		UPDATE user SET  
			user_password = '".password_hash($_POST["user_new_password"], PASSWORD_DEFAULT)."' 
			WHERE user_id = '".$_SESSION["user_id"]."'
		";

		//echo $query;
	}
	$statement = $connect->prepare($query);
	

	if($statement->execute())
	{
		echo '<div class="alert alert-success">Password changed </div>';
	}
}catch(PDOException $e)
{
	echo 'Error occured : ' . $e->getMessage();
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
		last_name = :last_name,address = :address,contact_number = :contact_number
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