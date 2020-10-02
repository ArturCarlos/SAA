<?php

mysqli_report(MYSQLI_REPORT_STRICT);

session_start();

/** *  Inicia a conexão com o BD    */
function open_database()
{
    try {
        $conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        return $conn;
    } catch (Exception $e) {
        echo $e->getMessage();
        return null;
    }
}

/** *  Fecha a conexão com o BD     */
function close_database($conn)
{
    try {
        mysqli_close($conn);
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}

/* Pesquisa um Registro pelo ID em uma Tabela */
function find($table = null, $id = null)
{
    $database = open_database();
    $found = null;
    try {
        if ($id) {
            if ($table == 'emprestimos') {
                $sql = "SELECT * FROM " . $table . " WHERE id = " . $id;
            } else {
                $sql = "SELECT * FROM " . $table . " WHERE id = " . $id . " ORDER BY nome ASC";
            }
            $result = $database->query($sql);
            if ($result->num_rows > 0) {
                $found = $result->fetch_assoc();
            }
        } else {
            if ($table == 'emprestimos') {
                $sql = "SELECT * FROM " . $table;
            } else {
                $sql = "SELECT * FROM " . $table . " ORDER BY nome ASC";
            }
            $result = $database->query($sql);
            if ($result->num_rows > 0) {
                $found = $result->fetch_all(MYSQLI_ASSOC);
            }
        }
    } catch (Exception $e) {
        $_SESSION['message'] = $e->GetMessage();
        $_SESSION['type'] = 'danger';
    }
    close_database($database);
    return $found;
}

function find_data_prazo_emprestimo($table, $id)
{
    $database = open_database();
    $found = null;
    try {
        if ($id) {
            //$sql = "SELECT nome FROM " . $table . " WHERE id = " . $local_id;
            //$result = $database->query($sql);
            $result = mysqli_fetch_array($database->query("SELECT data_prazo_devolucao FROM " . $table . " WHERE id = " . $id));
            $found = $result[0];
        }
    } catch (Exception $e) {
        $_SESSION['message'] = $e->GetMessage();
        $_SESSION['type'] = 'danger';
    }
    close_database($database);
    return $found;
}

function find_nome($table, $id)
{
    $database = open_database();
    $found = null;
    try {
        if ($id) {
            //$sql = "SELECT nome FROM " . $table . " WHERE id = " . $local_id;
            //$result = $database->query($sql);
            $result = mysqli_fetch_array($database->query("SELECT nome FROM " . $table . " WHERE id = " . $id));
            $found = $result[0];
        }
    } catch (Exception $e) {
        $_SESSION['message'] = $e->GetMessage();
        $_SESSION['type'] = 'danger';
    }
    close_database($database);
    return $found;
}

/* Retonar o id_local do setor*/
function setor_local_id($table, $id)
{
    $database = open_database();
    $found = null;
    try {
        if ($id) {

            $result = mysqli_fetch_array($database->query("SELECT local_id FROM " . $table . " WHERE id = " . $id));
            $found = $result[0];
        }
    } catch (Exception $e) {
        $_SESSION['message'] = $e->GetMessage();
        $_SESSION['type'] = 'danger';
    }
    close_database($database);
    return $found;
}

function find_patrimonio_emprestimo($table, $id)
{
    $database = open_database();
    $found = null;
    try {
        if ($id) {
            $result = mysqli_fetch_array($database->query("SELECT patrimonio_id FROM " . $table . " WHERE id = " . $id));
            $found = $result[0];
        }
    } catch (Exception $e) {
        $_SESSION['message'] = $e->GetMessage();
        $_SESSION['type'] = 'danger';
    }
    close_database($database);
    return $found;
}

/* Pesquisa um Registro pelo ID do setor em uma Tabela */
function find_operacional($table1 = null, $table2 = null, $id)
{
    $database = open_database();
    $found = FALSE;
    try {
        if ($_SESSION['id'] != NULL) {
            $sql = "SELECT id FROM " . $table1 . " WHERE setor_id = " . $id . " AND setor_id IN (SELECT setor_id FROM " . $table2 . " WHERE user_id = " . $_SESSION['id'] . ")";
            //SELECT * FROM `patrimonio` WHERE setor_id IN (SELECT id FROM setor WHERE usuario_id = 1);
            $result = $database->query($sql);
            if ($result->num_rows > 0) {
                $found = TRUE;
            }
        }
    } catch (Exception $e) {
        $_SESSION['message'] = $e->GetMessage();
        $_SESSION['type'] = 'danger';
    }
    close_database($database);
    return $found;
}

/* Pesquisa um Registro pelo ID do setor em uma Tabela */
function find_edit_operacional($table1 = null, $table2 = null, $id)
{
    $database = open_database();
    $found = FALSE;
    try {
        if ($_SESSION['id'] != NULL) {
            $sql = "SELECT id,setor_id FROM " . $table1 . " WHERE id = " . $id . " AND setor_id IN (SELECT setor_id FROM " . $table2 . " WHERE user_id = " . $_SESSION['id'] . ")";
            //SELECT * FROM `patrimonio` WHERE setor_id IN (SELECT id FROM setor WHERE usuario_id = 1);
            $result = $database->query($sql);
            if ($result->num_rows > 0) {
                $found = TRUE;
            }
        }
    } catch (Exception $e) {
        $_SESSION['message'] = $e->GetMessage();
        $_SESSION['type'] = 'danger';
    }
    close_database($database);
    return $found;
}

/* Pesquisa um setor pelo ID do usuário */
function find_setor_operacional($table1 = null)
{
    $database = open_database();
    $found = null;
    try {
        if ($_SESSION['id'] != NULL) {
            $sql = "SELECT * FROM " . $table1 . " WHERE user_id = " . $_SESSION['id'];
            //SELECT * FROM `patrimonio` WHERE setor_id IN (SELECT id FROM setor WHERE usuario_id = 1);
            $result = $database->query($sql);
            if ($result->num_rows > 0) {
                $found = $result->fetch_all(MYSQLI_ASSOC);
            }
        }
    } catch (Exception $e) {
        $_SESSION['message'] = $e->GetMessage();
        $_SESSION['type'] = 'danger';
    }
    close_database($database);
    return $found;
}

/* Pesquisa se o usuário é responsável por algum setor */
function find_exist_setor_usuario($table = null)
{
    $database = open_database();
    $found = FALSE;
    try {
        if ($_SESSION['id'] != NULL) {
            $sql = "SELECT user_id FROM " . $table . " WHERE user_id = " . $_SESSION['id'];
            $result = $database->query($sql);
            if ($result->num_rows > 0) {
                $found = TRUE;
            } else {
                $_SESSION['message'] = 'Você não tem permissão para cadastrar um patrimônio, pois não é responsável por nenhum setor.';
                $_SESSION['type'] = 'danger';
            }
        }
    } catch (Exception $e) {
        $_SESSION['message'] = $e->GetMessage();
        $_SESSION['type'] = 'danger';
    }
    close_database($database);
    return $found;
}

/* Pesquisa Todos os Registros de uma Tabela */
function find_all($table)
{
    return find($table);
}

/** *  Insere um registro no BD     */
function save($table = null, $data = null)
{
    $database = open_database();

    $columns = null;
    $values = null;
    foreach ($data as $key => $value) {
        $columns .= trim($key, "'") . ",";
        $values .= "'$value',";
    }

    //Verifica se o arquivo foi enviado
    if (is_uploaded_file($_FILES['img']['tmp_name'])) {
        //pega a extensao do arquivo
        $extensao = strtolower(substr($_FILES['img']['name'], -4));
        $novo_nome = md5(time()) . $extensao; //define o nome do arquivo
        $columns .= 'img';
        $values .= "'$novo_nome',";
    }

    // remove a ultima virgula
    $columns = rtrim($columns, ',');
    $values = rtrim($values, ',');

    $sql = "INSERT INTO " . $table . "($columns)" . " VALUES " . "($values);";

    try {
        $database->query($sql);
        if (($database->affected_rows) > 0) {

            //move a tofo para pasta
            if (isset($_FILES['img'])) {
                $diretorio = '../../imagens/'; //define o diretorio para onde enviaremos o arquivo
                move_uploaded_file($_FILES['img']['tmp_name'], $diretorio . $table . '/' . $novo_nome); //efetua o upload
            }
            $_SESSION['message'] = 'Registro cadastrado com sucesso.';
            $_SESSION['type'] = 'success';
        } else {
            $_SESSION['message'] = 'Registro já cadastrado no sistema';
            $_SESSION['type'] = 'warning';
        }
    } catch (Exception $e) {
        $_SESSION['message'] = 'Nao foi possivel realizar a operacao.';
        $_SESSION['type'] = 'danger';

    }
    close_database($database);
}

/** *  Salva informações do formulário    */
function saveForm($tipo_req, $tipo_form, $usuario_matricula)
{
    date_default_timezone_set('America/Sao_Paulo');
    $database = open_database();
    $sql = "INSERT INTO formulario(data_requerimento, usuario_id, tipo_requisicao, tipo_formulario) "
        . "VALUES(NOW()," . $usuario_matricula . ",'" . $tipo_req . "','" . $tipo_form . "')";
    try {
        $database->query($sql);
        if (($database->affected_rows) > 0) {
//            $_SESSION['message'] = 'Registro cadastrado com sucesso.';
//            $_SESSION['type'] = 'success';
        } else {
//            $_SESSION['message'] = 'Registro já cadastrado no sistema';
//            $_SESSION['type'] = 'warning';
        }
    } catch (Exception $e) {
        $_SESSION['message'] = 'Nao foi possivel realizar a operacao.';
        $_SESSION['type'] = 'danger';

    }
    close_database($database);
}

/** *  Salva informações dos emprestimos    */
function save_emp($user_solicitou, $patrimonio_id, $status, $data_prazo_devolucao)
{
    $found = FALSE;
    $user_realizou = $_SESSION['id'];
    //$data_emprestimo = NOW();
    date_default_timezone_set('America/Sao_Paulo');
    $database = open_database();
    $sql = "INSERT INTO emprestimos(data_emprestimo, user_realizou, user_solicitou, patrimonio_id, status, data_prazo_devolucao) "
        . "VALUES(NOW()," . $user_realizou . "," . $user_solicitou . "," . $patrimonio_id . ",'" . $status . "','" . $data_prazo_devolucao . "')";
    try {
        $database->query($sql);
        if (($database->affected_rows) > 0) {
            $_SESSION['message'] = 'Empréstimo realizado com sucesso.';
            $_SESSION['type'] = 'success';
            $found = TRUE;
        } else {
            $_SESSION['message'] = 'Empréstimo não realizado!';
            $_SESSION['type'] = 'warning';
        }
    } catch (Exception $e) {
        $_SESSION['message'] = 'Nao foi possivel realizar a operacao.';
        $_SESSION['type'] = 'danger';

    }
    close_database($database);
    return $found;
}

/** *  Atualiza um registro no BD   */
function update($table = null, $id = 0, $data = null)
{
    $database = open_database();

    $img = recupera_img($table, $id);
    $items = null;

    //Verifica se um arquivo foi enviado
    if (is_uploaded_file($_FILES['img']['tmp_name'])) {
        //pega a extensao do arquivo
        $extensao = strtolower(substr($_FILES['img']['name'], -4));
        $novo_nome = md5(time()) . $extensao;
        //define o nome do arquivo
        $items .= trim('img', "'") . "='$novo_nome',";

        //move a foto para pasta
        $diretorio = '../../imagens/';//define o diretorio para onde enviaremos o arquivo
        move_uploaded_file($_FILES['img']['tmp_name'], $diretorio . $table . '/' . $novo_nome); //efetua o upload

        //diretorio da imagem da imagem antida
        $dir_img = ABSPATH . 'imagens/' . $table . '/' . $img;
        //apaga imagem antiga
        unlink($dir_img);

    }

    foreach ($data as $key => $value) {
        $items .= trim($key, "'") . "='$value',";
    }    // remove a ultima virgula


    $items = rtrim($items, ',');
    $sql = "UPDATE " . $table;
    $sql .= " SET $items";
    $sql .= " WHERE id=" . $id . ";";
    try {
        $database->query($sql);
        //verifica se ouve alguma alteracão no banco
        if (($database->affected_rows) > 0) {
            $_SESSION['message'] = 'Registro atualizado com sucesso.';
            $_SESSION['type'] = 'success';
        } else {
            $_SESSION['message'] = 'Não foi possível realizar essa operacão! Verifique se os dados editados estão corretos ou já estão cadastrados.';
            $_SESSION['type'] = 'warning';
        }
    } catch (Exception $e) {
        $_SESSION['message'] = 'Nao foi possivel realizar a operacao.';
        $_SESSION['type'] = 'danger';
    }
    close_database($database);
}

/** *  Atualiza um registro no BD   */
function update_status($table = null, $id = null, $status = null)
{
    $database = open_database();
    $sql = "UPDATE " . $table . " SET status = '" . $status . "' WHERE id = " . $id;
    try {
        $database->query($sql);
        if (($database->affected_rows) > 0) {
        }
    } catch (Exception $e) {
        $_SESSION['message'] = 'Nao foi possivel realizar a operacao.';
        $_SESSION['type'] = 'danger';
    }
    close_database($database);
}

/** *  Faz login no sistema */
function login($table, $matricula, $senha)
{
    $database = open_database();
    $found = null;
    try {
        if ($matricula != null && $senha != null) {
            $senha = md5($senha);
            $sql = "SELECT * FROM " . $table . " WHERE matricula =" . $matricula . " AND senha='" . $senha . "'";
            $result = $database->query($sql);
            if ($result->num_rows == 1 /*usuario existe na base */) {
                $row = $result->fetch_assoc();
                if ($row['permissao'] == 1 /*usuario administrador */) {

                    $nome = explode(" ", $row['nome']);

                    $_SESSION['message'] = "Bem Vindo(a) " . $nome[0];
                    $_SESSION['type'] = 'success';
                    $_SESSION['id'] = $row['id'];
                    $_SESSION['matricula'] = $matricula;
                    $_SESSION['senha'] = $senha;
                    $_SESSION['nome'] = $row['nome'];
                    $_SESSION['email'] = $row['email'];
                    $_SESSION['permissao'] = $row['permissao'];
                    $found = $row['permissao'];
                } elseif ($row['permissao'] == 2 /*usuario operacional */) {

                    $nome = explode(" ", $row['nome']);

                    $_SESSION['message'] = "Bem Vindo(a): " . $nome[0];
                    $_SESSION['type'] = 'success';
                    $_SESSION['id'] = $row['id'];
                    $_SESSION['matricula'] = $matricula;
                    $_SESSION['senha'] = $senha;
                    $_SESSION['nome'] = $row['nome'];
                    $_SESSION['email'] = $row['email'];
                    $_SESSION['permissao'] = $row['permissao'];
                    $found = $row['permissao'];
                } else /*usuario comum */ {
                    $_SESSION['message'] = "Você não tem permissão para logar no sistema";
                    $_SESSION['type'] = 'danger';
                    $found = $row['permissao'];
                }
            } else {
                // Mensagem de erro quando os dados são inválidos e/ou o usuário não foi encontrado
                $_SESSION['message'] = "Viiixe, não foi possivel logar, usuário não encontrado ou dados inválidos";
                $_SESSION['type'] = 'danger';
                $found = 0;
            }
        }
    } catch (Exception $e) {
        $_SESSION['message'] = $e->GetMessage();
        $_SESSION['type'] = 'danger';
        $found = 0;
    }
    close_database($database);
    return $found;
}

/** *  Remove um registro no BD     */
function remove($table = null, $id = null)
{
    $database = open_database();

    $img = recupera_img($table, $id);

    try {
        if ($id) {
            $sql = "DELETE FROM " . $table . " WHERE id = " . $id;
            $result = $database->query($sql);
            if ($result = $database->query($sql)) {
                if ($img != null) {
                    //diretorio da imagem
                    $dir_img = ABSPATH . 'imagens/' . $table . '/' . $img;
                    //exclui a imagem
                    unlink($dir_img);
                }
                $_SESSION['message'] = "Registro Removido com Sucesso";
                $_SESSION['type'] = 'success';
            } else {

                $_SESSION['message'] = "Viiixe! Não foi possivel realizar a operação. Verifique se esse registro está sendo referenciado em outro local";
                $_SESSION['type'] = 'danger';
            }
        }

    } catch (Exception $e) {
        $_SESSION['message'] = $e->GetMessage();
        $_SESSION['type'] = 'danger';
    }
    close_database($database);
}

function updateSenha($table, $id, $senha)
{
    $database = open_database();
    $found = null;
    try {
        if ($id != null && $senha != null) {
            $senha = md5($senha);
            $sql = "UPDATE " . $table . " SET senha='" . $senha . "' WHERE id=" . $id;
            $database->query($sql);
            //verifica se ouve alguma alteracão no banco
            if (($database->affected_rows) > 0) {
                $_SESSION['message'] = 'Senha redefinida com sucesso.';
                $_SESSION['type'] = 'success';
                $found = $_SESSION['permissao'];
            } else {
                $_SESSION['message'] = 'O usuário já está com a senha padrão.';
                $_SESSION['type'] = 'warning';
            }
        } else {
            $_SESSION['message'] = "Viiixe, não foi possivel mudar a senha";
            $_SESSION['type'] = 'danger';
        }
    } catch (Exception $e) {
        $_SESSION['message'] = 'Nao foi possivel realizar a operacao.';
        $_SESSION['type'] = 'danger';
    }
    close_database($database);
    return $found;
}

function updateSenhaLogin($table, $id, $senha)
{
    $database = open_database();
    $found = null;
    try {
        if ($id != null && $senha != null) {
            $senha = md5($senha);
            $sql = "UPDATE " . $table . " SET senha='" . $senha . "' WHERE id=" . $id;
            $database->query($sql);
            //verifica se ouve alguma alteracão no banco
            if (($database->affected_rows) > 0) {
                $_SESSION['senha'] = $senha;
                $_SESSION['message'] = 'Senha atualizada com sucesso. Bem vindo ao sistema!';
                $_SESSION['type'] = 'success';
                $found = $_SESSION['permissao'];
            } else {
                $_SESSION['message'] = 'Não foi possível realizar essa operacão! Verifique se os dados editados estão corretos ou já estão cadastrados.';
                $_SESSION['type'] = 'warning';
            }
        } else {
            $_SESSION['message'] = "Viiixe, não foi possivel mudar a senha";
            $_SESSION['type'] = 'danger';
        }
    } catch (Exception $e) {
        $_SESSION['message'] = 'Nao foi possivel realizar a operacao.';
        $_SESSION['type'] = 'danger';
    }
    close_database($database);
    return $found;
}

function recupera_img($table = null, $id = null)
{

    $database = open_database();
    //Recupera o valor da imagem
    $img = mysqli_fetch_array($database->query("SELECT img FROM " . $table . " WHERE id = " . $id));
    $img = $img[0];
    close_database($database);
    return $img;

}

function valor_id($table = null, $chave = null, $id = null)
{

    $database = open_database();
    //Recupera ao tombo do produto
    $valor = mysqli_fetch_array($database->query("SELECT " . $chave . " FROM " . $table . " WHERE id = " . $id));
    $valor = $valor[0];
    close_database($database);
    return $valor;

}

function recupera_nome($table = null, $id = null)
{

    $database = open_database();
    //Recupera o valor da imagem
    $img = mysqli_fetch_array($database->query("SELECT nome FROM " . $table . " WHERE id = " . $id));
    $img = $img[0];
    close_database($database);
    return $img;

}

/* Pesquisa um setor pelo ID de um local */
function findSetor($table = null, $idLocal = null)
{
    $database = open_database();
    $found = null;
    try {
        if ($idLocal != NULL) {
            $sql = "SELECT * FROM " . $table . " WHERE local_id = " . $idLocal . " ORDER BY nome ASC";
            $result = $database->query($sql);
            if ($result->num_rows > 0) {
                $found = $result->fetch_assoc();
                $_SESSION['message'] = 'true';
                $_SESSION['type'] = 'success';
            }
        }
    } catch (Exception $e) {
        $_SESSION['message'] = $e->GetMessage();
        $_SESSION['type'] = 'danger';
    }
    close_database($database);
    return $found;
}

function find_all_achados($table, $status)
{
    return find_filtros($table, $status);
}

function find_filtros($table = null, $filtro = null)
{
    $database = open_database();
    $found = null;
    try {
        if ($filtro != null) {
            $sql = "SELECT * FROM " . $table . " WHERE " . implode(' and ', $filtro) . " ORDER BY nome ASC";

            //$sql = "SELECT * FROM " . $table . " WHERE status = " . $status . " ORDER BY nome ASC";
            $result = $database->query($sql);
            if ($result->num_rows > 0) {
                $found = $result->fetch_all(MYSQLI_ASSOC);
            }
        } else {
            $sql = "SELECT * FROM " . $table . " ORDER BY nome ASC";
            $result = $database->query($sql);
            if ($result->num_rows > 0) {
                $found = $result->fetch_all(MYSQLI_ASSOC);
            }
        }
    } catch (Exception $e) {
        $_SESSION['message'] = $e->GetMessage();
        $_SESSION['type'] = 'danger';
    }
    close_database($database);
    return $found;
}

function find_all_emprestimos($table, $status)
{
    return find_emprestimos($table, $status);
}

function emprestimos_filtro($table, $filtro)
{
    return find_emprestimos_filtro($table, $filtro);
}

function find_emprestimos_filtro($table = null, $filtro = null)
{
    $database = open_database();
    $found = null;

    //permissao do patrimonio emprestavel
    $permissao = 1;
    try {
        if ($filtro != null) {
            // SELECT * FROM `patrimonio` WHERE setor_id IN (SELECT id FROM setor WHERE local_id IN (SELECT id FROM locais))
            $sql = "SELECT * FROM " . $table . " WHERE " . implode(' and ', $filtro) . " AND permissao = 1 ORDER BY nome ASC";
            $result = $database->query($sql);

            if ($result->num_rows > 0) {
                $found = $result->fetch_all(MYSQLI_ASSOC);
            }
        }
    } catch (Exception $e) {
        $_SESSION['message'] = $e->GetMessage();
        $_SESSION['type'] = 'danger';
    }
    close_database($database);
    return $found;
}


function find_emprestimos($table = null, $status = null)
{
    $database = open_database();
    $found = null;
    try {
        if ($status != null) {
            $sql = "SELECT * FROM " . $table . " WHERE status ='" . $status . "'    ORDER BY data_emprestimo DESC";
            $result = $database->query($sql);
            if ($result->num_rows > 0) {
                $found = $result->fetch_all(MYSQLI_ASSOC);
            }
        } else {
            $sql = "SELECT * FROM " . $table . " ORDER BY data_emprestimo DESC";
            $result = $database->query($sql);
            if ($result->num_rows > 0) {
                $found = $result->fetch_all(MYSQLI_ASSOC);
            }
        }
    } catch (Exception $e) {
        $_SESSION['message'] = $e->GetMessage();
        $_SESSION['type'] = 'danger';
    }
    close_database($database);

    return $found;
}

function itens_emptrestimo($table = null, $id = null)
{
    $database = open_database();
    $found = null;
    try {
        if ($id != null) {
            $sql = "SELECT nome, tombo FROM " . $table . " WHERE id IN (SELECT patrimonio_id FROM emprestimos WHERE id =" . $id . " )";

            $result = $database->query($sql);
            if ($result->num_rows > 0) {
                $found = $result->fetch_all(MYSQLI_ASSOC);
            }
        } else {
            $sql = "SELECT * FROM " . $table;
            $result = $database->query($sql);
            if ($result->num_rows > 0) {
                $found = $result->fetch_all(MYSQLI_ASSOC);
            }
        }
    } catch (Exception $e) {
        $_SESSION['message'] = $e->GetMessage();
        $_SESSION['type'] = 'danger';
    }
    close_database($database);

    return $found;
}

function find_user_matricula($table = null, $matricula = null)
{
    $database = open_database();
    $found = FALSE;
    try {
        if ($matricula != null) {
            $sql = "SELECT * FROM " . $table . " WHERE matricula = " . $matricula;
            $result = $database->query($sql);
            if ($result->num_rows > 0) {
                $found = $matricula;
                $_SESSION['message'] = 'Usuário informado encontrado!';
                $_SESSION['type'] = 'success';
            } else {
                $_SESSION['message'] = 'Usuário informado não existe!';
                $_SESSION['type'] = 'warning';
            }
        }
    } catch (Exception $e) {
        $_SESSION['message'] = $e->GetMessage();
        $_SESSION['type'] = 'danger';
    }
    close_database($database);
    return $found;
}

/*retorna o id do emprestimo*/
function find_id_empretimo($table, $patrimonio_id)
{
    $database = open_database();
    $found = null;
    try {
        if ($patrimonio_id) {
            //$sql = "SELECT nome FROM " . $table . " WHERE id = " . $local_id;
            //$result = $database->query($sql);
            $result = mysqli_fetch_array($database->query("SELECT id FROM " . $table . " WHERE patrimonio_id = " . $patrimonio_id . " and status = 'emprestado'"));
            $found = $result[0];
        }
    } catch (Exception $e) {
        $_SESSION['message'] = $e->GetMessage();
        $_SESSION['type'] = 'danger';
    }
    close_database($database);
    return $found;
}

/*Retorna o ultimo id inserido na tabela*/
function id_table($table)
{

    $database = open_database();
    try {
        if ($table != NULL) {
            $sql = "SELECT id FROM (
            SELECT id FROM " . $table . " ORDER BY id DESC LIMIT 1) AS 
                " . $table . " ORDER BY id LIMIT 1";
            $result = $database->query($sql);
            if ($result->num_rows > 0) {
                $found = $result->fetch_assoc();
                $_SESSION['message'] = 'true';
                $_SESSION['type'] = 'success';
            }
        }
    } catch (Exception $e) {
        $_SESSION['message'] = $e->GetMessage();
        $_SESSION['type'] = 'danger';
    }
    close_database($database);

    return $found;


}

