<?php
/**
 * Contrôleur pour choisir quelle fiche de frais afficher
 * 
 * choisirMois : Sélection du mois
 * choisirVisiteur : Sélection du visiteur
 * voirFicheFrais : Affichage de la fiche de frais
 * 
 * @author MAINENTI Eugène
 * @author LAZE Aymeric
 */


//affichage du sommaire sur la page
include("vues/v_sommaireComptable.php");

$action = $_REQUEST['action'];

switch ($action) {
    case 'choisirMois':{
        
        //suppresion des sessions leMois leVisiteur
        unset($_SESSION['leMois']);
        unset($_SESSION['leVisiteur']);
        
        //affichage selection du mois
        $lesMois = $pdo->getLesMoisEnAttente();
        include("vues/v_listeMoisComptable.php");
        break;
    }
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
    case 'voirFicheFrais':{
        
        //recuperation leVisiteur et nom prenom en variable de session
        if(isset($_REQUEST['lstVisiteur'])){
            $_SESSION['leVisiteur'] = $_REQUEST['lstVisiteur'];
            $infosVisiteur = $pdo->getNomPrenomVisiteur($_SESSION['leVisiteur']);
            $_SESSION['leNom'] = $infosVisiteur['nom'];
            $_SESSION['lePrenom'] = $infosVisiteur['prenom'];
        }
        
        //declaration - initialisation
        $moisASelectionner = $_SESSION['leMois'];
        $visiteurASelectionner = $_SESSION['leVisiteur'];
        $nomVisiteur = $_SESSION['leNom'];
        $prenomVisiteur = $_SESSION['lePrenom'];
        
        //affichage selection du mois
        $lesMois = $pdo->getLesMoisEnAttente();
        include("vues/v_listeMoisComptable.php");
        
        //affichage selection du visiteur
        $lesVisiteurs = $pdo->getLesVisiteursAValider($moisASelectionner);
        include("vues/v_listeVisiteur.php");

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
        
        include("vues/v_ficheFraisComptable.php");
        break;
    }
}