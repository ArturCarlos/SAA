<?php require_once '../../config.php'; ?>
<?php require_once DBAPI; ?>
<?php
    require_once LOGIN2;
    verificaLoginAdmin();
?>
<?php 
    require_once CHAMADO;
  
?>
<?php
    require_once LOCAL;
    indexLocal();
?>

<?php include(HEADER_TEMPLATE); ?>


<?php


echo $_GET['ch'];


?>






<!-- /.content -->

<?php include('modal.php'); ?>
<?php include(FOOTER_TEMPLATE); ?>