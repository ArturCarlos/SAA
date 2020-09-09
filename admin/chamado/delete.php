<?php require_once '../../config.php'; ?>
<?php require_once DBAPI; ?>
<?php
    require_once LOGIN2;
    verificaLoginAdmin();
?>
<?php require_once CHAMADO;
    if (isset($_GET['id-tag'])) {
        deletetag($_GET['id-tag']);
    } else {
        die("ERRO: ID não definido.");
    } 
?>