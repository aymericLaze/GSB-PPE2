<?php
/**
 * page pour generer le PDF imprimable
 * 
 * @author LAZE Aymeric
 */    

    /**
     * Permet d'afficher le PDF imprimable avec les informations de la fiche de
     * frais selectionne
     * 
     * @param str $idVisiteur
     * @param str $nomVisiteur
     * @param str $prenomVisiteur
     * @param array $lesFraisHorsForfait
     * @param array $lesFraisForfait
     * @param array $lesInfosFicheFrais
     * @param int $numAnnee
     * @param int $numMois
     * 
     * @author LAZE Aymeric
     */
    function creerPDF($idVisiteur, $nomVisiteur, $prenomVisiteur, $lesFraisHorsForfait, $lesFraisForfait, $numAnnee, $numMois) {
        
        //definition de constante
        define('TAILLE_PETIT', 45);
        define('TAILLE_GRAND', 60);
        
        //declaration - initialisation de variable
        $montantTotal = 0;
        $dateDuJour = new DateTime();
        $aujourdhui = $dateDuJour->format('d/m/Y');
        $nomMois = getMoisTextuelle($numMois);
        
        //recuperation classe fpdf
        require('lib/fpdf/fpdf.php');
        
        // instancie un objet de type FPDF qui permet de créer le PDF
        ob_start();
        $pdf = new FPDF();
        
        // ajout d'une page
        $pdf->AddPage();
        
        // définit la police courante
        $pdf->SetFont('Arial', 'B', 16);
        
        //HEADER
        $pdf->Image('./images/logo.jpg', 70);
        
        //TITRE
        $pdf->Cell(0, 10, 'REMBOURSEMENT DE FRAIS ENGAGES', 1, 1, 'C'); //titre du tableau
        
        
        //information sur visiteur et fiche
        $pdf->SetFont('Arial', 'B', 14); //changement de taille de la police
        $pdf->Ln();
        $pdf->Cell(TAILLE_PETIT, 10, 'Visiteur', 0, 0,'L');
        $pdf->Cell(TAILLE_PETIT, 10, $idVisiteur, 0, 0,'L');
        $pdf->Cell(TAILLE_PETIT, 10, utf8_decode($prenomVisiteur), 0, 0,'L');
        $pdf->Cell(TAILLE_PETIT, 10, utf8_decode(strtoupper($nomVisiteur)), 0, 1,'L');
        
        $pdf->Cell(TAILLE_PETIT, 10, 'Mois', 0, 0, 'L');
        $pdf->Cell(TAILLE_PETIT, 10, $nomMois.' '.$numAnnee, 0, 0, 'L');
        
        //tableau frais forfait
        $pdf->Ln(20);
        $pdf->Cell(TAILLE_PETIT, 10, 'Frais forfaitaires', 1, 0, 'L');
        $pdf->Cell(TAILLE_PETIT, 10, utf8_decode('Quantité'), 1, 0, 'C');
        $pdf->Cell(TAILLE_PETIT, 10, 'Montant Unitaire', 1, 0, 'C');
        $pdf->Cell(TAILLE_PETIT, 10, 'Total', 1, 1, 'C');
        
        foreach ($lesFraisForfait as $fraisForfait) {
            //stockage des valeurs dans variables (lisibilite)
            $libelle = $fraisForfait["libelle"];
            $quantite = $fraisForfait["quantite"];
            $montant = $fraisForfait["montant"];
            $total = $quantite * $montant;
            $montantTotal += $total;
            
            //affichage des lignes du tableau
            $pdf->Cell(TAILLE_PETIT, 10, utf8_decode($libelle),1, 0, 'C');
            $pdf->Cell(TAILLE_PETIT, 10, utf8_decode($quantite), 1, 0, 'C');
            $pdf->Cell(TAILLE_PETIT, 10, utf8_decode($montant), 1, 0, 'C');
            $pdf->Cell(TAILLE_PETIT, 10, utf8_decode($total), 1, 1    , 'C');
        }
        
        //tableau frais hors forfait
        $pdf->Ln();
        $pdf->Cell(TAILLE_GRAND * 3, 10, 'Autre frais', 1, 1, 'C');
        $pdf->Cell(TAILLE_PETIT, 10, 'Date', 1, 0, 'C');
        $pdf->Cell(TAILLE_PETIT * 2, 10, utf8_decode('Libellé'), 1, 0, 'C');
        $pdf->Cell(TAILLE_PETIT, 10, 'Montant', 1, 1, 'C');
        
        foreach($lesFraisHorsForfait as $fraisHorsForfait) {
            //stockage des valeurs dans variables (lisibilite)
            $date = $fraisHorsForfait['date'];
            $libelle = $fraisHorsForfait['libelle'];
            $montant = $fraisHorsForfait['montant'];
            $montantTotal += $montant;
            
            //affichage des lignes du tableau
            $pdf->Cell(45, 10, $date, 1, 0, 'C');
            $pdf->Cell(TAILLE_PETIT * 2, 10, utf8_decode($libelle), 1, 0, 'C');
            $pdf->Cell(TAILLE_PETIT, 10, $montant, 1, 1, 'C');
        }
        
        //prix total
        $pdf->Ln();
        $pdf->Cell(TAILLE_PETIT * 2, 10, '', 0, 0, 'R');
        $pdf->Cell(45, 10, 'Total '.$numMois.'/'.$numAnnee, 1, 0, 'R');
        $pdf->Cell(45, 10, $montantTotal, 1, 1, 'R');
        
        //fait a, le et zone pour la signature
        $pdf->Ln();
        $pdf->Cell(0, 10, utf8_decode('Fait à Cachan, le '.$aujourdhui), 0, 1, 'R');
        $pdf->Cell(0, 10, "Vu l'agent comptable", 0, 1, 'R');
        
        //ouverture dans le navigateur
        $pdf->Output();
        ob_end_flush();
    }
?>