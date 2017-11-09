<?php
/**
 * Vue pour sélectionner une fiche en cours de payement
 * 
 * La valeur du select est la concatenation de l'idVisiteur et du mois avec un "/"
 * 
 * @author LAZE Aymeric
 */

if ($nbFiche != 0){
?>
<div id="contenu">
    <h2>Fiches de frais</h2>
    <h3>Fiche à sélectionner : </h3>
    <form action="index.php?uc=selectionnerFicheFrais&action=voirFicheFraisAPayer" method="post">
        <div class="corpsForm">
            <p>
                <label for="lstMois" accesskey="n">Fiches : </label>
                
                <!-- liste déroulante des fiches en payement -->
                <select id="listMois" name="lstFiche" onchange="submit();">
                    <option selected value=0>Choisir un visiteur</option>
                    <?php
                    foreach ($lesFicheEnPayement as $uneFiche) {
                        $visiteur = $uneFiche['visiteur'];
                        $mois = $uneFiche['mois'];
                        $identite = $uneFiche['identite'];
                        $numAnnee = $uneFiche['numAnnee'];
                        $numMois = $uneFiche['numMois'];

                        //affichage du choix fait precedement
                        if($moisASelectionner == $mois && $visiteurASelectionner == $visiteur) {
                    ?>
                            <option selected value="<?php echo $visiteur. "/" .$mois ?>"><?php echo $numMois . "/" . $numAnnee." - ". $identite ?> </option>
                    <?php
                        } else {
                    ?>
                            <option value="<?php echo $visiteur. "/" .$mois ?>"><?php echo $numMois . "/" . $numAnnee." - ". $identite ?> </option>
                    <?php
                        }
                    }
                    ?>    
                </select>
                
            </p>
        </div>
    </form>
    
<?php
} else {
?>
    <!-- affichage message d'erreur si aucune fiche en cours de payement n'est disponible -->  
    <h3>Aucune fiche en cours de payement</h3>
<?php
}
?>