<?php require_once '../../config.php'; ?>
<?php require_once DBAPI; ?>
<?php
    require_once LOGIN2;
    verificaLoginAdmin();
?>
<?php require_once ACHADOS_E_PERDIDOS;
    if (isset($_GET['id'])) {
        deleteAchados_e_Perdidos($_GET['id']);
    } else {
        die("ERRO: ID não definido.");
    } 
?>