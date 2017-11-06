<?php
/**
 * Vue du sommaire pour un comptable
 * 
 * @author MAINENTI Eugène
 */
?>

<!-- Division pour le sommaire -->
    <div id="menuGauche">
     <div id="infosUtil">
    
        <h2>
    
</h2>
    
      </div>  
        <ul id="menuList">
            <li>
                    Comptable :<br>
                    <?php echo $_SESSION['prenom']."  ".$_SESSION['nom']  ?>
            </li>

            <!-- lien pour valider une fiche -->
            <li class="smenu">
                    <a href="index.php?uc=selectionnerFicheFrais&action=choisirMois" title="Valider fiche de frais ">Valider fiche de frais</a>
            </li>
            
            <!-- lien pour voir fiche frais en payement -->
            <li class="smenu">
                <a href="index.php?uc=selectionnerFicheFrais&action=choisirFicheSuiviPayement" title="Suivi de paiement ">Suivi des fiches en paiement</a>
            </li>
            
            <!-- lien pour deconnexion -->
            <li class="smenu">
                    <a href="index.php?uc=connexion&action=deconnexion" title="Se déconnecter">Déconnexion</a>
            </li>
         </ul>
        
    </div>
    