/* Pesquisa Todos os Registros de uma Tabela */
function find_all_user_setor($table)
{
    return find_user_setor($table);
}

/** *  Atualiza um registro no BD   */
function deleta_user_setor($table = null, $id = null)
{
    $database = open_database();

    try {
        if ($id) {

            $sql1 = "SELECT setor_id FROM patrimonio WHERE setor_id = " . $id;

            $result1 = $database->query($sql1);
            if ($result1->num_rows == 0) {

                $sql = "DELETE FROM " . $table . " WHERE setor_id = " . $id;
                $result = $database->query($sql);
                if ($result = $database->query($sql)) {

                    $_SESSION['message'] = "Registro Removido com Sucesso";
                    $_SESSION['type'] = 'success';
                } else {

                    $_SESSION['message'] = "Viiixe! Não foi possivel realizar a operação. Verifique se esse registro está sendo referenciado em outro local";
                    $_SESSION['type'] = 'danger';
                }
            }
        }

    } catch (Exception $e) {
        $_SESSION['message'] = $e->GetMessage();
        $_SESSION['type'] = 'danger';
    }
    close_database($database);

}


/** *  Remove usuario do setor id     */
function remove_user_setor($table = null, $id = null)
{
    $database = open_database();


    try {
        if ($id) {
            $sql = "DELETE FROM " . $table . " WHERE setor_id = " . $id;
            $result = $database->query($sql);
            if ($result = $database->query($sql)) {

                $_SESSION['message'] = "Registro Removido com Sucesso";
                $_SESSION['type'] = 'success';
            } else {

                $_SESSION['message'] = "Viiixe! Não foi possivel realizar a operação. Verifique se esse registro está sendo referenciado em outro local";
                $_SESSION['type'] = 'danger';
            }
        }

    } catch (Exception $e) {
        $_SESSION['message'] = $e->GetMessage();
        $_SESSION['type'] = 'danger';
    }
    close_database($database);
}

