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
        switch($_GET['cmd'])
        {
/*
    Le détail d'une proposition et la boite de réponse
*/
        case "detail":
          echo "<p>Voici les détails de la proposition sélectionnée.</p>";            
          afficheDetails($_GET['id'], 'W');
        break;
        default:
            echo "<p>This is the list of propositions in your program.<br/>"
            . "<ul>"
            . "<li>If you see a <img src='./images/add.png'> the proposition is available, click on the icon to reserve it for you.</li>"
            . "<li>If you see a <img src='./images/cross.png'> the proposition is already hold by another student</li>"
            . "<li>If you see a <img src='./images/accept.png'> the proposition is reserved by you.</li>"
            . "</ul>"
            . "</p>";
            listeMarketPlace("student","Proposer"," $sortOrder");
        break;
        }
    } else {
        echo "<h4>Vous devez d'abord remplir votre profil dans <a href='user_settings.php'>User Settings</a></h4>";
    }     
}

    
/* = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = =  

         Page for permission level 2 (professor)

 = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = */
if ($loggedInUser->checkPermission(array(2)))
{
    openPage("Your propositions for student thesis");

    $idUser = $loggedInUser->user_id;
    //Forms posted
    if(!empty($_POST))
    {
//        print_r($_POST);
        switch($_POST['cmd'])
        {
        case "delconfirm":
            $sql = "DELETE FROM market WHERE id = '".$_POST['id']."'";
            $result = mysqli_query($mysqli, $sql);
            echo "<h2>Entry deleted.</h2>";           
        break;
        default:
            insertMarketTransaction();
        break;
        }
    }


    if(!empty($_GET))
    {
    $marketId     = trim($_GET["id"]);

        switch($_GET['sort'])
        {
            case "titre":
                $sortOrder =" ORDER BY titre DESC";
            break;
            case "desc":
                $sortOrder =" ORDER BY description ASC";
            break;
            case "time":
                $sortOrder =" ORDER BY timestamp ASC";
            break;
            default:
                $sortOrder = "";
        }
    }

    switch($_GET['cmd'])
    {
/*
 *     Effacer une proposition
 * 
 */
        case "delete":
            echo "<h2>You asked to delete this proposition</h2>";
            afficheDetails($_GET['id']);
            echo "
                <form name='delete' action='account.php' method='post'>
                <div class='form_settings'>
                <input type='hidden'name='cmd' value='delconfirm'>
                <input type='hidden'name='id' value='".$_GET['id']."'>
                <p style='color:red;text-align:center;'>Attention, cette action est définitive !</p>
                <p style='padding-top: 15px;'>
                <input type='submit' name='button' value='Confirmer' class='submit'>
                </p>
                </div>
                </form>";
        break;
/*
 *     La liste des réponses à une proposition
 * 
 */
        case "Rdetail":
            echo "Voici les détails de la proposition sélectionnée.";
            afficheDetails($_GET['id'], 'W');
            
            echo "<h2>Liste des paiements obtenus pour cette offre de compétence</h2>";
            echo "<table>
            <tr><th>".sortLink("equipe&cmd=$cmd","Equipe")."</th><th>".sortLink("titre&cmd=$cmd","Titre")."</th><th>".sortLink("desc&cmd=$cmd","Description")."</th><th>".sortLink("presta&cmd=$cmd","Date")."</th><th>".sortLink("time&cmd=$cmd","Prix proposé")."</th><th></th></tr>";

            $sql = "SELECT M.id, type, user_name, titre, description, timestamp, price FROM market M, sk_users U WHERE market_id = '".$_GET['id']."' AND user_id =U.id ";
//            echo "<p>$sql";
            $detail =  mysqli_query($mysqli, $sql);
            while (list($id, $type, $idUser, $titre, $description, $timestamp, $price)  = mysqli_fetch_row($detail))
            {
                if ($type == 'Payed') {
                    $tmp = "<img src='images/accept.png'>";
                } else {
                    $tmp ="PROBLEME";
                }
                echo "<tr><td>$idUser</td><td>$titre</td><td>$description</td><td>$timestamp</td><td>$price</td><td>$tmp</td></tr>";                
            }
            echo "</table>";                                    
        break;
/*
    Le détail d'une proposition et la boite de réponse
*/
        case "detail":
            echo "<p>Here are the details of your proposition. You may want to update the programs or discipline it applies.</p>";            
            afficheDetails($_GET['id'], 'W');
            echo "You can <a href='account.php?cmd=delete&id=".$_GET['id']."'><img src='images/delete.png' width='24' height='24'>delete</a> or <a href='account.php?cmd=delete&id=".$_GET['id']."'><img src='images/process.png' width='24' height='24'>update</a> this entry.";
        break;
/*
 * La page de garde par défaut du Marketplace
 *   Liste des offres de compétences déposées par l'équipe.
 *   Quand une réponse est disponible, la loupe est affichée au bout de la ligne avec le nombre de réponses.
 */            

        default:
           echo "<p>This is the list of subjects you already proposed to students, you can select one to view the student that is willing to work on this or delete your proposition if you no longer want it.</p>";
           echo "<br/>"
            . "<ul>"
            . "<li>If you see a <img src='./images/loupe.png' width='24' height='24'> the proposition is available, click on the icon to modify or delete <img src='./images/delete.png' width='24' height='24'> it.</li>"
            . "<li>If you see a <img src='./images/cross.png' width='24' height='24'> the proposition is already hold by a student</li>"
            . "</ul>"
            . "</p>";
 
            listeMarketPlace("professor","Proposer"," $sortOrder");

            echo "You can propose another subject";
            displayInputForm("Proposer");
        break;
    }
} //fin professor
   
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
