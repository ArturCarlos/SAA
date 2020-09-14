<?php
require_once('../../config.php');
require_once(DBAPI);

$chamados = null;

$chamado = null;

$acesso_chamado = null;

$chamado_setor = null;

$tags = null;

function add_acesso_chamado()
{
    if ((!empty($_POST['acesso_chamado']))) {
        $setores = $_POST['acesso_chamado'];

        remove_setor_acesso('acesso_chamado');

        foreach ($setores as $setor):
            foreach ($setor as $id):
                $setor_id["'setor_id'"] = $id;

                add('acesso_chamado', $setor_id);

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

function add_tag()
{
    if (!empty($_POST['tag'])) {
        $tag = $_POST['tag'];
        add('tag', $tag);
    }
}

/** *  Listagem de tags     */
function indextag()
{
    global $tags;
    $tags = find_all('tag');
}

function deletetag($id = null)
{
    remove('tag', $id);
    header('location: tag.php');
}

/** *  Cadastro de chamados     */
function add_chamado()
{

    if (!empty($_POST['chamado'])) {

        //usuario criador do chamado
        $id_user = $_SESSION['id'];
        $_POST['chamado']["'user_id'"] = $id_user;
        $_POST['chamado']["'status'"] = 1; //status aberto
        $chamado = $_POST['chamado'];
        add('chamado', $chamado);
        header('location: index.php');


    }
}

/** *  Listagem de chamados     do usuario*/
function index_chamado_user()
{
    global $chamados;
    $id = $_SESSION['id'];
    $chamados = find_all_chamado('chamado', $id, 'user');
}

/** *  Listagem de chamados     do setor*/
function index_chamado_setor()
{

    global $chamado_setor;
    $setor = find_setor_operacional('user_setor');
    if ($setor) {
        foreach ($setor as $chamado) {
            $chamado_setor = find_all_chamado('chamado', $chamado['setor_id'], 'setor');
        }
    }
}

function formata_data($data)
{
    $data = explode('-', $data);
    $ano = $data[0];
    $mes = $data[1];
    $data = explode(' ', $data[2]);
    $dia = $data[0];
    $hora = $data[1];
    $data = $dia . '-' . $mes . '-' . $ano . ' ' . $hora;
    return $data;
}

function viewchamado($id = null) {
    global $chamado;
    $chamado = find_chamado('chamado', $id);
}

