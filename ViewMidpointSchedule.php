<?php
   // Conection criterial for database connection; 
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
   error_reporting(0);
   
   /// -----------------SHOW CURRENT SCHEDULE FOR MIDPOINT -----------------------/// 
   if(isset($_POST["ViewMidpointSchedule"])){
   
       $Sql = "SELECT * FROM MidpointPresentation";
       $result = mysqli_query($con, $Sql);  
    
   
       if (mysqli_num_rows($result) > 0) {
      echo "<div class='container'>";
   
   echo "<h2> Current schedule </h2>"; 
        echo "<div class='table-responsive'><table id='myTable' class='table table-striped table-bordered'>
                <thead><tr><th>Day</th>
                             <th>Room Name</th>
                             <th>Start Time</th>
                             <th>End Time</th>
   						  <th>Student ID</th>
   						  <th>Student Name</th>
   						  <th>Stream Name</th>
   						  <th>Programme</th>
   						  <th>Supervisor</th>
   						  <th>Second Supervisor</th>
                           </tr></thead><tbody>";
    
    
        while($row = mysqli_fetch_assoc($result)) {
    
            echo "<tr contenteditable><td>" . $row['Day']."</td>
                      <td>" . $row['Room_Name']."</td>
                      <td>" . $row['StartTime']."</td>
   				   <td>" . $row['EndTime']."</td>
   				   <td>" . $row['Student_ID']."</td>
   				   <td>" . $row['Student_Name']."</td>
   				   <td>" . $row['Stream_Name']."</td>
   				   <td>" . $row['Programme']."</td>
   				   <td>" . $row['Supervisor']."</td>
                      <td>" . $row['Second_Examiner']."</td></tr>";        
        }
       
        echo "</tbody></table></div>";
        
   } else {
    echo "<div class='container'>";
    echo "<h2> Current schedule </h2>"; 
            echo "<div class='table-responsive'><table id='myTable' class='table table-striped table-bordered'>
                <thead><tr><th>Day</th>
                             <th>Room Name</th>
                             <th>Start Time</th>
                             <th>End Time</th>
   						  <th>Student ID</th>
   						  <th>Student Name</th>
   						  <th>Stream Name</th>
   						  <th>Programme</th>
   						  <th>Supervisor</th>
   						  <th>Second Supervisor</th>
                           </tr></thead><tbody>
   						</tbody></table></div>"; 
   }
   
      // Failed Table 
   $Sql = "SELECT * FROM failedschedules";
       $result = mysqli_query($con, $Sql);  
   	
   	
   	
   	if (mysqli_num_rows($result) > 0) {
   		echo "<h3 class = 'text-center'> Students who couldn't be assigned to slots <h3>"; 
   		  echo "<div class='table-responsive'><table id='FailedTable' class='table table-striped table-bordered'>
     <thead><tr><th>Supervisor</th>
                             <th>Second Supervisor</th>
                             <th>Student ID</th>
   						  <th>Student Name</th>
                           </tr></thead><tbody>";
   	
   	 while($row = mysqli_fetch_assoc($result)) {
    
            echo "<tr><td>" . $row['Supervisor_Name']."</td>
                      <td>" . $row['Second_Supervisor_Name']."</td>
                      <td>" . $row['Student_ID']."</td>
                      <td>" . $row['Student_Name']."</td></tr>";        
        }
   
   echo "</tbody></table></div>";
   
   
   
   }
   
   
   
    }
    
    
    //---------------------BUTTON FOR FULL TIME STUDENTS TO BE SCHEDULED ------------------------------// 
    // -------------------------------------Full TIME ------------------------------------------------// 
    
    // Schedule Full Time Students
    // Full Time students 
   if(isset($_POST["MidpointFullStudents"])){
   $sql = "SELECT Student_ID FROM student WHERE PartTime =0"; 
   $result = mysqli_query($con, $sql);
   $FullTimeStudents = array(); 
   if(mysqli_num_rows($result) > 0){
   	while($row = mysqli_fetch_assoc($result)){
   		
   		$FullTimeStudents [] = $row;
   	
   	}
   }
   
   
   // ------------------------------ CONVERT STUDENT_IDS TO STRINGS -----------------------------------// 
   
   
   // Extract student id and Supervisor_ID 
   
   function extractStudentId($FullTimeStudents){
   return $FullTimeStudents['Student_ID'];
   
   }
   
   $students = array_map("extractStudentId",$FullTimeStudents);
   
   foreach($students as $Student){
   $sql = "select Supervisor_ID , Second_Supervisor_ID FROM student where Student_ID = $Student";
   $query = mysqli_query($con, $sql);
   $row = mysqli_fetch_array($query); 
   $SuperID = $row['Supervisor_ID'];
   $SecondSupervisorID = $row['Second_Supervisor_ID'];
   // echo  "SuperID : $SuperID Second Super ID : $SecondSupervisorID ";
   
   
    
   $sql = "SELECT Slot_ID, StartTime FROM slot WHERE Slot.Slot_ID NOT IN (Select Slot_ID FROM student_slot) AND Slot.StartTime NOT IN (SELECT UnavailableTime FROM supervisor_availability WHERE Supervisor_ID = $SuperID) AND Slot.StartTime NOT IN (SELECT UnavailableTime FROM supervisor_availability WHERE Supervisor_ID = $SecondSupervisorID) AND TIME(StartTime) < '18:00:00' AND Midpoint = 1 LIMIT 1";
   $query = mysqli_query($con, $sql);
   $row = mysqli_fetch_array($query); 
   $SlotID = $row['Slot_ID'];
   $UnavailableTime = $row['StartTime'];
   //echo $SlotID; 
   //echo $UnavailableTime;
   
   
   if($SlotID != Null){
   	$sql = "INSERT INTO student_slot (Student_ID, Slot_ID) VALUES ($Student, $SlotID)"; 
   $query = mysqli_query($con, $sql);
   
   	$sql = "INSERT INTO supervisor_availability (Supervisor_ID, UnavailableTime) VALUES ($SuperID, '$UnavailableTime')"; 
   $query = mysqli_query($con, $sql);
   
   	$sql = "INSERT INTO supervisor_availability (Supervisor_ID, UnavailableTime) VALUES ($SecondSupervisorID, '$UnavailableTime')"; 
   $query = mysqli_query($con, $sql);
   
   
   }else{ 
    // get Student Name
   $sql = "Select Student_Name from student WHERE Student_ID = $Student"; 
   $query = mysqli_query($con, $sql);
   $row = mysqli_fetch_array($query); 
   $SlotID = $row['Slot_ID'];
   $StudentName = $row['Student_Name'];
   
   
   $sql = "Select Supervisor_Name from supervisor WHERE Supervisor_ID = $SuperID"; 
   $query = mysqli_query($con, $sql);
   $row = mysqli_fetch_array($query); 
   $SlotID = $row['Slot_ID'];
   $SuperName = $row['Supervisor_Name'];
   
   
   $sql = "Select Supervisor_Name from supervisor WHERE Supervisor_ID = $SecondSupervisorID"; 
   $query = mysqli_query($con, $sql);
   $row = mysqli_fetch_array($query); 
   $SlotID = $row['Slot_ID'];
   $SecondSuperName = $row['Supervisor_Name'];
   
   
       $sql = "INSERT INTO `failedschedules` (`Supervisor_Name`, `Second_Supervisor_Name`, `Student_ID`, `Student_Name`) VALUES ('$SuperName', '$SecondSuperName', '$Student', '$StudentName')";
       $result = mysqli_query($con, $sql);  
   	
   
   
   } 
    }  
   
   
       $Sql = "SELECT * FROM MidpointPresentation";
       $result = mysqli_query($con, $Sql);  
    
    
       if (mysqli_num_rows($result) > 0) {
		   echo "<h2> Current schedule </h2>";
     echo "<div class='container'>";
        echo "<div class='table-responsive'><table id='myTable' class='table table-striped table-bordered'>
                <thead><tr><th>Day</th>
                             <th>Room Name</th>
                             <th>Start Time</th>
                             <th>End Time</th>
   						  <th>Student ID</th>
   						  <th>Student Name</th>
   						  <th>Stream Name</th>
   						  <th>Programme</th>
   						  <th>Supervisor</th>
   						  <th>Second Supervisor</th>
                           </tr></thead><tbody>";
    
    
        while($row = mysqli_fetch_assoc($result)) {
    
            echo "<tr contenteditable><td>" . $row['Day']."</td>
                      <td>" . $row['Room_Name']."</td>
                      <td>" . $row['StartTime']."</td>
   				   <td>" . $row['EndTime']."</td>
   				   <td>" . $row['Student_ID']."</td>
   				   <td>" . $row['Student_Name']."</td>
   				   <td>" . $row['Stream_Name']."</td>
   				   <td>" . $row['Programme']."</td>
   				   <td>" . $row['Supervisor']."</td>
                      <td>" . $row['Second_Examiner']."</td></tr>";        
        }
       
        echo "</tbody></table></div>";
        
   } else {
	   
    echo "<div class='container'>";
	echo "<h2> Current schedule </h2>";
            echo "<div class='table-responsive'><table id='myTable' class='table table-striped table-bordered'>
                <thead><tr><th>Day</th>
                             <th>Room Name</th>
                             <th>Start Time</th>
                             <th>End Time</th>
   						  <th>Student ID</th>
   						  <th>Student Name</th>
   						  <th>Stream Name</th>
   						  <th>Programme</th>
   						  <th>Supervisor</th>
   						  <th>Second Supervisor</th>
                           </tr></thead><tbody>
   						</tbody></table></div>"; 
   
   	 											
   } 
   
      // Failed Table 
   $Sql = "SELECT * FROM failedschedules";
       $result = mysqli_query($con, $Sql);  
   	
   	
   	
   	if (mysqli_num_rows($result) > 0) {
   		echo "<h3 class = 'text-center'> Students who couldn't be assigned to slots <h3>"; 
   		  echo "<div class='table-responsive'><table id='FailedTable' class='table table-striped table-bordered'>
     <thead><tr><th>Supervisor</th>
                             <th>Second Supervisor</th>
                             <th>Student ID</th>
   						  <th>Student Name</th>
                           </tr></thead><tbody>";
   	
   	 while($row = mysqli_fetch_assoc($result)) {
    
            echo "<tr><td>" . $row['Supervisor_Name']."</td>
                      <td>" . $row['Second_Supervisor_Name']."</td>
                      <td>" . $row['Student_ID']."</td>
                      <td>" . $row['Student_Name']."</td></tr>";        
        }
   
   echo "</tbody></table></div>";
   
   
   
   }
   
   
   }
   
   //------------------------- BUTTON FOR SCHEDULING PART TIME STUDENTS --------// 
   // ------------------------ PART TIME ---------------------------------------// 
   
   // // Submit Part Time students. 
   
   // Evening Time Slots
   if(isset($_POST["MidpointPartStudents"])){
   $sql = "SELECT Student_ID FROM student WHERE PartTime =1"; 
   $result = mysqli_query($con, $sql);
   $PartTimeStudents = array(); 
   if(mysqli_num_rows($result) > 0){
   	while($row = mysqli_fetch_assoc($result)){
   		
   		$PartTimeStudents [] = $row;
   	
   	}
   }
   
   
   // ------------------------------ CONVERT STUDENT_IDS TO STRINGS -----------------------------------// 
   
   
   // Extract student id and Supervisor_ID 
   
   function extractPartTimeStudentId($PartTimeStudents){
   return $PartTimeStudents['Student_ID'];
   
   }
   
   $Partstudents = array_map("extractPartTimeStudentId",$PartTimeStudents);
   
   foreach($Partstudents as $PartStudent){
   $sql = "select Supervisor_ID , Second_Supervisor_ID FROM student where Student_ID = $PartStudent";
   $query = mysqli_query($con, $sql);
   $row = mysqli_fetch_array($query); 
   $SuperID = $row['Supervisor_ID'];
   $SecondSupervisorID = $row['Second_Supervisor_ID'];
   //echo  "SuperID : $SuperID Second Super ID : $SecondSupervisorID ";
   
   
    
   $sql = "SELECT Slot_ID, StartTime FROM slot WHERE Slot.Slot_ID NOT IN (Select Slot_ID FROM student_slot) AND Slot.StartTime NOT IN (SELECT UnavailableTime FROM supervisor_availability WHERE Supervisor_ID = $SuperID) AND Slot.StartTime NOT IN (SELECT UnavailableTime FROM supervisor_availability WHERE Supervisor_ID = $SecondSupervisorID)AND TIME(StartTime) >= '18:00:00' AND Midpoint = 1 LIMIT 1";
   $query = mysqli_query($con, $sql);
   $row = mysqli_fetch_array($query); 
   $SlotID = $row['Slot_ID'];
   $UnavailableTime = $row['StartTime'];
   //echo $SlotID; 
   //echo $UnavailableTime;
   
   
   if($SlotID != Null){
   	$sql = "INSERT INTO student_slot (Student_ID, Slot_ID) VALUES ($PartStudent, $SlotID)"; 
   $query = mysqli_query($con, $sql);
   
   	$sql = "INSERT INTO supervisor_availability (Supervisor_ID, UnavailableTime) VALUES ($SuperID, '$UnavailableTime')"; 
   $query = mysqli_query($con, $sql);
   
   	$sql = "INSERT INTO supervisor_availability (Supervisor_ID, UnavailableTime) VALUES ($SecondSupervisorID, '$UnavailableTime')"; 
   $query = mysqli_query($con, $sql);
   
   
   }else{ 
     
    // get Student Name
   $sql = "Select Student_Name from student WHERE Student_ID = $PartStudent"; 
   $query = mysqli_query($con, $sql);
   $row = mysqli_fetch_array($query); 
   $SlotID = $row['Slot_ID'];
   $StudentName = $row['Student_Name'];
   
   
   
   $sql = "Select Supervisor_Name from supervisor WHERE Supervisor_ID = $SuperID"; 
   $query = mysqli_query($con, $sql);
   $row = mysqli_fetch_array($query); 
   $SlotID = $row['Slot_ID'];
   $SuperName = $row['Supervisor_Name'];
   
   
   $sql = "Select Supervisor_Name from supervisor WHERE Supervisor_ID = $SecondSupervisorID"; 
   $query = mysqli_query($con, $sql);
   $row = mysqli_fetch_array($query); 
   $SlotID = $row['Slot_ID'];
   $SecondSuperName = $row['Supervisor_Name'];
   
   
       $sql = "INSERT INTO `failedschedules` (`Supervisor_Name`, `Second_Supervisor_Name`, `Student_ID`, `Student_Name`) VALUES ('$SuperName', '$SecondSuperName', '$PartStudent', '$StudentName')";
       $result = mysqli_query($con, $sql);   
   
   
   
   	
   } 
    }
    
    // show table 
      $Sql = "SELECT * FROM MidpointPresentation";
       $result = mysqli_query($con, $Sql);  
    
    
       if (mysqli_num_rows($result) > 0) {
     echo "<div class='container'>";
	 echo "<h2> Current schedule </h2>";
        echo "<div class='table-responsive'><table id='myTable' class='table table-striped table-bordered'>
                <thead><tr><th>Day</th>
                             <th>Room Name</th>
                             <th>Start Time</th>
                             <th>End Time</th>
   						  <th>Student ID</th>
   						  <th>Student Name</th>
   						  <th>Stream Name</th>
   						  <th>Programme</th>
   						  <th>Supervisor</th>
   						  <th>Second Supervisor</th>
                           </tr></thead><tbody>";
    
    
        while($row = mysqli_fetch_assoc($result)) {
    
            echo "<tr contenteditable><td>" . $row['Day']."</td>
                      <td>" . $row['Room_Name']."</td>
                      <td>" . $row['StartTime']."</td>
   				   <td>" . $row['EndTime']."</td>
   				   <td>" . $row['Student_ID']."</td>
   				   <td>" . $row['Student_Name']."</td>
   				   <td>" . $row['Stream_Name']."</td>
   				   <td>" . $row['Programme']."</td>
   				   <td>" . $row['Supervisor']."</td>
                      <td>" . $row['Second_Examiner']."</td></tr>";        
        }
       
        echo "</tbody></table></div>";
        
   } else {
    echo "<div class='container'>";
	echo "<h2> Current schedule </h2>";
            echo "<div class='table-responsive'><table id='myTable' class='table table-striped table-bordered'>
                <thead><tr><th>Day</th>
                             <th>Room Name</th>
                             <th>Start Time</th>
                             <th>End Time</th>
   						  <th>Student ID</th>
   						  <th>Student Name</th>
   						  <th>Stream Name</th>
   						  <th>Programme</th>
   						  <th>Supervisor</th>
   						  <th>Second Supervisor</th>
                           </tr></thead><tbody>
   						</tbody></table></div>"; 
   						
   }
   
   
       // Failed Table 
   $Sql = "SELECT * FROM failedschedules";
       $result = mysqli_query($con, $Sql);  
   	
   	
   	
   	if (mysqli_num_rows($result) > 0) {
   		echo "<h3 class = 'text-center'> Students who couldn't be assigned to slots <h3>"; 
   		  echo "<div class='table-responsive'><table id='FailedTable' class='table table-striped table-bordered'>
     <thead><tr><th>Supervisor</th>
                             <th>Second Supervisor</th>
                             <th>Student ID</th>
   						  <th>Student Name</th>
                           </tr></thead><tbody>";
   	
   	 while($row = mysqli_fetch_assoc($result)) {
    
            echo "<tr><td>" . $row['Supervisor_Name']."</td>
                      <td>" . $row['Second_Supervisor_Name']."</td>
                      <td>" . $row['Student_ID']."</td>
                      <td>" . $row['Student_Name']."</td></tr>";        
        }
   
   echo "</tbody></table></div>";
   
   
   
   }
   
   
   
   
   
   
   }
   	
   
   // ----------------Refresh the Schedule ---------------------// 
   
   if(isset($_POST["Refresh"])){
   
       $Sql = "SELECT * FROM MidpointPresentation";
       $result = mysqli_query($con, $Sql);  
    
    
       if (mysqli_num_rows($result) > 0) {
     echo "<div class='container'>";
        echo "<div class='table-responsive'><table id='myTable' class='table table-striped table-bordered'>
                <thead><tr><th>Day</th>
                             <th>Room Name</th>
                             <th>Start Time</th>
                             <th>End Time</th>
   						  <th>Student ID</th>
   						  <th>Student Name</th>
   			  <th>Stream Name</th>
   						  <th>Programme</th>
   						  <th>Supervisor</th>
   						  <th>Second Supervisor</th>
                           </tr></thead><tbody>";
    
    
        while($row = mysqli_fetch_assoc($result)) {
    
            echo "<tr contenteditable><td>" . $row['Day']."</td>
                      <td>" . $row['Room_Name']."</td>
                      <td>" . $row['StartTime']."</td>
   				   <td>" . $row['EndTime']."</td>
   				   <td>" . $row['Student_ID']."</td>
   				   <td>" . $row['Student_Name']."</td>
   	   <td>" . $row['Stream_Name']."</td>
   				   <td>" . $row['Programme']."</td>
   				   <td>" . $row['Supervisor']."</td>
                      <td>" . $row['Second_Examiner']."</td></tr>";        
        }
       
        echo "</tbody></table></div>";
        
   } else {
    echo "<div class='container'>";
	 echo "<h2> Current schedule </h2>"; 
    
            echo "<div class='table-responsive' contenteditable><table id='myTable' class='table table-striped table-bordered'>
                <thead><tr><th>Day</th>
                            
                             <th>Room Name</th>
                             <th>Start Time</th>
                             <th>End Time</th>
   						  <th>Student ID</th>
   						  <th>Student Name</th>
   			  <th>Stream Name</th>
   						  <th>Programme</th>
   						  <th>Supervisor</th>
   						  <th>Second Supervisor</th>
                           </tr></thead><tbody>
   						</tbody></table></div>"; 
   			
   			echo "</div contenteditable>";
   }
   
   
       // Failed Table 
   $Sql = "SELECT * FROM failedschedules";
       $result = mysqli_query($con, $Sql);  
   	
   	
   	
   	if (mysqli_num_rows($result) > 0) {
   		echo "<h3 class = 'text-center'> Students who couldn't be assigned to slots <h3>"; 
   		  echo "<div class='table-responsive'><table id='FailedTable' class='table table-striped table-bordered'>
     <thead><tr><th>Supervisor</th>
                             <th>Second Supervisor</th>
                             <th>Student ID</th>
   						  <th>Student Name</th>
                           </tr></thead><tbody>";
   	
   	 while($row = mysqli_fetch_assoc($result)) {
    
            echo "<tr><td>" . $row['Supervisor_Name']."</td>
                      <td>" . $row['Second_Supervisor_Name']."</td>
                      <td>" . $row['Student_ID']."</td>
                      <td>" . $row['Student_Name']."</td></tr>";        
        }
   
   echo "</tbody></table></div>";
   
   
   
   }
    }
   
   
   
    
    // Exporting The Schedule // 
    
    
    if(isset($_POST["ExportSchedule"])){
   		 
        header('Content-Type: text/csv; charset=utf-8');  
        header('Content-Disposition: attachment; filename= Midpoint Schedule.csv');  
         $output = fopen("php://output", "w");  
         fputcsv($output, array('Day', 'Room_Name', 'StartTime', 'EndTime', 'Student_ID', 'Student_Name', 'Stream_Name' ,'Programme', 'Supervisor', 'Second Examiner'));  
         $query = "SELECT * From MidpointPresentation";  
         $result = mysqli_query($con, $query);  
         while($row = mysqli_fetch_assoc($result))  
         {  
              fputcsv($output, $row);  
         }  
         fclose($output);  
   	  
   	  exit();
    } 
       
    ?> 
