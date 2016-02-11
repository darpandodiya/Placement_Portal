<?php
	require('../functions/isadminloggedin.php');
    require('../functions/gettable.php');
    $con = getConnection();
    
    $backupFile = 'projectdb.sql';
    $query      = "SELECT * INTO OUTFILE \'$backupFile\' FROM $candidates";
    $result = mysqli_query($con, $query);

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Backup Database | Placement Cell</title>

<link type="text/css" rel="stylesheet" href="../css/master.css" />
<link type="text/css" rel="stylesheet" href="../css/backup.css" />

<link rel="icon" href="../images/fevicon.png" />
</head>

<body>
        <header id="header">
				<img src="../images/placementlogoSmall.png">
		</header>
      
       <p id="heading">
           Backup Data
       </p>
      
      <a href="home.php">  
        <table id="home" onClick="window.location='home.php'">
                <tr>
                    <td>
                        <img src="../images/home.png" alt="Home">
                    </td>
                </tr>
            
                <tr>
                    <td>
                        <strong>
                            Panel
                        </strong>
                    </td>
                </tr>
            </table>
       </a>
       
    
    
      <div id="backuptable">
		
        <table border="0" align="center" cellpadding="20" name="backupdb">
        	
            <tr>
            	
               <td width="128">
                	<a href="
                        <?php
                            $mysqlDatabaseName =$db_name;
                            $mysqlUserName =$username;
                            $mysqlPassword =$password;
                            $mysqlHostName =$host.':3306';
                            $mysqlExportPath ='backup.sql';
                    
                            //DO NOT EDIT BELOW THIS LINE
                            //Export the database and output the status to the page
                            $command="mysqldump --opt  -h $mysqlHostName -u $mysqlUserName -p $mysqlPassword $mysqlDatabaseName > $mysqlExportPath";
                            exec($command);
                            
                            echo $mysqlExportPath;
                        ?>
                    ">
                    <table class="tabs">
                    <tr><td>
                    	<img src="../images/downloadsql.png" alt="Download SQL" title="Download SQL">
                        <div align="center" id="texts">Download SQL</div>
                    </td></tr></table>
                    </a>
                </td>
                
               <td width="128">
                	<a href="
                            <?php
                                $src="../temp/cv.zip";
                                
                                if (file_exists($src)) 
                                    unlink($src);
                                    
                                $zip = new ZipArchive();
                                
                                if ($zip->open($src, ZipArchive::CREATE)!==TRUE) {
                                    exit("cannot open <$src>\n");
                                }
                                $sqlquery = "SELECT id FROM $candidates";
                                $result = mysqli_query($con, $sqlquery);
                                
                                while($rows = mysqli_fetch_array($result)){
                                    $addsrc = '../cv/'.md5($rows['id'],false) . '.doc';
                                    $zipfilename = $rows['id'].'.doc';
                                    
                                    if (file_exists($addsrc)){
                                        $zip->addFile($addsrc ,$zipfilename); 
                                    }
                                }
                                
                                $zip->close();
                                
                                echo $src;
                            ?>
                    ">
                    <table class="tabs">
                    <tr><td>
                    	<img src="../images/word.png" alt="Download All CVs" title="Download All CVs">
                        <div align="center" id="texts">Download <br>All CVs</div>
                    </td></tr></table>
                    </a>
                </td> 
            </tr>
        </table>
    </div>
       
       

    <footer id="footer">
		&copy;2014 Computer Engineering Department, Dharmsinh Desai University, Nadiad.
	</footer>
</body>
</html>