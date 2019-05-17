<?php

//category_action.php
include('database_config_dashboard.php');

// $role_name='';
// function validate_params(){
	
// 		if(empty(trim($_POST["role_name"]))){
// 			$msg=array('msg'=>'Empty values Inserted','type'=>'err');
// 			die(json_encode($msg));
			
// 		}else{
			
// 		}
// }

if(isset($_POST['btn_action']))
{
	if($_POST['btn_action'] == 'Add')
	{
		$role_name=trim($_POST["role_name"]);
		$query = "
		INSERT INTO user_role (role_name,role_status) 
		SELECT * FROM (SELECT TRIM(:role_name), :role_status)
		AS tmp
		WHERE NOT EXISTS (
    	SELECT role_name FROM user_role WHERE role_name = TRIM(:role_name)
		) LIMIT 1"
		;
		
		execute_query("User Role","Inserted",$connect,$query,array(
			':role_name'	=>	$role_name,
			':role_status'	=>	'Active'
		));
	}
	
	if($_POST['btn_action'] == 'fetch_single')
	{
		$query = "SELECT * FROM user_role WHERE role_id = :role_id";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':role_id'	=>	$_POST["role_id"]
			)
		);
		$result = $statement->fetchAll();
		foreach($result as $row)
		{
			$output['role_name'] = $row['role_name'];
		}
		echo json_encode($output);
	}

	if($_POST['btn_action'] == 'Edit')
	{
		$role_name=trim($_POST["role_name"]);
		$query = "
		UPDATE user_role set role_name = :role_name
		WHERE role_id = :role_id";

		

		execute_query("User Role","Edited",$connect,$query,array(
			':role_name'	=>	$role_name,
			':role_id'		=>	$_POST["role_id"]
		));
		
	}

	if($_POST['btn_action'] == 'delete')
	{
		$status = 'Active';
		if($_POST['status'] == 'Active')
		{
			$status = 'Inactive';	
		}
	
		$query = "
		UPDATE user_role 
		SET role_status = :role_status 
		WHERE role_id = :role_id
		";

		execute_query("User Role","Changed",$connect,$query,array(
			':role_status'	=>	$status,
			':role_id'		=>	$_POST["role_id"]
		));	
}
}
function execute_query($message,$query_type,$connect,$query,$array_param){
	$msg=array('msg'=>'','type'=>'');
	try{
		
	$statement = $connect->prepare($query);
		if($statement->execute($array_param))
		{
			
			if($statement->rowCount()>0){
				$msg['msg']="{$message} {$query_type}";
				$msg['type']='success';
			}else if($statement->rowCount()==0){
				$msg['msg']="May be the {$message} already exist";
				$msg['type']='err';
			}else{
				$msg['msg']='error occured please check';
				$msg['type']='err';
			}
			echo json_encode($msg);
		}
	}catch(PDOException $e)
	{
	
	$msg['msg']='Error occured : ' . $e->getMessage();
	$msg['type']='err';
	}
	}

?>