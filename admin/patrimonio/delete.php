<?php require_once '../../config.php'; ?>
<?php require_once DBAPI; ?>
<?php
    require_once LOGIN2;
    verificaLoginAdmin();
?>
<?php require_once PATRIMONIO;
    if (isset($_GET['id'])) {
        deletePatrimonio($_GET['id']);
    } else {
        die("ERRO: ID não definido.");
    } 
?>