/*Retorna valores de setor*/
function find_user_setor($table = null)
{
    $database = open_database();
    $found = null;
    try {
        $sql = "SELECT * FROM " . $table;

        $result = $database->query($sql);
        if ($result->num_rows > 0) {
            $found = $result->fetch_all(MYSQLI_ASSOC);
        }

    } catch (Exception $e) {
        $_SESSION['message'] = $e->GetMessage();
        $_SESSION['type'] = 'danger';
    }
    close_database($database);
    return $found;
}


function remove_setor_acesso($table = null)
{
    $database = open_database();
    $found = null;
    try {
        if ($table = 'acesso_chamado') {
            $sql = "DELETE FROM " . $table;

            $result = $database->query($sql);

        }
    } catch (Exception $e) {
        $_SESSION['message'] = $e->GetMessage();
        $_SESSION['type'] = 'danger';
    }
    close_database($database);
    return $found;
}

//Adiciona sem anexo
function adicionar($table = null, $data = null)
{
    $database = open_database();

    $columns = null;
    $values = null;
    foreach ($data as $key => $value) {
        $columns .= trim($key, "'") . ",";
        $values .= "'$value',";
    }


    // remove a ultima virgula
    $columns = rtrim($columns, ',');
    $values = rtrim($values, ',');

    $sql = "INSERT INTO " . $table . "($columns)" . " VALUES " . "($values);";

    try {
        $database->query($sql);

        if (($database->affected_rows) > 0) {

            $_SESSION['message'] = 'Registro cadastrado com sucesso.';
            $_SESSION['type'] = 'success';
        } else {
            $_SESSION['message'] = 'Registro já cadastrado no sistema';
            $_SESSION['type'] = 'warning';
        }
    } catch (Exception $e) {
        $_SESSION['message'] = 'Nao foi possivel realizar a operacao.';
        $_SESSION['type'] = 'danger';

    }
    close_database($database);
}


