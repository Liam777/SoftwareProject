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
   
  
   
   ?> 
<!DOCTYPE html>
<html lang="en">
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
      <li ><a href="/Project/Options.html">Create a schedule</a></li>
      <li><a href="/Project/Dashboard.php">Dashboard</a></li>
	  <li class = "active"><a href="/Project/Admin.php">Administration</a></li>
    </ul>
         </div>
      </nav>
	  
	  
      <div class="container">
         <div class="panel panel-primary">
            <div class="panel-heading">Upload Classrooms</div>
            <div class="panel-body">

               <form class="form-inline" action="functions.php" method="post" name="upload_excel" enctype="multipart/form-data">
                  <div class="form-group" >
                     <label class="col-lg-12 control-label" for="filebutton">Select File</label>
                     <div class="col-lg-12">
                        <input type="file" name="file" id="file" class="input-large">
                     </div>
                  </div>
                  <div class="form-group">
                     <label class="col-lg-12 control-label" for="singlebutton">Import data</label>
                     <div class="col-lg-12">
                        <button type="submit" id="submit" name="Import" class="btn btn-primary button-loading" data-loading-text="Loading...">Import</button>
                     </div>
                  </div> 
                  <div>          
               </form>
               </div>
			<a href="./Web Sheets/Classrooms.xlsx" download="Classrooms"> 
			<button type="submit" id="submit" class="btn btn-primary button-loading" style="float: right; width: 400px" data-loading-text="Loading...">Download template for Classrooms</button>
			</a>
            </div>
         </div>
		 
		 
         <div class="panel panel-primary">
            <div class="panel-heading">Upload Subjects</div>
            <div class="panel-body">
               <form class="form-inline" action="functions.php" method="post" name="upload_excel" enctype="multipart/form-data">
                  <div class="form-group">
                     <label class="col-lg-12 control-label" for="filebutton">Select File</label>
                     <div class="col-lg-12">
                        <input type="file" name="file" id="file" class="input-large">
                     </div>
                  </div>
                  <div class="form-group">
                     <label class="col-lg-12 control-label" for="singlebutton">Import data</label>
                     <div class="col-lg-12">
                        <button type="submit" id="submit" name="ImportSubjects" class="btn btn-primary button-loading" data-loading-text="Loading...">Import</button>
                     </div>
                  </div>
                  <div>
               </form>
               </div>
			   <a href="./Web Sheets/SubjectsTemplate.xlsx" download="Subjects"> 
			<button type="submit" id="submit" class="btn btn-primary button-loading" style="float: right; width: 400px" data-loading-text="Loading...">Download template for Subjects</button>
			</a>
            </div>
         </div>
		 
         <div class="panel panel-primary">
            <div class="panel-heading">Upload Supervisors</div>
            <div class="panel-body">
               <form class="form-inline" action="functions.php" method="post" name="upload_excel" enctype="multipart/form-data">
                  <div class="form-group">
                     <label class="col-lg-12 control-label" for="filebutton">Select File</label>
                     <div class="col-lg-12">
                        <input type="file" name="file" id="file" class="input-large">
                     </div>
                  </div>
                  <div class="form-group">
                     <label class="col-lg-12 control-label" for="singlebutton">Import data</label>
                     <div class="col-lg-12">
                        <button type="submit" id="submit" name="ImportSupervisors" class="btn btn-primary button-loading" data-loading-text="Loading...">Import</button>
                     </div>
					 </div>
                  <div>
               </form>
            </div>
			<a href="./Web Sheets/Supervisor Template.xlsx" download="Supervisors"> 
			<button type="submit" id="submit" class="btn btn-primary button-loading" style="float: right; width: 400px" data-loading-text="Loading...">Download template for Supervisors</button>
			</a>
         </div>
		 </div>
		

		 
         <div class="panel panel-primary">
            <div class="panel-heading">Import Students</div>
            <div class="panel-body">
               <form class="form-inline" action="functions.php" method="post" name="upload_excel" enctype="multipart/form-data">
                  <div class="form-group">
                     <label class="col-lg-12 control-label" for="filebutton">Select File</label>
                     <div class="col-lg-12">
                        <input type="file" name="file" id="file" class="input-large">
                     </div>
                  </div>
                  <!-- Button -->
                  <div class="form-group">
                     <label class="col-lg-12 control-label" for="singlebutton">Import data</label>
                     <div class="col-lg-12">
                        <button type="submit" id="submit" name="ImportStudents" class="btn btn-primary button-loading" data-loading-text="Loading...">Import</button>
                     </div>
                  </div>
				  <div>
               </form>
            </div>
			<a href="./Web Sheets/Student Template.xlsx" download="Students"> 
			<button type="submit" id="submit" class="btn btn-primary button-loading" style="float: right; width: 400px" data-loading-text="Loading...">Download template for Students</button>
			</a>
         </div>
		 </div>
         <div class="panel panel-primary">
            <div class="panel-heading">Allocate Slots</div>
            <div class="panel-body">
               <form class="form-inline" action="functions.php" method="post" name="upload_excel" enctype="multipart/form-data">
                  <div class="form-group">
                     <label class="col-lg-12 control-label" for="filebutton">Select File</label>
                     <div class="col-lg-12">
                        <input type="file" name="file" id="file" class="input-large">
                     </div>
                  </div>
                  <div class="form-group">
                     <label class="col-lg-12 control-label" for="singlebutton">Import data</label>
                     <div class="col-lg-12">
                        <button type="submit" id="submit" name="ImportSlots" class="btn btn-primary button-loading" data-loading-text="Loading...">Import</button>
                     </div>
                  </div>
				  <div>
               </form>
            </div>
			<a href="./Web Sheets/Presentation Times.xlsx" download="Slots"> 
			<button type="submit" id="submit" class="btn btn-primary button-loading" style="float: right; width: 400px" data-loading-text="Loading...">Download template for Presentation Timings</button>
			</a>
         </div>
		 </div>
         <div class="panel panel-primary">
            <div class="panel-heading">Import Supervisor Availability</div>
            <div class="panel-body " style = "text-align: centre">
               <form class="form-inline " action="functions.php" method="post" name="upload_excel" enctype="multipart/form-data">
                  <div class="form-group">
                     <label class="col-lg-12 control-label" for="filebutton">Select File</label>
                     <div class="col-lg-12">
                        <input type="file" name="file" id="file" class="input-large">
                     </div>
                  </div>
                  <div class="form-group">
                     <label class="col-lg-12 control-label" for="singlebutton">Import data</label>
                     <div class="col-lg-12">
                        <button type="submit" id="submit" name="ImportAvailability" class="btn btn-primary button-loading" data-loading-text="Loading...">Import</button>
                     </div>
                  </div>
				  <div>
               </form>
            </div>
			<a href="./Web Sheets/Supervisor Unavailable Times.xlsx" download="Supervisor Time Availability"> 
			<button type="submit" id="submit" class="btn btn-primary button-loading" style="float: right; width: 400px" data-loading-text="Loading...">Download template for Supervisor Availability</button>
			</a>
         </div>
      </div>
	   
	   
          <form class="form-horizontal" action="functions.php" method="post" name="Delete" enctype="multipart/form-data" style = "text-align: centre">
            <div class="form-group">
               <button type="submit" class="btn btn-danger btn-lg" name="Delete" style = "text-align: centre; float: centre; width: 400px">Clear All Data!</button>
            </div>
         </form>
		
	  
	  
	  </div>
   </body>
</html>