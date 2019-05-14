<?php
try
{
      
	$connect = new PDO('mysql:host=localhost;dbname=calendar;charset=utf8', 'root', 'manager');
}
catch(Exception $e)
{
        die('Error : '.$e->getMessage());
}
