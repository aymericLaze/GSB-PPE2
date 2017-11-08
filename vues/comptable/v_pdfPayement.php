<?php

    function creerPDF($idVisiteur, $nomVisiteur, $prenomVisiteur, $lesFraisHorsForfait, $lesFraisForfait, $lesInfosFicheFrais, $numAnnee, $numMois) {

        //recuperation classe fpdf
        require('lib/fpdf/fpdf.php');
        //instanciation objet type pdf
        ob_start();
        $pdf = new FPDF();
        //ajout de la page
        $pdf->AddPage();
        //definition police courante
        $pdf->SetFont('times', 'B', 16);
        //HEADER
        $pdf->Image('images/logo.jpg', 10, 10, 50, 50);
        //Titre
        //ouverture dans le navigateur
        $pdf->Output();
        ob_end_flush();
    }
?>