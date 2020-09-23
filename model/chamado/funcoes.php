<?php
require_once('../../config.php');
require_once(DBAPI);

$chamados = null;

$chamado = null;

$acesso_chamado = null;

$chamado_setor = null;

$tags = null;

$tags_chamado = null;

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

function add_tag_chamado()
{

    if ((!empty($_POST['tag_chamado'])) & (!empty($_POST['chamado_id']))) {
        $id_chamdo = $_POST['chamado_id'];
        $tags = $_POST['tag_chamado'];
        remove_tag_chamado('tag_chamado', $id_chamdo["'chamado_id'"]);

        foreach ($tags as $tag):
            foreach ($tag as $id):
                $tags["'tag_id'"] = $id;
                $result = array_merge($id_chamdo, $tags);
                adicionar('tag_chamado', $result);
            endforeach;
        endforeach;

        $id = $id_chamdo["'chamado_id'"];
        header('location: view.php?id=' . $id);

    }

}

function index_acesso_chamado()
{
    global $acesso_chamado;
    $acesso_chamado = find_all_user_setor('acesso_chamado');
}

function index_tag_chamado()
{
    global $tags_chamado;
    $id = $_GET['id'];
    $tags_chamado = find_all_chamado('tag_chamado', $id, 'tag_chamado');
}

function add_tag()
{
    if (!empty($_POST['tag'])) {
        $tag = $_POST['tag'];
        adicionar('tag', $tag);
    }
}

function nome_tag($tag_id)
{
    return find_nome('tag', $tag_id);
}

/** *  Listagem de tags     */
function indextag()
{
    global $tags;
    $tags = find_all('tag');
}

function deletetag($id = null)
{
    if ($id) {
        remove('tag', $id);
        header('location: tag.php');
    }
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
    $chamados = find_all_chamado('chamado', $id, 'user',1);
}

/** *  Listagem de chamados     do setor*/
function index_chamado_setor()
{

    global $chamado_setor;
    $chamado_setor = [];
    $setor = find_setor_operacional('user_setor');
    if ($setor) {
        foreach ($setor as $chamado) {
            $chamado_setor = array_merge($chamado_setor,find_all_chamado('chamado', $chamado['setor_id'], 'setor', 1));
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

function formata_data_hora($data = null, $tipo = null)
{
    $data = formata_data($data);
    $data = explode(' ', $data);
    if ($tipo == 'data') {
        return $data[0];
    } elseif ($tipo == 'hora') {
        return $data[1];

    }

}


function viewchamado($id = null)
{
    global $chamado;
    $chamado = find_chamado('chamado', $id);
    if($chamado) {
        $chamado = $chamado[0];
    }
}

function anexo($nome)
{
    $caminho = BASEURL . "anexo/chamado/{$nome}";
    return $caminho;
}

function edit_chamado()
{
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        if (isset($_POST['chamado'])) {
            $chamado = $_POST['chamado'];
            update_chamado('chamado', $id, $chamado);
            header('location: index.php');
        } else {
            global $chamado;
            $chamado = find_chamado('chamado', $id);
            if($chamado) {
                $chamado = $chamado[0];
            }
        }
    } else {
        header('location: index.php');
    }
}

function fechar_chamado()
{
    if (isset($_GET['fechar_id'])) {
        $id = $_GET['fechar_id'];
        $_POST['chamado']["'status'"] = 0;//status fechado

        if (isset($_POST['chamado'])) {

            $chamado = $_POST['chamado'];
            chamado_fechar('chamado', $id, $chamado);
            header('location: index.php');
        }
    }
}

/*** Verifica se o usuário pode acessar a pagina pelo id*/
function chamado_acesso(){
    $id_user = $_SESSION['id'];
    $id_cham = $_GET['id'];
    $result = find_chamado_acesso('chamado',$id_cham,'id',$id_user);
    if($result){
        return true;
    }else{
        return false;

    }
}