<?php

// Connexion à la base de données
require_once('database_config_dashboard.php');

if (isset($_POST['Event'][0]) && isset($_POST['Event'][1]) && isset($_POST['Event'][2])){
	
	
	$id = $_POST['Event'][0];
	$start = $_POST['Event'][1];
	$end = $_POST['Event'][2];

	$sql = "UPDATE events SET  start = '$start', end = '$end' WHERE id = $id ";

	
	$query = $connect->prepare( $sql );
	if ($query == false) {
	 print_r($connect->errorInfo());
	 die ('Erreur prepare');
	}
	$sth = $query->execute();
	if ($sth == false) {
	 print_r($query->errorInfo());
	 die ('Erreur execute');
	}else{
		die ('OK');
	}

}
//header('Location: '.$_SERVER['HTTP_REFERER']);

	
?>
