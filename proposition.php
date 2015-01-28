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

$idUser = $loggedInUser->user_id;
$userIsBanker = (($loggedInUser->role == 6)? true : false);

//Forms posted
if(!empty($_POST))
{
    insertMarketTransaction();
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

/* = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = =  

Page for permission level 2 (professor)

= = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = =  = */
if ($loggedInUser->checkPermission(array(2)))
    {        
        openPage("Your thesis propositions");    
        
        echo "<p>This is the list of subjects you already proposed to students, you can select one to view the student that is willing to work on this or delete your proposition if you no longer want it.</p>";
            
        switch($_GET['cmd'])
        {
/*
 *     Effacer une proposition
 * 
 */
        case "delete":
            echo "<h2>You asked to delete this proposition</h2>";
            afficheDetails($_GET['id'], 'W');
            echo "
                <form name='delete' action='wok.php' method='post'>
                <div class='form_settings'>
                <input type='hidden'name='cmd'value='delete'>
                <input type='hidden'name='id'value='".$_GET['id']."'>
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
            echo "<p>Voici les détails de la proposition sélectionnée, si vous êtes réellement intéressé vous devrez prendre rapidement contact avec l'équipe qui a posté cette proposition de compétence pour réaliser la transaction.</p>";            
            afficheDetails($_GET['id'], 'W');
            echo "<h2>Paiement</h2>";
            afficheReponse($_GET['id'], 'W');
        break;
/*
 * La page de garde par défaut du Marketplace
 *   Liste des offres de compétences déposées par l'équipe.
 *   Quand une réponse est disponible, la loupe est affichée au bout de la ligne avec le nombre de réponses.
 */            

        default:
            listeMarketPlace("ysell","Proposer"," $sortOrder");

            echo "Propose a subject";
            displayInputForm("Proposer");
        break;
        }

    } //fin professor
   
/* = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = =  

Page for permission level 1 (student)

= = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = =  = */   
    if ($loggedInUser->checkPermission(array(1))){
        openPage("Welcome professor");

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
            echo "<p>Voir la liste des compétences déjà déposées par les équipes, vous pouvez en voir le détail en cliquant sur la loupe <img src='images/loupe.png'>.<br/></p>";
            listeMarketPlace("bsell","Proposer"," $sortOrder");
        break;
        }

        
    } // fin professeur
    
    if ($loggedInUser->checkPermission(array(3))){ //Links for permission level 3 (administrator)
        openPage("Les scores globaux");
        
        if ($result = mysqli_query($mysqli, "SELECT display_name, sum(debit),count(debit), sum(credit), count(credit) 
            FROM account A, sk_users U WHERE A.account1 = U.id GROUP BY account1")) {
    		echo "<table style='width:100%; border-spacing:0;'>".
				  "<tr><th>Program</th><th>Débit</th><th>Crédit</th><th width='50%'>Solde</th></tr>";
		/* fetch associative array */
                while (list($programName, $debit, $debitTrans, $credit, $creditTrans)  = mysqli_fetch_row($result)) {
			echo "<tr><td>$programName</td><td>".number_format($debit)." ($debitTrans) </td><td>".number_format($credit)." ($creditTrans)</td><td>".number_format($credit-$debit)."</td></tr>";
	         }
                 echo "</table>
		<br/>
* * * * End Of Report * * * *";
            /* Libération du jeu de résultats */
            mysqli_free_result($result);        
        }
    } // fin admin

closePage();

?>