/** *  Insere um registro no BD Com arquivos em anexo     */
function add($table = null, $data = null)
{
    $database = open_database();

    $columns = null;
    $values = null;
    foreach ($data as $key => $value) {
        $columns .= trim($key, "'") . ",";
        $values .= "'$value',";
    }

    //Verifica se o arquivo foi enviado
    if (is_uploaded_file($_FILES['anexo']['tmp_name'])) {
        //pega a extensao do arquivo
        $extensao = strtolower(substr($_FILES['anexo']['name'], -4));
        $novo_nome = md5(time()) . $extensao; //define o nome do arquivo
        $columns .= 'anexo';
        $values .= "'$novo_nome',";
    }


    // remove a ultima virgula
    $columns = rtrim($columns, ',');
    $values = rtrim($values, ',');

    $sql = "INSERT INTO " . $table . "($columns)" . " VALUES " . "($values);";

    try {
        $database->query($sql);

        if (($database->affected_rows) > 0) {

            //move o anexo para pasta
            if (isset($_FILES['anexo'])) {
                $diretorio = '../../anexo/'; //define o diretorio para onde enviaremos o arquivo
                move_uploaded_file($_FILES['anexo']['tmp_name'], $diretorio . $table . '/' . $novo_nome); //efetua o upload
            }
            adicionar_notificacao($table, id_table($table));
            $_SESSION['message'] = 'Registro cadastrado com sucesso.';
            $_SESSION['type'] = 'success';
        } else {
            $_SESSION['message'] = 'Registro já cadastrado no sistema';
            $_SESSION['type'] = 'warning';
        }
    } catch (Exception $e) {
        $_SESSION['message'] = 'Nao foi possivel realizar a operacao.';
        $_SESSION['type'] = 'danger';

    }
    close_database($database);
}

