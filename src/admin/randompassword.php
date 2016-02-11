<?php
	require('../functions/isadminloggedin.php');
    require('../functions/gettable.php');
    $con = getConnection();


?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Generate Random Password | Placement Cell</title>

<link type="text/css" rel="stylesheet" href="../css/master.css" />
<link type="text/css" rel="stylesheet" href="../css/randompassword.css" />

<link rel="icon" href="../images/fevicon.png" />
</head>

<body>
        <header id="header">
				<img src="../images/placementlogoSmall.png">
		</header>
      
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
       
       <p id="heading">
           Generate Random Password
       </p>
    
       <div id="inputbox"> 
           <form action="#" method="post">
               <table align="center">
                    <tr>      
                       <td>
                            <input type="text" name="query" required placeholder="Enter Student ID" autocomplete="on" autofocus id="inputquery">
                       </td>
                       <td>
                            <input type="submit" name="generate" value="View" id="submitquery">
                       </td>
                    </tr>   
               </table>
           </form> 
       
       </div>
       
       <?php
            if(isset($_POST['generate'])) {
                
                $query = "SELECT hashedpass, has_logged_once  FROM $candidates where id='".$_POST['query']."'";
                
                $result = mysqli_query($con, $query);
                $dataarray = mysqli_fetch_array($result);
      
                echo "<p align='center' class='result' style='font-weight:bold'>";
                
                if($dataarray['has_logged_once'] == 0) {    
                    echo "ID:".$_POST['query']."<br>";
                    echo "Random Password: $dataarray[0]";
                }
                else 
				{
					echo "This candidate uses a personalised password. <a href='resetpass.php?id=" . $_POST['query'] . "'>Reset his/her password</a> to a random string.";
				}
                echo "</p>"; 
            }
        ?>
       
       
        <?php
                $query2 = "SELECT * FROM $candidates";
				$x=0;
                if($result2 = mysqli_query($con, $query2))
				{
        ?>
       

            <table border="0" cellpadding="5" cellspacing="5" class="displaytable" align="center" id="passtable">
       		<tr align="right"><td colspan="3">Click <a id="exports">here</a> to get Excel file.</td></tr>
            <tr>
                <td width="80px" class="bold">Index</td>
                <td width="170px" class="bold">ID</td>
                <td width="150px" class="bold">Password</td>
            </tr>
            
			<?php
					while($rows = mysqli_fetch_array($result2)){
						$x++;
						if($rows['has_logged_once'] == 1)
						{
							echo	"<tr>
									<td>".$x."</td>
									<td>".$rows['id']."</td>
									<td><a id=\"res\" data-resett='".$rows['id']."' data-resettname='".$rows['name']."' onClick=\"confirmReset();\" >Reset password</a></td>
									</tr>";
						}
						else
						{
							echo	"<tr>
									<td>".$x."</td>
									<td>".$rows['id']."</td>
									<td>".$rows['hashedpass']."</td>
									</tr>";
						}
					}
				}
            ?> 
       </table>    
       

    <footer id="footer">
		&copy;2014 Computer Engineering Department, Dharmsinh Desai University, Nadiad.
	</footer>
    <script src="../js/jquery-2.0.1.min.js"></script>
    <script>
	var resetlink = document.querySelector('#res'),
    data = resetlink.dataset;

	
	function confirmReset(){
		var ask=confirm("Are you sure you want to reset the password of "+data.resettname+" ("+data.resett+") ?");
		if(ask){
			window.location='resetpass.php?id='+data.resett;
		}
	}
    
	$(document).ready(function() {
		$("#exports").click(function(e) {
			//getting values of current time for generating the file name
			var dt = new Date();
			var day = dt.getDate();
			var month = dt.getMonth() + 1;
			var year = dt.getFullYear();
			var hour = dt.getHours();
			var mins = dt.getMinutes();
			var postfix = day + "." + month + "." + year + "_" + hour + "." + mins;
			//creating a temporary HTML link element (they support setting file names)
			var a = document.createElement('a');
			//getting data from our div that contains the HTML table
			var data_type = 'data:application/vnd.ms-excel';
			var table_div = document.getElementById('passtable');
			var table_html = table_div.outerHTML.replace(/ /g, '%20');
			a.href = data_type + ', ' + table_html;
			//setting the file name
			a.download = 'generated_passwords_' + postfix + '.xls';
			//triggering the function
			a.click();
			//just in case, prevent default behaviour
			e.preventDefault();
		});
	});
</script>
</body>
</html>