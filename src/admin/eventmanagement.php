<?php
	require('../functions/isadminloggedin.php');
    require('../functions/gettable.php');
    $con = getConnection();    
?>        

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Event Management | Placement Cell</title>

<link type="text/css" rel="stylesheet" href="../css/master.css" />
<link type="text/css" rel="stylesheet" href="../css/eventmanagement.css" />
<link type="text/css" rel="stylesheet" href="../css/print.css" media="print"/>

<link rel="icon" href="../images/fevicon.png"/>
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
			Event Management
		</p>
        
        <?php
            if(isset($_REQUEST['action']) && ($_REQUEST['action'] != 'add'))
                
                echo "
                    <div class='whitebg addevent' align='center'>
                       
                       <a href='eventmanagement.php?action=add'> 
                            <table align='center'>
                                <tr>
                                    <td>
                                        <img src='../images/add.png' width='30' height='30' alt='Add Event' title='Add Event'>
                                    </td>
                                    <td>
                                    </td>
                                    <td>    
                                        <strong>Add Event</strong>
                                    </td>
                                </tr>
                            </table>        
                       </a>
                                    
                </div>";     
        ?>

<!-- Add An Event To Database-->        
        <?php
            
            if(isset($_POST['add'])) {
                $type = $_POST['typeselector'];
                $name = $_POST['eventname'];       
                $date = $_POST['dobdate']."/".$_POST['dobmonth']."/".$_POST['dobyear']; 
                $time = $_POST['eventtime'];       
                $eligibility = $_POST['eligibility'];
                $description = $_POST['description'];
                $publish = $_POST['publish'];
                
                $sql3 = "SELECT * FROM $event";
                $result3 = mysqli_query($con, $sql3);
                $eventid= mysqli_num_rows($result3)+1;
                
                $sql = "INSERT INTO $event (`type`, `name`, `date`, `time`, `eligibility`, `description`, `ispublished`) 
                        VALUES ('".$type."', '".$name."', '".$date."', '".$time."','".$eligibility."', '".$description."', '".$publish."');";

                $result = mysqli_query($con, $sql);
                
                //print_r($sql);
              	header("location: eventmanagement.php?action=view&success=true");
                
            }
            
            if(isset($_REQUEST['success']) && ($_REQUEST['success'] == 'true')) {
                echo "<br><center>Event has been added.</center><br>";
            }
            
        ?>
<!-- Update An Event-->

        <?php
            
            if(isset($_POST['update'])) {
                $hiddenid = $_POST['hiddenid'];
                $type = $_POST['typeselector'];
                $name = $_POST['eventname'];       
                $date = $_POST['dobdate']."/".$_POST['dobmonth']."/".$_POST['dobyear']; 
                $time = $_POST['eventtime'];       
                $eligibility = $_POST['eligibility'];
                $description = $_POST['description'];
                $publish = $_POST['publish'];
                
                $sql7 = "UPDATE $event SET
                        `type` = '".$type."', 
                        `name` = '".$name."', 
                        `date` = '".$date."', 
                        `time` = '".$time."', 
                        `eligibility` = '".$eligibility."', 
                        `description` = '".$description."', 
                        `ispublished` = '".$publish."' 
                        WHERE `id`='".$hiddenid."'";

                $result = mysqli_query($con, $sql7);
                
                //print_r($sql7);
              	header("location: eventmanagement.php?action=view&updatesuccess=true");
                
            }
            
            if(isset($_REQUEST['updatesuccess']) && ($_REQUEST['updatesuccess'] == 'true')) {
                echo "<br><center>Event has been updated.</center><br>";
            }
            
        ?>


<!-- Remove An Event-->
        
        <?php
           if(isset($_REQUEST['remove'])) {
               $removeid = $_REQUEST['remove'];
               
			   $query1 = "DELETE FROM $event WHERE id ='".$removeid."'";
               $query2 = "DELETE FROM $xref WHERE eid ='".$removeid."'";
               $qresult1 = mysqli_query($con, $query1);
               $qresult2 = mysqli_query($con, $query2);
               
               //print_r($query1);
               //print_r($query2);
               
			   header("Location:eventmanagement.php?action=view&removed=true"); 
			   exit(0);
           }

            if(isset($_REQUEST['removed']) && ($_REQUEST['removed'] == 'true')) {
                echo "<br><center>Event has been removed.</center><br>";
            }
    
        ?>
        
