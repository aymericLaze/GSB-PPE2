<?php

include("vues/v_sommaireComptable.php");
$mois = getMois(date("d/m/Y"));
$numAnnee = substr($mois, 0, 4);
$numMois = substr($mois, 4, 2);
$action = $_REQUEST['action'];
switch ($action) {
    //choisir mois
    case 'choisirMois':
        //affichage selection du mois
        $lesMois = $pdo->getLesMoisEnAttente();
        include 'vues/v_listeMoisComptable.php';
        break;
    
    //choisir visiteur (affichage select mois)
    case 'voirVisiteurFrais':
        //recuperation leMois
        $moisASelectionner = $_REQUEST['lstMois'];
        
        //affichage selection du mois
        $lesMois = $pdo->getLesMoisEnAttente();
        include("vues/v_listeMoisComptable.php");
        
        //affichage selection de l'utilisateur
        $lesVisiteurs = $pdo->getLesVisiteursAValider($leMois);
        include 'vues/v_listeVisiteur.php';
        break;
    
    //affichage fiche de frais (affichage select mois/visiteur)
    case 'voirFicheFrais':
        //recuperation leMois et leVisiteur
        $moisASelectionner = $_REQUEST["mois"];
        $visiteurASelectionner = $_REQUEST['lstVisiteur'];
        
        //affichage selection du mois
        $lesMois = $pdo->getLesMoisEnAttente();
        include("vues/v_listeMoisComptable.php");
        
        //affichage selection du visiteur
        $lesVisiteurs = $pdo->getLesVisiteursAValider($moisASelectionner);
        include 'vues/v_listeVisiteur.php';

        
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

