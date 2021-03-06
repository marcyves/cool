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
UserCake Version: 2.0.2
http://usercake.com
*/

require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}
require_once("inc/functions.php");

openPage("Les utilisateurs");

//Forms posted
if(!empty($_POST))
{
		$errors[] = lang("SQL_ERROR");
}

for($i=1;$i <= 153; $i++)
{
	$teamPresent[$i] = $i.", ";
}

$userData = fetchAllUsersByTeam(); //Fetch information for all users

//echo resultBlock($errors,$successes);

echo "
<form name='adminUsers' action='".$_SERVER['PHP_SELF']."' method='post'>
<table class='admin'>
<tr>
<th>Username</th><th>Display Name</th><th>Role</th><th>Campus</th><th>Last Sign In</th>
</tr>";

//Cycle through users
$previousTeam = '';
foreach ($userData as $v1) {
    if ($v1['team'] != $previousTeam)
    {
    	$previousTeam = $v1['team'];
    	$teamPresent[$previousTeam] ='';
    	echo "
	<tr>
	<td colspan='5'>Team : ".$v1['team']."</td></tr>";
    }
//    if ($v1['title']=='Student'){
	echo "
	<tr>
	<td><a href='admin_user.php?id=".$v1['id']."'>".$v1['user_name']."</a></td>
	<td>".$v1['display_name']."</td>
	<td>".$v1['role']."</td>
	<td>".$v1['campus']."</td>
	<td>
	";
	
	//Interprety last login
	if ($v1['last_sign_in_stamp'] == '0'){
		echo "Never";	
	}
	else {
		echo date("j M, Y", $v1['last_sign_in_stamp']);
	}
	echo "
	</td>
	</tr>";
//    }
}

echo "</table>
    </form>";

echo "<p>Equipes absentes : ";
for($i=1;$i <= 153; $i++)
{
	echo $teamPresent[$i];
}
echo ".";
closePage();

?>