<!-- Edit An Event-->

        <?php
            if(isset($_REQUEST['view'])) {
                
                $vieweventid = $_REQUEST['view'];
                
                $sql4 = "SELECT * FROM $event where id='".$vieweventid."'";
                $result4 = mysqli_query($con, $sql4);
                $rows4 = mysqli_fetch_array($result4);
        ?>                
        <div class='whitebg addeventform'>
            <form action='' method='POST'>
                
                <input type="hidden" value="<?php echo $vieweventid;?>" name="hiddenid">
                <center> <h3 style='color:blue'>Edit an Event</h3> </center>
                
                <table id='formtable' cellspacing='3px' cellpadding='5px'>
                    
                    
                    <tr>
                        <td class='left'>
                                Event Type: 
                        </td>
                        <td class='right'>
                            <select class='typeselector font' name='typeselector'>
                                <option value='Placement' <?php if($rows4['type'] == "Placement") echo "selected"?>>Placement</option>
                                <option value='Training' <?php if($rows4['type'] == "Training") echo "selected"?>>Training</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td class='left'>
                                Event Name:
                        </td>
                        <td class='right'>
                            <input type='text' name='eventname' required class='typeselector font' style='width:300px' placeholder='Infosys Recruitment' value="<?php echo $rows4['name'];?>">
                        </td>
                    </tr>
                    <tr>
                        <td class='left'>
                                Event Date: 
                        </td>
                        <td class='right'>
                                <select name='dobdate' class='typeselector font' title='Date' required>
                                    <option value='' selected disabled>Day</option>";
                                    
                                    <?php 
                                        $day=1;
						                $dates=explode('/',$rows4['date']);
                                        for(;$day <= 31;$day++){
                                            if(isset($dates[0]) && $dates[0]==$day) echo "<option selected value='".$day."'>".$day."</option>";
                                            else echo "<option value='".$day."'>".$day."</option>";
                                        }
                                    ?>
                                    

                                 </select>
                                    
                                    <select name='dobmonth' class='typeselector font' required title='Month'>
                                    <option value='' selected disabled>Month</option>";
                                       <?php 
                                            $day=1;
                                            for(;$day <= 12;$day++){
                                                if(isset($dates[1]) && $dates[1]==$day) echo "<option selected value='".$day."'>".$day."</option>";
                                                else echo "<option value='".$day."'>".$day."</option>";
                                            }
                                        ?>
                                 </select>
                                    
                                    <select name='dobyear' class='typeselector font' required title='Year'>
                                    <option value='' selected disabled>Year</option>";
                                        <?php $day=2014;
                                            for(;$day <= 2030;$day++){
                                                if(isset($dates[2]) && $dates[2]==$day) echo "<option selected value='".$day."'>".$day."</option>";
                                                else echo "<option value='".$day."'>".$day."</option>";
                                            }
                                        ?>
                                 </select>                                                        
                                   
                        </td>
                    </tr>
                    
                    <tr>
                        <td class='left'>
                                Event Time:
                        </td>
                        <td class='right'>
                            <input type='text' name='eventtime' required class='typeselector font' style='width:300px' placeholder='09:30 AM Onwards' value="<?php echo $rows4['time'];?>">
                        </td>
                    </tr>
                    
                    <tr>
                        <td class='left'>
                                Eligibility:
                        </td>
                        <td class='right'>
                            <input type='text' name='eligibility' required class='typeselector font' style='width:300px' placeholder='CPI more than 6.5' value="<?php echo $rows4['eligibility'];?>">
                        </td>
                    </tr>
                    
                    <tr>
                        <td align='left'>
                                Description:
                        </td>
                        <td class='right'>
                            <textarea  rows='6' cols='42' name='description' class='typeselector font' placeholder='Details about event.'><?php echo $rows4['description'];?></textarea>
                        </td>
                    </tr>
                    
                    <tr>
                        <td class='left'>
                                Publish:
                        </td>
                        <td  class='right'>
                            <input type='radio' name='publish' value='1' <?php if($rows4['ispublished'] == 1) echo "checked";?>>Yes 
                            <input type='radio' name='publish' value='0' <?php if($rows4['ispublished'] == 0) echo "checked";?>>No 
                        </td>
                    </tr>
                    
                    <tr>
                        <td></td>
                        <td align='right'>
                            <input type='submit' name='update' value='Update' id='submit'>
                        </td>
                    </tr>
                </table>
            </form>
            <span class='small'>This events are applicable to current batch only.</span> 
        </div>
    <?php
            }
    ?>

