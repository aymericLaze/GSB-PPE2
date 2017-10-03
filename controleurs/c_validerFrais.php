<?php
include("vues/v_sommaireComptable.php");
$mois = getMois(date("d/m/Y"));
$numAnnee =substr( $mois,0,4);
$numMois =substr( $mois,4,2);
$action = $_REQUEST['action'];
switch($action){
    case 'choisirMois':
        echo "vue pour choisir le mois<br />";
        print_r($pdo->getLesMoisEnAttente());
        break;
    
}

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

