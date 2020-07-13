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
            if($table == 'emprestimos'){
                $sql = "SELECT * FROM " . $table . " WHERE id = " . $id;
            }else{
                $sql = "SELECT * FROM " . $table . " WHERE id = " . $id. " ORDER BY nome ASC";
            }
            $result = $database->query($sql);
            if ($result->num_rows > 0) {
                $found = $result->fetch_assoc();
            }
        } else {
            if($table == 'emprestimos'){
                $sql = "SELECT * FROM " . $table;
            }
            else{
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
            $sql = "SELECT id FROM " . $table1 . " WHERE setor_id = " . $id . " AND setor_id IN (SELECT id FROM " . $table2 . " WHERE usuario_id = " . $_SESSION['id'] . ")";
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
            $sql = "SELECT id,setor_id FROM " . $table1 . " WHERE id = " . $id . " AND setor_id IN (SELECT id FROM " . $table2 . " WHERE usuario_id = " . $_SESSION['id'] . ")";
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
            $sql = "SELECT * FROM " . $table1 . " WHERE usuario_id = " . $_SESSION['id'] . " ORDER BY nome ASC";;
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
            $sql = "SELECT id FROM " . $table . " WHERE usuario_id = " . $_SESSION['id'];
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
    //print_r($data);		  
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
            $sql = "SELECT * FROM " . $table . " WHERE status ='" . $status . "'";
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
            }else{
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
            $result = mysqli_fetch_array($database->query("SELECT id FROM " . $table . " WHERE patrimonio_id = " . $patrimonio_id." and status = 'emprestado'"));
            $found = $result[0];
        }
    } catch (Exception $e) {
        $_SESSION['message'] = $e->GetMessage();
        $_SESSION['type'] = 'danger';
    }
    close_database($database);
    return $found;
}

/* Criar chamado */
function add_chamado($chamado_id, $user_id, $setor_id_user, $mensagem_chamado, $setor_id_pedido, $data_pedido, $image_nome){ 
    $database = open_database();  
    $sql = "INSERT INTO chamado(id, setor_id_user, user_id, data_pedido, mensagem_chamado, status, prioridade, img) 
    VALUES (". $chamado_id ."," . $setor_id_user . " ," . $user_id . ",'" . $data_pedido . "','" . $mensagem_chamado . "', " . 0 . ", " . 0 . ",'" . $image_nome . "');";
  
  echo $sql;

    try {
        $database->query($sql);
        $verificar_cadastro_validado = $database->affected_rows;
        if ($verificar_cadastro_validado  > 0) {         
            $_SESSION['message'] = 'Registro cadastrado com sucesso.';
            $_SESSION['type'] = 'success';
        } else {
            $verificar_cadastro_validado = -1;
            $_SESSION['message'] = 'Registro já cadastrado no sistema';
            $_SESSION['type'] = 'warning';
        }
    } catch (Exception $e) {
        $verificar_cadastro_validado = -1;
        $_SESSION['message'] = 'Nao foi possivel realizar a operacao.';
        $_SESSION['type'] = 'danger';
    }    
    close_database($database);

    if($verificar_cadastro_validado > 0 ){
        $database = open_database();
        $sql = "INSERT INTO `chamado_atr_setor`(`chamado_id`, `setor_id`, `permissao_chamado`,status) 
        VALUES ( " . $chamado_id . "," . $setor_id_pedido . ", 1, 0 );" ;
        try {
            $database->query($sql);
            if (($database->affected_rows) > 0) {                
                $_SESSION['message'] = 'Registro cadastrado com sucesso.';
                $_SESSION['type'] = 'success';
            } else {
                $verificar_cadastro_validado = 0;
                $_SESSION['message'] = 'O registro foi cadastrado na tabela "chamado", mas não foi possivel cadastrar na tabela "chamado_atr_setor". </br>Entrar em contato com os adminstradores do sistema.';
                $_SESSION['type'] = 'warning';
            }
        } catch (Exception $e) {
            $verificar_cadastro_validado = 0;
            $_SESSION['message'] = 'Nao foi possivel realizar a operacao.';
            $_SESSION['type'] = 'danger';
        }
        close_database($database);
    }

    if($verificar_cadastro_validado == 0 ){        
        remove('chamado', $chamado_id);
    }
}

/**
 * Realiza a seleção dos setores que o usuario possui permissão retornando um arry 
 * organizado da seguinte forma:
 * $found = array{array{usuario_id => [valor] ,  setor_id => [valor]},
 *                array{usuario_id => [valor] ,  setor_id => [valor]}
 *               } 
 */
function setor_user_select($user_id){

    $database = open_database();
    $found = array();
    $pegar_dados = false;
    try {
        $sql = "SELECT * FROM user_setor WHERE user_id=".$user_id;   
        $result = $database->query($sql);
        if ($result->num_rows > 0) { 
            while($row = $result->fetch_assoc()) {                
                array_push( $found, array( "usuario_id" => $row["user_id"] , "setor_id" => $row["setor_id"]));                              
            }   
            $pegar_dados = true;  
        }
    } catch (Exception $e) {
        $_SESSION['message'] = $e->GetMessage();
        $_SESSION['type'] = 'danger';
    }
    close_database($database);
    
    if($pegar_dados){
        $found = setor_nome($found);
        $found = local_nome($found);
    }   
   
    return $found;
}

