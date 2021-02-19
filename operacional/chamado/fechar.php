<?php require_once '../../config.php'; ?>
<?php require_once DBAPI; ?>
<?php
require_once LOGIN2;
verificaLoginOperador();
?>
<?php require_once CHAMADO;
if (isset($_GET['fechar_id'])) {
    fechar_chamado($_GET['fechar_id']);
}/*elseif (isset($_GET['abrir_id'])) {
    abrir_chamado($_GET['abrir_id']);
}*/ else {
    header('location: 404.php');
}
?>