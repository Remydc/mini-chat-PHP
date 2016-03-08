<?php
session_start();
$_SESSION['pseudo'] = !empty($_POST['pseudo']);
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Mini-chat</title>
    </head>
    <style>
        form
        {
            text-align: center;
        }
    </style>
    <body>
        <form action="minichat_post.php" method="post">
            <p><label>Pseudo: </label><input type="text" name="pseudo" value="hito" /></p>
            <p><label>Message: </label><input type="text" name="message" /></p>
            <p><input type="submit" value="Envoyer" /></p>
        </form>
        <?php
        try
        {
            // On se connecte à MySQL
            $bdd = new PDO('mysql:host=localhost;dbname=test;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
        }
        catch(Exception $e)
        {
            // En cas d'erreur, on affiche un message et on arrête tout
                die('Erreur : '.$e->getMessage());
        }

        // Si tout va bien, on peut continuer

        // Récupération desv 10 derniers messages
        $reponse = $bdd->query('SELECT pseudo, message FROM minichat ORDER BY ID DESC LIMIT 11, 255');

        // Affichage de chaque message (toutes les données sont protégées par htmlspecialchars)
        while ($donnees = $reponse->fetch())
        {
            echo '<p><strong>' . htmlspecialchars($donnees['pseudo']) . '</strong> : ' . htmlspecialchars($donnees['message']) . '</p>';
        }
        $reponse->closeCursor();
        ?>
        <p><a href="minichat.php">Retour au chat</a></p>
    </body>
</html>