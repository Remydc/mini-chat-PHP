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
            
            <p><label>Pseudo: </label><input type="text" name="pseudo" value="<?php if (isset($_COOKIE['pseudo']))
            {
            echo $_COOKIE['pseudo'];
            }else
            {
            echo ' pseudo';
            } ?>" required/></p>
            
            <p><label>Message: </label><input type="text" name="message" required/></p>
            
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

        // Récupération des 10 derniers messages
        $reponse = $bdd->query('SELECT pseudo, message, DATE_FORMAT(date_post, \'%d/%m/%Y à %Hh%imin%ss\') AS date_post_fr FROM minichat ORDER BY ID DESC LIMIT 0,10');

        // Affichage de chaque message (toutes les données sont protégées par htmlspecialchars)
        while ($donnees = $reponse->fetch())
        {
        ?>
        <p> [<?php echo($donnees['date_post_fr']) ?>]<strong> <?php echo strip_tags($donnees['pseudo']) ?></strong> : <?php echo strip_tags($donnees['message']) ?></p>
        <?php
        }
        $reponse->closeCursor();
        
        ?>
        
        <p><a href="minichat.php">actualiser la page</a></p>
        
        <p><a href="minichat_p2.php">Afficher les anciens messages</a></p>
        
    </body>
    
</html>