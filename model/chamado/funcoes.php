<?php
require_once('../../config.php');
require_once(DBAPI);

$chamados = null;

$chamado = null;

$acesso_chamado = null;

function add_acesso_chamado()
{
    if ((!empty($_POST['acesso_chamado']))) {
        $setores = $_POST['acesso_chamado'];

        remove_setor_acesso('acesso_chamado');

        foreach ($setores as $setor):
            foreach ($setor as $id):
                $setor_id["'setor_id'"] = $id;

                save('acesso_chamado', $setor_id);

            endforeach;

        endforeach;

        header('location: gerenciar.php');

    }

}

function index_acesso_chamado()
{
    global $acesso_chamado;
    $acesso_chamado = find_all_user_setor('acesso_chamado');
}