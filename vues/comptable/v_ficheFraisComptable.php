<?php
/**
 * Vue de la fiche de frais sélectionner en fonction du mois et du visiteur
 * 
 * Le comptable peut intéragir avec la fiche pour
 * modifier le nombre de justificatifs et de frais forfait
 * ainsi que reporter ou refuser un frais hors forfait
 * 
 * @author LAZE Aymeric
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
                if ($unFraisForfait['libelle']!='Frais Kilométrique'){
                $quantite = $unFraisForfait['quantite'];
                }
                else {
                $quantite = intval($unFraisForfait['quantite']);
                $quantite=$quantite*$prixKm." €";
                
                }
    ?>
                <td class="qteForfait"><?php echo $quantite?> </td>
    <?php
            }
    ?>
        </tr>
    </table>
    
    <!-- formulaire pour modification des elements -->
    <form action="index.php?uc=actionFicheFrais&action=modifier" method="post">
        <input type="submit" value="Modifier" />
    </form>
        
        
    <!-- tableau des frais hors forfait -->
    <table class="listeLegere">
        <caption>Descriptif des éléments hors forfait -<?php echo $nbJustificatifs ?> justificatifs reçus -</caption>
        <tr>
            <th class="date">Date</th>
            <th class="libelle">Libellé</th>
            <th class='montant'>Montant</th>
            <th>Reporter frais</th> <!-- ajout possibiliter de reporter -->
            <th>Supprimer frais</th> <!-- ajout possibiliter de supprimer -->
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
           
            <!-- formulaire pour recuperer les informations sur le forfait hors frais -->
            <form action="index.php?uc=actionFicheFrais&action=reporter" method="post">
                <input type="hidden" name="hdIdFraisHorsForfait" value="<?php echo $idFrais ?>" />
                <td><input type="submit" value="Reporter" /></td>
            </form>

            <!-- formulaire pour recuperer les informations sur le forfait hors frais -->
            <form action="index.php?uc=actionFicheFrais&action=refuser" method="post">
                <input type="hidden" name="hdIdFraisHorsForfait" value="<?php echo $idFrais ?>" />
                <td><input type="submit" value="Refuser" /></td>
            </form>
        </tr>
    <?php 
        }
    ?>
    </table>
        
    <!-- formulaire pour valider la la fiche de frais -->
    <form action="index.php?uc=actionFicheFrais&action=validerFiche" method="post">
        <input type="submit" value="Valider la fiche" />
    </form>
        
</div>
