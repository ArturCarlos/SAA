<?php require_once '../../config.php'; ?>
<?php require_once DBAPI; ?>
<?php
require_once LOGIN2;
verificaLoginAdmin();
?>
<?php require_once CHAMADO;
if (isset($_GET['fechar_id'])) {
    fechar_chamado($_GET['fechar_id']);
} else {
    die("ERRO: ID não definido.");
}
?>