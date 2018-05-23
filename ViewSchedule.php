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
if(isset($_POST["ViewSchedule"])){

    $Sql = "SELECT * FROM FinalPresntation";
    $result = mysqli_query($con, $Sql);  
 
 
    if (mysqli_num_rows($result) > 0) {
		echo "
<div class='container'>"; 
		echo "
	<h2> Current schedule </h2>"; 
     echo "
	<div class='table-responsive'>
		<table id='myTable' class='table table-striped table-bordered'>
			<thead>
				<tr>
					<th>Day</th>
					<th>Room Name</th>
					<th>Start Time</th>
					<th>End Time</th>
					<th>Student ID</th>
					<th>Student Name</th>
					<th>Stream_Name</th>
					<th>Programme</th>
					<th>Supervisor</th>
					<th>Second Supervisor</th>
				</tr>
			</thead>
			<tbody>";
 
 
     while($row = mysqli_fetch_assoc($result)) {
 
         echo "
				<tr contenteditable>
					<td>" . $row['Day']."</td>
					<td>" . $row['Room_Name']."</td>
					<td>" . $row['StartTime']."</td>
					<td>" . $row['EndTime']."</td>
					<td>" . $row['Student_ID']."</td>
					<td>" . $row['Student_Name']."</td>
					<td>" . $row['Stream_Name']."</td>
					<td>" . $row['Programme']."</td>
					<td>" . $row['Supervisor']."</td>
					<td>" . $row['Second_Examiner']."</td>
				</tr>";        
     }
    
     echo "
			</tbody>
		</table>
	</div>";

     
} else {
	echo "
	<div class='container'>"; 
	echo "
		<h2> Current schedule </h2>"; 
         echo "
		<div class='table-responsive'>
			<table id='myTable' class='table table-striped table-bordered'>
				<thead>
					<tr>
						<th>Day</th>
						<th>Room Name</th>
						<th>Start Time</th>
						<th>End Time</th>
						<th>Student ID</th>
						<th>Student Name</th>
						<th>Stream Name</th>
						<th>Programme</th>
						<th>Supervisor</th>
						<th>Second Supervisor</th>
					</tr>
				</thead>
				<tbody></tbody>
			</table>
		</div>"; 
}
 }
 
//----------------------------------------FULL TIME ---------------------------------// 
 
 
// Full Time students 
if(isset($_POST["FullStudents"])){
	
$sql = "SELECT * FROM slot WHERE  TIME(StartTime) < '18:00:00' AND Midpoint = 0"; 
$result = mysqli_query($con, $sql);
$DayTimeSlots = array(); 
if(mysqli_num_rows($result) > 0){
	while($row = mysqli_fetch_assoc($result)){
		
		$DayTimeSlots [] = $row;
		
	}
}
$sql = "SELECT Student_ID FROM student WHERE PartTime =0"; 
$result = mysqli_query($con, $sql);
$FullTimeStudents = array(); 
if(mysqli_num_rows($result) > 0){
	while($row = mysqli_fetch_assoc($result)){
		
		$FullTimeStudents [] = $row;
	
	}
}



//function to extract student id from students array
function extractDayStudentId($FullTimeStudents){
return $FullTimeStudents['Student_ID'];
}
//function to extract slot id from Slot array
function extractDaySlotId($DayTimeSlots){
return $DayTimeSlots['Slot_ID'];
}


$Daystudents = array_map("extractDayStudentId",$FullTimeStudents);//new students array
$Dayslots =array_map("extractDaySlotId",$DayTimeSlots);//new slots array


$min = min(count($Daystudents), count($Dayslots));
$result = array_combine(array_slice($Daystudents, 0, $min), array_slice($Dayslots, 0, $min));

foreach($result as $key=>$value){
	$sql = ("INSERT INTO student_slot (Student_ID, Slot_ID)VALUES ('$key' , '$value')");
	mysqli_query ($con, $sql);
} 


  $Sql = "SELECT * FROM FinalPresntation";
    $result = mysqli_query($con, $Sql);  
 
 
    if (mysqli_num_rows($result) > 0) {
		echo "
		<div class='container'>";
		echo "
			<h2> Current schedule </h2>"; 
     echo "
			<div class='table-responsive'>
				<table id='myTable' class='table table-striped table-bordered'>
					<thead>
						<tr>
							<th>Day</th>
							<th>Room Name</th>
							<th>Start Time</th>
							<th>End Time</th>
							<th>Student ID</th>
							<th>Student Name</th>
							<th>Stream Name</th>
							<th>Programme</th>
							<th>Supervisor</th>
							<th>Second Supervisor</th>
						</tr>
					</thead>
					<tbody>";
 
 
     while($row = mysqli_fetch_assoc($result)) {
 
         echo "
						<tr contenteditable>
							<td>" . $row['Day']."</td>
							<td>" . $row['Room_Name']."</td>
							<td>" . $row['StartTime']."</td>
							<td>" . $row['EndTime']."</td>
							<td>" . $row['Student_ID']."</td>
							<td>" . $row['Student_Name']."</td>
							<td>" . $row['Stream_Name']."</td>
							<td>" . $row['Programme']."</td>
							<td>" . $row['Supervisor']."</td>
							<td>" . $row['Second_Examiner']."</td>
						</tr>";        
     }
    
     echo "
					</tbody>
				</table>
			</div>";
     
} else {
	echo "
			<div class='container'>";
	echo "
				<h2> Current schedule </h2>"; 
         echo "
				<div class='table-responsive'>
					<table id='myTable' class='table table-striped table-bordered'>
						<thead>
							<tr>
								<th>Day</th>
								<th>Room Name</th>
								<th>Start Time</th>
								<th>End Time</th>
								<th>Student ID</th>
								<th>Student Name</th>
								<th>Stream Name</th>
								<th>Programme</th>
								<th>Supervisor</th>
								<th>Second Supervisor</th>
							</tr>
						</thead>
						<tbody></tbody>
					</table>
				</div>"; 
}
 
}



