<?php


$con = mysqli_connect("localhost", "root", "Iceburger2013@");
mysqli_select_db($con, 'user'); 


if (isset($_POST['submit'])){ 
	$un=$_POST['uname'];
	$pw=$_POST['psw']; 
	$sql=mysqli_query($conn, "select password from login where username='$un'");
		if($row = mysqli_fetch_array( $sql)){
			if($pw == $row['password']){
				header("location:options.html");
				exit();
			}

		}

		else
		echo "<script type=\"text/javascript\">
							alert(\"Invalid Username or Password. Please try again. \");
							window.location = \"jumbo.php\"
						  </script>";
}


?> 