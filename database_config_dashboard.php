<?php
try
{
        $connect=new PDO('mysql:host=localhost;dbname=sgic-user;charset=utf8', 'root', 'manager');
	
}
catch(Exception $e)
{
        die('Error : '.$e->getMessage());
}
