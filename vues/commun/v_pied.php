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
  <!-- Division pour le pied de page -->
    
  </body>
</html>


