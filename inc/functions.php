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

function openPage($title)
{
    global $websiteName, $template, $mysqli, $emailActivation, $loggedInUser;

    echo "
<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml'>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
<title>".$websiteName."</title>
  <link rel='stylesheet' type='text/css' href='css/style.css' />
<script src='models/funcs.js' type='text/javascript'>
<!-- modernizr enables HTML5 elements and feature detects -->
<script type='text/javascript' src='js/modernizr-1.5.min.js'></script>
<script type='text/javascript' src='js/jquery.min.js'></script>
<script type='text/javascript' src='js/pop.js'></script>

</script>
</head>

<body>
    <div id='main'>
    <header>
        <div id='logo'>
        <div id='logo_text'>
          <!-- class='logo_six', allows you to change the colour of the text -->
          <h1><span class='logo_six'><a href='index.php'>$websiteName</a></span></a></h1>
          <h2>Student Advisor Matching</h2>
        </div>
      </div>
";

if(isUserLoggedIn()) {
//Links for logged in user

    echo
	"<nav>
            <div id='menu_container'>
                <ul id='nav'>
                    <li><a href='account.php'>Home</a></li>";
	if (isUserReady($loggedInUser->user_id))
	{          
            if ($loggedInUser->checkPermission(array(2))){ //Links for permission level 2 (professor)
                echo "<li><a href='userlist.php'>Groupes</a></li>";
            }
        }        
   	echo "           <li><a href='user_settings.php'>User Settings</a></li>
                    <li><a href='logout.php'>Logout</a></li>
                    </ul>
            </div>
        </nav>
        </header>
        ";

        
if ($loggedInUser->checkPermission(array(1)))
	$userLevel = "Student";
if ($loggedInUser->checkPermission(array(2)))
	$userLevel = "Professor";
if ($loggedInUser->checkPermission(array(3)))
	$userLevel = "Admin";
	

        echo '<div id="site_content">';
        $text = "<h3>".$loggedInUser->displayname."</h3><i>$userLevel</i>".
         "<h2>Your program: ".getProgramById($loggedInUser->program)."</h2>";

        echo displaySideMenu($text);

	//Links for permission level 3 (default admin)
	if ($loggedInUser->checkPermission(array(3))){
	$text = '</div>
            <h3>Admin Menu</h3>'.
                "<ul>
	<li><a href='admin_configuration.php'>Admin Configuration</a></li>
	<li><a href='admin_users.php'>Admin Users</a></li>
	<li><a href='admin_permissions.php'>Admin Permissions</a></li>
	<li><a href='admin_pages.php'>Admin Pages</a></li>
	<li><a href='admin_init.php'>Initialisation des comptes users</a></li>
	</ul>";

        echo displaySideMenu($text);


        }
} else {
//Links for users not logged in
    /*
    echo "
	<nav>
         <div id='menu_container'>
          <ul class='sf-menu' id='nav'>
	<li><a href='index.php'>Home</a></li>
	<li><a href='login.php'>Login</a></li>
	<li><a href='register.php'>Register</a></li>
	<li><a href='forgot-password.php'>Forgot Password</a></li>";
	if ($emailActivation)
	{
            echo "<li><a href='resend-activation.php'>Resend Activation Email</a></li>";
	}
	echo "</ul>
                    </div>
        </nav>
        </header>";

*/
    echo "
	<nav>
         <div id='menu_container'>
          <ul class='sf-menu' id='nav'>
	<li><a href='index.php'>Home</a></li>
	<li><a href='forgot-password.php'>Forgot Password</a></li>";
	echo "</ul>
                    </div>
        </nav>
        </header>";

        echo '<div id="site_content">
      <div id="sidebar_container">
        <img class="paperclip" src="images/paperclip.png" alt="paperclip" />
        <div class="sidebar">'.
         "<h2>Important</h2>
          <ul>
          <li>Login with your usual credentials.</li>
          </ul>".
         "</div>
            ";
}

echo "</div>
<div class='content'>".
        '<img style="float: left; vertical-align: middle; margin: 0 10px 0 0;" src="images/examples.png" alt="examples" />
            <h1 style="margin: 15px 0 0 0;">'.$title.'</h1>';

}

