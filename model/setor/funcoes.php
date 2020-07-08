<?php
require_once('../../config.php');
require_once(DBAPI);

/* guardar um conjunto de registros de usuario */
$setores = null;
/* guardará um único cliente, para os casos de inserção e atualização (CREATE e UPDATE) */
$setor = null;

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
    $setores = find_setor_operacional('setor');
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
        print_r($setor);
        echo "-----------------";
        save('setor', $setor);
        print_r($_SESSION['type'] == 'success');

        if ($_SESSION['type'] == 'success') {

            //retorna o ultimo id inserido
            $setor = id_table("setor");

            $setor_id["'setor_id'"] = $setor['id'];

            $setore = $_POST['user_setor'];
            echo "-----------------setor    --->";
            print_r($setor_id);

            foreach ($setore as $setor):
                foreach ($setor as $user):
                    $user_id["'user_id'"] = $user;
                    //uni o os vetores para inserir no banco
                    $user_setor = array_merge($user_id, $setor_id);
                    save('user_setor', $user_setor);
                    print_r($user_setor);

                endforeach;
            endforeach;

            // print_r($setore);
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
            //$customer['modified'] = $now->format("Y-m-d H:i:s");
            update('setor', $id, $setor);
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
    $setor = remove('setor', $id);
    header('location: index.php');
}