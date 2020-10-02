<?php
require_once('../../config.php');
require_once(DBAPI);

$num = ['notificacao' => count_notificacao()];
echo json_encode($num);

