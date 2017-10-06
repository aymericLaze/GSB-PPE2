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
        echo $moisASelectionner;
        
        //affichage selection du mois
        $lesMois = $pdo->getLesMoisEnAttente();
        include("vues/v_listeMoisComptable.php");
        
        //affichage selection de l'utilisateur
        $lesVisiteurs = $pdo->getLesVisiteursAValider($moisASelectionner);
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

        //affichage de la fiche de frais
        $lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($visiteurASelectionner, $moisASelectionner);
        $lesFraisForfait = $pdo->getLesFraisForfait($visiteurASelectionner, $moisASelectionner);
        $lesInfosFicheFrais = $pdo->getLesInfosFicheFrais($visiteurASelectionner, $moisASelectionner);
        $numAnnee = substr($moisASelectionner, 0, 4);
        $numMois = substr($moisASelectionner, 4, 2);
        $libEtat = $lesInfosFicheFrais['libEtat'];
        $montantValide = $lesInfosFicheFrais['montantValide'];
        $nbJustificatifs = $lesInfosFicheFrais['nbJustificatifs'];
        $dateModif = $lesInfosFicheFrais['dateModif'];
        $dateModif = dateAnglaisVersFrancais($dateModif);
        
        include 'vues/v_validation.php';
        break;
}

