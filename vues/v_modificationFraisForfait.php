<!-- vue pour modifier la quantite de frais forfaitises -->
<div id="contenu">
<h3>Modifier la quantité d'élément forfaitisés</h3>

<form action="index.php?uc=validerFrais&action=appliquerModification" method="post">
    <!-- tableau des frais forfait -->
    <table class="listeLegere">
        
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
        
        <!-- reste du tableau -->
        <tr>
    <?php
            foreach (  $lesFraisForfait as $unFraisForfait  ) 
            {
                $quantite = $unFraisForfait['quantite'];
    ?>
                <!-- stockage des quantites dans une variable $_post avec comme index idfrais-->
                <td class="qteForfait">
                    <input type="text" value="<?php echo $quantite?>" size="15" name="<?php echo $unFraisForfait['idfrais'] ?>" />
                </td>
    <?php
            }
    ?>
        </tr>
    </table>
    
    <input type="submit" value="valider" size="20"/>
</form>