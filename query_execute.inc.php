<?php
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