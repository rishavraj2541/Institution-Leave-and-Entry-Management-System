<?php
session_start();
include "db_conn.php";

$sql = "SELECT * FROM leaves WHERE student_id='$_SESSION[id]' ORDER BY id DESC";
$result = mysqli_query($conn, $sql);

$leaves = [];

if (isset($_SESSION['id']) && isset($_SESSION['registration'])) {
?>



<!doctype html>
    <html lang="en">
    <head>
    <link rel="stylesheet" type="text/css" href="style.css">
        <link href="https://demo.dashboardpack.com/architectui-html-free/main.css" rel="stylesheet">
    </head>
<style>
    .out:hover{
background-color: red;
    }
    .in:hover{
        background-color: #07E948;
    }
</style>
    <body>
    <div class="app-container app-theme-white body-tabs-shadow fixed-sidebar fixed-header" style="width:100%;">
            <div class="app-header header">
                <div class="app-header__logo">
                    <div class="bold"><b>Student Panel</b></div>
                </div>
                <div class="app-header__content">
                    <div class="app-header-right">
                        <div class="header-btn-lg pr-0">
                            <div class="widget-content p-0">
                                <div class="widget-content-wrapper">
                                    <div class="widget-content-left">
                                        <div class="btn-group">
                                            <a data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="p-0 btn">
                                                <img width="42" class="rounded-circle" src="assets/images/avatars/1.jpg" alt="">
                                                <i class="fa fa-angle-down ml-2 opacity-8"></i>
                                            </a>
                                            <div style="background-color: black;" tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu dropdown-menu-right">
                                                <a style="padding-left:10px;color:white;text-decoration:none;" class="logout-button" href="logout.php">Logout</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="app-main">
               <?php include"side-nav.php"; ?>

          <a class="logout-button" href="logout.php">Logout</a>
          <div class="container" style="background-color:#53dcf3;">
               <div class="form-box">
               <center><label style="color:black;text-align:center;">Hello, <?php echo $_SESSION['name']; ?></u></label></center>
               <?php

if(isset($_POST['on'])){
  if($_POST['lat']=="27.2125487" AND $_POST['long']=="75.6997547"){
    $id=$_SESSION['id'];
    $place=$_POST['place'];
  $insert_d="INSERT INTO outing(currentDate,place,status,user,posi) VALUES(now(),'$place','1','$id','0')";
  $result=mysqli_query($conn,$insert_d);
  if($result){
  echo '<script>alert("Outing registered successfully ")</script>';
  }else{
  echo '<script>alert("try again")</script>';
  }
}else{
  echo '<script>alert("try again and check your location ")</script>';
}
}

if(isset($_POST['in'])){
    if($_POST['lat']=="27.2125487" AND $_POST['long']=="75.6997547"){
    $id=$_SESSION['id'];
  $insert_d="Update outing set status='0' ,in_datetime=now(),posi='1' where user='$id' and status='1'";
  $result=mysqli_query($conn,$insert_d);
  if($result){
  echo '<script>alert("Outing registered successfully ")</script>';
}else{
  echo '<script>alert("try again")</script>';
}
}else{
  echo '<script>alert("try again and check your location ")</script>';
}

}

     ?>

     <div class="hover" >
    <form  method="post" >
    <link rel="stylesheet" href="style1.css">

    <input type="text" placeholder="place" name="place">




    <input type="submit" name="on" value="Out" class="out" id="ou" onclick="click_me()">
    <input type="submit" name="in" value="In" class="in" id="in"  onclick="click_me2()">
    <input type="text" name="lat" id="lat" readonly>
      <input type="text" name="long" id="long" readonly>





    </form>
    <button id="getLocation">Get My Location</button>


    </div>


    <div class="app-main__outer" style="padding: 5rem;margin-left: 6rem;">
                    <div class="p-5">
                        <h3 style="color:black;text-align:center">Outing Register</h3>
                        <table class="table">
                            <thead>
                                <tr>


                                    <th>User Id</th>

                                    <th>Out-Time</th>
                                    <th>In-Time</th>
                                    <th>Status</th>
                                    <th>Place</th>

                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                $id02=$_SESSION['id'];
                                $sql2 = "SELECT * FROM outing where user='$id02'";
                                $result2 = $conn->query($sql2);
                                  if ($result2->num_rows > 0) {
                                    // output data of each row
                                        while($row2 = $result2->fetch_assoc())
                                        {

                                            echo "<tr>";


                                            echo "<td>" . $row2['user'] . "</td>";

                                            echo "<td>" . $row2['currentDate'] . "</td>";
                                            echo "<td>" . $row2['in_datetime'] . "</td>";

                                            echo "<td>" . $row2['status'] . "</td>";
                                            echo "<td>" . $row2['Place'] . "</td>";



                                            echo "</tr>";
                                        }
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
<script>
function hideButton() {
  document.getElementById("myButton").style.display ="none";
}
</script>
<script>
    document.getElementById("getLocation").addEventListener("click", getLocation);

    function getLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition);
        } else {
            alert("Geolocation is not supported by your browser.");
        }
    }

    function showPosition(position) {
        const latitude = position.coords.latitude;
        const longitude = position.coords.longitude;



        // Use the OpenCage Data Geocoding API to get location details
        fetch(`https://api.opencagedata.com/geocode/v1/json?q=${latitude}+${longitude}&key=e082011bf6f847ec9a98ea22b96a4003`)
            .then(response => response.json())
            .then(data => {
                const results = data.results[0];
                if (results) {
                    document.getElementById("lat").value = results.geometry.lat;
                    document.getElementById("long").value = results.geometry.lng;


                    console.log(results);
                }
            })
            .catch(error => console.error("Error fetching location data:", error));

    }
</script>
     </body>

     </html>










<?php
} else {
     header("Location: student-login.php");
    exit();
}
?>
