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
echo  "SuperID : $SuperID Second Super ID : $SecondSupervisorID ";


 
$sql = "SELECT Slot_ID, StartTime FROM slot WHERE Slot.Slot_ID NOT IN (Select Slot_ID FROM student_slot) AND Slot.StartTime NOT IN (SELECT UnavailableTime FROM supervisor_availability WHERE Supervisor_ID = $SuperID) AND Slot.StartTime NOT IN (SELECT UnavailableTime FROM supervisor_availability WHERE Supervisor_ID = $SecondSupervisorID) AND Slot.StartTime < '18:00:00 AND Midpoint = 1 LIMIT 1";
$query = mysqli_query($con, $sql);
$row = mysqli_fetch_array($query); 
$SlotID = $row['Slot_ID'];
$UnavailableTime = $row['StartTime'];
echo $SlotID; 
echo $UnavailableTime;


if($SlotID != Null){
	$sql = "INSERT INTO student_slot (Student_ID, Slot_ID) VALUES ($Student, $SlotID)"; 
$query = mysqli_query($con, $sql);

	$sql = "INSERT INTO supervisor_availability (Supervisor_ID, UnavailableTime) VALUES ($SuperID, '$UnavailableTime')"; 
$query = mysqli_query($con, $sql);

	$sql = "INSERT INTO supervisor_availability (Supervisor_ID, UnavailableTime) VALUES ($SecondSupervisorID, '$UnavailableTime')"; 
$query = mysqli_query($con, $sql);


}else{ 
echo "HelloWorld!"; 


} 
 } 
 

?>