// ----------------------------------------PART TIME -----------------------------------------// 

// Submit Part Time students. 

// Evening Time Slots
if(isset($_POST["PartStudents"])){
$sql = "SELECT * FROM slot WHERE  TIME(StartTime) >= '18:00:00' AND Midpoint = 0"; 
$result = mysqli_query($con, $sql);
$EveningTimeSlots = array(); 
if(mysqli_num_rows($result) > 0){
	while($row = mysqli_fetch_assoc($result)){
		
		$EveningTimeSlots [] = $row;
		
	}
}

// Part Time Students

$sql = "SELECT Student_ID FROM student WHERE PartTime =1"; 
$result = mysqli_query($con, $sql);
$PartTimeStudents = array(); 
if(mysqli_num_rows($result) > 0){
	while($row = mysqli_fetch_assoc($result)){
		
		$PartTimeStudents [] = $row;
		
	}
}


//function to extract student id from students rray
function extractStudentId($PartTimeStudents){
return $PartTimeStudents['Student_ID'];
}
//function to extract slot id from Slot array
function extractSlotId($EveningTimeSlots){
return $EveningTimeSlots['Slot_ID'];
}


$Eveningstudents = array_map("extractStudentId",$PartTimeStudents);//new students array
$Eveningslots =array_map("extractSlotId",$EveningTimeSlots);//new slots array


$min = min(count($Eveningstudents), count($Eveningslots));
$result = array_combine(array_slice($Eveningstudents, 0, $min), array_slice($Eveningslots, 0, $min));

foreach($result as $key=>$value){
	$sql = ("INSERT INTO student_slot (Student_ID, Slot_ID)VALUES ('$key' , '$value')");
	mysqli_query ($con, $sql);
}
  $Sql = "SELECT * FROM FinalPresntation";
    $result = mysqli_query($con, $Sql);  
 
 
    if (mysqli_num_rows($result) > 0) {
		echo "
				<div class='container'>";
		echo "
					<h2> Current schedule </h2>"; 
     echo "
					<div class='table-responsive'>
						<table id='myTable' class='table table-striped table-bordered'>
							<thead>
								<tr>
									<th>Day</th>
									<th>Room Name</th>
									<th>Start Time</th>
									<th>End Time</th>
									<th>Student ID</th>
									<th>Student Name</th>
									<th>Stream Name</th>
									<th>Programme</th>
									<th>Supervisor</th>
									<th>Second Supervisor</th>
								</tr>
							</thead>
							<tbody>";
 
 
     while($row = mysqli_fetch_assoc($result)) {
 
         echo "
								<tr contenteditable>
									<td>" . $row['Day']."</td>
									<td>" . $row['Room_Name']."</td>
									<td>" . $row['StartTime']."</td>
									<td>" . $row['EndTime']."</td>
									<td>" . $row['Student_ID']."</td>
									<td>" . $row['Student_Name']."</td>
									<td>" . $row['Stream_Name']."</td>
									<td>" . $row['Programme']."</td>
									<td>" . $row['Supervisor']."</td>
									<td>" . $row['Second_Examiner']."</td>
								</tr>";        
     }
    
     echo "
							</tbody>
						</table>
					</div>";
     
} else {
		echo "
					<div class='container'>";
		echo "
						<h2> Current schedule </h2>"; 
         echo "
						<div class='table-responsive'>
							<table id='myTable' class='table table-striped table-bordered'>
								<thead>
									<tr>
										<th>Day</th>
										<th>Room Name</th>
										<th>Start Time</th>
										<th>End Time</th>
										<th>Student ID</th>
										<th>Student Name</th>
										<th>Stream Name</th>
										<th>Programme</th>
										<th>Supervisor</th>
										<th>Second Supervisor</th>
									</tr>
								</thead>
								<tbody></tbody>
							</table>
						</div>"; 
						
						echo "
					</div>";
						
}
}



