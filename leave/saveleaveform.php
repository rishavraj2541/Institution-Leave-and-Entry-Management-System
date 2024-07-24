<?php
session_start();
include "db_conn.php";

if (isset($_POST['subject']) && isset($_POST['start_date']) && isset($_POST['end_date'])) {

	function validate($data){
       $data = trim($data);
	   $data = stripslashes($data);
	   $data = htmlspecialchars($data);
	   return $data;
	}

	$subject = validate($_POST['subject']);
	$start_date = validate($_POST['start_date']);
	$end_date = validate($_POST['end_date']);
	$roll_number = validate($_POST['roll_number']);
	$class_name = validate($_POST['class_name']);
	$phone_number = validate($_POST['phone_number']);
	$reason = validate($_POST['reason']);
	$student_id = validate($_POST['student_id']);
	$student_name = validate($_POST['student_name']);


	$image_01= $_FILES['image_01']['name'];
     $image_01 = filter_var($image_01, FILTER_SANITIZE_STRING);
     $image_tmp_name_01 = $_FILES['image_01']['tmp_name'];
     $image_folder_01 = 'image/documents/'.$image_01;






	if (empty($subject)) {
		header("Location: home.php?error=Subject is required");
	    exit();
	}else if(empty($start_date)){
        header("Location: home.php?error=Start Date is required");
	    exit();
	}else if(empty($end_date)){
        header("Location: home.php?error=End Date is required");
	    exit();
	}else if(empty($roll_number)){
        header("Location: home.php?error=Roll Number of days is required");
	    exit();
	}else if(empty($reason)){
        header("Location: home.php?error=Reason is required");
	    exit();
	}else{
        $start_date = strtotime($start_date);
        $start_date = date('Y-m-d', $start_date);

		$end_date = strtotime($end_date);
        $end_date = date('Y-m-d', $end_date);


        $sql = "SELECT * FROM leaves WHERE student_id='$student_id' ";
		$result = mysqli_query($conn, $sql);

		if (mysqli_num_rows($result) > 12) {
			header("Location: home.php?error=You have already applied for 12 leaves");
	        exit();
		}

		$sql1 = "SELECT * FROM leaves WHERE student_id='$student_id' AND status='pending'";
		$result1 = mysqli_query($conn, $sql1);

		if (mysqli_num_rows($result1) > 0) {
			header("Location: home.php?error=Your Previous Leave is still pending");
	        exit();
		}


                      $to = "jhashiva045@gmail.com";
                      $student_name=$_SESSION['name'];
                      $sub="Leave Application of ";
                      $subject = $sub.$student_name;
                      $rea="<h3>Reason: ".$reason."<br /> From-Date: ".$start_date."<br /> To-date: ".$end_date."<br>Student details:- </h3><br /> Name: ".$_SESSION['name']."<br> Roll No:".$roll_number."<br />Phone Number: ".$phone_number."<br />Class: ".$class_name;
                      $message =$rea;
                      // $message .= "<h1>The verification code is </h1>";

                      $header = "From:admin@reminderpvtlmt.com \r\n";
                      $header .= "MIME-Version: 1.0\r\n";
                      $header .= "Content-type: text/html\r\n";

                      $retval = mail ($to,$subject,$message,$header);


        $sql2 = "INSERT INTO leaves(subject, start_date, end_date , roll_number , class_name , contact_number , reason , student_id , student_name,status,DOCU) VALUES ('$subject', '$start_date', '$end_date', '$roll_number' , '$class_name', '$phone_number' , '$reason',$student_id,'$student_name','2','$image_01')";
		$result2 = mysqli_query($conn, $sql2);

		if ($result2) {
			move_uploaded_file($image_tmp_name_01, $image_folder_01);
			header("Location: home.php?success=Your leave has been created successfully ");
			exit();
		}else {
			header("Location: home.php?error=unknown error occurred");
			exit();
		}
	}

}else{
	header("Location: home.php");
	exit();
}
