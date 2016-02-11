<?php
    require('getdbcon.php');
    $con1 = getConnection();
    $mysqliquery = "SELECT * FROM current";
    $mysqliresult = mysqli_query($con1, $mysqliquery);
    $tempvar = mysqli_fetch_array($mysqliresult);
    
    /*if($tempvar[0] == 'none') {
        echo "System is in maintenance. Please come back later.";
        exit();
    }*/
    
    $candidates = $tempvar[0];
	$GLOBALS['candidates'] = $candidates;
    $event = $tempvar[1];
    $xref = $tempvar[2];

?>