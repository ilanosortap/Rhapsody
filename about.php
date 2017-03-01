﻿<?php require_once("includes/session.php"); ?>
<?php include_once("includes/connection.php")?>
<?php include_once("includes/functions.php")?>
<?php
    if (logged_in()) {
		redirect_to("admin.php");
	}
	include_once("includes/form_functions.php");
	
	// START FORM PROCESSING
	if (isset($_POST['commit'])) { // Form has been submitted.
		$errors = array();

		// perform validations on the form data
		$required_fields = array('user', 'pass');
		$errors = array_merge($errors, check_required_fields($required_fields, $_POST));

		$fields_with_lengths = array('user' => 30, 'pass' => 30);
		$errors = array_merge($errors, check_max_field_lengths($fields_with_lengths, $_POST));

		$user = trim(mysql_prep($_POST['user']));
		$pass = trim(mysql_prep($_POST['pass']));
		$hashed_password = sha1($pass);
		
		if ( empty($errors) ) {
			// Check database to see if username and the hashed password exist there.
			$query = "SELECT id, username ";
			$query .= "FROM users ";
			$query .= "WHERE username = '{$user}' ";
			$query .= "AND hashed_password = '{$hashed_password}' ";
			$query .= "LIMIT 1";
			$result_set = mysqli_query($connection,$query);
			//confirm_query($result_set);
			if (mysqli_num_rows($result_set) == 1) {
				// username/password authenticated
				// and only 1 match
				$found_user = mysqli_fetch_array($result_set);
				redirect_to("aboutad.html");
			} else {
				// username/password combo was not found in the database
				$message = "Username/password combination incorrect.<br />
					Please make sure your caps lock key is off and try again.";
			}
		} else {
			if (count($errors) == 1) {
				$message = "There was 1 error in the form.";
			} else {
				$message = "There were " . count($errors) . " errors in the form.";
			}
		}
		
	} else { // Form has not been submitted.
		$user = "";
		$pass = "";
	}
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>About</title>
    <link rel="stylesheet" href="Styles/bootstrapsimplex.min.css" />
	<link rel="stylesheet" href="Styles/style.css" />
</head>
<body>
    <nav class="navbar navbar-default" role="navigation">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">Rhapsody</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li><a href="index.php" role="button">Home</a></li>
                    <li class="active"><a href="about.php" role="button">About</a></li>
                    <li><a href="contact.php" role="button">Contact</a></li>
                </ul>

                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown">
                        <a href="#login" class="dropdown-toggle" data-toggle="dropdown">Login<strong class="caret"></strong></a>
                        <div class="dropdown-menu" style="padding:15px; padding-bottom:15px;">
                            <form action="about.php" method="post" accept-charset="UTF-8">
                                <input id="user_username" style="margin-bottom: 15px;" type="text" name="user" size="30" placeholder="Username" />
                                <input id="user_password" style="margin-bottom: 15px;" type="password" name="pass" size="30" placeholder="Password" />
                                <input id="user_remember_me" style="float: left; margin-right: 10px;" type="checkbox" name="user[remember_me]" value="1" />
                                <label class="string optional" for="user_remember_me"> Remember me</label>

                                <input class="btn btn-primary" style="clear: left; width: 100%; height: 32px; font-size: 13px; padding-bottom:15px;" type="submit" name="commit" value="Sign In" />
                            </form>
                        </div>
                    </li>
                </ul>
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>
        
            <div class="jumbotron" style="background-color:firebrick;">
                <h1 style="font-family:'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif; color:white;">About us</h1>
            </div>
            <p style="padding-top:25px;"></p>
			<div class="containter">
			<h4 style="padding-left:50px; padding-right:50px; font-family:Calibri,Candara,Segoe,Segoe UI,Optima,Arial,sans-serif;"><strong style="color:firebrick; font-size:25px;">Rhapsody</strong> is the flagship event of Leo Club of NIT Rourkela. It is help every year in the month of November.
			This inter-school fest has emerged to be one of the biggest school meets in Odisha involving participation of 800-900 students from 20+ schools.
			A plethora of events are organized from singing, dancing, painting, spellbee to debating, MUN and even science exhibition.
            This fest is organized solely by Leo Club mainly for the purpose of raising funds, and the money generated goes to the poor and needy. 
            In the process, a large number of school students get the opportunity to visit and participate in events hosted on our institute campus.
            It is a big platform for them to showcase their talents and assess their skills. The events are judged by eminent professors or senior student on campus that give their valuable feedback and encourage parents to keep their children involved in these extra-curricular activities.
            </h4>
			<p style="padding-top:20px;"></p>
			<h4 style="padding-left:50px; padding-right:50px;font-family:Calibri,Candara,Segoe,Segoe UI,Optima,Arial,sans-serif;"><strong style="color:firebrick; font-size:25px;">Project Rhapsody</strong> is the Database Management system for Rhapsody 2k15. It contains all the data warehouses related to the participants, events, coordinators, judges, sponsors, participating schools, their travel and accommodation and the winners. The database has been designed taking into account the practical needs of managing such a large-scale fest. 
			The project has GUI based software that will help in storing, updating and retrieving information through the user-friendly functions and display.
            </h4>
			<p style="padding-top:20px;"></p>
			<h4 style="padding-left:50px; padding-right:50px;font-family:Calibri,Candara,Segoe,Segoe UI,Optima,Arial,sans-serif;"><strong style="color:firebrick; font-size:15px;">Front-end Specifications: </strong>HTML/CSS,Javascript,Bootstrap</h4>
			<h4 style="padding-left:50px; padding-right:50px;font-family:Calibri,Candara,Segoe,Segoe UI,Optima,Arial,sans-serif;"><strong style="color:firebrick; font-size:15px;">Back-end Specifications: </strong>PHP,mySQL,WAMP</h4>
	        </div>
        
    <script src="Scripts/jquery-2.1.4.min.js"></script>
    <script src="Scripts/bootstrap.min.js"></script>

</body>
</html>
<?php
 mysqli_close($connection);
 ?>