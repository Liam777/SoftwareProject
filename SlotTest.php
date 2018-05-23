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
 if(isset($_POST["ExportSchedule"])){
		 
     header('Content-Type: text/csv; charset=utf-8');  
     header('Content-Disposition: attachment; filename=data.csv');  
      $output = fopen("php://output", "w");  
      fputcsv($output, array('Day', 'Date', 'Room_Name', 'StartTime', 'EndTime', 'Student_ID', 'Student_Name', 'Stream_Name' ,'Programme', 'Supervisor', 'Second Examiner'));  
      $query = "SELECT * From end_of_year_schedulev1";  
      $result = mysqli_query($con, $query);  
      while($row = mysqli_fetch_assoc($result))  
      {  
           fputcsv($output, $row);  
      }  
      fclose($output);  
 } 





// Creating the view
$view = "CREATE OR REPLACE VIEW FinalPresntation AS SELECT\n"

    . "    sl.Day,\n"

    . "    cl.Room_Name,\n"

    . "    sl.StartTime,\n"

    . "    sl.EndTime,\n"

    . "    stud.Student_ID,\n"

    . "    stud.Student_Name,\n"

    . "    sub.Stream_Name,\n"

    . "    sub.Programme,\n"

    . "    sup1.Supervisor_Name AS Supervisor,\n"

    . "    sup2.Supervisor_Name AS Second_Examiner\n"

    . "FROM\n"

    . "    (\n"

    . "        student stud,\n"

    . "        SUBJECT sub,\n"

    . "        classroom cl,\n"

    . "        slot sl,\n"

    . "        student_slot ss\n"

    . "    )\n"

    . "INNER JOIN supervisor sup1 ON\n"

    . "    stud.Supervisor_ID = sup1.Supervisor_ID\n"

    . "INNER JOIN supervisor sup2 ON\n"

    . "    stud.Second_Supervisor_ID = sup2.Supervisor_ID\n"

    . "WHERE\n"

    . "    stud.Stream_ID = sub.Stream_ID AND cl.Room_ID = sl.Room_ID AND stud.Student_ID = ss.Student_ID AND sl.Slot_ID = ss.Slot_ID AND sl.Midpoint = 0\n"

    . "    \n"

    . "ORDER BY cl.Room_Name ASC, sl.StartTime ASC";
$result = mysqli_query($con, $view);



// Creating the view
$view = "CREATE OR REPLACE VIEW MidpointPresentation AS SELECT\n"

    . "    sl.Day,\n"

    . "    cl.Room_Name,\n"

    . "    sl.StartTime,\n"

    . "    sl.EndTime,\n"

    . "    stud.Student_ID,\n"

    . "    stud.Student_Name,\n"

    . "    sub.Stream_Name,\n"

    . "    sub.Programme,\n"

    . "    sup1.Supervisor_Name AS Supervisor,\n"

    . "    sup2.Supervisor_Name AS Second_Examiner\n"

    . "FROM\n"

    . "    (\n"

    . "        student stud,\n"

    . "        SUBJECT sub,\n"

    . "        classroom cl,\n"

    . "        slot sl,\n"

    . "        student_slot ss\n"

    . "    )\n"

    . "INNER JOIN supervisor sup1 ON\n"

    . "    stud.Supervisor_ID = sup1.Supervisor_ID\n"

    . "INNER JOIN supervisor sup2 ON\n"

    . "    stud.Second_Supervisor_ID = sup2.Supervisor_ID\n"

    . "WHERE\n"

    . "    stud.Stream_ID = sub.Stream_ID AND cl.Room_ID = sl.Room_ID AND stud.Student_ID = ss.Student_ID AND sl.Slot_ID = ss.Slot_ID AND sl.Midpoint = 1\n"

    . "    \n"

    . "ORDER BY cl.Room_Name ASC, sl.StartTime ASC";
$result = mysqli_query($con, $view);



?>