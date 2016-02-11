<?php
function getRealNames($input)
{
    $realNames1 = array('HTML', 'Java', 'SQL', 'JavaScript', 'C', 'CSS', 'Python', 'PHP', '.NET');
    $realNames2 = array('Photoshop', 'Excel', 'AutoCAD', 'CorelDraw', 'MATLAB', 'Flash'); 
    $dbNames1 = array('html', 'java', 'sql', 'javascript', 'c', 'css', 'python', 'php', 'dotnet');
    $dbNames2 = array('photoshop', 'excel', 'autocad', 'coreldraw', 'matlab', 'flash'); 
    $i=0; $j=0;
    $extract = explode(',', $input);
    $output= '';    
    for($i=0; $i<9; $i++) {
        if(in_array($dbNames1[$i], $extract)) {
           if($j==0){ 
               $output = $realNames1[$i]; 
           }
           else { 
               $output = $output.", ".$realNames1[$i];    
           }
           $j++;
               
        }
    }
    $j=0;   
    for($i=0; $i<6; $i++) {
        if(in_array($dbNames2[$i], $extract)) {
           if($j==0)
               $output = $realNames2[$i]; 
           else 
               $output = $output.", ".$realNames2[$i];    
            
           $j++;
               
        }
    } 
	return $output;
}
?>