/* Pesquisa Todos os Registros de uma Tabela */
function find_all_chamado($table, $id_user, $type, $status = null)
{
    if ($status == 1 || $status == 0) {
        if ($type == 'setor') {
            //Pesquisa o atribuido ao setor
            $pesquisa = 'setor_destino';
            return find_chamado($table, $id_user, $pesquisa, $status);

        } elseif ($type == 'user') {
            $pesquisa = 'user_id';

            //Pesquisa o chamado criado por um usuario
            return find_chamado($table, $id_user, $pesquisa, $status);

        } elseif ($type == 'tag_chamado') {
            $pesquisa = 'chamado_id';

            //Pesquisa o chamado criado por um usuario
            return find_chamado($table, $id_user, $pesquisa, $status);
        }

    } else {
        if ($type == 'setor') {
            //Pesquisa o atribuido ao setor
            $pesquisa = 'setor_destino';
            return find_chamado($table, $id_user, $pesquisa);

        } elseif ($type == 'user') {
            $pesquisa = 'user_id';

            //Pesquisa o chamado criado por um usuario
            return find_chamado($table, $id_user, $pesquisa);

        } elseif ($type == 'tag_chamado') {
            $pesquisa = 'chamado_id';

            //Pesquisa o chamado criado por um usuario
            return find_chamado($table, $id_user, $pesquisa);
        }
    }
}

