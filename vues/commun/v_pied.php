<?php
    if(isset($_SESSION['fonction'])){
    if(($_SESSION['fonction'] === 'comptable') and !($action === 'accueil'))
    {
?>
        <a href='index.php?uc=selectionnerFicheFrais&action=accueil'>Retour à l'accueil</a>
<?php
    }
    }
?>
        <script>
            var selectElmt = document.getElementById("listMois");
            var valeurselectionnee = selectElmt.options[selectElmt.selectedIndex].value;
            var textselectionne = selectElmt.options[selectElmt.selectedIndex].text;
            var selectElmt = document.getElementById("listVisiteur");
            var valeurselectionnee = selectElmt.options[selectElmt.selectedIndex].value;
            var textselectionne = selectElmt.options[selectElmt.selectedIndex].text;
        </script>
<?php
?>
  <!-- Division pour le pied de page -->
    
    </body>
</html>


