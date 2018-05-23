<?php 

//connect to the database

$conn = mysqli_connect("localhost", "root", "Iceburger2013@");
mysqli_select_db($conn, 'classroom');

if($_FILES[csv][size] > 0){


   // getting the CSV file to import
   $file = $_FILES[csv][tmp_name];
   $handle = fopen($file, "r"); 

      // go through each entry in the CSV file and insert into the table

   do{ 

      if($data[0]){

         mysql_query("INSERT into classroom(Room_ID, Room_Name) VALUES 
            (
               '".addslashes($data[0])."',
               '".addslashes($data[1])."',
            )

               ");
      } 


      } while ($data = fgetcsv($handle, 1000, ",","'"));

      //

      //redirect 

      header('location:administration.php?sucess=1'); die;

   }
?> 






<html lang="en">
   <head>
      <title>Bootstrap 4 Example</title>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
   </head>
   <body>
 
      <!-- A grey horizontal navbar that becomes vertical on small screens -->
      <nav class="navbar navbar-expand-sm bg-dark">
         <!-- Links -->
         <ul class="navbar-nav" color = ">
            <li class="nav-item">
            <a class="nav-link" href="#">Xchedule</a>
            </li>
            <li class="nav-item">
               <a class="nav-link" href="#">Documentation</a>
            </li>
            <li class="nav-item">
               <a class="nav-link" href="#">Online Tutorial</a>
            </li>
         </ul>
      </nav> 
	  

	        <p class="text-center">This Section is for administration purposes.  In this Section please provide the information to be used in the creation of the schedule for the different types of schedule that are required.</p>

<?php if(!empty($_GET[sucess])) { echo "<br> You're file has been imported. </b><br><br> ";  } ?> 

<form action "" method="post" enctype="multipart/form-data" name="form1" id="form1">
   choose your file: <br/> 
   <input  name="CSV" type="file" id="csv" />
   <input type="submit" name="Submit" value="submit" />
</form>



		 
		 
 
	  
	  
	  
	  
	  
      <script>
         $(function(){
         $('[data-toggle="tooltip"]').tooltip();
         });
      </script> 
   </body>
</html>