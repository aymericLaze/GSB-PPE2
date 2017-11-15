<?php
/**
 * fichier d'inclusion de fonctions
 * 
 * fichier regroupant les fonctions ayant du etre cree au cours des differentes
 * missions
 * 
 * @author MAINENTI Eugène
 * @author LAZE Aymeric
 */


/**
 * Retourne le mois augmente d'un sous la forme aaaamm
 * 
 * @param str $mois sous forme aaaamm
 * @return str $nouveauMois sous la forme aaaamm augmenté d'un, l'annee peut augmenter en consequence
 * 
 * @author Aymeric Laze
 */
function incrementerMois($mois)
{    
    //scindage et transtypage de $mois 
    $numAnnee = (int) substr($mois, 0, 4);
    $numMois = (int) substr($mois, 4, 2);
    
    //test si passage d'annee ou si nescessaire d'ajouter un 0
    if($numMois == 12)
    {
        $numAnnee++;
        $nouveauMois = $numAnnee."01";
    }
    else if($numMois < 9)
    {
        $numMois++;
        $nouveauMois = $numAnnee."0".$numMois;
    }
    else
    {
        $numMois++;
        $nouveauMois = $numAnnee."".$numMois;
    }
    
    return $nouveauMois;
}

/**
 * retourne le nom du mois textuelle
 * 
 * @param str $numMois
 * @return string
 * 
 * @author LAZE Aymeric
 */
function getMoisTextuelle($numMois) {
    $listMois = array(  '01'=>'Janvier',
                        '02'=>'Février',
                        '03'=>'Mars',
                        '04'=>'Avril',
                        '05'=>'Mai',
                        '06'=>'Juin',
                        '07'=>'Juillet',
                        '08'=>'Août',
                        '09'=>'Septembre',
                        '10'=>'Octobre',
                        '11'=>'Novembre',
                        '12'=>'Decembre'
                    );
    
    return $listMois[$numMois];
}

/**
 * recuperation des infos de la fiche selectionner
 * 
 * supppression de redondance dans le code, pour gain de temps, avec une fonction
 * unique et passage de certains parametres par reference pour retourner plusieurs
 * resultats
 * 
 * @param str $visiteur
 * @param str $mois
 * @param array $fraisHorsForfait
 * @param array $fraisForfait
 * @param array $infosFiche
 * @param int $numAnnee
 * @param int $numMois
 * @param Pdogsb $pdo
 * 
 * @author LAZE Aymeric
 */
function getLaFiche($visiteur, $mois, &$fraisHorsForfait, &$fraisForfait, &$infosFiche, &$numAnnee, &$numMois, &$pdo) {
    $fraisHorsForfait = $pdo->getLesFraisHorsForfait($visiteur, $mois);
    $fraisForfait = $pdo->getLesFraisForfait($visiteur, $mois);
    $infosFiche = $pdo->getLesInfosFicheFrais($visiteur, $mois);
    $numAnnee = substr($mois, 0, 4);
    $numMois = substr($mois, 4, 2);
}
?>