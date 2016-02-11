<?php
    require('../functions/isadminloggedin.php');
    require('../functions/gettable.php');
    
    $con = getConnection();
    
    if(isset($_REQUEST['remove'])) {
           $id = $_REQUEST['remove'];
           
           $query = "DELETE FROM $candidates WHERE id =".$id;
           $result = mysqli_query($con, $query);
		   
		   $query = "DELETE FROM $xref WHERE sid =".$id;
           $result = mysqli_query($con, $query);
           
           header("Location:explorerecords.php"); 
    }
?>