function setor_nome($itens){
    $database = open_database();
    $found = array();
    foreach($itens as $item){ 
        try {
            $sql = "SELECT * FROM setor WHERE id=".$item['setor_id'];   
            $result = $database->query($sql);
            if ($result->num_rows > 0) {     
                $row = $result->fetch_assoc();                      
                array_push( $found, array("setor_id" => $item["setor_id"],
                                            "usuario_id" => $item['usuario_id'],                                            
                                            "setor_nome" => $row['nome'],
                                            "local_id" => $row['local_id']));                                                                  
            }
        } catch (Exception $e) {
            $_SESSION['message'] = $e->GetMessage();
            $_SESSION['type'] = 'danger';
        }
        close_database($database);
    }   
    return $found;
}

function local_nome($itens){
    $database = open_database();
    $found = array();
    foreach($itens as $item){ 
        try {
            $sql = "SELECT * FROM locais WHERE id=".$item['local_id'];   
            $result = $database->query($sql);
            if ($result->num_rows > 0) {     
                $row = $result->fetch_assoc();                      
                array_push( $found, array("setor_id" => $item["setor_id"],
                                            "usuario_id" => $item['usuario_id'],                                            
                                            "setor_nome" => $item['setor_nome'],
                                            "local_nome" => $row['nome']));                                                                  
            }
        } catch (Exception $e) {
            $_SESSION['message'] = $e->GetMessage();
            $_SESSION['type'] = 'danger';
        }
        close_database($database);
    }   
    return $found;
}

function chamados_abertos_atr_setor_aberto ($itens){

    $found = array();      
    foreach($itens as $item){               
        $database = open_database();
        try {
            $sql = "SELECT DISTINCT(chamado_id) FROM chamado_atr_setor WHERE setor_id=" . $item['setor_id'] . " AND status=1";   
            $result = $database->query($sql);
            if ($result->num_rows > 0) { 
                while($row = $result->fetch_assoc()) {                
                    array_push( $found, array(  "chamado_id" => $row["chamado_id"], 
                                                "setor_id" => $item['setor_id'],
                                                "setor_nome" => $item['setor_nome'],
                                                "local_nome" => $item['local_nome']));
                }
            }
        } catch (Exception $e) {
            $_SESSION['message'] = $e->GetMessage();
            $_SESSION['type'] = 'danger';
        }
        close_database($database);
    }
    return $found;
}

function chamados_abertos_atr_setor_novo ($itens){

    $found = array();      
    foreach($itens as $item){               
        $database = open_database();
        try {
            $sql = "SELECT DISTINCT(chamado_id) FROM chamado_atr_setor WHERE setor_id=" . $item['setor_id'] . " AND status=0";   
            $result = $database->query($sql);
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    array_push( $found, array(  "chamado_id" => $row["chamado_id"], 
                                                "setor_id" => $item['setor_id'],
                                                "setor_nome" => $item['setor_nome'],
                                                "local_nome" => $item['local_nome']));
                }
            }
        } catch (Exception $e) {
            $_SESSION['message'] = $e->GetMessage();
            $_SESSION['type'] = 'danger';
        }
        close_database($database);
    }      
    return $found;
}

function chamado_prioridade_select($itens){

    $found = array();  
    foreach($itens as $item){              
        $database = open_database();
        try {
            $sql = "SELECT * FROM chamado WHERE id=" . $item['chamado_id'] ." AND status=1";   
            $result = $database->query($sql);
            if ($result->num_rows > 0) { 
                while($row = $result->fetch_assoc()) {                
                    array_push( $found, array("chamado_id"=> $item['chamado_id'], 
                                              "setor_id" => $item["setor_id"],
                                              "setor_nome" => $item['setor_nome'],
                                              "local_nome" => $item['local_nome'],
                                              "user_id" => $row['user_id'],
                                              "data_pedido_chamado" => $row["data_pedido"],
                                              "prioridade_chamado" => $row["prioridade"], 
                                              "mensagem" => $row['mensagem_chamado']));
                }     
            }
        } catch (Exception $e) {
            $_SESSION['message'] = $e->GetMessage();
            $_SESSION['type'] = 'danger';
        }
        close_database($database);
    }    
    
    return $found;
}

function chamado_novo_select($itens){

    $found = array();
    $verificacao = false;  
    foreach($itens as $item){               
        $database = open_database();
        try {
            $sql = "SELECT * FROM chamado WHERE id=" . $item['chamado_id'] ." AND 'status'=0";   
            $result = $database->query($sql);
            if ($result->num_rows > 0) { 
                $verificacao = true;
                while($row = $result->fetch_assoc()) {                
                    array_push( $found, array("chamado_id"=> $item['chamado_id'], 
                                              "setor_id" => $item["setor_id"],
                                              "setor_nome" => $item['setor_nome'],
                                              "local_nome" => $item['local_nome'],
                                              "user_id" => $row['user_id'],                                              
                                              "data_pedido_chamado" => $row["data_pedido"],
                                              "prioridade_chamado" => $row["prioridade"], 
                                              "mensagem" => $row['mensagem_chamado']));
                }     
            }
        } catch (Exception $e) {
            $_SESSION['message'] = $e->GetMessage();
            $_SESSION['type'] = 'danger';
        }
        close_database($database);
    } 
    if($verificacao)     
        return $found;
    else
        return null;
}
