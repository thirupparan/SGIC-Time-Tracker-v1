<?php
function ifNotexists($connect,$table_name,$column_name,$value){
	$sltquery="SELECT count({$column_name}) as countnum FROM {$table_name} WHERE {$column_name} = TRIM(:value)";
	$statement = $connect->prepare($sltquery);
		$statement->execute(
			array(
				':value'	=>	$value
			)
		);
		$result = $statement->fetch(PDO::FETCH_ASSOC);
		if($result["countnum"]>0){
			
			return false;
		}else{
			return true;
		}
}
?>