<?php
/**
 * Vue de la fiche de frais sélectionner en fonction du mois et du visiteur
 * 
 * Le comptable peut générer le pdf de la fiche de frais correspondante et confirmer le remboursement des fiches mises en payement.
 * 
 * @author MAINENTI Eugène
 */
?>

<h3>Fiche de frais de <?php echo $nomVisiteur." "; echo $prenomVisiteur." " ?> du mois <?php echo $numMois."-".$numAnnee?> : </h3>

<div class="encadre">
    <p>Etat : <?php echo $libEtat ?> depuis le <?php echo $dateModif?> <br></p>
        
    <!-- tableau des frais forfait -->
    <table class="listeLegere">
        <caption>Eléments forfaitisés </caption>
        <!-- entete du tableau -->
        <tr>
    <?php
            foreach ( $lesFraisForfait as $unFraisForfait ) 
            {
                $libelle = $unFraisForfait['libelle'];
    ?>	
                <th> <?php echo $libelle?></th>
    <?php
            }
    ?>
        </tr>
    
    
        <tr>
    <?php
            foreach (  $lesFraisForfait as $unFraisForfait  ) 
            {
                $quantite = $unFraisForfait['quantite'];
    ?>
                <td class="qteForfait"><?php echo $quantite?> </td>
    <?php
            }
    ?>
        </tr>
    </table>
        
    <!-- tableau des frais hors forfait -->
    <table class="listeLegere">
        <caption>Descriptif des éléments hors forfait -<?php echo $nbJustificatifs ?> justificatifs reçus -</caption>
        <tr>
            <th class="date">Date</th>
            <th class="libelle">Libellé</th>
            <th class='montant'>Montant</th>
        </tr>
    <?php      
        foreach ( $lesFraisHorsForfait as $unFraisHorsForfait ) 
        {
                $idFrais = $unFraisHorsForfait['id'];
                $date = $unFraisHorsForfait['date'];
                $libelle = $unFraisHorsForfait['libelle'];
                $montant = $unFraisHorsForfait['montant'];
    ?>
        <!-- formulaire pour recuperer les informations sur le forfait hors frais -->
        <tr>
            <td><?php echo $date ?></td>
            <td><?php echo $libelle ?></td>
            <td><?php echo $montant ?></td>
        </tr>
    <?php 
        }
    ?>
    </table>
</div>
<div>
    <form action="index.php?uc=actionFicheFrais&action=pdf-payement" target="_blank" method="POST"><input type="image" src="images/icon_pdf.png" style="width: 70px; height: 70px; padding-left: 0;" onclick="submit" >
        <input type='hidden' name='idVisiteur' value='<?php echo $visiteurASelectionner ?>' />
        <input type='hidden' name='mois' value='<?php echo  $moisASelectionner ?>' />
    </form>
    <form action="index.php?uc=actionFicheFrais&action=validerFicheRemboursement" method="POST"><input type="submit" value="Valider le remboursement" style="padding-right: 0;" />
        <input type='hidden' name='idVisiteur' value='<?php echo $visiteurASelectionner ?>' />
        <input type='hidden' name='mois' value='<?php echo  $moisASelectionner ?>' />
</div>
