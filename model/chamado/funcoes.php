<?php
    require_once('../../config.php');
    require_once(DBAPI);

/*
    **************************************Cadastrar o chamado ao sistema ***********************
    * Essa função é realizada quando o usuario confirma o cadastramento de um novo chamado.    *
    * Usa as variaveis aseguir para a realização da tarefa:                                    *
    * > $_SESSION['id'] -> ID do usuario                                                       *
    * > $_POST['setor_id_user'] -> Setor do usuario que esta realizando a soliciação           *
    * > $_POST['setor_id_pedido'] -> Setor que esta sendo requisitado a solucionar o problema  *
    * > $_POST['mensagem_chamado] -> Guarda o texto que especifiaca o problema                 *
    * > $data_pedido -> data que foi ralizado o pedido                                         *
    * > $chamado_id -> É o id da tabela chamado, pega o timestamp do servidor atual.           *
    * > $_FILE['img'] -> É a imagem que o usuario deseje colocar se desejado, que pode ser     *
    *                    dos tipo: JPG,JPEG,PNG.
    * > $status -> é divido em três categorias
            0 - novos
            1 - em aberto
            2 - concluidos 
    ********************************************************************************************
*/
    if(isset($_POST['cadastrar_chamado']) ){

        if (!empty($_POST['setor_id_user']) && !empty($_POST['mensagem_chamado']) && !empty($_POST['setor_id_pedido'])) {
        
            $user_id = $_SESSION['id'];
            $setor_id_user = $_POST['setor_id_user'];
            $mensagem_chamado = $_POST['mensagem_chamado'];
            $setor_id_pedido = $_POST['setor_id_pedido'];
            
            date_default_timezone_set('America/Recife');
            $date = new DateTime();
            $chamado_id = $date->getTimestamp();
            $data_pedido = date("Y-m-d H:i:s");
            $image_nome = add_Imagem_chamado();            
            
            add_chamado($chamado_id,$user_id, $setor_id_user, $mensagem_chamado, $setor_id_pedido, $data_pedido, $image_nome);
       
            header('location: index.php');
 
            exit();
        }
    }

/*
    *********Tratamento da Imagem para o servidor**********
    * Gera a localização da imagem no servidor            *
    * Move a imagem para o servidor                       *
    * Retornando o endereço onde a imagem estara alocada  *
    *******************************************************
*/
    function add_Imagem_chamado(){         
         if (is_uploaded_file($_FILES['img']['tmp_name'])) {
            $extensao = strtolower(substr($_FILES['img']['name'], -4)); //pega a extensao do arquivo
            $novo_nome = md5(time()) . $extensao; //define o nome do arquivo
            $diretorio = '../../imagens/chamado/'; //define o diretorio para onde enviaremos o arquivo  
            move_uploaded_file($_FILES['img']['tmp_name'], $diretorio.$novo_nome);          
            return $novo_nome;
         }
         else
             return null;  
    }

/* 
    Listagem de todos Setores cadastrados no banco 
*/
    function Setor_all() {        
        return find_all('setor');
    }


/**
 * Cria um vetor com todos os chamados que o usuario tem acesso a visuzilizar,
 * sendo de terminado setor especificado.
 */
    function chamados_abertos(){
        $itens_chamado_aberto = setor_user_select($_SESSION['id']);
   
        $itens_chamado_aberto = chamados_abertos_atr_setor_aberto($itens_chamado_aberto);

        $itens_chamado_aberto = chamado_prioridade_select($itens_chamado_aberto);

        return $itens_chamado_aberto;        
        
    }

    function sertores_user(){
        return setor_user_select($_SESSION['id']);     
    }


/**  Chamados Criados a pouco tempo 
 * 
 *
 *
 * 
 */
    function chamados_novos(){

        $itens_chamado_aberto = setor_user_select($_SESSION['id']);        
   
        $itens_chamado_aberto = chamados_abertos_atr_setor_novo($itens_chamado_aberto);

        $itens_chamado_aberto = chamado_novo_select($itens_chamado_aberto);

        return $itens_chamado_aberto;
    }

?>