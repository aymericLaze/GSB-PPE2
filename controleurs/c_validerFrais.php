<?php

//affichage du sommaire sur la page
include("vues/v_sommaireComptable.php");

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
    
    //afficahge modification des frais forfait
    case 'modifier':
        
        //recuperation leMois et leVisiteur
        $moisASelectionner = $_REQUEST["mois"];
        $visiteurASelectionner = $_REQUEST['idVisiteur'];
        
        //recuperation du nombre de justificatifs
        $nbJustificatifs = $pdo->getNbJustificatifs($visiteurASelectionner, $moisASelectionner);
        //recuperation des frais forfait
        $lesFraisForfait = $pdo->getLesFraisForfait($visiteurASelectionner, $moisASelectionner);

        include 'vues/v_modificationFraisForfait.php';
        break;
    
    //modifie les quantites de frais forfait et retourne sur l'affichage des fiches NOUVEAU CONTROLEUR
    case 'appliquerModification':
        
        //recuperation des variables post
        $moisASelectionner = $_REQUEST['leMois'];
        $visiteurASelectionner = $_REQUEST['leVisiteur'];
        $lesFrais = $_REQUEST['lesFrais'];
        $nbJustificatifs = $_REQUEST['nbJustificatifs'];
        
        //verification de valeur valide puis mise a jour
        if(lesQteFraisValides($lesFrais)){
            $pdo->majFraisForfait($visiteurASelectionner,$moisASelectionner,$lesFrais);
            $pdo->majNbJustificatifs($visiteurASelectionner,$moisASelectionner,$nbJustificatifs);
        }
        
        //redirection
        header('Location: index.php?uc=validerFrais&action=voirFicheFrais&lstVisiteur='.$visiteurASelectionner.'&mois='.$moisASelectionner);
        break;
        
    //reporte le frais hors forfait au mois suivant
    case 'reporter':
        
        //recuperation des variables post
        $idFraisHorsForfait = $_REQUEST['idFraisHorsForfait'];
        $moisASelectionner = $_REQUEST['mois'];
        $visiteurASelectionner = $_REQUEST['idVisiteur'];
        
        //recuperation date du dernier mois saisi
        $dernierMois = $pdo->dernierMoisSaisi($visiteurASelectionner);
        
        //verification que le frais est dans le dernier mois de saisi
        if($moisASelectionner == $dernierMois)
        {
            $dernierMois = incrementerMois($moisASelectionner);
            $pdo->creeNouvellesLignesFrais($visiteurASelectionner, $dernierMois);
            $pdo->reportDUnFraisHorsForfait($idFraisHorsForfait,$dernierMois);
        }
        else
        {
            $pdo->reportDUnFraisHorsForfait($idFraisHorsForfait,$dernierMois);
        }
        
        //redirection
        header('Location: index.php?uc=validerFrais&action=voirFicheFrais&lstVisiteur='.$visiteurASelectionner.'&mois='.$moisASelectionner);
        break;
        
    //validation de la fiche de frais
    case 'validerFiche' :
        
        //recuperation des variables post
        $moisASelectionner = $_REQUEST['mois'];
        $visiteurASelectionner = $_REQUEST['idVisiteur'];
        $numAnnee = substr($moisASelectionner, 0, 4);
        $numMois = substr($moisASelectionner, 4, 2);
        
        //TEST
        echo "Page de validation";
        
        //validation
        // $pdo->majEtatFicheFrais($moisASelectionner,$visiteurASelectionner,"VA"); A DECOMMENTER
        
        //vue :
        include 'vues/v_confirmationValidation.php';
        
        break;
    
    //refuser un frais
    case 'refuser':
        //récuperation des variables
        $idFraisHorsForfait=$_REQUEST['idFraisHorsForfait'];
        $moisASelectionner = $_REQUEST['mois'];
        $visiteurASelectionner = $_REQUEST['idVisiteur'];
        
        //fonction refuserFraisHorsForfait
        $pdo->refuserFraisHorsForfait($idFraisHorsForfait);
        
         //redirection
        header('Location: index.php?uc=validerFrais&action=voirFicheFrais&lstVisiteur='.$visiteurASelectionner.'&mois='.$moisASelectionner);
        break;
        
        
    
}