function closePage()
{
    echo "</div>
        </div>
<footer>
<p>(c) <a href='http://about.me/marc.augier'>Marc Augier</a> 2013 | TSS is a branch of <a href='https://github.com/marcyves/cool'>Cool on GitHub</a> | <a href='http://www.css3templates.co.uk'>design from css3templates.co.uk</a></p>
</footer>

</body>
</html>";

}

function displaySideMenu($t)
{
    return '<div id="sidebar_container">
        <img class="paperclip" src="images/paperclip.png" alt="paperclip" />
        <div class="sidebar">'.$t."</div>";
}

function title($icon, $title)
{
    echo '<img style="float: left; vertical-align: middle; margin: 0 10px 0 0;" src="images/'.$icon.'.png" alt="examples" />
            <h1 style="margin: 15px 0 0 0;">'.$title.'</h1>';

}

function sortLink($cmd, $label)
{
 return "<a href='".$_SERVER['PHP_SELF']."?sort=$cmd'>$label</a>";
}

function cleanThisString($t)
{
	$t = htmlentities($t, ENT_QUOTES, "UTF-8");
	$t = strip_tags($t);

	return $t;
}


function listeMarketPlace($cmd,$type,$sqlTmp)
{
    // cmd is professor or student
    global $mysqli, $loggedInUser;
    
    // On affiche les données de la table Market pour $type
    $sql = "SELECT M.id, display_name, email, titre, description, timestamp
            FROM market M, sk_users U 
            WHERE U.id = M.user_id AND type = '$type'$sqlTmp";
               
//debug    echo "<br/>$sql";
    if ($result = mysqli_query($mysqli, $sql))
    {
        $nbLignes = mysqli_num_rows($result);
        
        if ($nbLignes > 0)
        {
            echo "<table>".
             "<tr><th>".sortLink("titre&cmd=$cmd","Title")."</th><th>".sortLink("desc&cmd=$cmd","Description")."</th>><th>".sortLink("time&cmd=$cmd","Date dépot")."</th><th></th></tr>";

            while (list($idMarket, $idUser, $email, $titre, $description, $timestamp, $prestation)  = mysqli_fetch_row($result))
            {
                $nbLignesDetail = countMarketReply($idMarket);
                $iconDetail = iconMarketReply($idMarket, "");
                
                switch($cmd)
                {
                    case "professor":
                    // On vérifie d'abord si elle a reçu des réponses
                    if ($nbLignesDetail > 0)
                    {
                        $tmp = "<a href='".$_SERVER['PHP_SELF']."?cmd=Rdetail&id=$idMarket'>($nbLignesDetail) $iconDetail </a>";
                    } else {
                        // pas de réponse, on peut l'effacer
                        $tmp = "<a href='".$_SERVER['PHP_SELF']."?cmd=delete&id=$idMarket'><img src='images/delete.png' width='24' height='24'></a>"
                              ."<a href='".$_SERVER['PHP_SELF']."?cmd=update&id=$idMarket'><img src='images/process.png' width='24' height='24'></a>";
                    }
                    break;
                    case "student":
 	                    $tmp = "<a href='mailto:$email'>$idUser</td><td><a href='".$_SERVER['PHP_SELF']."?cmd=detail&id=$idMarket'>".iconMarketReply($idMarket, $loggedInUser->user_id)."</a>";
                    break;
               }
                echo "<tr><td>$titre</td><td>$description</td><td>$timestamp</td><td>$tmp</td></tr>";
            }
            echo "</table>";

        } else {
            if ($flagSelf)
                echo "<h3>Vous n'avez encore rien déposé</h3>";
            else {
                echo "<h3>Il n'y a pas encore de demande des autres équipes</h3>";
            }
        }
   }
}

function iconMarketReply($marketId, $userId){
    global $mysqli;
    
    if ($userId != ""){
        $sql1 = "SELECT * FROM market WHERE market_id = '$marketId' and user_id='$userId'";
        $sql2 = "SELECT * FROM market WHERE market_id = '$marketId' and user_id='$userId' AND type != 'Payed'";
    } else {
        $sql1 = "SELECT * FROM market WHERE market_id = '$marketId'";
        $sql2 = "SELECT * FROM market WHERE market_id = '$marketId' AND type != 'Payed'";
    }
    $detail =  mysqli_query($mysqli, $sql1);
    $nbLignesDetail = mysqli_num_rows($detail);

    if ($nbLignesDetail > 0)
    {
        $detail =  mysqli_query($mysqli, $sql2);
        $nbLignesDetail = mysqli_num_rows($detail);

        if ($nbLignesDetail > 0){
            return "<img src='images/cross.png'>";
        } else {            
            return "<img src='images/accept.png'>";
        }
    } else {
        return "<img src='images/add.png'>";
    }
}


