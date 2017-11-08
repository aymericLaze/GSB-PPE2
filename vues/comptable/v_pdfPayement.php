<?php

    function creerPDF($idVisiteur, $nomVisiteur, $prenomVisiteur, $lesFraisHorsForfait, $lesFraisForfait, $lesInfosFicheFrais, $numAnnee, $numMois) {

        //recuperation classe fpdf
        require('lib/fpdf/fpdf.php');
        // instancie un objet de type FPDF qui permet de créer le PDF
        ob_start();
        $pdf = new FPDF();
        // ajoute une page
        $pdf->AddPage();
        // définit la police courante
        $pdf->SetFont('Arial', 'B', 16);

        //ouverture dans le navigateur
        $pdf->Output();
        ob_end_flush();
    }
?>