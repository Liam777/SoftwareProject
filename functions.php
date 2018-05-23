<?php
$servername = "localhost";
$username = "root";
$password = "Iceburger2013@";
$dbname = "xchedule";

// Create connection
$con = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

 if(isset($_POST["Import"])){
		
		$filename=$_FILES["file"]["tmp_name"];		


		 if($_FILES["file"]["size"] > 0)
		 {
		  	$file = fopen($filename, "r");
			fgetcsv($handle);
	        while (($getData = fgetcsv($file, 10000, ",")) !== FALSE)
	         {


	           $sql = "INSERT into classroom (Room_ID,Room_Name) 
                   values ('".$getData[0]."','".$getData[1]."')";
                   $result = mysqli_query($con, $sql);
				if(!isset($result))
				{
					echo "<script type=\"text/javascript\">
							alert(\"Invalid File:Please Upload CSV File.\");
							window.location = \"Admin.php\"
						  </script>";		
				}
				
else {
					  echo "<script type=\"text/javascript\">
						alert(\"CSV File has been successfully Imported.\");
						window.location = \"Admin.php\"
					</script>";
				}
	         }
			
	         fclose($file);	
		 }
	}	 
	
	
	
	if(isset($_POST["ImportSubjects"])){
		
		$filename=$_FILES["file"]["tmp_name"];		


		 if($_FILES["file"]["size"] > 0)
		 {
		  	$file = fopen($filename, "r");
	        while (($getData = fgetcsv($file, 10000, ",")) !== FALSE)
	         {


	           $sql = "INSERT into subject (Stream_ID, Stream_Name, Programme) 
                   values ('".$getData[0]."','".$getData[1]."','".$getData[2]."')";
                   $result = mysqli_query($con, $sql);
				if(!isset($result))
				{
					echo "<script type=\"text/javascript\">
							alert(\"Invalid File:Please Upload CSV File.\");
							window.location = \"Admin.php\"
						  </script>";		
				}
				else {
					  echo "<script type=\"text/javascript\">
						alert(\"CSV File has been successfully Imported.\");
						window.location = \"Admin.php\"
					</script>";
				}
	         }
			
	         fclose($file);	
		 }
	}	 
	
	if(isset($_POST["ImportSupervisors"])){
		
		$filename=$_FILES["file"]["tmp_name"];		


		 if($_FILES["file"]["size"] > 0)
		 {
		  	$file = fopen($filename, "r");
	        while (($getData = fgetcsv($file, 10000, ",")) !== FALSE)
	         {


	           $sql = "INSERT into supervisor (Supervisor_ID, Supervisor_Name) 
                   values ('".$getData[0]."','".$getData[1]."')";
                   $result = mysqli_query($con, $sql);
				if(!isset($result))
				{
					echo "<script type=\"text/javascript\">
							alert(\"Invalid File:Please Upload CSV File.\");
							window.location = \"Admin.php\"
						  </script>";		
				}
				else {
					  echo "<script type=\"text/javascript\">
						alert(\"CSV File has been successfully Imported.\");
						window.location = \"Admin.php\"
					</script>";
				}
	         }
			
	         fclose($file);	
		 }
	}	

	if(isset($_POST["ImportStudents"])){
		
		$filename=$_FILES["file"]["tmp_name"];		


		 if($_FILES["file"]["size"] > 0)
		 {
		  	$file = fopen($filename, "r");
	        while (($getData = fgetcsv($file, 10000, ",")) !== FALSE)
	         {


	           $sql = "INSERT INTO student (Student_ID, Student_Name, Supervisor_ID, Second_Supervisor_ID, Stream_ID, PartTime) 
                   values ('".$getData[0]."','".$getData[1]."','".$getData[2]."','".$getData[3]."','".$getData[4]."','".$getData[5]."')";
                   $result = mysqli_query($con, $sql);
				if(!isset($result))
				{
					echo "<script type=\"text/javascript\">
							alert(\"Invalid File:Please Upload CSV File.\");
							window.location = \"Admin.php\"
						  </script>";		
				}
				else {
					  echo "<script type=\"text/javascript\">
						alert(\"CSV File has been successfully Imported.\");
						window.location = \"Admin.php\"
					</script>";
				}
	         }
			
	         fclose($file);	
		 }
	}		
	
	
		if(isset($_POST["ImportSlots"])){
		
		$filename=$_FILES["file"]["tmp_name"];		


		 if($_FILES["file"]["size"] > 0)
		 {
		  	$file = fopen($filename, "r");
	        while (($getData = fgetcsv($file, 10000, ",")) !== FALSE)
	         {


	           $sql = "INSERT into slot (Slot_ID, Day, StartTime, EndTime, Room_ID, Midpoint) 
                   values (Null , '".$getData[0]."','".$getData[1]."','".$getData[2]."','".$getData[3]."','".$getData[4]."')";
                   $result = mysqli_query($con, $sql);
				if(!isset($result))
				{
					echo "<script type=\"text/javascript\">
							alert(\"Invalid File:Please Upload CSV File.\");
							window.location = \"Admin.php\"
						  </script>";		
				}
				else {
					  echo "<script type=\"text/javascript\">
						alert(\"CSV File has been successfully Imported.\");
						window.location = \"Admin.php\"
					</script>";
				}
	         }
			
	         fclose($file);	
		 }
	}		
	
			if(isset($_POST["ImportAvailability"])){
		
		$filename=$_FILES["file"]["tmp_name"];		


		 if($_FILES["file"]["size"] > 0)
		 {
		  	$file = fopen($filename, "r");
	        while (($getData = fgetcsv($file, 10000, ",")) !== FALSE)
	         {


	           $sql = "INSERT into supervisor_availability (SupervisorUnavailableID, Supervisor_ID, UnavailableTime) 
                   values (Null , '".$getData[0]."','".$getData[1]."')";
                   $result = mysqli_query($con, $sql);
				if(!isset($result))
				{
					echo "<script type=\"text/javascript\">
							alert(\"Invalid File:Please Upload CSV File.\");
							window.location = \"Admin.php\"
						  </script>";		
				}
				else {
					  echo "<script type=\"text/javascript\">
						alert(\"CSV File has been successfully Imported.\");
						window.location = \"Admin.php\"
					</script>";
				}
	         }
			
	         fclose($file);	
		 }
	}		
	
		
	
	
	
 if(isset($_POST["ViewSchedule"])){

    $Sql = "SELECT * FROM end_of_year_schedulev1";
    $result = mysqli_query($con, $Sql);  
 
 
    if (mysqli_num_rows($result) > 0) {
     echo "<div class='table-responsive'><table id='myTable' class='table table-striped table-bordered'>
             <thead><tr><th>Day</th>
                          <th>Date</th>
                          <th>Room Name</th>
                          <th>Start Time</th>
                          <th>End Time</th>
						  <th>Student ID</th>
						  <th>Student Name</th>
						  <th>Programme</th>
						  <th>Supervisor</th>
						  <th>Second Supervisor</th>
                        </tr></thead><tbody>";
 
 
     while($row = mysqli_fetch_assoc($result)) {
 
         echo "<tr><td>" . $row['Day']."</td>
                   <td>" . $row['Date']."</td>
                   <td>" . $row['Room_Name']."</td>
                   <td>" . $row['StartTime']."</td>
				   <td>" . $row['EndTime']."</td>
				   <td>" . $row['Student_ID']."</td>
				   <td>" . $row['Student_Name']."</td>
				   <td>" . $row['Programme']."</td>
				   <td>" . $row['Supervisor']."</td>
                   <td>" . $row['Second_Examiner']."</td></tr>";        
     }
    
     echo "</tbody></table></div>";
     
} else {
     echo "you have no records";
}
 }



if(isset($_POST["Delete"])){
		 
    $sql = "DELETE FROM failedschedules";
    $result = mysqli_query($con, $sql);
	
	$sql = "DELETE FROM student_slot";
    $result = mysqli_query($con, $sql);
	
	$sql = "DELETE FROM supervisor_availability";
    $result = mysqli_query($con, $sql);
	
	$sql = "DELETE FROM student";
    $result = mysqli_query($con, $sql);
	
	$sql = "DELETE FROM subject";
    $result = mysqli_query($con, $sql);
	
	$sql = "DELETE FROM slot";
    $result = mysqli_query($con, $sql);
	
	$sql = "DELETE FROM classroom";
    $result = mysqli_query($con, $sql);
	
	$sql = "DELETE FROM supervisor";
    $result = mysqli_query($con, $sql);
	
	if(!isset($result))
				{
					echo "<script type=\"text/javascript\">
							alert(\"Oops, Something went wrong.\");
							window.location = \"Admin.php\"
						  </script>";		
				}
				else {
					  echo "<script type=\"text/javascript\">
						alert(\"Data has been cleared! \");
						window.location = \"Admin.php\"
					</script>";
				}
	         }

   
 ?>