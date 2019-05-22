<?php
function ifNotexists($connect,$role_name){
	$sltquery="SELECT count(role_name) as countrole FROM user_role WHERE role_name = TRIM(:role_name)";
	$statement = $connect->prepare($sltquery);
		$statement->execute(
			array(
				':role_name'	=>	$role_name
			)
		);
		$result = $statement->fetch(PDO::FETCH_ASSOC);
		if($result["countrole"]>0){
			
			return false;
		}else{
			return true;
		}
}
?>