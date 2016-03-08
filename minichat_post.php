<?php
setcookie('pseudo', $_POST['pseudo'], time() + 365*24*3600, null, null, false, true);
try
{
	// On se connecte à MySQL
	$bdd = new PDO('mysql:host=localhost;dbname=test;charset=utf8', 'root', '');
}
catch(Exception $e)
{
	// En cas d'erreur, on affiche un message et on arrête tout
        die('Erreur : '.$e->getMessage());
}

// Si tout va bien, on peut continuer

// Insertion du message à l'aide d'une requête préparée
$req = $bdd->prepare('INSERT INTO minichat (pseudo, message, date_post) VALUES (?, ?, NOW())');
$req->execute(array($_POST['pseudo'], $_POST['message']));

//Redirection du visiteur vers la page du minichat
header('Location: minichat.php');
?>