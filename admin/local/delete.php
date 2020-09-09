<?php require_once '../../config.php'; ?>
<?php require_once DBAPI; ?>
<?php
    require_once LOGIN2;
    verificaLoginAdmin();
?>
<?php require_once LOCAL;
    if (isset($_GET['id'])) {
        deleteLocal($_GET['id']);
    } else {
        die("ERRO: ID não definido.");
    } 
?>