<?php

require 'temboo/temboo.php';
require 'config.php';

date_default_timezone_set("Asia/Manila");
$timestamp 	= date("m-d-Y") . " " . date("h:i:s");
$fname		  = str_replace(",", "", $_POST['fname']);
$lname		  = str_replace(",", "", $_POST['lname']);
$age		    = str_replace(",", "", $_POST['age']);
$school     = str_replace(",", "", $_POST['school']);
$year		    = str_replace(",", "", $_POST['year']);
$course		  = str_replace(",", "", $_POST['course']);
$email		  = str_replace(",", "", $_POST['email']);
$cell		    = str_replace(",", "", $_POST['cpnum']);
$team		    = str_replace(",", "", $_POST['team']);
$size		    = str_replace(",", "", $_POST['shirtSize']);
$allergies	= str_replace(",", "", $_POST['fa']);
if(isset($_POST['identify1'])) $hacker = "Yes";
else $hacker = "No";
if(isset($_POST['identify2'])) $hustler = "Yes";
else $hustler = "No";
if(isset($_POST['identify3'])) $healthHunk = "Yes";
else $healthHunk = "No";
if(isset($_POST['identify4'])) $hipster = "Yes";
else $hipster = "No";
$overnight	= str_replace(",", "", $_POST['overnight']);
$survey		= str_replace(",", "", $_POST['survey']);

if ($year == "Other") {
  $year = str_replace(",", "", $_POST['yearOther']);
}

$job = new Google_Spreadsheets_AppendRow(new Temboo_Session($config["TEMBOO"]["USERNAME"], $config["TEMBOO"]["APP"], $config["TEMBOO"]["KEY"]));
$input = $job->newInputs();
$input  ->setRowData("$timestamp ,$fname ,$lname ,$age ,$school ,$year ,$course ,$email ,$cell ,$team, $size ,$allergies ,$hacker ,$hustler ,$healthHunk ,$hipster ,$overnight ,$survey ")
		->setSpreadsheetTitle($config["GOOGLE"]["FILE"])
		->setRefreshToken($config["GOOGLE"]["REFRESH_TOKEN"])
		->setClientSecret($config["GOOGLE"]["CLIENT_SECRET"])
		->setClientID($config["GOOGLE"]["CLIENT_ID"]);
try {
	$result = $job->execute($input)->getResults();
	$message = "Your application has been sent and is being processed. Have a Nice Day! :)";
}
catch(Exception $e) {
	$message = "It seems like an error occured while trying to process your application. Please check back later.<br><br>";
	$errorPage = true;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>HealthHacks PH - The Premier Health Hackathon for Students</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" href="assets/img/favicons/favicon.ico">
  <link type="text/css" rel="stylesheet" href="assets/css/index.css" />
  <link href="https://fonts.googleapis.com/css?family=Oswald" rel="stylesheet">
</head>
<body>
  <div class="section about">
      <div class="customNavbar fixed" id="navbar">
        <div class="logoDiv">
          <img src="assets/img/Yellow Logo.png" class="logoImage"/>
          <div class="logoText"><span>Health</span>Hacks</div>
        </div>
        <div class="navlinks">
          <ul class="floatRight">
            <a href=""><li>Apply Now</li></a>
          </ul>
          <ul class="floatLeft">
            <li><a href="#about">About</a></li>
            <li><a href="#lineup">Lineup</a></li>
            <li><a href="#details">Details</a></li>
            <li><a href="#speakers">Speakers</a></li>
            <li><a href="#sponsors">Sponsors</a></li>
            <li><a href="#faqs">FAQs</a></li>
            <li><a href="#contact">Contact Us</a></li>
          </ul>
        </div>
        <div id="hamburger"></div>
        <div class="menu" id="menu">
          <li><a href="">About</a></li>
          <li><a href="">Lineup</a></li>
          <li><a href="">Details</a></li>
          <li><a href="">Program</a></li>
          <li><a href="">Speakers</a></li>
          <li><a href="">FAQs</a></li>
          <li><a href="">Sponsors</a></li>
          <li><a href="">Contact Us</a></li>
        </div>
      </div>
      <div class="formContent">
        <div class="box">
        <?php
        if (isset($errorPage)) {
        	header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
        	echo "<h1>Error 500: Internal Server Error.</h1>";
       	}
        ?>
        <h1>HealthHacks 2017 Application Form</h1>
          <p>
          Hey there! Thank you for showing interest in registering for HealthHacks PH 2017.<br>
          <?php echo $message; ?>
          </p>
        </div>
      </div>
      <br class="clear">
  </div>

  <script>
    window.addEventListener("load", function(){
      document.getElementById('hamburger').addEventListener("click", function(){
        var ham = document.getElementById('hamburger');
        var links = document.getElementById('menu');
        if(ham.className == "arrow"){
          links.className = "menu";
          ham.className = "";
        } else{
          links.className = "menu show";
          ham.className = "arrow";
        }
      }, false);
    }, false);
  </script>
  <script type="text/javascript" src="assets/js/jquery.js"></script>
  <script type="text/javascript" src="assets/js/learn-jquery.js"></script>
</body>
</html>
