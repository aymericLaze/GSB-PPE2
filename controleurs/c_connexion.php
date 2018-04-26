<?php
if(!isset($_REQUEST['action'])){
	$_REQUEST['action'] = 'demandeConnexion';
}
$action = $_REQUEST['action'];
switch($action){
	case 'demandeConnexion':{
		include("vues/commun/v_connexion.php");
		break;
	}
	case 'valideConnexion':{
		$login = $_REQUEST['login'];
		$mdp = $_REQUEST['mdp'];
                //chiffrage du mot de passe
                //$mdp = hash("sha512", $mdp);
		$visiteur = $pdo->getInfosVisiteur($login,$mdp);
		if(!is_array( $visiteur)){
			ajouterErreur("Login ou mot de passe incorrect");
			include("vues/commun/v_erreurs.php");
			include("vues/commun/v_connexion.php");
		}
		else{
			$id = $visiteur['id'];
			$nom =  $visiteur['nom'];
			$prenom = $visiteur['prenom'];
                        $fonction = $visiteur['fonction'];
			connecter($id,$nom,$prenom,$fonction);
                        
                        if($_SESSION['fonction'] === 'visiteur')
                        {
                            include("vues/visiteur/v_sommaire.php");
                        }
                        else
                        {
                            include("vues/comptable/v_sommaireComptable.php");
                        }
                        include ("vues/commun/v_accueilUtilisateur.php");
                        
		}
		break;
	}
        case 'deconnexion' :{
                deconnecter();
		include("vues/commun/v_connexion.php");
		break;
	}
}
?>