<?php
require_once('../../config.php');
require_once(DBAPI);

/* guardar um conjunto de registros de usuario */
$setores = null;
/* guardará um único cliente, para os casos de inserção e atualização (CREATE e UPDATE) */
$setor = null;

$user_setor = null;

function index_user_setor($id_setor = null)
{
    global $user_setor;
    $user_setor = find_all_user_setor('user_setor');
}

/** *  Listagem de Setores     */
function indexSetor()
{
    global $setores;
    $setores = find_all('setor');
}

/** *  Listagem de Setores que o usuário é responsável     */
function indexSetor_operacional()
{
    global $setores;
    $setores = find_setor_operacional('user_setor');
}

/** *  Pega nome do setor através do id	 */
function nome_setor($id){
    return find_nome('setor', $id);
}
/** *  Pega nome do setor através do id	 */
function nome_usuario_setor($id){
    return find_nome('usuario', $id);
}

/** *  Pega nome do local do setor através do id	 */
function local_id_setor($id){
    return setor_local_id('setor', $id);
}


if (isset($_GET['search'])) {
    indexSetores();
}
function indexSetores()
{
    $local = isset($_GET['search']);
    global $setores;
    $setores = findSetor('setor', $local);
    //return $itens;
    /*while(null !== ($item = mysqli_fetch_assoc($itens)))($itens as $item){
        echo "<option value='".$item['id']."'>".$item['nome']."</option>";
    }*/
    /*for ($i = 0; $i < count($setores[0]); $i++) {
        // devolvendo a linha HTML para o javascript e montar no append
        echo "<option value='" . $setores[$i]['id'] . "' >" . $setores[$i]['nome'] . "</option>";
    }*/
    if ($setores) {
        foreach ($setores as $setor):
            echo "<option value='" . $setor . "' >" . $setor . "</option>";
        endforeach;
    }
    /*if($itens){
        foreach ($itens as $item => $value):
            echo "<option value='" . $value['id'] . "' >" . $value['nome'] . "</option>";
        endforeach;
    }*/

}

function addSetor()
{
    if ((!empty($_POST['setor'])) && (!empty($_POST['user_setor']))) {
        $setor = $_POST['setor'];

        save('setor', $setor);

        if ($_SESSION['type'] == 'success') {

            //retorna o ultimo id inserido
            $setor = id_table("setor");

            $setor_id["'setor_id'"] = $setor['id'];

            $setore = $_POST['user_setor'];

            foreach ($setore as $setor):
                foreach ($setor as $user):
                    $user_id["'user_id'"] = $user;
                    //uni o os vetores para inserir no banco
                    $user_setor = array_merge($user_id, $setor_id);
                    save('user_setor', $user_setor);

                endforeach;
            endforeach;

            header('location: index.php');
        }
    }


}

function editSetor()
{
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        if (isset($_POST['setor'])) {
            $setor = $_POST['setor'];
            update('setor', $id, $setor);


            $seto = $id;

            $setor_id["'setor_id'"] = $seto;
            $setore = $_POST['user_setor'];
            remove_user_setor('user_setor',$id);

            foreach ($setore as $seto):
                foreach ($seto as $user):
                    $user_id["'user_id'"] = $user;
                    //uni o os vetores para inserir no banco
                    $user_setor = array_merge($user_id, $setor_id);
                    save('user_setor', $user_setor);

                endforeach;
            endforeach;

            header('location: index.php');

        } else {
            global $setor;
            $setor = find('setor', $id);
        }
    } else {
        header('location: index.php');
    }
}

function viewSetor($id = null)
{
    global $setor;
    $setor = find('setor', $id);
}

function deleteSetor($id = null)
{
    global $setor;
    deleta_user_setor('user_setor',$id);
    $setor = remove('setor', $id);
    header('location: index.php');
}