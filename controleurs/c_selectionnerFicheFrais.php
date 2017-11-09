<?php
/**
 * Contrôleur pour choisir quelle fiche de frais afficher
 * 
 * choisirMois : Sélection du mois avec frais non validé (CL)
 * choisirVisiteur : Sélection du visiteur avec frais non validé (CL)
 * voirFicheFrais : Affichage de la fiche de frais non validé (CL)
 * choisirFicheSuiviPayement : Sélection des mois avec frais en payement (VA)
 * 
 * @author MAINENTI Eugène
 * @author LAZE Aymeric
 */


//affichage du sommaire sur la page
include("vues/comptable/v_sommaireComptable.php");

$action = $_REQUEST['action'];

switch ($action) {
    case 'accueil':{
        include ("vues/commun/v_accueilUtilisateur.php");
        break;
    }
    case 'choisirMois':{
        
        //suppresion des sessions leMois leVisiteur
        unset($_SESSION['leMois']);
        unset($_SESSION['leVisiteur']);
        
        //affichage selection du mois
        $lesMois = $pdo->getLesMoisEnAttente();
        $nbMois=count($lesMois);
        include("vues/comptable/v_listeMoisComptable.php");
        break;
    }
    case 'choisirVisiteur':{
        
        //recuperation leMois en variable de session
        $_SESSION['leMois'] = $_REQUEST['lstMois'];
        
        //declaration - initialisation
        $moisASelectionner = $_SESSION['leMois'];
        
        //affichage selection du mois
        $lesMois = $pdo->getLesMoisEnAttente();
        $nbMois=count($lesMois);
        include("vues/comptable/v_listeMoisComptable.php");
        
        //affichage selection de l'utilisateur
        $lesVisiteurs = $pdo->getLesVisiteursAValider($moisASelectionner);
        include("vues/comptable/v_listeVisiteur.php");
        break;
    }
    case 'voirFicheFraisAValider':{
        
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
        $nbMois=count($lesMois);
        include("vues/comptable/v_listeMoisComptable.php");
        
        //affichage selection du visiteur
        $lesVisiteurs = $pdo->getLesVisiteursAValider($moisASelectionner);
        include("vues/comptable/v_listeVisiteur.php");

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
        
        $prixKm=intval($pdo->calculerKilometrique($visiteurASelectionner));
        include("vues/comptable/v_ficheFraisComptable.php");
        break;
    }
    case 'choisirFicheSuiviPayement':{
    
        //recuperation des infos
        $lesFicheEnPayement = $pdo->getInfoFichesEnPayement();
        $nbFiche = count($lesFicheEnPayement);
        
        
        //inclusion de la vue de selection
        include("vues/comptable/v_selectionFichesEnPayement.php");
        break;
    }
    
    case 'voirFicheFraisAPayer':{
        
        //recuperation des variables
        $lstFiche = $_REQUEST['lstFiche'];
        
        //separation de l'id et de la date de la fiche
        $selection = explode('/', $lstFiche);
        $visiteurASelectionner = $selection[0];
        $moisASelectionner = $selection[1];
        
        //récupération du nom et prénom du visiteur correspondant
        $infosVisiteur = $pdo->getNomPrenomVisiteur($visiteurASelectionner);
        $nomVisiteur = $infosVisiteur['nom'];
        $prenomVisiteur = $infosVisiteur['prenom'];
        
        //recuperation des infos de la fiche de frais
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
        
        //inclusion de la vue de selection
        $lesFicheEnPayement = $pdo->getInfoFichesEnPayement();
        $nbFiche = count($lesFicheEnPayement);
        include("vues/comptable/v_selectionFichesEnPayement.php");

        $prixKm=intval($pdo->calculerKilometrique($visiteurASelectionner));
        //inclusion de la vue de la fiche a valider le payement
        include ("vues/comptable/v_afficherFichesEnPayement.php");
        
        break;
    }
}