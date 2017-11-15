<?php
//recuperation des fichiers inc
require_once("include/fct.inc.php");
require_once ("include/class.pdogsb.inc.php");

session_start();
$pdo = PdoGsb::getPdoGsb();
$estConnecte = estConnecte();
if(!isset($_REQUEST['uc']) || !$estConnecte){
     $_REQUEST['uc'] = 'connexion';
}	 
$uc = $_REQUEST['uc'];

//verification si action existe et recuperation
$actionEstExistant = isset($_REQUEST['action']);
if(!$actionEstExistant) {
    $action = 'default';
} else {
    $action = $_REQUEST['action'];
}

//inclusion entete
if($action != 'pdf-payement') {
    include("vues/commun/v_entete.php") ;
}

switch($uc){
	case 'connexion':{
		include("controleurs/c_connexion.php");break;
	}
	case 'gererFrais' :{
		include("controleurs/c_gererFrais.php");break;
	}
	case 'etatFrais' :{
		include("controleurs/c_etatFrais.php");break; 
	}
        case 'selectionnerFicheFrais':{
            include("controleurs/c_selectionnerFicheFrais.php");
            break;
        }
        case 'actionFicheFrais':{
            include("controleurs/c_actionFicheFrais.php");
            break;
        }
}

//inclusion pied
if($action != 'pdf-payement') {
    include("vues/commun/v_pied.php") ;
}
?>