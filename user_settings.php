<?php


/*
==============================================================================

	Copyright (c) 2013 Marc Augier

	For a full list of contributors, see "credits.txt".
	The full license can be read in "license.txt".

	This program is free software; you can redistribute it and/or
	modify it under the terms of the GNU General Public License
	as published by the Free Software Foundation; either version 2
	of the License, or (at your option) any later version.

	See the GNU General Public License for more details.

	Contact: m.augier@me.com
==============================================================================
*/

/*
The User Authentication provides from:

UserCake Version: 2.0.2
http://usercake.com
*/

require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}

//Prevent the user visiting the logged in page if he is not logged in
if(!isUserLoggedIn()) { header("Location: index.php"); die(); }

require_once("inc/functions.php");

/* Debug
echo "<h1>user</h1>";
print_r($loggedInUser);

echo "<h1>POST</h1>";
print_r($_POST);
*/

if(!empty($_POST))
{
	$errors = array();
	$successes = array();
// email and title can be modified at any moment
	$email = $_POST["email"];
	$title = $_POST["title"];

	$errors = array();
	$email = $_POST["email"];
	
	//Perform some validation
	
	if($email != $loggedInUser->email)
	{
		if(trim($email) == "")
		{
			$errors[] = lang("ACCOUNT_SPECIFY_EMAIL");
		}
		else if(!isValidEmail($email))
		{
			$errors[] = lang("ACCOUNT_INVALID_EMAIL");
		}
		else if(emailExists($email))
		{
			$errors[] = lang("ACCOUNT_EMAIL_IN_USE", array($email));	
		}
		
		//End data validation
		if(count($errors) == 0)
		{
			$loggedInUser->updateEmail($email);
			$successes[] = lang("ACCOUNT_EMAIL_UPDATED");
		}
	}

	if($title != $loggedInUser->title)
	{
		$title = trim($title);		
		//Validate title
		if(minMaxRange(1,50,$title))
		{
			$errors[] = lang("ACCOUNT_TITLE_CHAR_LIMIT",array(1,50));
		}
		else {
			if (updateTitle($loggedInUser->user_id, $title)){
				$loggedInUser->title = $title;
				$successes[] = lang("ACCOUNT_TITLE_UPDATED", array ($loggedInUser->displayname, $title));
			}
			else {
				$errors[] = lang("SQL_ERROR");
			}
		}
	}

// campus can only be set one time 
	if($campus = $_POST["campus"])
	{
		if($campus != $loggedInUser->campus)
		{
			$loggedInUser->updateCampus($campus);
			$successes[] = lang("ACCOUNT_CAMPUS_UPDATED", array ($loggedInUser->displayname, getCampusById($campus)));
		}
	}
	
// program can only be set one time 
	if($program = $_POST["program"])
	{
		if($program != $loggedInUser->program)
		{
			$loggedInUser->updateProgram($program);
			$successes[] = lang("ACCOUNT_PROGRAM_UPDATED", array ($loggedInUser->displayname, getProgramById($program)));
		}
	}
	

	if(count($errors) == 0 AND count($successes) == 0){
		$errors[] = lang("NOTHING_TO_UPDATE");
	}
}

openPage("User Settings");

echo resultBlock($errors,$successes);

echo "
<form name='updateAccount' action='".$_SERVER['PHP_SELF']."' method='post'>
<div class='form_settings'>
<span>Email:</span>
<input type='text' name='email' value='".$loggedInUser->email."' />
<span>Nickname:</span>
<input type='text' name='title' value='".$loggedInUser->title."' />
";


/*
   The campus Box
*/
$campusId = $loggedInUser->campus;

echo "<span>Campus:</span>";

if ($campusId == NULL)
{
	$campusId0 = 0;
	$campusName0 = "--> Please Select";
	
	echo "<select name='campus' />
	<option style='color:purple;' value='$campusId0' selected>$campusName0</option>";

	$result = mysqli_query($mysqli,"SELECT id, campusName FROM campus ORDER BY campusName");

	while (list($campusId, $campusName) = mysqli_fetch_row($result))
	{
		if ($campusId0 != $campusId )
			echo "<option style='color:grey;' value='$campusId'>$campusName</option>";
	}
	mysqli_free_result($result);

	echo "
	</select>";
} 
else
{
	echo "<input type='text' name='campusOk' value='".getCampusById($campusId)."' readonly>";
}

/*
    The Program Box
*/
echo "<span>Program :</span>";
$programId = $loggedInUser->program;

if ($programId == NULL)
{
	$programId0 = 0;
	$programName0 = "--> Please Select";
	echo "<select name='program' />
	<option style='color:red;' value='$programId0' selected>$programName0</option>";

        $result = mysqli_query($mysqli,"SELECT id, programName FROM program ORDER BY programName");
	
	while(list($id, $name) = mysqli_fetch_row($result))
        {
            echo "<option style='color:grey;' value='$id'>$name</option>";
        }
        
	echo "
	</select>";
} 
else
{
	echo "<input type='text' name='programOk' value='".getProgramById($programId)."' readonly>";
}

echo "<p style='padding-top: 15px'>
<input type='submit' value='Update' class='submit' />
</div>
</form>";


closePage();

?>
