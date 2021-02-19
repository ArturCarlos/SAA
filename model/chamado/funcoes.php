<?php
require_once(DBAPI);

$chamados = null;

$chamado = null;

$acesso_chamado = null;

$chamado_setor = null;

$chamado_setor_origem = null;

$tags = null;

$tags_chamado = null;

$resp_chamado = null;

function notificacao_lida()
{

    if (isset($_GET['msgLida_id']) || isset($_GET['all_msg'])) {

        if (isset($_GET['all_msg'])) {
            $id_user = $_SESSION['id'];
            delete_all_notificacao($id_user);

        } elseif (isset($_GET['msgLida_id'])) {

            $id_not = $_GET['msgLida_id'];
            $id_chamado = $_GET['id'];
            delete_notificacao($id_not, $id_chamado);
        }
    }
}

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

function libera_acesso()
{

    $result = find_all_user_setor('acesso_chamado');
    $id_user = $_SESSION['id'];

    foreach ($result as $id):

        $setor = (find_chamado_setor('user_setor', $id['setor_id']));

        foreach ($setor as $user)
            if ($user['user_id'] == $id_user)
                return true;

    endforeach;

    return false;

}

/*verifica se o usuario pode fechar o chamado*/
function user_fecha_chamado($id)
{
    $table = 'user_setor';
    $resp = find_chamado_setor($table, $id);
    foreach ($resp as $user) {
        if ($user['user_id'] == $_SESSION['id']) {
            return true;

        }

    }
    return false;
}


