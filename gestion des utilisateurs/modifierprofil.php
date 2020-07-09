<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Modifier votre profil</title>
    </head>
    <body>      
        <div>Modification</div>
        <form method="post">
<?php
if(isset($nom)){
?>
<div><?= $nom ?></div>
<?php
}
?>
<input type="text" placeholder="username" name="nom" required>   
<?php
if (isset($mail)){
?>
<div><?= $mail ?></div>
<?php
}
?>
<input type="email" placeholder="Adresse mail" name="mail" required>
<button type="submit" name="modification">Modifier</button>
</form>
</body>
</html>