<!-- Display Applicants of Event-->        

    <?php
    
        if(isset($_REQUEST['applications']) && isset($_REQUEST['removeapplicant'])) {
            $appeventid = $_REQUEST['applications'];
            $removeapplicantid = $_REQUEST['removeapplicant'];
            $sql8 = "DELETE FROM $xref WHERE `eid` = '".$appeventid."' AND `sid` = '".$removeapplicantid."'";
//            echo $sql8;
            $result8= mysqli_query($con, $sql8);
            header("Location:eventmanagement.php?applications=$appeventid");
             
        }
        if(isset($_REQUEST['applications'])) {
     
           $appeventid = $_REQUEST['applications'];
           
           $resulttable = "
             <div class='whitebg eventdisplay'>
                
                <center><h3>Applications</h3></center>";
                
                $sql5 = "SELECT `sid` FROM $xref WHERE `eid` = '".$appeventid."'";
                $result5= mysqli_query($con, $sql5);
                $i=1;
                
           $resulttable = $resulttable."
                    <div class='lft'>Total ".mysqli_num_rows($result5)." applicants(s).</div>";
                    if(mysqli_num_rows($result5)!=0){
                        $resulttable = $resulttable."<div class='rgt'>Click <a id='exports' style='cursor:pointer'>here</a> to get Excel file of results.</div>";
                    }
           $resulttable = $resulttable."<br><hr style='width:1090px;' />
                                        
                    <center>            
                    <table border='0' cellpadding='5' cellspacing='5' class='eventtable' id='eventtable'>
                
                    <tr class='tableheaders'>
                        <td class='bold b1'>Index</td>
                        <td class='bold b2'>ID</td>
                        <td class='bold b3'>Name</td>
                        <td class='bold b4'>Contact</td>
                        <td class='bold b5'>Mail</td>
                        <td class='bold b6'>City</td>
                        <td class='bold b7'>CPI</td>
                        <td class='bold b8'>View/Edit</td>
                        <td class='bold b9'>Remove</td>
                    </tr>";
                
                while($rows5 = mysqli_fetch_array($result5)) {

                    $sql6 = "SELECT * FROM $candidates WHERE `id` = '".$rows5['0']."'";
                    $result6= mysqli_query($con, $sql6);
                    $rows6 = mysqli_fetch_array($result6);
                                       
                    $resulttable = $resulttable."<tr>
                                                    <td class='normal b1'>$i</td>
                                                    <td class='normal b2'>".$rows6['id']."</td>
                                                    <td class='normal b3'>".$rows6['name']."</td>
                                                    <td class='normal b4'>".$rows6['contact']."</td>
                                                    <td class='normal b5'>".$rows6['email']."</td>
                                                    <td class='normal b7'>".$rows6['city']."</td>
                                                    <td class='normal b7'>".$rows6['cpi']."</td>
                                                    <td class='normal b8'>
														<a href='view.php?view=".$rows6['id']."&name=".$rows6['name']."' target='_blank'>View/Edit</a></td>
                                                    <td class='normal b9'>
														<a id=\"applicantrem".$rows6['id']."\" data-appeventid='".$appeventid."' data-applicant='".$rows6['id']."' data-applicantname='".$rows6['name']."' onClick=\"confirmApplicantRemoval(".$rows6['id'].");\">Remove</a>
													</td>
                                                    
                                                </tr>"; 
	//<a id=\"evntrem\" data-eventid='".$rows['id']."' onClick=\"confirmEventRemoval();\" >Remove</a></td>
                    $i++;                                        
                }
                if(mysqli_num_rows($result5) == 0) {
                    $resulttable = $resulttable."<tr><td colspan='9'><center>No applications found.</center></td></tr>";   
                }
                $resulttable = $resulttable."</table></center></div>";
                
                echo $resulttable;
        }
    
    ?>

