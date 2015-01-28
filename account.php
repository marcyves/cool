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

require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}
require_once("inc/functions.php");

/* = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = =  

Page for permission level 1 (user)

= = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = =  = */
if ($loggedInUser->checkPermission(array(1))) {
    openPage("Your Account");

	if (isUserReady($loggedInUser->user_id))
	{
	    echo "<p>
            This is the list of Research proposal you made.</p>";

            accountBrowse($loggedInUser->user_id);

	    echo "<h4>bla bla</h4>
                lorem ipsum...";
    	    
	    browseMyProgram($loggedInUser->program);
	} else
	{
		echo "<h4>Vous devez d'abord remplir votre profil dans <a href='user_settings.php'>User Settings</a></h4>";
	}
}
    
/* = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = =  

         Page for permission level 2 (professor)

 = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = */
if ($loggedInUser->checkPermission(array(2)))
    {
        openPage("Your propositions for student thesis");

       
        if ($result = mysqli_query($mysqli, "SELECT U.id, display_name, programId, coalesce(sum(debit), 0) as totalDebit ,count(debit), coalesce(sum(credit),0) as totalCredit, count(credit),  coalesce(sum(credit), 0)- coalesce(sum(debit), 0) FROM account A, sk_users U, WHERE A.errorFlag <> '1' AND A.account1 = U.id GROUP BY account1  ORDER BY programId"))
            {
    		echo "<table style='width:100%; border-spacing:0;'>".
				  "<tr><th>".sortLink("name","Name")."</th>
				                       
				                       <th>".sortLink("program","Program")."</th>
                                       <th>".sortLink("debit","Débit")." (".sortLink("cdebit","nb").")</th>
                                       <th>".sortLink("credit","Crédit")." (".sortLink("ccredit","nb").")</th>
                                       <th width='50%'>".sortLink("solde","Solde")."</th></tr>";
		/* fetch associative array */
		        $flagProgram = 0;
                while (list($userId, $userName, $programName, $debit, $debitTrans, $credit, $creditTrans, $solde)  = mysqli_fetch_row($result))
                {
                	if ($flagProgram == 0)
                		$flagProgram = $programName;
                		
                	if ($flagProgram != $programName)
                	{
                		/* This entry is for a new program */
                		// First display the total for the previous program
                		$resultProgram = mysqli_query($mysqli, "SELECT coalesce(sum(debit),0) as totalDebit, count(debit), coalesce(sum(credit),0) as totalCredit, count(credit),  coalesce(sum(credit),0)- coalesce(sum(debit),0) FROM account A, sk_users U, WHERE A.errorFlag <> '1' AND  A.account1 = U.id and programId = '$flagProgram' GROUP BY programId");
                		
                		// Display the entry for the program
                		list ($debit1, $debitTrans1, $credit1, $creditTrans1, $solde1)  = mysqli_fetch_row($resultProgram);
        	            echo "<tr><td><b>Equipe $flagProgram</b></td><td>&nbsp;</td><td>Total: </td><td style='text-align: right;'>".number_format($debit1)." ($debitTrans1) </td><td  style='text-align: right;'>".number_format($credit1)." ($creditTrans1)</td><td>".number_format($solde1)."</td></tr>";
        	                            		
    	            	$flagProgram = $programName;

            	    } 
                	            	    
               		// Now display the entry for the user
            	    echo "<tr><td><a href='accountDetail.php?id=$userId'>$userName</a></td><td>$programName</td><td style='text-align: right;'>".number_format($debit)." ($debitTrans) </td><td  style='text-align: right;'>".number_format($credit)." ($creditTrans)</td><td>".number_format($solde)."</td></tr>";
	        }
                echo "</table>
		<br/>
* * * * End Of Report * * * *";
            /* Libération du jeu de résultats */
                mysqli_free_result($result);        
            }
    }
/* = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = =  

Page for permission level 3 (administrator)

 = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = */    
if ($loggedInUser->checkPermission(array(3)))
    {
        openPage("Les scores globaux des équipes");

        switch($_GET['sort'])
        {
            case "ccredit":
                $sortOrder =" ORDER BY count(credit) DESC";
            break;
            case "cdebit":
                $sortOrder =" ORDER BY count(debit) DESC";
            break;
            case "credit":
                $sortOrder =" ORDER BY sum(credit) DESC";
            break;
            case "debit":
                $sortOrder =" ORDER BY sum(debit) DESC";
            break;
            case "solde":
                $sortOrder =" ORDER BY coalesce(sum(credit), 0)- coalesce(sum(debit), 0) DESC";
            break;
            default:
                $sortOrder = "ORDER BY programId";
        }
        
        if ($result = mysqli_query($mysqli, "SELECT U.programId, display_name, coalesce(sum(debit), 0) as totalDebit ,count(debit), coalesce(sum(credit),0) as totalCredit, count(credit),  coalesce(sum(credit), 0)- coalesce(sum(debit), 0) FROM account A, sk_users U WHERE A.account1 = U.id GROUP BY account1 $sortOrder"))
            {
    		echo "<table style='width:100%; border-spacing:0;'>".
				  "<tr><th>".sortLink("program","Program")."</th>
				  					   <th>".sortLink("user","User")."</th>
                                       <th>".sortLink("debit","Débit")." (".sortLink("cdebit","nb").")</th>
                                       <th>".sortLink("credit","Crédit")." (".sortLink("ccredit","nb").")</th>
                                       <th width='50%'>".sortLink("solde","Solde")."</th></tr>";
		/* fetch associative array */
                while (list($programName, $userName, $debit, $debitTrans, $credit, $creditTrans, $solde)  = mysqli_fetch_row($result))
                {
                    echo "<tr><td>$programName</td><td>$userName</td><td style='text-align: right;'>".number_format($debit)." ($debitTrans) </td><td  style='text-align: right;'>".number_format($credit)." ($creditTrans)</td><td>".number_format($solde)."</td></tr>";
	        }
                echo "</table>
		<br/>
* * * * End Of Report * * * *";
            /* Libération du jeu de résultats */
                mysqli_free_result($result);        
            }            
    }

closePage();

?>
