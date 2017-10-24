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
    <form action="" method="post">
        <div class="corpsForm">
            <p>
                <label for="lstMois" accesskey="n">Fiches : </label>
                
                <!-- liste déroulante des fiches en payement -->
                <select id="listMois" name="lstFiche">
                    <?php
                    foreach ($lesFicheEnPayement as $uneFiche) {
                        $visiteur = $uneFiche['visiteur'];
                        $mois = $uneFiche['mois'];
                        $identite = $uneFiche['identite'];
                        $numAnnee = $uneFiche['numAnnee'];
                        $numMois = $uneFiche['numMois'];
                    ?>
                            <option value="<?php echo $visiteur. "/" .$mois ?>"><?php echo $numMois . "/" . $numAnnee." - ". $identite ?> </option>
                    <?php
                    }
                    ?>    
                </select>
                
            </p>
        </div>
        
        <!-- pied de la page pour validation -->
        <div class="piedForm">    
            <p>
                <input id="ok" type="submit" value="Valider" size="20" />
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