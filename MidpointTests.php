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

// Full Time students 
$sql = "SELECT Student_ID FROM student WHERE PartTime =0"; 
$result = mysqli_query($con, $sql);
$FullTimeStudents = array(); 
if(mysqli_num_rows($result) > 0){
	while($row = mysqli_fetch_assoc($result)){
		
		$FullTimeStudents [] = $row;
	
	}
}
echo count($FullTimeStudents);
print_r($FullTimeStudents); 
echo "<br/>"; 
 
// Day Time Slots 

$sql = "SELECT Slot_ID, StartTime FROM slot WHERE  StartTime < '18:00:00'"; 
$result = mysqli_query($con, $sql);
$DayTimeSlots = array(); 
if(mysqli_num_rows($result) > 0){
	while($row = mysqli_fetch_assoc($result)){
		
		$DayTimeSlots [] = $row;
		
	}
}
echo count($DayTimeSlots);
print_r($DayTimeSlots); 
echo "<br/>";

$StartTime = "'09:00:00'"; 
// Availabiltity 
$sql = "SELECT $StartTime FROM supervisor_availability WHERE Supervisor_ID = 1";
$result = mysqli_query($con, $sql);
$Avail = array(); 
if(mysqli_num_rows($result) > 0){
	while($row = mysqli_fetch_assoc($result)){
		
		$Avail [] = $row;
		
	}
}
echo count($Avail);
print_r($Avail); 
echo "<br/>";

// Extract student id and Supervisor_ID 

function extractStudentId($FullTimeStudents){
return $FullTimeStudents['Student_ID'];
}


$students = array_map("extractStudentId",$FullTimeStudents);

echo "<br>"; 
echo "<br>"; 
echo "<br>"; 
echo "<br>"; 

foreach ($students as $studentID) {
echo "$studentID <br>"; 


}



// get the supervisor. 
$sql = "SELECT Supervisor_ID FROM student WHERE PartTime =0"; 
$result = mysqli_query($con, $sql);
$Supervisor= array(); 
if(mysqli_num_rows($result) > 0){
	while($row = mysqli_fetch_assoc($result)){
		
		$Supervisor[] = $row;
	
	}
}
echo count($Supervisor);
print_r($Supervisor); 
echo "<br/>"; 


function extractSupervisorId($Supervisor){
return $Supervisor['Supervisor_ID'];
}


$Supervisor_ID = array_map("extractStudentId",$Supervisor);

echo $Supervisor_ID;

?>