/* Pesquisa Todos os Registros de uma Tabela */
function find_all_resp_chamado($table, $id_user, $type)
{

    if ($type == 'chamado_id') {
        //Pesquisa o atribuido ao setor
        $pesquisa = 'chamado_id';
        return find_chamado($table, $id_user, $pesquisa);

    }
}


function find_chamado($table = null, $id = null, $type = null, $status = null)
{
    $database = open_database();
    $found = null;
    try {
        if (is_int($status)) {
            $sql = "SELECT * FROM " . $table . " WHERE " . $type . " = " . $id . " AND status = " . $status;
        } elseif ($type) {
            $sql = "SELECT * FROM " . $table . " WHERE " . $type . " = " . $id;
        } elseif ($id) {
            $sql = "SELECT * FROM " . $table . " WHERE id = " . $id;

        }


        $result = $database->query($sql);
        if ($result->num_rows > 0) {
            $found = $result->fetch_all(MYSQLI_ASSOC);
        }

    } catch
    (Exception $e) {
        $_SESSION['message'] = $e->GetMessage();
        $_SESSION['type'] = 'danger';
    }
    close_database($database);

    return $found;
}

function recupera_anexo($table = null, $id = null)
{

    $database = open_database();
    //Recupera o valor da imagem
    $img = mysqli_fetch_array($database->query("SELECT anexo FROM " . $table . " WHERE id = " . $id));
    $img = $img[0];
    close_database($database);
    return $img;

}


