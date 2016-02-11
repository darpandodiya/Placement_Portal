<?php

$host="localhost"; 
	$username="root";  
	$password="";      
	$db_name="projectdb";  
	$branch = "ce"; 
        $batchYear = "2013";
		
	$con=mysqli_connect($host, $username, $password, $db_name)or die("cannot connect"); 
	
	$sqlquery2 = "TRUNCATE ce2013";
             $result2 = mysqli_query($con, $sqlquery2);
			 print_r($result2);
	
$sqlquery3 = "LOAD DATA INFILE 'CE2013.csv' 
                           INTO TABLE ce2013
                           FIELDS TERMINATED BY ',' 
                           ENCLOSED BY '\"'                            
                           LINES TERMINATED BY '\r\n'
							IGNORE 1 LINES
                           (id, rollno, name, spi_1, spi_2, spi_3, spi_4, spi_5, spi_6, cpi)";
                           
             $result3 = mysqli_query($con, $sqlquery3);   
             print_r($result3);
             
             $sqlquery4 = "SELECT * FROM CE2013";
             $result4 = mysqli_query($con, $sqlquery4);   
             print_r($result4);
			 
?>