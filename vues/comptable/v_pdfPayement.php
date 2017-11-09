<?php

    function creerPDF($idVisiteur, $nomVisiteur, $prenomVisiteur, $lesFraisHorsForfait, $lesFraisForfait, $lesInfosFicheFrais, $numAnnee, $numMois) {

        $montantTotal = 0;
        $dateDuJour = new DateTime();
        $aujourdhui = $dateDuJour->format('d/M/Y');
        
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
        $pdf->Cell(0, 10, 'IMAGE', 0, 1, 'C');
        
        //titre
        $pdf->Cell(0, 10, 'REMBOURSEMENT DE FRAIS ENGAGES', 1, 1, 'C'); //titre du tableau
        
        
        //information sur visiteur et fiche
        $pdf->SetFont('Arial', 'B', 14); //cahngement de taille de la police
        $pdf->Ln();
        $pdf->Cell(100, 10, utf8_decode('Visiteur :     '.$idVisiteur.'   -   '.$prenomVisiteur.' '.strtoupper($nomVisiteur)), 0, 1, 'C'); //affichage le visiteur
        $pdf->Cell(75, 10, 'Mois :         '.$numMois.'/'.$numAnnee, 0, 1, 'C'); //affichage le mois
        
        
        //tableau frais forfait
        $pdf->Ln();
        $pdf->Cell(0, 10, utf8_decode('Frais Forfaitaires       Quantité        Montant Unitaire        Total'), 0, 1, 'C');
        
        foreach ($lesFraisForfait as $fraisForfait) {
            $libelle = $fraisForfait["libelle"];
            $quantite = $fraisForfait["quantite"];
            $montant = $fraisForfait["montant"];
            $total = $quantite * $montant;
            $montantTotal += $total;
            
            $pdf->Cell(0, 10, utf8_decode($libelle.' '.$quantite.' '.$montant.' '.$total), 0, 1, 'C');
        }
        
        //tableau frais hors forfait
        $pdf->Ln();
        $pdf->Cell(0, 10, 'Autre frais', 0, 1, 'C');
        $pdf->Cell(0, 10, utf8_decode('Date       Libellé        Montant'), 0, 1, 'C');
        
        foreach($lesFraisHorsForfait as $fraisHorsForfait) {
            $date = $fraisHorsForfait['date'];
            $libelle = $fraisHorsForfait['libelle'];
            $montant = $fraisHorsForfait['montant'];
            $montantTotal += $montant;
            
            $pdf->Cell(0, 10, utf8_decode($date.' '.$libelle.' '.$montant), 0, 1, 'C');
        }
        
        //prix total
        $pdf->Ln();
        $pdf->Cell(0, 10, utf8_decode('Total '.$numMois.'/'.$numAnnee.' '.$montantTotal), 0, 1, 'R');
        
        //fait a, le et zone signature
        $pdf->Ln();
        $pdf->Cell(0, 10, utf8_decode('Fait à Cachan, le '.$aujourdhui), 0, 1, 'R');
        $pdf->Cell(0, 10, "Vu l'agent comptable", 0, 1, 'R');
        
        //ouverture dans le navigateur
        $pdf->Output();
        ob_end_flush();
    }
?>