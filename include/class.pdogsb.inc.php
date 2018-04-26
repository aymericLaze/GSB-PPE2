﻿<?php
/** 
 * Classe d'accès aux données. 
 
 * Utilise les services de la classe PDO
 * pour l'application GSB
 * Les attributs sont tous statiques,
 * les 4 premiers pour la connexion
 * $monPdo de type PDO 
 * $monPdoGsb qui contiendra l'unique instance de la classe
 
 * @package default
 * @author Cheri Bibi
 * @version    1.0
 * @link       http://www.php.net/manual/fr/book.pdo.php
 */

class PdoGsb {   		
      	private static $serveur='mysql:host=localhost';
      	private static $bdd='dbname=gsbFrais2';   		
      	private static $user='root' ;    		
      	private static $mdp='' ;	
		private static $monPdo;
		private static $monPdoGsb=null;
/**
 * Constructeur privé, crée l'instance de PDO qui sera sollicitée
 * pour toutes les méthodes de la classe
 */				
	private function __construct(){
    	PdoGsb::$monPdo = new PDO(PdoGsb::$serveur.';'.PdoGsb::$bdd, PdoGsb::$user, PdoGsb::$mdp); 
		PdoGsb::$monPdo->query("SET CHARACTER SET utf8");
	}
	public function _destruct(){
		PdoGsb::$monPdo = null;
	}
/**
 * Fonction statique qui crée l'unique instance de la classe
 
 * Appel : $instancePdoGsb = PdoGsb::getPdoGsb();
 
 * @return l'unique objet de la classe PdoGsb
 */
	public  static function getPdoGsb(){
		if(PdoGsb::$monPdoGsb==null){
			PdoGsb::$monPdoGsb= new PdoGsb();
		}
		return PdoGsb::$monPdoGsb;  
	}
/**
 * Retourne les informations d'un utilisateur
 
 * @param $login 
 * @param $mdp
 * @return l'id, le nom et le prénom sous la forme d'un tableau associatif 
*/
	public function getInfosVisiteur($login, $mdp){
		$req = "select utilisateur.id as id, utilisateur.nom as nom, utilisateur.prenom as prenom, utilisateur.fonction as fonction from utilisateur 
		where utilisateur.login='$login' and utilisateur.mdp='$mdp'";
		$rs = PdoGsb::$monPdo->query($req);
		$ligne = $rs->fetch();
		return $ligne;
	}

/**
 * Retourne sous forme d'un tableau associatif toutes les lignes de frais hors forfait
 * concernées par les deux arguments
 
 * La boucle foreach ne peut être utilisée ici car on procède
 * à une modification de la structure itérée - transformation du champ date-
 
 * @param $idVisiteur 
 * @param $mois sous la forme aaaamm
 * @return tous les champs des lignes de frais hors forfait sous la forme d'un tableau associatif 
*/
	public function getLesFraisHorsForfait($idVisiteur,$mois){
	    $req = "select * from lignefraishorsforfait where lignefraishorsforfait.idUtilisateur ='$idVisiteur' 
		and lignefraishorsforfait.mois = '$mois' ";	
		$res = PdoGsb::$monPdo->query($req);
		$lesLignes = $res->fetchAll();
		$nbLignes = count($lesLignes);
		for ($i=0; $i<$nbLignes; $i++){
			$date = $lesLignes[$i]['date'];
			$lesLignes[$i]['date'] =  dateAnglaisVersFrancais($date);
		}
		return $lesLignes; 
	}
 
/**
 * Retourne le nombre de justificatif d'un utilisateur pour un mois donné
 
 * @param $idVisiteur 
 * @param $mois sous la forme aaaamm
 * @return le nombre entier de justificatifs 
*/
	public function getNbJustificatifs($idVisiteur, $mois){
		$req = "select fichefrais.nbjustificatifs as nb from  fichefrais where fichefrais.idUtilisateur ='$idVisiteur' and fichefrais.mois = '$mois'";
		$res = PdoGsb::$monPdo->query($req);
		$laLigne = $res->fetch();
		return $laLigne['nb'];
	}
/**
 * Retourne sous forme d'un tableau associatif toutes les lignes de frais au forfait
 * concernées par les deux arguments
 
 * @param $idVisiteur 
 * @param $mois sous la forme aaaamm
 * @return l'id, le libelle, la quantité et les montants sous la forme d'un tableau associatif 
*/
	public function getLesFraisForfait($idVisiteur, $mois){
		$req = "select fraisforfait.id as idfrais, "
                            . "fraisforfait.libelle as libelle, "
                            . "lignefraisforfait.quantite as quantite, "
                            . "fraisforfait.montant as montant "
                        . "from lignefraisforfait inner join fraisforfait on fraisforfait.id = lignefraisforfait.idfraisforfait "
                        . "where lignefraisforfait.idUtilisateur ='$idVisiteur' and lignefraisforfait.mois='$mois' "
                        . "order by lignefraisforfait.idfraisforfait";
		$res = PdoGsb::$monPdo->query($req);
		$lesLignes = $res->fetchAll();
		return $lesLignes; 
	}
/**
 * Retourne tous les id de la table FraisForfait
 
 * @return un tableau associatif 
*/
	public function getLesIdFrais(){
		$req = "select fraisforfait.id as idfrais from fraisforfait order by fraisforfait.id";
		$res = PdoGsb::$monPdo->query($req);
		$lesLignes = $res->fetchAll();
		return $lesLignes;
	}
/**
 * Met à jour la table ligneFraisForfait
 
 * Met à jour la table ligneFraisForfait pour un utilisateur et
 * un mois donné en enregistrant les nouveaux montants
 
 * @param $idVisiteur 
 * @param $mois sous la forme aaaamm
 * @param $lesFrais tableau associatif de clé idFrais et de valeur la quantité pour ce frais
 * @return un tableau associatif 
*/
	public function majFraisForfait($idVisiteur, $mois, $lesFrais){
		$lesCles = array_keys($lesFrais);
		foreach($lesCles as $unIdFrais){
			$qte = $lesFrais[$unIdFrais];
			$req = "update lignefraisforfait set lignefraisforfait.quantite = $qte
			where lignefraisforfait.idUtilisateur = '$idVisiteur' and lignefraisforfait.mois = '$mois'
			and lignefraisforfait.idfraisforfait = '$unIdFrais'";
			PdoGsb::$monPdo->exec($req);
		}
		
	}
/**
 * met à jour le nombre de justificatifs de la table ficheFrais
 * pour le mois et le utilisateur concerné
 
 * @param $idVisiteur 
 * @param $mois sous la forme aaaamm
*/
	public function majNbJustificatifs($idVisiteur, $mois, $nbJustificatifs){
		$req = "update fichefrais set nbjustificatifs = $nbJustificatifs 
		where fichefrais.idUtilisateur = '$idVisiteur' and fichefrais.mois = '$mois'";
		PdoGsb::$monPdo->exec($req);	
	}
/**
 * Teste si un utilisateur possède une fiche de frais pour le mois passé en argument
 
 * @param $idVisiteur 
 * @param $mois sous la forme aaaamm
 * @return vrai ou faux 
*/	
	public function estPremierFraisMois($idVisiteur,$mois)
	{
		$ok = false;
		$req = "select count(*) as nblignesfrais from fichefrais 
		where fichefrais.mois = '$mois' and fichefrais.idUtilisateur = '$idVisiteur'";
		$res = PdoGsb::$monPdo->query($req);
		$laLigne = $res->fetch();
		if($laLigne['nblignesfrais'] == 0){
			$ok = true;
		}
		return $ok;
	}
/**
 * Retourne le dernier mois en cours d'un utilisateur
 
 * @param $idVisiteur 
 * @return le mois sous la forme aaaamm
*/	
	public function dernierMoisSaisi($idVisiteur){
		$req = "select max(mois) as dernierMois from fichefrais where fichefrais.idUtilisateur = '$idVisiteur'";
		$res = PdoGsb::$monPdo->query($req);
		$laLigne = $res->fetch();
		$dernierMois = $laLigne['dernierMois'];
		return $dernierMois;
	}
	
/**
 * Crée une nouvelle fiche de frais et les lignes de frais au forfait pour un utilisateur et un mois donnés
 
 * récupère le dernier mois en cours de traitement, met à 'CL' son champs idEtat, crée une nouvelle fiche de frais
 * avec un idEtat à 'CR' et crée les lignes de frais forfait de quantités nulles 
 * @param $idVisiteur 
 * @param $mois sous la forme aaaamm
*/
	public function creeNouvellesLignesFrais($idVisiteur,$mois){
		$dernierMois = $this->dernierMoisSaisi($idVisiteur);
		$laDerniereFiche = $this->getLesInfosFicheFrais($idVisiteur,$dernierMois);
		if($laDerniereFiche['idEtat']=='CR'){
				$this->majEtatFicheFrais($idVisiteur, $dernierMois,'CL');
				
		}
		$req = "insert into fichefrais(idUtilisateur,mois,nbJustificatifs,montantValide,dateModif,idEtat) 
		values('$idVisiteur','$mois',0,0,now(),'CR')";
		PdoGsb::$monPdo->exec($req);
		$lesIdFrais = $this->getLesIdFrais();
		foreach($lesIdFrais as $uneLigneIdFrais){
			$unIdFrais = $uneLigneIdFrais['idfrais'];
			$req = "insert into lignefraisforfait(idUtilisateur,mois,idFraisForfait,quantite) 
			values('$idVisiteur','$mois','$unIdFrais',0)";
			PdoGsb::$monPdo->exec($req);
		 }
	}
/**
 * Crée un nouveau frais hors forfait pour un utilisateur un mois donné
 * à partir des informations fournies en paramètre
 
 * @param $idVisiteur 
 * @param $mois sous la forme aaaamm
 * @param $libelle : le libelle du frais
 * @param $date : la date du frais au format français jj//mm/aaaa
 * @param $montant : le montant
*/
	public function creeNouveauFraisHorsForfait($idVisiteur,$mois,$libelle,$date,$montant){
		$dateFr = dateFrancaisVersAnglais($date);
		$req = "insert into lignefraishorsforfait 
		values('','$idVisiteur','$mois','$libelle','$dateFr','$montant')";
		PdoGsb::$monPdo->exec($req);
	}
/**
 * Supprime le frais hors forfait dont l'id est passé en argument
 
 * @param $idFrais 
*/
	public function supprimerFraisHorsForfait($idFrais){
		$req = "delete from lignefraishorsforfait where lignefraishorsforfait.id =$idFrais ";
		PdoGsb::$monPdo->exec($req);
	}
/**
 * Retourne les mois pour lesquel un utilisateur a une fiche de frais
 
 * @param $idVisiteur 
 * @return un tableau associatif de clé un mois -aaaamm- et de valeurs l'année et le mois correspondant 
*/
	public function getLesMoisDisponibles($idVisiteur){
		$req = "select fichefrais.mois as mois from  fichefrais where fichefrais.idUtilisateur ='$idVisiteur' 
		order by fichefrais.mois desc ";
		$res = PdoGsb::$monPdo->query($req);
		$lesMois =array();
		$laLigne = $res->fetch();
		while($laLigne != null)	{
			$mois = $laLigne['mois'];
			$numAnnee =substr( $mois,0,4);
			$numMois =substr( $mois,4,2);
			$lesMois["$mois"]=array(
		     "mois"=>"$mois",
		    "numAnnee"  => "$numAnnee",
			"numMois"  => "$numMois"
             );
			$laLigne = $res->fetch(); 		
		}
		return $lesMois;
	}
/**
 * Retourne les informations d'une fiche de frais d'un utilisateur pour un mois donné
 
 * @param $idVisiteur 
 * @param $mois sous la forme aaaamm
 * @return un tableau avec des champs de jointure entre une fiche de frais et la ligne d'état 
*/	
	public function getLesInfosFicheFrais($idVisiteur,$mois){
                $req = "select fichefrais.idEtat as idEtat, fichefrais.dateModif as dateModif, fichefrais.nbJustificatifs as nbJustificatifs, 
			fichefrais.montantValide as montantValide, etat.libelle as libEtat from  fichefrais inner join etat on fichefrais.idEtat = etat.id 
			where fichefrais.idUtilisateur ='$idVisiteur' and fichefrais.mois = '$mois'";
		$res = PdoGsb::$monPdo->query($req);
		$laLigne = $res->fetch();
		return $laLigne;
	}
/**
 * Modifie l'état et la date de modification d'une fiche de frais
 
 * Modifie le champ idEtat et met la date de modif à aujourd'hui
 * @param $idVisiteur 
 * @param $mois sous la forme aaaamm
 */
 
