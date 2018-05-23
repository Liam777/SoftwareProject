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

//--------------------------SUPERVISORS ---------------------------------// 


$sql = "SELECT Supervisor_ID FROM student WHERE Student_ID = 1 "; 
$result = mysqli_query($con, $sql);
$Supervisor= array(); 
if(mysqli_num_rows($result) > 0){
	while($row = mysqli_fetch_assoc($result)){
		
		$Supervisor[] = $row;
	
	}
}
 

// ------------------------CONVERT SUPERVISORS TO STRING ----------------------// 

function extractSupervisorId($Supervisor){
return $Supervisor['Supervisor_ID'];
}

$Supervisor = array_map("extractSupervisorId",$Supervisor);

foreach ($Supervisor as $supervisorID){
	echo "Supervisor ID: = $supervisorID <br>"; 
}


// ------------------------- IS THE SUPERVISOR AVAILABLE ??? GOD ONLY KNOWS!! ----------------------// 

$Time = "`09:00:00`"; 
$Sup = 1; 
$DateID = 1; 


$sql = "SELECT $Time FROM `supervisor_availability` WHERE Supervisor_ID = $Sup AND Date_ID = $DateID";
echo $sql; 
$result = mysqli_query($con, $sql);
$Available = array(); 
if(mysqli_num_rows($result) > 0){
	while($row = mysqli_fetch_assoc($result)){
		
		$Available [] = $row;
	
	}
}

print_r($Available); 
echo "<br/>"; 

// ----------------------Turns out he is! -------------------------------// ^^^^^^^^^^^^^^^^^^

// -----------------------But can we update him to not be???? Let's Find out ----------------------- //

$Avail = 1; 
$SlotID = 21; 
$StudentID = 1; 
$SuperID = 1; 
$DateID = 1; 
$Time = "`09:00:00`"; 


//if($Avail = 1){
//$sql = "INSERT INTO student_slot (Student_ID, Slot_ID) VALUES ($StudentID, $SlotID)";
//$result = mysqli_query($con, $sql);

// ---------------------------- Update Supervisor ------------------------------// 

//$sql = "UPDATE `supervisor_availability` SET $Time = '0' WHERE `supervisor_availability`.`Supervisor_ID` = $SuperID AND `supervisor_availability`.`Date_ID` = $DateID" ;
//$result = mysqli_query($con, $sql); 

// Remove the Slot from the Array. 
	
//} else {
 // Check the next slot 
// } 	




// --------------Testing Storing variables -------------------//  

// $sql = "select Date_ID FROM dates where Date = '2018-05-23'";
// $query = mysqli_query($con, $sql);


// $row = mysqli_fetch_array($query); 

// $DateID = $row['Date_ID'];
// echo $DateID; 


// ------------------------- THE FINAL ALGORITHM!!!!! --------------------------


echo "This is the algorithm Data. <br> "; 

// ------------------- SLOT ARRAY -------------------------------- // 


$sql = "SELECT Slot_ID  FROM slot WHERE  StartTime < '18:00:00'"; 
$result = mysqli_query($con, $sql);
$DayTimeSlots = array(); 
if(mysqli_num_rows($result) > 0){
	while($row = mysqli_fetch_assoc($result)){
		
		$DayTimeSlots [] = $row;
		
	}
}

// Get the slots array 
// ------------------------------ CONVERT SLOT_IDS TO STRINGS -----------------------------------// 


function extractSlotId($DayTimeSlots){
return $DayTimeSlots['Slot_ID'];

}

$slots = array_map("extractSlotId",$DayTimeSlots);

// SHOW SLOTS
foreach ($slots as $slotID) {
echo " SlotID:  = $slotID <br>"; 

}
 
// get students array 
// -------------------STUDENTS ARRAY ----------------------------- // 

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


// Combine the Two 

$min = min(count($FullTimeStudents), count($DayTimeSlots));
$result = array_combine(array_slice($students , 0, $min), array_slice($slots, 0, $min));

 foreach($result as $key=>$value){
	echo " $key : $value "; 
	
	// get supervisor ID 

$sql = "select Supervisor_ID FROM student where Student_ID = $key";
$query = mysqli_query($con, $sql);
$row = mysqli_fetch_array($query); 
$SuperID = $row['Supervisor_ID'];
echo  "SuperID : $SuperID "; 

// get slotID 

$sql = "select Date, StartTime FROM Slot where Slot_ID = $value";
$query = mysqli_query($con, $sql);
$row = mysqli_fetch_array($query); 
$Date = $row['Date'];
$StartTime = $row['StartTime'];
echo  "Slot Date : $Date Start Time : $StartTime "; 
	
	// get Date id 
	
$sql = "select Date_ID FROM dates where Date = '$Date'";
$query = mysqli_query($con, $sql);
$row = mysqli_fetch_array($query); 
$DateID = $row['Date_ID'];
echo  "Date ID : $DateID "; 
	
// Check if the supervisor is available 

$sql = "select `$StartTime` FROM supervisor_availability where Date_ID = $DateID AND Supervisor_ID = $SuperID";
$query = mysqli_query($con, $sql);
$row = mysqli_fetch_array($query); 
$Available = $row["$StartTime"];
echo  "Is the Lecture Available?  : $Available  "; 
$Time = "`$StartTime`"; 

if($Available == 1){
	
$sql = "INSERT INTO student_slot (Student_ID, Slot_ID) VALUES ($key, $value)";
$result = mysqli_query($con, $sql);
$sql = "UPDATE `supervisor_availability` SET $Time = '0' WHERE `supervisor_availability`.`Supervisor_ID` = $SuperID AND `supervisor_availability`.`Date_ID` = $DateID" ;
$result = mysqli_query($con, $sql); 

	
} else if ($Available == 0) {
	
	// 
	
}
 }

?> 