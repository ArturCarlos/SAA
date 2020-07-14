<?php require_once '../../config.php'; ?>
<?php require_once DBAPI; ?>
<?php
    require_once LOGIN2;
    verificaLoginAdmin();
?>
<?php 
    require_once CHAMADO;
  
?>
<?php
    require_once LOCAL;
    indexLocal();
?>

<?php include(HEADER_TEMPLATE); ?>

<!-- Main conteudoCentral -->

<section class="content-header">
    <div class="row">
        <div class="col-sm-6 text-left">
            <ol class="breadcrumb">
                <li><a href="<?php echo BASEURL; ?>index.php"><i class="fa fa-home"></i>Página Inicial</a></li>
                <li><i class="glyphicon glyphicon-bullhorn"></i>

                    <small> Chamados</small>
                </li>
            </ol>
        </div>
        <div class="breadcrumb text-right">
            <a class="btn btn-primary" href="./add.php"><i class="fa fa-plus">
                </i> &nbsp Criar Chamado </a>
        </div>
    </div>
</section>

<section class="content">

    <?php include(ALERT_MSG); ?>

    <div class='row'>
        <div class="col-xs-12">
            <div class='box'>
                <div class="nav-tabs-custom">
                    <!-- Tabs within a box -->
                    <ul class="nav nav-tabs pull-lefth ui-sortable-handle">
                        <li class="">
                            <a href="#chamado_novos" data-toggle="tab" aria-expanded="false">Novos Chamados
                                <?php
                                    $item_chamando_novos = chamados_novos();
                                    //var_dump( $item_chamando_novos);  
                                    if(isset($item_chamando_novos)): 
                                    ?>
                                <span>
                                    <i class="fa  fa-exclamation"
                                        style="background-color: red; width: 15px; padding-top: 2px; padding-bottom: 2px; padding-left: 5px; padding-right: 5px; color:#ffffff; border-radius: 3px">
                                    </i>
                                </span>
                                <?php endif; ?>
                            </a>
                        </li>

                        <li class="active">
                            <a href="#chamado_aberto" data-toggle="tab" aria-expanded="true">Em Aberto</a>
                        </li>
                        <li class=""><a href="#chamado_concluido" data-toggle="tab" aria-expanded="false">Concluidos</a>
                        </li>
                        <li class=""><a href="#chamado_pedido" data-toggle="tab" aria-expanded="false">Enviados</a></li>
                    </ul>
                </div>
                <div class="tab-content no-padding">

                    <div class="chart tab-pane" id="chamado_novos"
                        style="padding-top:25px; position: relative; padding-bottom: 25px;">
                        <div class="row">
                            <div class=col-md-12>
                                <?php 
                                if(isset($item_chamando_novos)):                                    
                                    foreach ($item_chamando_novos as $chamado): ?>
                                        <div class="col-md-3">
                                            <div class="chamado-box box-body">
                                                <a href="chamado_detalhe.php?ch=<?php echo $chamado["chamado_id"]; ?>">
                                                    <div class="chamado-box-head-neutro">
                                                        <p class="chamado-box-user"> <?php echo $chamado["user_id"]; ?> </p>
                                                        <p class="chamado-box-setor"> <?php echo $chamado["setor_nome"] ." - ". $chamado['local_nome']; ?> </p>
                                                    </div>
                                                    <div class="chamado-box-body">
                                                        <p> <strong>Detalhes do chamado:</strong> <br />
                                                            <?php 
                                                            if(strlen($chamado['mensagem']) < 120){ 
                                                                echo $chamado["mensagem"];
                                                            }else{
                                                                echo substr($chamado["mensagem"],0,120) . "...";
                                                            }                                                            
                                                            ?>
                                                        </p>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    <?php endforeach;  
                                endif; ?>
                            </div>
                        </div>
                    </div>


                    <div class="chart tab-pane active" id="chamado_aberto"
                        style="padding-top:25px; position: relative; padding-bottom: 25px; -webkit-tap-highlight-color: rgba(0, 0, 0, 0);">
                        <div class="row">
                            <div class=col-md-12>
                                <?php $item_chamando_aberto = chamados_abertos();
                                foreach ($item_chamando_aberto as $chamado): ?>
                                    <div class="col-md-3">
                                        <div class="chamado-box box-body">
                                            <a href="chamado_detalhe.php?ch=<?php echo $chamado["chamado_id"];?>">
                                                <?php if($chamado["prioridade_chamado"] == 1): ?>
                                                <div class="chamado-box-head-red">
                                                <?php endif; ?>
                                                <?php if ( $chamado["prioridade_chamado"] == 2): ?>
                                                <div class="chamado-box-head-yellow">
                                                <?php endif; ?>
                                                <?php if($chamado["prioridade_chamado"] == 3): ?>
                                                <div class="chamado-box-head-blue">
                                                <?php endif; ?>                                                   
                                                    <p class="chamado-box-user"> <?php echo $chamado["user_id"]; ?> </p>
                                                    <p class="chamado-box-setor"> <?php echo $chamado["setor_nome"] ." - ". $chamado['local_nome']; ?> </p>                                        
                                                </div>
                                                <div class="chamado-box-body">
                                                    <p> <strong>Detalhes do chamado:</strong> <br />
                                                        <?php 
                                                            if(strlen($chamado['mensagem']) < 120){ 
                                                                echo $chamado["mensagem"];
                                                            }else{
                                                                echo substr($chamado["mensagem"],0,120) . "...";
                                                            }                                                           
                                                        ?>
                                                    </p>
                                                </div>                                                  
                                                
                                            </a>
                                        </div>
                                    </div>
                                    <?php
                                            /** echo '<br>ID chamado - - - - - - - - ' . $chamado["chamado_id"] . 
                                            *    '<br>User_id - - - - - - - - - - - -' . $chamado["user_id"] .
                                            *    '<br>Setor - - - - - - - - - - - - - -' . $chamado["setor_id"] . 
                                            *    '<br>Data - - - - - - - - - - - - - - ' . $chamado["data_pedido_chamado"] . 
                                            *    '<br>Prioridade chamado -  ' . $chamado["prioridade_chamado"]  . 
                                            *    '<br>Mensagem - - - - - - - - - ' . $chamado["mensagem"];
                                            */
                                    endforeach; ?>
                            </div>
                        </div>
                    </div>

                    <div class="chart tab-pane" id="chamado_concluido"
                        style="padding-top:25px; position: relative; padding-bottom: 25px; ">
                        <div class="row">

                            <div class=col-md-12>
                                <?php 
                                //$itens_chamando = chamados_concluidos();
                                //foreach ($itens_chamando as $chamado): ?>
                                <div class="col-md-3">
                                    <div class="chamado-box box-body">
                                        <a href="chamado_detalhe.php?ch=<?php echo $chamado["chamado_id"];?>">
                                            <div class="chamado-box-head-green">
                                                <p class="chamado-box-user"> <?php //echo $chamado["user_id"]; ?> </p>
                                                <p class="chamado-box-setor"> <?php //echo $chamado["setor_nome"] ." - ". $chamado['local_nome']; ?> </p>
                                            </div>

                                            <div class="chamado-box-body">                                               
                                                <p> <strong>Detalhes do chamado:</strong> <br />
                                                    <?php 
                                                    /*
                                                        if(strlen($chamado['mensagem']) < 120){ 
                                                            echo $chamado["mensagem"];
                                                        }else{
                                                            echo substr($chamado["mensagem"],0,120) . "...";
                                                        }   
                                                    */                                                        
                                                    ?>
                                                </p>                                      
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                <?php //endforeach; ?>                              
                            </div>
                        </div>
                    </div>

                    <div class="chart tab-pane" id="chamado_pedido"
                        style="padding-top:25px; position: relative; padding-bottom: 25px;">
                        <div class="row">
                        
                            <div class=col-md-12>
                                <?php 
                                //$itens_chamando = chamados_enviados();
                                //foreach ($itens_chamando as $chamado): ?>
                                <div class="col-md-3">
                                    <div class="chamado-box">
                                        <div class="chamado-box-head-neutro">
                                            <p class="chamado-box-user"> <?php //echo $chamado["user_id"]; ?> </p>
                                            <p class="chamado-box-setor"> <?php //echo $chamado["setor_nome"] ." - ". $chamado['local_nome']; ?> </p>
                                        </div>

                                        <div class="chamado-box-body">
                                            <p> <strong>Detalhes do chamado:</strong> <br />
                                                <?php 
                                                /*
                                                    if(strlen($chamado['mensagem']) < 120){ 
                                                        echo $chamado["mensagem"];
                                                    }else{
                                                        echo substr($chamado["mensagem"],0,120) . "...";
                                                    }   
                                                */                                                        
                                                ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- /.content -->

<?php include('modal.php'); ?>
<?php include(FOOTER_TEMPLATE); ?>