<?php
    require('functions/isloggedin.php');
	require('functions/gettable.php');
?>    

<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<title>CV Management  | Placement Cell</title>
		<link href="css/master.css" rel="stylesheet" type="text/css">
		<link href="css/cvupload.css" rel="stylesheet" type="text/css">
        
        <link rel="icon" href="images/fevicon.png" />
        
	</head>

	<body>
	
		<header id="header">
				<img src="images/placementlogoSmall.png">
		</header>
	
		<p id="heading">
			CV Management
		</p>
        <a href="home.php">
		<table id="home">
			<tr>
				<td>
					<img src="images/home.png" alt="Home">
				</td>
			</tr>
		
			<tr>
				<td>
					<strong>
						Home
					</strong>
				</td>
			</tr>
		</table>
        </a>

		<br><br>
        
        <?php
        
            //$_FILES['file']['name']=md5($_SESSION['username'],false) . '.doc';
            $src = 'cv/'.md5($_SESSION['username'],false) . '.doc';
            
            
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
                $allowedExts = array('doc');
                $temp = explode('.', $_FILES['file']['name']);
                $extension = end($temp);
        
                if (($_FILES['file']['type'] == 'application/msword') && ($_FILES['file']['size'] < 2000000 && $_FILES['file']['size'] > 0) && in_array($extension, $allowedExts))
                {
                        if(move_uploaded_file($_FILES['file']['tmp_name'], $src)) {
                            echo '<p>The file has been successfully uploaded.</p>';
                        }
                        
                    
                }
                else
                {
                    echo '<p>Invalid file. Please select valid file.</p>';
                }
                }
            }
                
                if(isset($_POST['remove']))
                {
                   if(unlink($src)) {
                        echo '<p> File has been removed.</p>';   
                   }
                   
                }
            
              if (file_exists($src))
               {
                           echo "<div align='center'>";
                           echo "<form action='' method='post' id='isExist'>
                                    <table cellspacing='10px'>
                                    <tr>
                                       <td>
                                           <span class='note'> Your CV </span>
                                       </td>
                                    
                                       <td> 
                                           <a href='".$src."'>  
                                               <input type='button' value='View' id='view' name='view'>
                                           </a>
                                       </td>
                                       <td>
                                           <input type='submit' value='Remove' id='remove' name='remove'>
                                       </td>
                                    </tr>
                                    </table>
                                 
                                 </form>   
                                         
                           ";
                          echo "</div>";
                           
               }  
            
               
        ?>
        
        <br><br>    
		<form action='' method='post' id='upform' enctype='multipart/form-data'>
            

            
            <div class="input" align="center">
                <input type="hidden" name="MAX_FILE_SIZE" value="2000000">
                <input type="file" accept="application/msword" class="hidden" name="file">
            </div>
            
                      
		    <div align="center">
                <input name="upload" type="submit" id="upload" value="Upload">
                <br><br>
                <strong class="warning">Only .doc format is allowed. Max file size 2MB.</strong>
            </div>
		</form>
		    
        
        <script type="text/javascript" src="js/cvupload.js"></script>
        

		<footer id="footer">
			&copy; 2014 Computer Engineering Department, Dharmsinh Desai University, Nadiad.
		</footer>	
	
	</body>
</html>