if(isset($_POST["Refresh"])){

    $Sql = "SELECT * FROM FinalPresntation";
    $result = mysqli_query($con, $Sql);  
 
 
    if (mysqli_num_rows($result) > 0) {
		echo "
					<div class='container'>";
		echo "
						<h2> Current schedule </h2>"; 
     echo "
						<div class='table-responsive'>
							<table id='myTable' class='table table-striped table-bordered'>
								<thead>
									<tr>
										<th>Day</th>
										<th>Room Name</th>
										<th>Start Time</th>
										<th>End Time</th>
										<th>Student ID</th>
										<th>Student Name</th>
										<th>Stream Name</th>
										<th>Programme</th>
										<th>Supervisor</th>
										<th>Second Supervisor</th>
									</tr>
								</thead>
								<tbody>";
 
 
     while($row = mysqli_fetch_assoc($result)) {
 
         echo "
									<tr contenteditable>
										<td>" . $row['Day']."</td>
										<td>" . $row['Room_Name']."</td>
										<td>" . $row['StartTime']."</td>
										<td>" . $row['EndTime']."</td>
										<td>" . $row['Student_ID']."</td>
										<td>" . $row['Student_Name']."</td>
										<td>" . $row['Stream_Name']."</td>
										<td>" . $row['Programme']."</td>
										<td>" . $row['Supervisor']."</td>
										<td>" . $row['Second_Examiner']."</td>
									</tr>";        
     }
    
     echo "
								</tbody>
							</table>
						</div>";
     
} else {
	echo "
						<div class='container'>";
		 echo "
							<h2> Current schedule </h2>"; 
         echo "
							<div class='table-responsive'>
								<table id='myTable' class='table table-striped table-bordered'>
									<thead>
										<tr>
											<th>Day</th>
											<th>Room Name</th>
											<th>Start Time</th>
											<th>End Time</th>
											<th>Student ID</th>
											<th>Student Name</th>
											<th>Stream_Name</th>
											<th>Programme</th>
											<th>Supervisor</th>
											<th>Second Supervisor</th>
										</tr>
									</thead>
									<tbody></tbody>
								</table>
							</div>"; 
}
 }
 
 
if(isset($_POST["ExportSchedule"])){
		 
     header('Content-Type: text/csv; charset=utf-8');  
     header('Content-Disposition: attachment; filename=Final Presentation.csv');  
      $output = fopen("php://output", "w");  
      fputcsv($output, array('Day', 'Room_Name', 'StartTime', 'EndTime', 'Student_ID', 'Student_Name', 'Stream_Name' ,'Programme', 'Supervisor', 'Second Examiner'));  
      $query = "SELECT * FROM finalpresntation";  
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
									<meta charset="utf-8">
										<meta name="viewport" content="width=device-width, initial-scale=1">
											<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
												<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
												<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
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
												<form class="form-horizontal" action="ViewSchedule.php" method="POST" name="upload_excel" enctype="multipart/form-data">
													<div class="form-row text-center">
														<button type="submit" class="btn btn-primary btn-lg" name ="FullStudents">Schedule Full Time Students</button>
														<button type="submit" class="btn btn-primary btn-lg" name ="PartStudents">Schedule Part Time Students</button>
														<button type="submit" name ="Refresh" class="btn btn-primary btn-lg" onclick="exportTableToCSV('Modified midpoint.csv')">Export Modified Changes</button>
														<button type="submit" class="btn btn-primary btn-lg" name ="ExportSchedule">Export Schedule to Excel</button>
													</div>
												</form>
											</body>
										</html>