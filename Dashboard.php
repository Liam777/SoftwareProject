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
   
   error_reporting(0);
   
   // Total Students
   
$sql = "Select COUNT(`Student_ID`) FROM student";
$query = mysqli_query($con, $sql);
$row = mysqli_fetch_array($query); 
$TotalStudents = $row['COUNT(`Student_ID`)'];
if($TotalStudents =null){
	
	$TotalStudents = 0;
	
}else {
	
	$TotalStudents = $row['COUNT(`Student_ID`)'];
}


   // Total Full Time Students
   
$sql = "Select COUNT(`Student_ID`) FROM student WHERE PartTime = 0";
$query = mysqli_query($con, $sql);
$row = mysqli_fetch_array($query); 
$TotalFullTime  = $row['COUNT(`Student_ID`)'];
if( $TotalFullTime  =null){
	
	 $TotalFullTime  = 0;
	
}else {
	
	 $TotalFullTime  = $row['COUNT(`Student_ID`)'];
}


   // Total Part Time Students
   
$sql = "Select COUNT(`Student_ID`) FROM student WHERE PartTime = 1";
$query = mysqli_query($con, $sql);
$row = mysqli_fetch_array($query); 
$TotalPartTime  = $row['COUNT(`Student_ID`)'];
if( $TotalPartTime  =null){
	
	 $TotalPartTime  = 0;
	
}else {
	
	 $TotalPartTime  = $row['COUNT(`Student_ID`)'];
}


// TotalSlots
$sql = "Select COUNT(`Slot_ID`) FROM slot";
$query = mysqli_query($con, $sql);
$row = mysqli_fetch_array($query); 
$TotalSlots = $row['COUNT(`Slot_ID`)'];
if($TotalSlots = null){
	
	$TotalSlots = 0;
	
}else {
	
	$TotalSlots = $row['COUNT(`Slot_ID`)'];
}

// Full Time slots

$sql = "Select COUNT(`Slot_ID`) FROM slot WHERE TIME(StartTime) < '18:00:00' ";
$query = mysqli_query($con, $sql);
$row = mysqli_fetch_array($query); 
$TotalFullTimeSlots = $row['COUNT(`Slot_ID`)'];
if($TotalFullTimeSlots = null){
	
	$TotalFullTimeSlots = 0;
	
} else {
	
	$TotalFullTimeSlots = $row['COUNT(`Slot_ID`)'];
	
}


// Full Time slots

$sql = "Select COUNT(`Slot_ID`) FROM slot WHERE TIME(StartTime) >= '18:00:00' ";
$query = mysqli_query($con, $sql);
$row = mysqli_fetch_array($query); 
$TotalPartTimeSlots = $row['COUNT(`Slot_ID`)'];
if($TotalPartTimeSlots= null){
	
	$TotalPartTimeSlots = 0;
	
} else {
	
	$TotalPartTimeSlots = $row['COUNT(`Slot_ID`)'];
	
}

// Total Supervisors 

$sql = "Select COUNT(`Supervisor_ID`) FROM supervisor";
$query = mysqli_query($con, $sql);
$row = mysqli_fetch_array($query); 
$TotalSupervisors = $row['COUNT(`Supervisor_ID`)'];
if($TotalSupervisors= null){
	
	$TotalSupervisors = 0;
	
} else {
	
	$TotalSupervisors = $row['COUNT(`Supervisor_ID`)'];
	
}
   
  // Total Rooms Used  

$sql = "Select COUNT(`Room_ID`) FROM classroom";
$query = mysqli_query($con, $sql);
$row = mysqli_fetch_array($query); 
$TotalRooms = $row['COUNT(`Supervisor_ID`)'];
if($TotalRooms = null){
	
	$TotalRooms = 0;
	
} else {
	
	$TotalRooms = $row['COUNT(`Room_ID`)'];
	
}  
   
 ?> 


<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head> 

<body> 



 <nav class="navbar navbar-inverse">
         <div class="container-fluid">
            <div class="navbar-header">
               <a class="navbar-brand" href="#">Xchedule</a>
            </div>
            <ul class="nav navbar-nav">
      <li><a href="/Project/Options.html">Create a schedule</a></li>
      <li class= "active"><a href="/Project/Dashboard.php">Dashboard</a></li>
	  <li><a href="/Project/Admin.php">Administration</a></li>
    </ul>
         </div>
      </nav>




<div class="container text-center">    
  <h3> Student Information </h3><br>
  <div class="row">
<div class="panel panel-primary col-md-4">
      <div class="panel-heading"> <h3> Total Students: <h3> </div>
      <div class="panel-body">
	   <h1> <?= $TotalStudents ?> </h1>
	  </div>
    </div>
	
	
	
   <div class="panel panel-primary col-md-4">
      <div class="panel-heading">  <h3> Total Full Time Students: <h3> </div>
      <div class="panel-body">
	   <h1> <?= $TotalFullTime ?> </h1> 
	  </div>
    </div>
	
	<div class="panel panel-primary col-md-4">
      <div class="panel-heading"> <h3> Total Part Time Students: <h3> </div>
      <div class="panel-body">
	  
	            <h1> <?= $TotalPartTime ?> </h1> 
	  </div>
    </div>
</div>



   
  <h3> Slot Information </h3><br>
  <div class="row">
<div class="panel panel-primary col-md-4">
      <div class="panel-heading"> <h3> Total Slots: <h3></div>
      <div class="panel-body">
	  
	  <h1> <?= $TotalSlots ?> </h1>
	  
	  
	  </div>
    </div>
	
	
	
   <div class="panel panel-primary col-md-4">
      <div class="panel-heading"> <h3> Total Full Time Slots: <h3> </div>
      <div class="panel-body">
	  
	   <h1> <?= $TotalFullTimeSlots?> </h1>

	  
	  
	  </div>
    </div>
	
	<div class="panel panel-primary col-md-4">
      <div class="panel-heading"><h3> Total Part Time Slots: <h3> </div>
      <div class="panel-body">
	  
		<h1> <?= $TotalPartTimeSlots ?> </h1>
	 
	  </div>
    </div>

	
	
	</div> 
	
	
	 <h3> Admin information </h3><br>
  <div class="row">
<div class="panel panel-primary col-md-6">
      <div class="panel-heading"> <h3> Total Supervisors: <h3></div>
      <div class="panel-body">
	  
	  <h1> <?= $TotalSupervisors ?> </h1>
	  
	  
	  </div>
    </div>
	
	
	
   <div class="panel panel-primary col-md-6">
      <div class="panel-heading"> <h3> Total Rooms Available:  <h3> </div>
      <div class="panel-body">
	  
	   <h1> <?= $TotalRooms?> </h1>

	  
	  
	  </div>
    </div>
	


	
	
	</div> 
	
	
	
	
</div>
    

</body> 



</html> 