/** *  Atualiza um registro no BD   */
function update_chamado($table = null, $id = 0, $data = null)
{
    $database = open_database();

    $img = recupera_anexo($table, $id);
    $items = null;

    //Verifica se um arquivo foi enviado
    if (is_uploaded_file($_FILES['anexo']['tmp_name'])) {
        //pega a extensao do arquivo
        $extensao = strtolower(substr($_FILES['anexo']['name'], -4));
        $novo_nome = md5(time()) . $extensao;
        //define o nome do arquivo
        $items .= trim('anexo', "'") . "='$novo_nome',";

        //move a foto para pasta
        $diretorio = '../../anexo/';//define o diretorio para onde enviaremos o arquivo
        move_uploaded_file($_FILES['anexo']['tmp_name'], $diretorio . $table . '/' . $novo_nome); //efetua o upload

        //diretorio da imagem da imagem antida
        $dir_img = ABSPATH . 'anexo/' . $table . '/' . $img;
        //apaga imagem antiga
        unlink($dir_img);

    }

    foreach ($data as $key => $value) {
        $items .= trim($key, "'") . "='$value',";
    }    // remove a ultima virgula


    $items = rtrim($items, ',');
    $sql = "UPDATE " . $table;
    $sql .= " SET $items";
    $sql .= " WHERE id=" . $id . ";";
    try {
        $database->query($sql);
        //verifica se ouve alguma alteracão no banco
        if (($database->affected_rows) > 0) {
            $_SESSION['message'] = 'Registro atualizado com sucesso.';
            $_SESSION['type'] = 'success';
        } else {
            $_SESSION['message'] = 'Não foi possível realizar essa operacão! Verifique se os dados editados estão corretos ou já estão cadastrados.';
            $_SESSION['type'] = 'warning';
        }
    } catch (Exception $e) {
        $_SESSION['message'] = 'Nao foi possivel realizar a operacao.';
        $_SESSION['type'] = 'danger';
    }
    close_database($database);
}


/** *  Atualiza um registro no BD   */
function chamado_fechar($table = null, $id = 0, $data = null)
{
    $database = open_database();

    $items = null;

    foreach ($data as $key => $value) {
        $items .= trim($key, "'") . "='$value',";
    }    // remove a ultima virgula


    $items = rtrim($items, ',');
    $sql = "UPDATE " . $table;
    $sql .= " SET $items";
    $sql .= " WHERE id=" . $id . ";";
    try {
        $database->query($sql);
        //verifica se ouve alguma alteracão no banco
        if (($database->affected_rows) > 0) {
            $_SESSION['message'] = 'Registro atualizado com sucesso.';
            $_SESSION['type'] = 'success';
        } else {
            $_SESSION['message'] = 'Não foi possível realizar essa operacão! Verifique se os dados editados estão corretos ou já estão cadastrados.';
            $_SESSION['type'] = 'warning';
        }
    } catch (Exception $e) {
        $_SESSION['message'] = 'Nao foi possivel realizar a operacao.';
        $_SESSION['type'] = 'danger';
    }
    close_database($database);
}


/** *  Remove usuario do setor id     */
function remove_tag_chamado($table = null, $id = null)
{
    $database = open_database();

    try {
        if ($id) {
            $sql = "DELETE FROM " . $table . " WHERE chamado_id = " . $id;
            $result = $database->query($sql);
            if ($result = $database->query($sql)) {

                $_SESSION['message'] = "Registro Removido com Sucesso";
                $_SESSION['type'] = 'success';
            } else {

                $_SESSION['message'] = "Viiixe! Não foi possivel realizar a operação. Verifique se esse registro está sendo referenciado em outro local";
                $_SESSION['type'] = 'danger';
            }
        }

    } catch (Exception $e) {
        $_SESSION['message'] = $e->GetMessage();
        $_SESSION['type'] = 'danger';
    }
    close_database($database);
}


function find_chamado_acesso($table, $id, $type, $status)
{
    $database = open_database();
    $found = null;
    try {
        $sql = "SELECT * FROM " . $table . " WHERE " . $type . " = " . $id . " AND user_id = " . $status;


        $result = $database->query($sql);
        if ($result->num_rows > 0) {
            $found = $result->fetch_all(MYSQLI_ASSOC);
        }

    } catch
    (Exception $e) {
        $_SESSION['message'] = $e->GetMessage();
        $_SESSION['type'] = 'danger';
    }
    close_database($database);

    return $found;
}


/** *  Remove um registro no BD     */
function remove_chamado($table = null, $id = null)
{
    $database = open_database();

    $img = recupera_anexo($table, $id);

    $resp_chamado = null;
    try {
        if ($id) {
            if ($table == 'chamado') {
                $resp_chamado = find_all_resp_chamado('resp_chamado', $id, 'chamado_id');
            }
            $sql = "DELETE FROM " . $table . " WHERE id = " . $id;
            $result = $database->query($sql);
            if ($result = $database->query($sql)) {
                if ($img != null) {
                    //diretorio do anexo
                    $dir_img = ABSPATH . 'anexo/' . $table . '/' . $img;
                    //exclui o anexo
                    unlink($dir_img);
                }
                if ($resp_chamado) {
                    foreach ($resp_chamado as $anexo) {
                        if ($anexo['anexo']) {
                            $dir_img = ABSPATH . 'anexo/resp_chamado/' . $anexo['anexo'];
                            //exclui o anexo
                            unlink($dir_img);
                        }
                    }
                }
                $_SESSION['message'] = "Registro Removido com Sucesso";
                $_SESSION['type'] = 'success';
            } else {

                $_SESSION['message'] = "Viiixe! Não foi possivel realizar a operação. Verifique se esse registro está sendo referenciado em outro local";
                $_SESSION['type'] = 'danger';
            }
        }

    } catch (Exception $e) {
        $_SESSION['message'] = $e->GetMessage();
        $_SESSION['type'] = 'danger';
    }
    close_database($database);
}