<!-- Add An Event Form-->        
        <?php
            if(isset($_REQUEST['action']) && ($_REQUEST['action'] == 'add')) {
                
                
                $addform=
                    "<div class='whitebg addeventform'>
                        <form action='' method='POST'>
                            
                            <center> <h3 style='color:blue'>Add an Event</h3> </center>
                            
                            <table id='formtable' cellspacing='3px' cellpadding='5px'>
                                
                                
                                <tr>
                                    <td class='left'>
                                            Event Type: 
                                    </td>
                                    <td class='right'>
                                        <select class='typeselector font' name='typeselector'>
                                            <option value='Placement'>Placement</option>
                                            <option value='Training'>Training</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td class='left'>
                                            Event Name:
                                    </td>
                                    <td class='right'>
                                        <input type='text' name='eventname' required class='typeselector font' style='width:300px' placeholder='Infosys Recruitment'>
                                    </td>
                                </tr>
                                <tr>
                                    <td class='left'>
                                            Event Date: 
                                    </td>
                                    <td class='right'>
                                            <select name='dobdate' class='typeselector font' title='Date' required>
                                                <option value='' selected disabled>Day</option>";
                                                
                                                    $day=1;
                                                    for(;$day <= 31;$day++){
                                                        $addform = $addform."<option value='$day'>$day</option>";
                                                    }
                                                
                                             $addform = $addform."
                                             </select>
                                                
                                                <select name='dobmonth' class='typeselector font' required title='Month'>
                                                <option value='' selected disabled>Month</option>";
                                                    $day=1;
                                                    for(;$day <= 12;$day++){
                                                        $addform = $addform."<option value='$day'>$day</option>";
                                                    }

                                             $addform = $addform."
                                             </select>
                                                
                                                <select name='dobyear' class='typeselector font' required title='Year'>
                                                <option value='' selected disabled>Year</option>";
                                                    $day=2014;
                                                    for(;$day <= 2030;$day++){
                                                        $addform = $addform."<option value='$day'>$day</option>";
                                                    }
                                             $addform = $addform."
                                             </select>                                                        
                                               
                                    </td>
                                </tr>
                                
                                <tr>
                                    <td class='left'>
                                            Event Time:
                                    </td>
                                    <td class='right'>
                                        <input type='text' name='eventtime' required class='typeselector font' style='width:300px' placeholder='09:30 AM Onwards'>
                                    </td>
                                </tr>
                                
                                <tr>
                                    <td class='left'>
                                            Eligibility:
                                    </td>
                                    <td class='right'>
                                        <input type='text' name='eligibility' required class='typeselector font' style='width:300px' placeholder='CPI more than 6.5'>
                                    </td>
                                </tr>
                                
                                <tr>
                                    <td align='left'>
                                            Description:
                                    </td>
                                    <td class='right'>
                                        <textarea rows='6' cols='42' name='description' class='typeselector font' placeholder='Details about event.'></textarea>
                                    </td>
                                </tr>
                                
                                <tr>
                                    <td class='left'>
                                            Publish:
                                    </td>
                                    <td  class='right'>
                                        <input type='radio' name='publish' value='1' checked>Yes 
                                        <input type='radio' name='publish' value='0'>No 
                                    </td>
                                </tr>
                                
                                <tr>
                                    <td></td>
                                    <td align='right'>
                                        <input type='submit' name='add' value='Add' id='submit'>
                                    </td>
                                </tr>
                            </table>
                        </form>
                        <span class='small'>This events are applicable to current batch only.</span> 
                    </div>
                ";
                
                echo $addform;
                     
                               
            }
        ?>
        
