<?php 
 
$base = mysqli_connect("127.0.0.1", "root", "", "user"); 
if ($base) { 
   echo 'Connexion réussie.<br />'; 
   echo 'Informations sur le serveur:'.mysqli_get_host_info($base); 

   // Exécution de la requête 
   $resultat = mysqli_query($base, 'SELECT * FROM users'); 
   //fetch sur chaque ligne ramenée par la requête 
   while ($ligne = mysqli_fetch_assoc($resultat)) { 
    // Affichage du nom et prénom des personnes 
    //echo "Je suis ".$ligne['username']." ".$ligne['email']." <br />"; 
 }
   if ($resultat == FALSE) { 
      echo "Echec de l exécution de la requête.<br />"; 
   } 
} 
else { 
   printf('Erreur %d : %s.<br/>',mysqli_connect_errno(), mysqli_connect_error()); 
}
?>