function index_tag_chamado($id = null)
{
    global $tags_chamado;
    if ($id) {
        $tags_chamado = find_all_chamado('tag_chamado', $id, 'tag_chamado');
    } else {

        $id = $_GET['id'];
        $tags_chamado = find_all_chamado('tag_chamado', $id, 'tag_chamado');
    }
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

function delete_notificacao($id_not = null, $id_cham = null)
{
    if ($id_not) {
        remove_notificacao('destino_notificacao', $id_not, 'id');

        header('location:view.php?id=' . $id_cham);
    }

}

function delete_all_notificacao($id = null)
{
    if ($id) {
        remove_notificacao('destino_notificacao', $id, 'user_id');

        header('location:index.php');
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

/** *  Cadastro de chamados     */
function add_resp_chamado()
{

    global $chamado;

    if (!empty($_POST['resp_chamado'])) {

        if ($chamado) {

            //usuario respondeu chamado
            $id_user = $_SESSION['id'];
            $_POST['resp_chamado']["'user_id'"] = $id_user;
            $id_chamado = $chamado['id'];

            $_POST['resp_chamado']["'chamado_id'"] = $id_chamado;
            $resp_chamado = $_POST['resp_chamado'];


            add('resp_chamado', $resp_chamado);
            header('location: view.php?id=' . $id_chamado);
        }

    }
}

/** *  Listagem de chamados     do usuario*/
function index_chamado_user()
{
    global $chamados;
    $id = $_SESSION['id'];
    $chamados = find_all_chamado('chamado', $id, 'user', 1);
}

/** *  Listagem de chamados fechados do usuario*/
function index_historico_user()
{
    global $chamados;
    $id = $_SESSION['id'];
    $chamados = find_all_chamado('chamado', $id, 'user', 0);
}

/** *  Listagem de chamados     do usuario*/
function index_resp_chamado()
{
    global $resp_chamado;
    global $chamado;
    $id = $chamado['id'];

    $resp_chamado = find_all_resp_chamado('resp_chamado', $id, 'chamado_id');
}

/** *  Listagem de chamados     do setor*/
function index_chamado_setor()
{

    global $chamado_setor;
    $chamado_setor = [];
    $setor = find_setor_operacional('user_setor');
    if ($setor) {
        foreach ($setor as $chamado) {
            $result = find_all_chamado('chamado', $chamado['setor_id'], 'setor', 1);
            if ($result) {
                $chamado_setor = array_merge($chamado_setor, $result);
            }
        }
    }

}

function index_chamado_setor_origem()
{

    global $chamado_setor_origem;
    $chamado_setor_origem = [];
    $setor = find_setor_operacional('user_setor');
    if ($setor) {
        foreach ($setor as $chamado) {
            $result = find_all_chamado('chamado', $chamado['setor_id'], 'setor_origem', 1);
            if ($result) {
                $chamado_setor_origem = array_merge($chamado_setor_origem, $result);
            }
        }
    }

}

/** *  Listagem de chamados fechados do setor*/
function index_historico_setor()
{

    global $chamado_setor;
    $chamado_setor = [];
    $setor = find_setor_operacional('user_setor');
    if ($setor) {
        foreach ($setor as $chamado) {
            $result = find_all_chamado('chamado', $chamado['setor_id'], 'setor', 0);
            if ($result) {
                $chamado_setor = array_merge($chamado_setor, $result);
            }
        }
    }

}

/** *  Listagem de chamados fechados do setor*/
function index_historico_setor_origem()
{

    global $chamado_setor_origem;
    $chamado_setor_origem = [];
    $setor = find_setor_operacional('user_setor');
    if ($setor) {
        foreach ($setor as $chamado) {
            $result = find_all_chamado('chamado', $chamado['setor_id'], 'setor_origem', 0);
            if ($result) {
                $chamado_setor_origem = array_merge($chamado_setor_origem, $result);
            }
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
    if ($chamado) {
        $chamado = $chamado[0];
    }else{
        header('location: 404.php');

    }
}

/*retorna o id do chamado de uma resposta*/
function id_chamado($id)
{
    $chamado = find_chamado('resp_chamado', $id, 'id');
    return $chamado[0]['chamado_id'];

}

function anexo($nome, $table)
{
    $caminho = BASEURL . "anexo/{$table}/{$nome}";
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
            if ($chamado) {
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

function abrir_chamado($id)
{
    if ($id) {
        $_POST['chamado']["'status'"] = 1;//status aberto

        if (isset($_POST['chamado'])) {

            $chamado = $_POST['chamado'];
            chamado_fechar('chamado', $id, $chamado);
            header('location: index.php');
        }
    }
}

/*** Verifica se o usuário pode acessar a pagina pelo id*/
function chamado_acesso()
{
    $id_user = $_SESSION['id'];
    $id_cham = $_GET['id'];
    $result = find_chamado_acesso('chamado', $id_cham, 'id', $id_user);
    if ($result) {
        return true;
    } else {
        return false;

    }
}


function deletechamado($id = null)
{
    if ($id) {
        remove_chamado('chamado', $id);
        header('location: index.php');
    }
}

function delete_resp_chamado($id = null)
{
    if ($id) {
        $id_chamado = find_chamado('resp_chamado', $id, 'id');
        $id_chamado = $id_chamado[0]['chamado_id'];
        remove_chamado('resp_chamado', $id);

        header('location: view.php?id=' . $id_chamado);
    }
}

function edit_resp_chamado()
{
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $id_chamado = find_chamado('resp_chamado', $id, 'id');
        $id_chamado = $id_chamado[0]['chamado_id'];
        if (isset($_POST['resp_chamado'])) {
            $resp_chamado = $_POST['resp_chamado'];
            update_chamado('resp_chamado', $id, $resp_chamado);
            header('location: view.php?id=' . $id_chamado);
        } else {
            global $resp_chamado;
            $resp_chamado = find_chamado('resp_chamado', $id);
            if ($resp_chamado) {
                $resp_chamado = $resp_chamado[0];
            }
        }
    } else {
        header('location: index.php');
    }
}


function filtro_chamado()
{
    global $chamados;

    //Verifica se foi passa algun parametro de pesquisa
    $result = 0;

    $like = "%";
    $filtro = array();

    if (isset($_GET['tag'])) {
        if (($_GET['tag'])) {
            $tag = $_GET['tag'];

            $filtro[] = "id IN (SELECT chamado_id FROM tag_chamado WHERE tag_id = '{$tag}')";

            $result = 1;
        }
    }

    if (isset($_GET['titulo'])) {
        if (($_GET['titulo'])) {
            $titulo = $like . "" . $_GET['titulo'] . "" . $like;
            $filtro[] = "titulo LIKE '{$titulo}'";

            $result = 1;
        }
    }

    if (isset($_GET['setor_origem'])) {
        if (($_GET['setor_origem'])) {
            $setor = $_GET['setor_origem'];
            $filtro[] = "setor_origem='{$setor}'";

            $result = 1;
        }
    }
    if (isset($_GET['setor_destino'])) {
        if (($_GET['setor_destino'])) {
            $setor = $_GET['setor_destino'];
            $filtro[] = "setor_destino='{$setor}'";

            $result = 1;
        }
    }


    if ((sizeof($filtro)) > 0) {
        $chamados = chamado_filtro('chamado', $filtro);
    }

    return $result;

}