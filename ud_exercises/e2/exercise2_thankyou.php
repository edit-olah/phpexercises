<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>
<head>
	<title>Exercise 2 - Thank You</title>
	<link rel="stylesheet" type="text/css" href="css/style.css" />
</head>

<body>

<h1>
    <a href="exercise2.html">
    Exercise 2 - Thank you
    </a>
</h1>

<div id="guest">

<?php

// Gather Data from Form

/**
 * Validation as per: http://www.w3schools.com/php/php_form_validation.asp
 */

// define variables and set to empty values
$firstname = $lastname = $contactchoice = $phoneormemail = $city = $comments = "";
$msg = "";
$error_cnt = 0;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Required. + Must only contain letters and whitespace
  if (empty($_POST['firstname'])) {
	$msg .= '<p class="errormsg">First name is required.</p>';
	$error_cnt++;
    } elseif (!preg_match("/^[a-zA-Z ]*$/", $_POST['firstname'])) {
	$msg .= "Only letters and white space allowed";
	$error_cnt++;
    } else {
	$firstname = test_input($_POST['firstname']);
    }
  // Required. + Must only contain letters and whitespace
  if (empty($_POST['lastname'])) {
	$msg .= '<p class="errormsg">Last name is required.</p>';
	$error_cnt++;
    } elseif (!preg_match("/^[a-zA-Z ]*$/", $_POST['lastname'])) {
	$msg .= "Only letters and white space allowed";
	$error_cnt++;
    } else {
	$lastname = test_input($_POST['lastname']);
    }
    // Must select one
    if (empty($_POST['contactchoice'])) {
	$msg .= '<p class="errormsg">Please select which type of contact information you would like to provide.</p>';
	$error_cnt++;
    } else {
	$contactchoice = test_input($_POST['contactchoice']);
    }
  // Must select one. + Must contain a valid email address (with @ and .)
    if (empty($_POST['phoneormemail'])) {
	$msg .= '<p class="errormsg">Please provide contact information.</p>';
	$error_cnt++;
    } else {
	if ($contactchoice === 'Phone') {
	    if (preg_match("/^(?:(?:\(?(?:0(?:0|11)\)?[\s-]?\(?|\+)44\)?[\s-]?(?:\(?0\)?[\s-]?)?)|(?:\(?0))(?:(?:\d{5}\)?[\s-]?\d{4,5})|(?:\d{4}\)?[\s-]?(?:\d{5}|\d{3}[\s-]?\d{3}))|(?:\d{3}\)?[\s-]?\d{3}[\s-]?\d{3,4})|(?:\d{2}\)?[\s-]?\d{4}[\s-]?\d{4}))(?:[\s-]?(?:x|ext\.?|\#)\d{3,4})?$/", $_POST['phoneormemail'])) {
		$phoneormemail = test_input($_POST['phoneormemail']);
	    } else {
		$msg .= '<p class="errormsg">Make sure you enter a valid UK telephone number. For example: \'+44 (0)20 5555 5555\' or \'020 5555 5555\' or \'02055555555\'.</p>';
		$error_cnt++;
	    }
	}
	if ($contactchoice === 'Email') {
	    if (!filter_var($_POST['phoneormemail'], FILTER_VALIDATE_EMAIL) === false) {
		$phoneormemail = test_input($_POST['phoneormemail']);
	    } else {
		$msg .= '<p class="errormsg">Make sure you enter a valid email address.</p>';
		$error_cnt++;
	    }
	}
    }
  // Must select one
    if (empty($_POST['city'])) {
	$msg .= '<p class="errormsg">Please select a city.</p>';
	$error_cnt++;
    } else {
	$city = test_input($_POST['city']);
    }
    // Optional. Multi-line input field (textarea)
    if (!empty($_POST['comments'])) {
	$comments = test_input($_POST['comments']);
    }
}

function test_input($data) {
  // Strip unnecessary characters (extra space, tab, newline) from the user input data (with the PHP trim() function)
  $data = trim($data);
  // Remove backslashes (\) from the user input data (with the PHP stripslashes() function)
  $data = stripslashes($data);
  // The htmlspecialchars() function converts special characters to HTML entities.
  $data = htmlspecialchars($data);
  
  return $data;
}

//Return input

if ($error_cnt > 0) {
	print "$msg";
} else {
    //Display New Page

    $fullname = $firstname.' '.$lastname;

    //print_r($_POST);

    print "<p class='topofdiv'>Thank You!  A representative will contact you soon</p>";

    print "<p>Information Submitted for: $fullname </p>";

    print "<p>Your $contactchoice is $phoneormemail <br />";
    print "and you are interested in living in $city </p>";

    if (empty($_POST['comments'])) {
	print "You haven't left any comments for us this time.";
    } else {
	print "<p>Our representive will review your comments below:</p>";
	print "<textarea cols='60' rows='5' disabled='disabled' class='textdisabled'>";
	print $comments;
	print "</textarea>";
    }
}
?>

</div>
</body>
</html>