<!-- Dispaly All Events-->
        
        <?php
            if(isset($_REQUEST['action']) && ($_REQUEST['action'] == 'view')) {
         
               $resulttable = "
                 <div class='whitebg eventdisplay'>
                    
                    <center><h3>Events</h3></center>";
                    
                    $sql1 = "SELECT * FROM $event";
                    $result1 = mysqli_query($con, $sql1);
                    $i=1;
                    
               $resulttable = $resulttable."
                        <div class='lft'>Total ".mysqli_num_rows($result1)." event(s).</div><div class='rgt'> Click <a href='javascript:window.print()'>here </a>to print events.</div>
                        <br>
                        <hr style='width:1090px;'/>
                                            
                        <center>            
                        <table border='0' cellpadding='5' cellspacing='5' class='eventtable' id='eventtable'>
                    
                        <tr class='tableheaders'>
                            <td class='bold b1'>Index</td>
                            <td class='bold b2'>Name</td>
                            <td class='bold b3'>Type</td>
                            <td class='bold b4'>Date</td>
                            <td class='bold b5'>Published</td>
                            <td class='bold b6'>Applications</td>
                            <td class='bold b7'>View/Edit</td>
                            <td class='bold b8'>Remove</td>
                        </tr>";
                    
                    while($rows = mysqli_fetch_array($result1)) {

                        $ispublished = "No";
                        
                        if($rows['ispublished'] == '1') {
                            $ispublished = "Yes";   
                        }
                        $resulttable = $resulttable."<tr>
                                                        <td class='normal b1'>$i</td>
                                                        <td class='normal b2'>".$rows['name']."</td>
                                                        <td class='normal b3'>".$rows['type']."</td>
                                                        <td class='normal b4'>".$rows['date']."</td>
                                                        <td class='normal b5'>$ispublished</td>
                                                        <td class='normal b7'><a href='eventmanagement.php?applications=".$rows['id']."'>View</a></td>
                                                        <td class='normal b7'><a href='eventmanagement.php?view=".$rows['id']."'>View/Edit</a></td>
                                                        <td class='normal b8'>
															<a id=\"evntrem".$rows['id']."\" data-eventid='".$rows['id']."' onClick=\"confirmEventRemoval(".$rows['id'].");\" >Remove</a></td>
                                                    </tr>"; 
                        $i++;                                        
                    }
                    if(mysqli_num_rows($result1) == 0) {
                        $resulttable = $resulttable."<tr><td colspan='8'><center>No events found.</center></td></tr>";   
                    }
                    $resulttable = $resulttable."</table></center></div>";
                    
                    echo $resulttable;
            }
       ?> 
        
        
    <footer id="footer">
		&copy;2014 Computer Engineering Department, Dharmsinh Desai University, Nadiad.
	</footer>
    <script src="../js/jquery-2.0.1.min.js"></script>
    <script>
	
	function confirmApplicantRemoval(applicantid){
		var remApp = document.querySelector('#applicantrem'+applicantid);
    	data = remApp.dataset;
	
		var ask=confirm("Are you sure you want to remove "+data.applicantname+" from participating in this event?");
		if(ask){
			window.location="eventmanagement.php?applications="+data.appeventid+"&removeapplicant="+data.applicant;
			
		}
	}
	
	function confirmEventRemoval(eventid){
		var ask=confirm("Are you sure you want to remove this event?");
		if(ask){
			window.location='eventmanagement.php?remove='+eventid;
			
		}
	}

	$.fn.extend({ 
         disableSelection: function() { 
              this.each(function() { 
                  if (typeof this.onselectstart != 'undefined') {
                       this.onselectstart = function() { return false; };
                  } else if (typeof this.style.MozUserSelect != 'undefined') {
                       this.style.MozUserSelect = 'none';
                  } else {
                      this.onmousedown = function() { return false; };
                  }
              }); 
          } 
    });

	       
        $(document).ready(function() {
			$('html').disableSelection();
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
                var table_div = document.getElementById('eventtable');
                var table_html = table_div.outerHTML.replace(/ /g, '%20');
                a.href = data_type + ', ' + table_html;
                //setting the file name
                a.download = 'exported_table_' + postfix + '.xls';
                //triggering the function
                a.click();
                //just in case, prevent default behaviour
                e.preventDefault();
            });
        });
    </script>
</body>
</html>