function countMarketReply($marketId){
    global $mysqli;
    
    $sql = "SELECT * FROM market WHERE market_id = '$marketId'";
    
    $detail =  mysqli_query($mysqli, $sql);
    $nbLignesDetail = mysqli_num_rows($detail);

    return $nbLignesDetail;
}

function countMyMarketReply($marketId){
    global $mysqli, $loggedInUser;
    
    $userId =  $loggedInUser->user_id;
    
    $sql = "SELECT * FROM market WHERE market_id = '$marketId' and user_id='$userId'";
    
    $detail =  mysqli_query($mysqli, $sql);
    $nbLignesDetail = mysqli_num_rows($detail);

    return $nbLignesDetail;
}

/* = = = = = = = = = = = = = = = = = = = = = = *
    Decoding functions
 * = = = = = = = = = = = = = = = = = = = = = = */
function getProgramById($id)
{
    global $mysqli;

	$result = mysqli_query($mysqli,"SELECT programName FROM program WHERE id='$id'");
	
	if (list($name) = mysqli_fetch_row($result))
		return $name;
	else
		return "$id";
}


function getRoleById($id)
{
    global $mysqli;

	$result = mysqli_query($mysqli,"SELECT role FROM role WHERE id='$id'");
	
	if (list($name) = mysqli_fetch_row($result))
		return $name;
	else
		return "No role defined";
}

function getCampusById($id)
{
    global $mysqli;

	$result = mysqli_query($mysqli,"SELECT campusName FROM campus WHERE id='$id'");
	
	if (list($name) = mysqli_fetch_row($result))
		return $name;
	else
		return false;
}

function isUserReady($id)
{
    global $mysqli;

	
    $result = mysqli_query($mysqli,"SELECT idProgram FROM user_program WHERE idUser='$id'");
    list($name) = mysqli_fetch_row($result);

    if ($name > 0)
    {
            $result = mysqli_query($mysqli,"SELECT campusId FROM sk_users WHERE id='$id'");
            list($name) = mysqli_fetch_row($result);

            if ($name > 0)
            {
                    return true;
            } else
            {
                    return false;
            }
    } else
    {
            return false;
    }
	
}

function getUserFromMarket($id)
{
    global $mysqli;

    $result = mysqli_query($mysqli, "SELECT user_id FROM market WHERE id = '$id'");    
    list($user_id) = mysqli_fetch_row($result);
    
    return $user_id;
}

function browseMyProgram($id)
{
	global $mysqli;
	    
    echo "<img style='float: left; vertical-align: middle; margin: 0 10px 0 0;' src='images/examples.png' alt='Information' />
           <h1 style='margin: 15px 0 0 0;'>Your program is ".getProgramById($id)."</h1><p>
           <table>
           <tr><th>Nom</th></tr>";

    $result = mysqli_query($mysqli, "SELECT `display_name` FROM `sk_users` U WHERE programId = '$id' ORDER BY display_name");
    
    while (list($user) = mysqli_fetch_row($result))
	{
        echo "<tr><td>$user</td></tr>";
    }
        
    echo "
    </table>";
	
}

function afficheDetails($id)
{
    global $mysqli, $loggedInUser;

    $result = mysqli_query($mysqli, "SELECT titre, description, timestamp FROM market WHERE id = '$id'");

    echo "<table>";
    
    list($titre, $description, $timestamp) = mysqli_fetch_row($result);
        
    echo "<tr><td colspan='2'>Read carefully the details below.</td></tr>";

    echo "<tr><td>Titre :</td><td>$titre</td></tr>
    <tr><td>Description :</td><td>$description</td></tr>
    <tr><td>Date de dépot :</td><td>$timestamp</td></tr>
    </table>";
}

