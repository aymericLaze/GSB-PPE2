<?php
/**
 * Vue pour sélectionner les visiteurs ayant des fiches de frais à l'état 'CL'
 * 
 * @author MAINENTI Eugène
 */
?>

<h3>Visiteur à sélectionner : </h3>
    <form action="index.php?uc=selectionnerFicheFrais&action=voirFicheFrais" method="post">
        <div class="corpsForm">

            <p>

                <label for="lstVisiteur" accesskey="n">Mois : </label>
                <select id="listVisiteur" name="lstVisiteur">
                    <?php
                    foreach ($lesVisiteurs as $unVisiteur) {
                        $idVisiteur = $unVisiteur['idVisiteur'];
                        $nom = $unVisiteur['nom'];
                        $prenom = $unVisiteur['prenom'];
                        if ($idVisiteur == $visiteurASelectionner) {
                            ?>
                            <option selected value="<?php echo $idVisiteur ?>"><?php echo $nom . "/" . $prenom ?> </option>
                            <?php
                        } else {
                            ?>
                            <option value="<?php echo $idVisiteur ?>"><?php echo $nom . "/" . $prenom ?> </option>
                            <?php
                        }
                    }
                    ?>    

                </select>
            </p>
        </div>
        <div class="piedForm">    
            <p>
                <input id="ok" type="submit" value="Valider" size="20" />
                <input id="annuler" type="reset" value="Effacer" size="20" />
            </p> 
        </div>

    </form>

