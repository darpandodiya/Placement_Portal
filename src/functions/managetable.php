<?php
    $branch = $_POST['branch']; 
    $batchYear = $_POST['year'];
    
    $isFileUploaded = 0;    
    $src = '../temp'.$branch.$batchYear.'.xls';
            
            
    if(isset($_POST['upload']))
    {   
        
        if ($_FILES['file']['error'] > 0)
        {
            switch ($_FILES['file']['error'])
            {   
                case 1:
                    echo '<p> The file is bigger than this form allows. Please select valid file.</p>';
                    break;
                case 2:
                    echo '<p> The file is bigger than this form allows. Please select valid file.</p>';
                    break;
                case 3:
                    echo '<p> Only part of the file was uploaded. Please select valid file.</p>';
                    break;
                case 4:
                    echo '<p> No file was uploaded. Please select valid file.</p>';
                    break;
            }
            
         }
         else {        
            $allowedExts = array('xls');
            $temp = explode('.', $_FILES['file']['name']);
            $extension = end($temp);
    
            if (($_FILES['file']['type'] == 'application/msexel') && ($_FILES['file']['size'] < 2000000 && $_FILES['file']['size'] > 0) && in_array($extension, $allowedExts))
            {
                    if(move_uploaded_file($_FILES['file']['tmp_name'], $src)) {
                        $isFileUploaded=1;
                    }
                    
                
            }
            else
            {
                echo '<p>Invalid file. Please select valid file.</p>';
            }
            }
        }
?>
    