function afficheAccept($id1, $id2)
{
    global $mysqli, $loggedInUser;

    $result1 = mysqli_query($mysqli, "SELECT display_name, email, titre, description, timestamp, prestation_name, price 
                                       FROM market M, sk_users U, prestation P WHERE M.id = '$id1' AND U.id = M.user_id");

    $result2 = mysqli_query($mysqli, "SELECT U.id, display_name, email, titre, description, timestamp, prestation_name, price 
                                       FROM market M, sk_users U, prestation P WHERE M.id = '$id2' AND U.id = M.user_id");
    echo "<table>
        <tr><td>
        <h2>Votre demande</h2>
        <table>";
    list($nameUser, $email, $titre, $description, $timestamp, $prestation, $price) = mysqli_fetch_row($result1);
    echo "<tr><td>Equipe :</td><td>$nameUser <a href='mailto:$email'>$email</a></td></tr>
    <tr><td>Titre :</td><td>$titre</td></tr>
    <tr><td>Description :</td><td>$description</td></tr>
    <tr><td>Type :</td><td>$prestation</td></tr>
    <tr><td>Prix :</td><td>$price</td></tr>
    <tr><td>Date de dépot :</td><td>$timestamp</td></tr>
    </table>
    </td>
    <td>";
    
    echo "<h2>La réponse sélectionnée</h2>
          <table>";
    list($idUser, $nameUser, $email, $titre, $description, $timestamp, $prestation, $price) = mysqli_fetch_row($result2);
    echo "<tr><td>Equipe :</td><td>$nameUser <a href='mailto:$email'>$email</a></td></tr>
    <tr><td>Titre :</td><td>$titre</td></tr>
    <tr><td>Description :</td><td>$description</td></tr>
    <tr><td>Type :</td><td>$prestation</td></tr>
    <tr><td>Prix :</td><td>$price</td></tr>
    <tr><td>Date de dépot :</td><td>$timestamp</td></tr>
    </table>";
    echo "    </td>
        </tr>
        </table>";
    echo "<h2>Paiement</h2>
    <form name='deposit' action='pay.php' method='post'>
    <div class='form_settings'>
    <span>Vous payez à l'équipe $nameUser : </span><input type='text'name='deposit'>
            <input type='hidden'name='accountTo' value='$idUser'>
            <input type='hidden'name='prestation'value='$prestation'>
            <input type='hidden'name='marketId'value='$id2'>
    <span style='color:red'>Attention, cette somme sera immédiatement débitée de votre compte !</span>
    <p style='padding-top: 15px'>
    <input type='submit' name='button' value='Payer' class='submit'>
    </div>
    </form>";
}

function afficheReponse($id,$market)
{
    global $mysqli, $loggedInUser;

    // On vérifie si cette demande a reçu une réponse de ce user
    if (countMyMarketReply($_GET['id'])>0)
    {
        $sql = "SELECT M.id, type, display_name, titre, description, timestamp, price 
                FROM market M, sk_users U WHERE market_id = '".$_GET['id']."' AND user_id =U.id AND U.id = '".$loggedInUser->user_id."'";
        $detail =  mysqli_query($mysqli, $sql);
        list($id, $type, $idUser, $titre, $description, $timestamp, $price)  = mysqli_fetch_row($detail);
        
        echo "Vous avez déjà répondu le $timestamp";
//debug echo "<p>$id, *$type*, $idUser, $titre, $description, $timestamp, $price, $market</p>";
        if ($type == "Payed"){
            if ($market == "M"){
                echo ", votre offre a été acceptée et vous avez été payé";
            } else if ($market == "W"){
                echo ", vous avez déjà payé pour acheter cette offre de compétence";
            }
        } else {
            echo ", votre offre n'a pas encore reçu de réponse";            
        }
        echo ".<br/>";
        echo "<table><tr><td>$titre</td></tr><tr><td>$description</td></tr><tr><td>".number_format ($price)." SKEMs </td></tr></table>";                
    } else {
        if ($market == 'M'){
            echo "Vous pouvez y répondre directement à l'aide du formulaire suivant.<br/>
                <form name='sell' action='".$_SERVER['PHP_SELF']."' method='post'>
                  <div class='form_settings'>";

            echo '<span>Titre : </span><input type="text" name="titre" value="" /><br/>
            <span>Description : </span><textarea rows="8" cols="50" name="description"></textarea><br/>
            <span>Prix : </span><input type="text" name="price" value="" /><br/>
            <input type="hidden" name="id" value="'.$id.'" />
            <input type="hidden" name="prestationId" value="NULL" />'.
            "<p style='padding-top: 15px'>
            <input type='submit' name='cmd' value='Repondre' class='submit' />
            </div></form></div>";
        }else if ($market == 'W'){
            $idUserWOC = getUserFromMarket($id);
            echo "<p>Une fois que vous êtes d'accord sur les modalités de la prestation, vous devez payer l'autre équipe à l'aide du formulaire ci-dessous</p>";

            echo "<form name='deposit' action='pay.php' method='post'>
            <div class='form_settings'>";
            
            echo "<span>Titre : </span><input type='text' name='titre' value='' /><br/>
            <span>Description : </span><textarea rows='8' cols='50' name='description'></textarea><br/>
            <input type='hidden' name='id' value='$id' />
            <input type='hidden' name='prestation' value='NULL' />
            <span>Vous payez à l'équipe $nameUser : </span><input type='text'name='deposit'>
            <input type='hidden'name='accountTo' value='$idUserWOC'>
            <input type='hidden'name='marketId'value='$id'>
            <input type='hidden'name='marketPlace'value='WOC'>
            <span style='color:red'>Attention, cette somme sera immédiatement débitée de votre compte !</span>
            <p style='padding-top: 15px'>
            <input type='submit' name='button' value='Payer' class='submit'>
            </div>
            </form>";
        }
    }
}

function insertMarketTransaction()
    {
        global $mysqli, $idUser;
        
//debug        print_r($_POST);

        $type         = $_POST["cmd"];
	$titre        = cleanThisString(trim($_POST["titre"]));
	$description  = cleanThisString(trim($_POST["description"]));
        
        $timeStamp    = date("Y-m-d H:i:s");
        
        if ($type == 'delete'){
            $sql = "DELETE FROM market WHERE id = '$marketId'";
        } else {
            $sql = "INSERT INTO `market` (`id`, `user_id`,`type`, `titre`, `description`, timestamp) 
            VALUES (NULL, '$idUser', '$type', '$titre', '$description', '$timeStamp');";
        }
//debug      echo "<p>$sql";
//      die ();
        $result = mysqli_query($mysqli, $sql);
        
        // Pour enchainer on force la cmd suivante
        switch ($type)
        {
            case "Repondre":
                $_GET['cmd'] = "bsell";
            break;
            case "Proposer":
                $_GET['cmd'] = "ysell";
            break;
            case "Demander":
                $_GET['cmd'] = "ybuy";
            break;
        }
    }
function displayInputForm($type){

    echo "<form action='".$_SERVER['PHP_SELF']."' method='post'>
          <div class='form_settings'>";
    echo '<p><span>Titre : </span><input type="text" name="titre" value="" /></p>
          <p><span>Description : </span><textarea rows="8" cols="50" name="description"></textarea></p>
          <p style="padding-top: 15px">
          <input type="submit" name="cmd" value="'.$type.'" class="submit" />
          </div></form></div>';
}

function addProfessor($name,$display, $mail){
    global $mysqli;
    
    $result = mysqli_query($mysqli, "INSERT INTO `sk_users` (`id`, `user_name`, `display_name`, `password`, `email`, `activation_token`, `last_activation_request`, `lost_password_request`, `active`, `title`, `sign_up_stamp`, `last_sign_in_stamp`) VALUES (NULL, '$name', '$display', '9051a509f95691159c7ed617fd884f29af9213d747b13b6c7860fff6fb40cb24d', '$mail', 'b3f4ed2c42cc370d457f9caa201617a8', 1377894239, 0, 1, 'Professor', 1377894239, 1377898821);");
    $result = mysqli_query($mysqli,"SELECT id FROM `sk_users` WHERE user_name = '$name';");
    list($idNew)  = mysqli_fetch_row($result);
    $result = mysqli_query($mysqli, "INSERT INTO `sk_user_permission_matches` (`id`, `user_id`, `permission_id`) VALUES (NULL, '$idNew', '2');");    
}

?>
