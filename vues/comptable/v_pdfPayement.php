<?php

    function creerPDF($idVisiteur, $nomVisiteur, $prenomVisiteur, $lesFraisHorsForfait, $lesFraisForfait, $lesInfosFicheFrais, $numAnnee, $numMois) {

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
        $pdf->Cell(0, 10, 'PHOTO', 0, 1, 'C');
        
        //tableau 1
        $pdf->Line($pdf->GetX()+5, $pdf->GetY()+5, $pdf->GetX()+185, $pdf->GetY()+5); //ligne haut
        $pdf->Line($pdf->GetX()+5, $pdf->GetY()+200, $pdf->GetX()+185, $pdf->GetY()+200); //ligne bas
        $pdf->Line($pdf->GetX()+5, $pdf->GetY()+5, $pdf->GetX()+5, $pdf->GetY()+200); //ligne gauche
        $pdf->Line($pdf->GetX()+185, $pdf->GetY()+5, $pdf->GetX()+185, $pdf->GetY()+200); //ligne droite
        
        //titre tableau
        $pdf->Ln(13); //saut de ligne
        $pdf->Cell(0, 10, 'REMBOURSEMENT DE FRAIS ENGAGES', 0, 1, 'C'); //titre du tableau
        $pdf->Line($pdf->getX()+5, $pdf->GetY()+7, $pdf->getX()+185, $pdf->GetY()+7); //ligne bas
        
        //information sur visiteur et fiche
        $pdf->SetFont('Arial', 'B', 12); //cahngement de taille de la police
        $pdf->Cell(0, 10, $nomVisiteur, 0, 1);
        
        
        //tableau frais forfait
        
        //tableau frais hors forfait
        
        //prix total
        
        //fait a, le et zone signature
        
        //ouverture dans le navigateur
        $pdf->Output();
        ob_end_flush();
    }
?>