<?php
/**
 * Vue pour confirmer que la fiche a été validé
 * 
 * @author LAZE Aymeric
 */
?>


<h3>Confirmation de la validation : </h3>
<div id='contenu'>
    <div class="encadre">
        <p>
            Enregistrement de la fiche de frais de <?php echo $nomVisiteur." "; echo $prenomVisiteur." " ?> du mois <?php echo $numMois."-".$numAnnee?>
        </p>
        <!-- bouton de retour à la page d'accueil du comptable -->
        <a href="index.php?uc=selectionnerFicheFrais&action=choisirMois">Valider une autre fiche</a>
    </div>