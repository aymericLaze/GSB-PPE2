<?php
/**
 * Contrôleur pour choisir quelle fiche de frais afficher
 * 
 * @author MAINENTI Eugène
 * @author LAZE Aymeric
 */


//affichage du sommaire sur la page
include("vues/v_sommaireComptable.php");

$action = $_REQUEST['action'];

switch ($action) {
    //choisir mois
    case 'choisirMois':{
        
        //suppresion des sessions leMois leVisiteur
        unset($_SESSION['leMois']);
        unset($_SESSION['leVisiteur']);
        
        //affichage selection du mois
        $lesMois = $pdo->getLesMoisEnAttente();
        include 'vues/v_listeMoisComptable.php';
        break;
    }
    //choisir visiteur (affichage select mois)
    case 'choisirVisiteur':{
        
        //recuperation leMois en variable de session
        $_SESSION['leMois'] = $_REQUEST['lstMois'];
        
        //declaration - initialisation
        $moisASelectionner = $_SESSION['leMois'];
        
        //affichage selection du mois
        $lesMois = $pdo->getLesMoisEnAttente();
        include("vues/v_listeMoisComptable.php");
        
        //affichage selection de l'utilisateur
        $lesVisiteurs = $pdo->getLesVisiteursAValider($moisASelectionner);
        include("vues/v_listeVisiteur.php");
        break;
    }
    //affichage fiche de frais (affichage select mois/visiteur)
    case 'voirFicheFrais':{
        
        //recuperation leVisiteur en variable de session
        if(isset($_REQUEST['lstVisiteur'])){
            $_SESSION['leVisiteur'] = $_REQUEST['lstVisiteur'];
        }
        
        //declaration - initialisation
        $moisASelectionner = $_SESSION['leMois'];
        $visiteurASelectionner = $_SESSION['leVisiteur'];
        
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
        
        include 'vues/v_ficheFraisComptable.php';
        break;
    }
}