	public function majEtatFicheFrais($idVisiteur,$mois,$etat){
		$req = "update fichefrais set idEtat = '$etat', dateModif = now() 
		where fichefrais.idUtilisateur ='$idVisiteur' and fichefrais.mois = '$mois'";
                
		PdoGsb::$monPdo->exec($req);
	}
        
        
/**
 * Retourne les mois ayant le statut en attente de validation (CL)
 * 
 */
        
        public function getLesMoisEnAttente(){
            $req = "select fichefrais.mois as mois"
                    . " from fichefrais"
                    . " where fichefrais.idEtat = 'CL'"
                    . " order by fichefrais.mois DESC ";
            $res = PdoGsb::$monPdo->query($req);
		$lesMois =array();
		$laLigne = $res->fetch();
		while($laLigne != null)	{
			$mois = $laLigne['mois'];
			$numAnnee =substr( $mois,0,4);
			$numMois =substr( $mois,4,2);
			$lesMois["$mois"]=array(
		     "mois"=>"$mois",
		    "numAnnee"  => "$numAnnee",
			"numMois"  => "$numMois"
             );
			$laLigne = $res->fetch(); 		
		}
		return $lesMois;
	}


//METHODES CREE LORS DES MISSIONS ========================================================================= 


/**
 *  Récupère la liste des visiteurs qui ont des fiches de frais à valider pour le mois donnée en paramètre
 * 
 *
 * @param int $unMois sous le format YYYYMM
 * @return array $lesVisiteurs comportant l'identifiant, le nom et le prénom des visiteurs en question
 * 
 * @author MAINENTI Eugene
 *
 */
        public function getLesVisiteursAValider($unMois){
            $req="select id,nom,prenom "
                 ."from utilisateur join fichefrais on fichefrais.idUtilisateur=utilisateur.id "
                 ."where mois=".$unMois." and fichefrais.idEtat = 'CL'";
            $res = PdoGsb::$monPdo->query($req);
               $lesVisiteurs=array();
               $laLigne = $res->fetch();
		while($laLigne != null)	{
			$idVisiteur = $laLigne['id'];
			$nom =$laLigne["nom"];
			$prenom=$laLigne["prenom"];
			$lesVisiteurs["$idVisiteur"]=array(
		     "idVisiteur"=>"$idVisiteur",
		    "nom"  => "$nom",
			"prenom"  => "$prenom"
             );
			$laLigne = $res->fetch(); 		
		}
		return $lesVisiteurs;
                    
        }        
        
/**
 * Récupère le libelle d'un frais hors forfait et lui rajoute [REFUSE] devant
 * 
 * @param str $idFraisHorsForfait identifiant du frais hors forfait à mettre a jour
 * 
 * @author MAINENTI Eugene
 */
        public function refuserFraisHorsForfait($idFraisHorsForfait){
            //requete
            $req="update lignefraishorsforfait"
                    ." set libelle=concat('[REFUSE] ' ,(select libelle from (select * from lignefraishorsforfait ) as L where L.id=".$idFraisHorsForfait."))"
                    ." where id=".$idFraisHorsForfait;
            
            //execution de la requête
            PdoGsb::$monPdo->exec($req);
        }

/**
 * 
 * Reporte le frais hors forfait au mois de la derniere fiche de frais
 * 
 * @param str $idFrais identifiant du mois à mettre à jour
 * @param str $dernierMois mois auquel doit être le frais hors forfait
 * 
 * @author LAZE Aymeric
 */
        public function reportDUnFraisHorsForfait($idFrais, $dernierMois)
        {
            //requete pour mettre a jour le champs
            $req = "update lignefraishorsforfait"
                    . " set mois = $dernierMois"
                    . " where id = $idFrais";
            
            //execution de la requete
            PdoGsb::$monPdo->exec($req);
        }
        

        
/**
 * Retourne le nom et prénom du visiteur
 * 
 * @param str $id numéro d'identification du visiteur
 * @return array nom et prénom du visiteur
 * 
 * @author LAZE Aymeric 
 */
        public function getNomPrenomVisiteur($id)
        {
            //requete et execution
            $req = "select nom, prenom"
                    . " from utilisateur"
                    . " where id='$id'";
            $res = PdoGsb::$monPdo->query($req);
            
            //stockage nom et prenom
            $leVisiteur = array();
            $laLigne = $res->fetch();
            $leVisiteur['nom'] = $laLigne['nom'];
            $leVisiteur['prenom'] = $laLigne['prenom'];
            
            return $leVisiteur;
        }

/**
* Retourne les informations pour séléctionner une fiche de frais en cours de payement
* 
* @return array lesInfoFichesEnPayement
* 
* @autor LAZE Aymeric
*/
        function getInfoFichesEnPayement()
        {
            //requete et execution
            $req = "Select fichefrais.idUtilisateur, fichefrais.mois, utilisateur.nom, utilisateur.prenom"
                    . " from fichefrais INNER JOIN utilisateur on fichefrais.idUtilisateur = utilisateur.id"
                    . " where idEtat='VA'";
            
            $res = PdoGsb::$monPdo->query($req);
            
            //ajout pk fiche 
            $lesLigne = $res->fetchall();
            $nbLigne = count($lesLigne);
            for($i=0; $i < $nbLigne; $i++)
            {
                //concatenation du nom prenom
                $lIdentite = $lesLigne[$i]['nom']." ".$lesLigne[$i]['prenom'];
                
                //scindement du num mois et num annee
                $leMois = $lesLigne[$i]['mois'];
                $numAnnee = substr( $leMois,0,4);
                $numMois = substr( $leMois,4,2);
                
                //stockage dans tableau
                $lesInfoFichesEnPayement[$i]['mois'] = $leMois; 
                $lesInfoFichesEnPayement[$i]['visiteur'] = $lesLigne[$i]['idUtilisateur'];
                $lesInfoFichesEnPayement[$i]['identite'] = $lIdentite;
                $lesInfoFichesEnPayement[$i]['numMois'] = $numMois;
                $lesInfoFichesEnPayement[$i]['numAnnee'] = $numAnnee;
            }
            
            return $lesInfoFichesEnPayement;
        }
        
/**
* Retourne le prix en fonction du véhicule du visiteur
* 
* @param str $idVisiteur
* @param int $quantite
* @return int
* 
* @author : MAINENTI Eugène
*/
        public function calculerKilometrique($idVisiteur){
		$req = "select vehicule.prixAuKm "
                        ."from vehicule join utilisateur on utilisateur.idVehicule=vehicule.id "
                        ."where utilisateur.id='$idVisiteur'";
		$res = PdoGsb::$monPdo->query($req);
                $ligne=$res->fetch();
		return $ligne;
        }

}

?>