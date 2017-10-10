<?php
    require_once ("class.pdogsb.inc.php");
    $pdo = PdoGsb::getPdoGsb();
    $pdo->scriptChiffrage();
?>
        

