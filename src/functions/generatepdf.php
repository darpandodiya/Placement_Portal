<?php
    require('isloggedin.php');
	require('gettable.php');

	//Database connection and function inclusion
	require('fpdf17/fpdf.php');
    require('realName.php');
	$con = getConnection();
				
	$sqlquery = "SELECT * FROM $candidates WHERE ID='".$_SESSION['username']."'";
	$result = mysqli_query($con, $sqlquery);	
	$data = mysqli_fetch_array($result);	
	
	class PDF extends FPDF {
	// Page header
		
		
		function Header() {
			// Logo
			$this->AddFont('Segoe','','segoeui.php');
			$this->Image('../images/placementlogoSmall.png',10,6,30);
    		// Segoe bold 15
    		$this->SetFont('Segoe', '', 15);
    		// Move to the right
    		$this->Cell(75);
    		// Title
	    	$this->Cell(40, 10, 'Registration Details','0',2,'C', false);
    	}

	// Page footer
		function Footer() {
    		// Position at 1.5 cm from bottom
    		$this->SetY(-10);
	    	// Arial italic 8
	    	$this->SetFont('Segoe','',8);
	    	// Page number
    		$this->Cell(0,10,'This page has been generated automatically by Placement Cell.',0,1,'C');
		}
	}
	
	//Setting meta-data for PDF
	$pdf = new PDF('P','mm','A4');
	$pdf->AddFont('Segoe','','segoeui.php');
	$pdf->AddPage();
	$pdf->SetFont('Segoe', '', 11);
	
	//Data to be printed. DON'T remove any white spaces. They're necessary for proper formatting.
	
    $src1 = '../photos/'.md5($_SESSION['username']).'.jpg';
    $src2 = '../photos/'.md5($_SESSION['username']).'.jpeg';
    $src3 = '../photos/'.md5($_SESSION['username']).'.png';
    $src4 = '../photos/'.md5($_SESSION['username']).'.gif';
    
    if (@getimagesize($src1)) {    
        $pdf->Image($src1, 170,20,30);
	    $pdf->Ln(8);
    }
    else if (@getimagesize($src2)) {
        $pdf->Image($src2, 170,20,30);
	    $pdf->Ln(8);
    }
    else if (@getimagesize($src3)) {
        $pdf->Image($src3, 170,20,30);
	    $pdf->Ln(8);
    }
    else if (@getimagesize($src4)) {
        $pdf->Image($src3, 170,20,30);
	    $pdf->Ln(8);
    }
    else {
        $pdf->Image('../images/profileupdate.png', 170,20,25);
	    $pdf->Ln(8);   
    }

	$pdf->Cell(180,8, 'ID');
	$pdf->SetX(57);
	$pdf->Multicell(123,8, ':   '.$data['id']);

	$pdf->Cell(180,8, 'Name');
	$pdf->SetX(57);
	$pdf->Multicell(123,8, ':   '.$data['name']);
    
    $pdf->Cell(180,8, 'Birthdate');
	$pdf->SetX(57);
	$pdf->Multicell(123,8, ':   '.$data['birthdate']);

	$pdf->Cell(180,8, 'Roll No.');
	$pdf->SetX(57);
	$pdf->Multicell(123,8, ':   '.$data['rollno']);
	
	$pdf->Cell(180,8, 'Contact');
	$pdf->SetX(57);
	$pdf->Multicell(123,8, ':   '.$data['contact']);
    
    if(!($data['contact_landline'] == '')) {
        $pdf->Cell(180,8, 'Landline');
    	$pdf->SetX(57);
	    $pdf->Multicell(123,8, ':   0'.$data['contact_landline']);
    }
	
	$pdf->Cell(180,8, 'Email');
	$pdf->SetX(57);
	$pdf->Multicell(123,8, ':   '.$data['email']);

	$pdf->Cell(180,8, 'Home Town');
	$pdf->SetX(57);
	$pdf->Multicell(123,8, ':   '.$data['city']);
	
	$pdf->Cell(180,8, 'Preffered City to Work');
	$pdf->SetX(57);
	$pdf->Multicell(123,8, ':   '.$data['preferred_city']);
	
	$pdf->Cell(180,8, 'SSC Result');
	$pdf->SetX(57);
	$pdf->Multicell(123,8, ':   '.$data['ssc']);
	
	$pdf->Cell(180,8, 'HSC Result');
	$pdf->SetX(57);
	$hsc = $data['hsc'];
	if($hsc == 0 || $hsc == '') {
		$hsc = "Not Applicable";
	}
	$pdf->Multicell(123,8, ':   '.$data['hsc']);
	
	$pdf->Cell(180,8, 'Diploma Result');
	$pdf->SetX(57);
	$diploma = $data['diploma'];
	if($diploma == 0 || $diploma == '') {
		$diploma = "Not Applicable";
	}
	$pdf->Multicell(123,8, ':   '.$diploma);

	$pdf->Cell(180,8, 'SPI 1st Semester');
	$pdf->SetX(57);
	$pdf->Multicell(123,8, ':   '.$data['spi_1']);
	
	$pdf->Cell(180,8, 'SPI 2nd Semester');
	$pdf->SetX(57);
	$pdf->Multicell(123,8, ':   '.$data['spi_2']);
	
	$pdf->Cell(180,8, 'SPI 3rd Semester');
	$pdf->SetX(57);
	$pdf->Multicell(123,8, ':   '.$data['spi_3']);
	
	$pdf->Cell(180,8, 'SPI 4th Semester');
	$pdf->SetX(57);
	$pdf->Multicell(123,8, ':   '.$data['spi_4']);
	
	$pdf->Cell(180,8, 'SPI 5th Semester');
	$pdf->SetX(57);
	$pdf->Multicell(123,8, ':   '.$data['spi_5']);
	
	$pdf->Cell(180,8, 'SPI 6th Semester');
	$pdf->SetX(57);
	$pdf->Multicell(123,8, ':   '.$data['spi_6']);

	$pdf->Cell(180,8, 'CPI');
	$pdf->SetX(57);
	$pdf->Multicell(123,8, ':   '.$data['cpi']);
	
	$pdf->Cell(180,8, 'Address');
	$pdf->SetX(57);
	$pdf->Write(8,':');
	$pdf->SetX(61);
	$pdf->Multicell(120,8, $data['address']);
	
	$pdf->Cell(180,8, 'Preferred Technologies');
	$pdf->SetX(57);
    $pretech = getRealNames($data['preferred_techs']);
	$pdf->Multicell(123,8, ':   '.$pretech);
	
	$pdf->Cell(180,8, 'Software Skills');
	$pdf->SetX(57);
    $othskl = getRealNames($data['skills']);
    $extract = explode(',', $data['other_skills']);
    
    foreach($extract as $temp){
        if(!($temp == '')) {
			if($othskl == '')
				$othskl = $temp;
			else  
            	$othskl = $othskl.", ".$temp;  
        }
    }
    
	$pdf->Multicell(123,8, ':   '.$othskl);
	
	
	//Output and closing the stream
	$pdf->Output($data['id'].".pdf", "I");	
	$pdf->Close();
?>