function chamado_filtro($table, $filtro)
{
    return find_chamado_filtro($table, $filtro);
}

function find_chamado_filtro($table = null, $filtro = null)
{
    $database = open_database();
    $found = null;

    try {
        if ($filtro != null) {

            $sql = "SELECT * FROM " . $table . " WHERE " . implode(' and ', $filtro);

            $result = $database->query($sql);

            if ($result->num_rows > 0) {
                $found = $result->fetch_all(MYSQLI_ASSOC);
            }
        }
    } catch (Exception $e) {
        $_SESSION['message'] = $e->GetMessage();
        $_SESSION['type'] = 'danger';
    }
    close_database($database);
    return $found;
}


//Adiciona sem anexo
function adicionar_notificacao($table, $id)
{
    $database = open_database();

    if ($table == 'chamado') {
        $id_chamado = $id['id'];
        $descricao = "Novo chamado";
        $sql = "INSERT INTO item_notificacao (chamado_id, descricao) VALUE " . "({$id_chamado},'$descricao');";
    }
    if ($table == 'resp_chamado') {
        $resposta_id = $id['id'];
        $chamado = find_chamado('resp_chamado', $resposta_id, 'id');
        $id_chamado = $chamado[0]['chamado_id'];
        $descricao = "Resposta do chamado";
        $sql = "INSERT INTO item_notificacao (chamado_id, resposta_id, descricao) VALUE " . "({$id_chamado},$resposta_id,'$descricao');";
    }


    try {
        if ($sql) {
            print_r($table);
            $database->query($sql);
            destino_notificacao();
        }

    } catch (Exception $e) {
        $_SESSION['message'] = 'Nao foi adicionar a notificação.';
        $_SESSION['type'] = 'danger';

    }
    close_database($database);
}

//Adiciona sem anexo
function destino_notificacao()
{
    $database = open_database();

    $item_notificacao_id = id_table('item_notificacao');
    $item_notificacao_id = $item_notificacao_id['id'];

    $item_notificacao = find_chamado('item_notificacao', $item_notificacao_id);

    $chamado_id = $item_notificacao[0]['chamado_id'];
    $chamado = find_chamado('chamado', $chamado_id);

    $setor_destino = find_chamado_setor('user_setor', $chamado[0]['setor_destino']);
    $setor_origem = find_chamado_setor('user_setor', $chamado[0]['setor_origem']);

    $user_setor = array_merge($setor_destino, $setor_origem);

    $id_user = [];

    foreach ($user_setor as $user) {
        array_push($id_user, $user['user_id']);
    }
    $id_user = array_unique($id_user);
    try {

        foreach ($id_user as $id) {
            if ($id != $_SESSION['id']) {
                $sql = "INSERT INTO destino_notificacao (item_notificacao_id, user_id, status) VALUE " . "($item_notificacao_id,$id,1);";
                $database->query($sql);

            }
        }


    } catch (Exception $e) {
        $_SESSION['message'] = 'Nao foi adicionar a notificação.';
        $_SESSION['type'] = 'danger';

    }
    close_database($database);
}

/*Retorna usuarios de um setor*/
function find_chamado_setor($table, $id)
{
    $database = open_database();
    $found = null;
    try {
        $sql = "SELECT user_id FROM " . $table . " WHERE setor_id = " . $id;

        $result = $database->query($sql);
        if ($result->num_rows > 0) {
            $found = $result->fetch_all(MYSQLI_ASSOC);
        }

    } catch (Exception $e) {
        $_SESSION['message'] = $e->GetMessage();
        $_SESSION['type'] = 'danger';
    }
    close_database($database);
    return $found;
}

function count_notificacao()
{
    $database = open_database();
    $id = $_SESSION['id'];
    try {
        //SELECT COUNT(column_name)
        //FROM table_name
        //WHERE condition;
        $sql = "SELECT COUNT(item_notificacao_id) FROM destino_notificacao WHERE user_id = " . $id . " AND status = 1";
        $result = $database->query($sql);
        if ($result->num_rows > 0) {
            $found = $result->fetch_all(MYSQLI_ASSOC);
        }

    } catch (Exception $e) {
        $_SESSION['message'] = $e->GetMessage();
        $_SESSION['type'] = 'danger';
    }
    close_database($database);
    return ($found[0]['COUNT(item_notificacao_id)']);

}

function lista_notificacao()
{
    $database = open_database();
    $id = $_SESSION['id'];
    $found = null;
    try {
        //SELECT chamado_id FROM item_notificacao WHERE id IN
        // ( SELECT item_notificacao_id FROM destino_notificacao WHERE user_id = 1 AND status = 1)
        $sql = "SELECT chamado_id FROM item_notificacao WHERE id IN" .
            "(SELECT item_notificacao_id FROM destino_notificacao WHERE user_id = " . $id .
            " AND status = 1)";
        $result = $database->query($sql);
        if ($result->num_rows > 0) {
            $found = $result->fetch_all(MYSQLI_ASSOC);
        }

    } catch (Exception $e) {
        $_SESSION['message'] = $e->GetMessage();
        $_SESSION['type'] = 'danger';
    }
    close_database($database);
    return $found;

}