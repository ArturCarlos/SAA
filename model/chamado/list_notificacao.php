<?php
require_once('../../config.php');

require_once(DBAPI);

$num = list_notificacao();
$notificacao = null;

if($num){
    list_notificacao();
}

function list_notificacao(){
    global $notificacao;
    $notificacao = lista_notificacao();

    echo(json_encode($notificacao));

}