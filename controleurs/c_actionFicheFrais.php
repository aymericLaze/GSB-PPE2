<?php
/**
 * Contrôleur pour agir sur la fiche de frais
 * 
 * modifier : Modification du nombre de justificatifs et de frais forfait
 * validerFiche : Confirmation de la validation de la fiche
 * appliquerModification : Applique les modifications de modifier
 * reporter : Report d'un frais hors forfait au mois dernier mois au statut CR
 * refuser : Refuse le frais hors forfait
 * 
 * @author MAINENTI Eugène
 * @author LAZE Aymeric
 */

$action = $_REQUEST['action'];

//affichage du sommaire sur la page
if($action != 'pdf-payement') {
    include("vues/v_sommaireComptable.php");
}

switch ($action) {
    case 'modifier':{
        
        //declaration - initialisation
        $moisASelectionner = $_SESSION['leMois'];
        $visiteurASelectionner = $_SESSION['leVisiteur'];
        
        //recuperation du nombre de justificatifs
        $nbJustificatifs = $pdo->getNbJustificatifs($visiteurASelectionner, $moisASelectionner);
        //recuperation des frais forfait
        $lesFraisForfait = $pdo->getLesFraisForfait($visiteurASelectionner, $moisASelectionner);

        include("vues/v_modificationFraisForfait.php");
        break;
    }
    case 'validerFiche':{
        
        //declaration - initialisation
        $moisASelectionner = $_SESSION['leMois'];
        $visiteurASelectionner = $_SESSION['leVisiteur'];
        $nomVisiteur = $_SESSION['leNom'];
        $prenomVisiteur = $_SESSION['lePrenom'];
        
        $numAnnee = substr($moisASelectionner, 0, 4);
        $numMois = substr($moisASelectionner, 4, 2);
        
        //validation
        $pdo->majEtatFicheFrais($visiteurASelectionner,$moisASelectionner,"VA");
        
        //vue affichage de la confirmation de la validation
        include("vues/v_confirmationValidation.php");
        break;
    }
    case 'appliquerModification':{
        
        //recuperation des variables post
        $lesFrais = $_REQUEST['txtLesFrais'];
        $nbJustificatifs = $_REQUEST['txtNbJustificatifs'];
        
        //declaration - initialisation
        $moisASelectionner = $_SESSION['leMois'];
        $visiteurASelectionner = $_SESSION['leVisiteur'];
        
        //verification de valeur valide puis mise a jour
        if(lesQteFraisValides($lesFrais)){
            $pdo->majFraisForfait($visiteurASelectionner,$moisASelectionner,$lesFrais);
            $pdo->majNbJustificatifs($visiteurASelectionner,$moisASelectionner,$nbJustificatifs);
        }
        
        //redirection
        header('Location: index.php?uc=selectionnerFicheFrais&action=voirFicheFrais');
        break;
    }
    case 'reporter':{
        
        //recuperation des variables post
        $idFraisHorsForfait = $_REQUEST['hdIdFraisHorsForfait'];
        
        //declaration - initialisation
        $moisASelectionner = $_SESSION['leMois'];
        $visiteurASelectionner = $_SESSION['leVisiteur'];
        
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
        header('Location: index.php?uc=selectionnerFicheFrais&action=voirFicheFrais');
        break;
    }
    case 'refuser':{
        //récuperation des variables
        $idFraisHorsForfait=$_REQUEST['hdIdFraisHorsForfait'];
        
        //declaration - initialisation
        $moisASelectionner = $_SESSION['leMois'];
        $visiteurASelectionner = $_SESSION['leVisiteur'];
        
        //fonction refuserFraisHorsForfait
        $pdo->refuserFraisHorsForfait($idFraisHorsForfait);
        
         //redirection
        header('Location: index.php?uc=selectionnerFicheFrais&action=voirFicheFrais');
        break;
    }
    
    case 'pdf-payement':{
        //recuperation des variables
        $lstFiche = $_REQUEST['idFiche'];
        
        break;
    }
}

