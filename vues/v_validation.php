<h3>Fiche de frais de <?php //echo $nomUtilisateur." "; echo $prenomUtilisateur." " ?> du mois <?php echo $numMois."-".$numAnnee?> : </h3>
    <div class="encadre">
    <p>
        Etat : <?php echo $libEtat ?> depuis le <?php echo $dateModif?> <br>
    </p>
  	<table class="listeLegere">
  	   <caption>Eléments forfaitisés </caption>
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
        <!-- lien pour modification des elements -->
        <a href="index.php?uc=validerFrais&action=modifier&idVisiteur=<?php echo $visiteurASelectionner ?>&mois=<?php echo $moisASelectionner ?>">Modifier</a>
        
        
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
			$date = $unFraisHorsForfait['date'];
			$libelle = $unFraisHorsForfait['libelle'];
			$montant = $unFraisHorsForfait['montant'];
		?>
             <tr>
                <td><?php echo $date ?></td>
                <td><?php echo $libelle ?></td>
                <td><?php echo $montant ?></td>
                <!-- ajout du lien de report -->
                <td><a href="index.php?uc=validerFrais&action=reporter&idFraisHorsForfait=<?php echo $unFraisHorsForfait['id'] ?>">Reporter</a></td>
                <!-- ajout du lien de suppression -->
                <td><a href="index.php?uc=validerFrais&action=supprimer&idFraisHorsForfait=<?php echo $unFraisHorsForfait['id'] ?>&idVisiteur=<?php echo $visiteurASelectionner ?>&mois=<?php echo $moisASelectionner ?>">Refuser</a></td>
             </tr>
        <?php 
          }
		?>
    </table>
  </div>
  </div>