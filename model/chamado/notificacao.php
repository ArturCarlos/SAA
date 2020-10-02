<?php
require_once('../../config.php');
require_once(DBAPI);

if(count_notificacao()){
    $num = ['notificacao' => count_notificacao()];
    echo json_encode($num);

}

