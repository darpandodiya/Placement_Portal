<?php 
    $host="localhost"; 
	$username="root";  
	$password="";      
	$db_name="projectdb";
function getConnection()
{
	$host="localhost"; 
	$username="root";  
	$password="";      
	$db_name="projectdb";  
	
	$con=mysqli_connect($host, $username, $password, $db_name)or die("cannot connect"); 
	return $con;
}
?>