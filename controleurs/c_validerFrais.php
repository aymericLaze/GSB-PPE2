<?php

include("vues/v_sommaireComptable.php");
$mois = getMois(date("d/m/Y"));
$numAnnee = substr($mois, 0, 4);
$numMois = substr($mois, 4, 2);
$action = $_REQUEST['action'];
switch ($action) {
    case 'choisirMois':
        $lesMois = $pdo->getLesMoisEnAttente();
        include 'vues/v_listeMoisComptable.php';
        break;
    case 'voirVisiteurFrais':
        $leMois = $_REQUEST['lstMois'];
        $lesMois = $pdo->getLesMoisEnAttente();
        include("vues/v_listeMoisComptable.php");
        $lesVisiteurs = $pdo->getLesVisiteursAValider($leMois);
        include 'vues/v_listeVisiteur.php';
        break;
    case 'voirFicheFrais':
        $leMois = $_REQUEST["mois"];
        $lesMois = $pdo->getLesMoisEnAttente();
        
        include("vues/v_listeMoisComptable.php");
        
        $lesVisiteurs = $pdo->getLesVisiteursAValider($leMois);
        
        include 'vues/v_listeVisiteur.php';

        $leVisiteur = $_REQUEST['lstVisiteur'];
        $lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($leVisiteur, $leMois);
        $lesFraisForfait = $pdo->getLesFraisForfait($leVisiteur, $leMois);
        $lesInfosFicheFrais = $pdo->getLesInfosFicheFrais($leVisiteur, $leMois);
        $numAnnee = substr($leMois, 0, 4);
        $numMois = substr($leMois, 4, 2);
        $libEtat = $lesInfosFicheFrais['libEtat'];
        $montantValide = $lesInfosFicheFrais['montantValide'];
        $nbJustificatifs = $lesInfosFicheFrais['nbJustificatifs'];
        $dateModif = $lesInfosFicheFrais['dateModif'];
        $dateModif = dateAnglaisVersFrancais($dateModif);
        
        include 'vues/v_validation.php';
        break;
}

