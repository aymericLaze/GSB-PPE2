<?php
/**
 * Vue pour modifier le nombre de justificatifs et de frais forfait
 * 
 * @author LAZE Aymeric
 */
?>


<div id="contenu">
    <h2>Modifier la fiche de frais</h2>
    
    <!-- formulaire pour recuperer les quantites -->
    <form method="POST"  action="index.php?uc=actionFicheFrais&action=appliquerModification">
        
        <!-- modification du nombre d'element forfaitises -->
        <div class="corpsForm">
            <fieldset>
                <legend>Eléments forfaitisés</legend>
                 
        <?php
                foreach ($lesFraisForfait as $unFrais)
                {
                    $idFrais = $unFrais['idfrais'];
                    $libelle = $unFrais['libelle'];
                    $quantite = $unFrais['quantite'];
	?>
                <p>
                    <label for="idFrais"><?php echo $libelle ?></label>
                    <input type="text" id="idFrais" name="txtLesFrais[<?php echo $idFrais?>]" size="10" maxlength="5" value="<?php echo $quantite?>" >
		</p>
	<?php
		}
	?>
            </fieldset>    
                
            <br />
            <br />
               
            <!-- modification du nombre de justificatif -->
            <label>Nombre de justificatifs</label>
            <input type="text" name="txtNbJustificatifs" size="10" maxlength="5" value="<?php echo $nbJustificatifs ?>" />
            
            <br />
            <br />
            
        </div>
        
        <div class="piedForm">
            <p>
                <input id="ok" type="submit" value="Valider" size="20" />
                <input id="annuler" type="reset" value="Effacer" size="20" />
            </p> 
        </div>
        
    </form>