<!DOCTYPE html>
<html lang="en">
   <head>
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" crossorigin="anonymous">
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" crossorigin="anonymous">
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" crossorigin="anonymous"></script>
      <script> 
         function downloadCSV(csv, filename) {
          var csvFile;
          var downloadLink;
         
          // CSV file
          csvFile = new Blob([csv], {type: "text/csv"});
         
          // Download link
          downloadLink = document.createElement("a");
         
          // File name
          downloadLink.download = filename;
         
          // Create a link to the file
          downloadLink.href = window.URL.createObjectURL(csvFile);
         
          // Hide download link
          downloadLink.style.display = "none";
         
          // Add the link to DOM
          document.body.appendChild(downloadLink);
         
          // Click download link
          downloadLink.click();
         }
         
         function exportTableToCSV(filename) {
          var csv = [];
          var rows = document.querySelectorAll("table tr");
          
          for (var i = 0; i < rows.length; i++) {
              var row = [], cols = rows[i].querySelectorAll("td, th");
              
              for (var j = 0; j < cols.length; j++) 
                  row.push(cols[j].innerText);
              
              csv.push(row.join(","));        
          }
         
          // Download CSV file
          downloadCSV(csv.join("\n"), filename);
         }
      </script> 
   </head>
   <body>
      <form class="form-horizontal" action="ViewMidpointSchedule.php" method="POST" name="upload_excel" enctype="multipart/form-data">
         <div class="form-row text-center">
            <button type="submit" class="btn btn-primary btn-lg" name ="MidpointFullStudents">Schedule Full Time Students</button>
            <button type="submit" class="btn btn-primary btn-lg" name ="MidpointPartStudents">Schedule Part Time Students</button>
            <button type="submit" name ="Refresh" class="btn btn-primary btn-lg" onclick="exportTableToCSV('Modified midpoint.csv')">Export Modified Changes</button>
            <button type="submit" class="btn btn-primary btn-lg" name ="ExportSchedule">Export Schedule to Excel</button>
         </div>
      </form>
   </body>
</html>