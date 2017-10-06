<div id="contenu">
    <h2>Modifier la fiche de frais</h2>
    
    <!-- formulaire pour recuperer les quantites -->
    <form method="POST"  action="index.php?uc=validerFrais&action=appliquerModification">
        <!--leMois et leVisiteur -->
        <input type="hidden" value="<?php echo $moisASelectionner?>" name="leMois" />
        <input type="hidden" value="<?php echo $visiteurASelectionner?>" name="leVisiteur" />
        
        
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
                    <input type="text" id="idFrais" name="lesFrais[<?php echo $idFrais?>]" size="10" maxlength="5" value="<?php echo $quantite?>" >
		</p>
	<?php
		}
	?>
            </fieldset>
            
        </div>
          
        <div class="piedForm">
            <p>
                <input id="ok" type="submit" value="Valider" size="20" />
                <input id="annuler" type="reset" value="Effacer" size="20" />
            </p> 
        </div>
        
    </form>