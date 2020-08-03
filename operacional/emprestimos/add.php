<?php require_once '../../config.php'; ?>
<?php require_once DBAPI; ?>
<?php
require_once LOGIN2;
verificaLoginOperador();
?>
<?php
require_once EMPRESTIMOS;
add_emprestimos();
//$USER = FALSE;
?>
<?php
require_once USUARIO;
$USER = verifica_user_matricula();
index();
?>
<?php
require_once PATRIMONIO;
indexPatrimonio();
?>
<?php include(HEADER_TEMPLATE_OPERACIONAL); ?>

<section class="content-header">
    <div class="row">
        <div class="col-sm-6 text-left">
            <ol class="breadcrumb">
                <li><a href="<?php echo BASEURL; ?>index.php"><i class="fa fa-home"></i>Página Inicial</a></li>
                <li><a href="index.php"><i class="glyphicon glyphicon-list-alt"></i> Listagem de Itens Emprestados</a>
                </li>
                <li><i class="glyphicon glyphicon-plus-sign"></i>
                    <small> Adicionar Empréstimo</small>
                </li>
            </ol>
        </div>
        <div class="breadcrumb text-right">
            <a class="btn btn-default" href="index.php"><i class="glyphicon glyphicon-arrow-left"></i> Voltar</a>
        </div>
    </div>
</section>


<section class="content">

    <!-- *****Alertas de Operações*****-->
    <?php include(ALERT_MSG); ?>

    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <!-- /.box-header -->
                <div class="box-body">
                    <h3 class="text-center">Preencha os campos abaixo para realizar um empréstimo</h3>
                    <hr/>
                    <div class="dataTables_length">
                        <form method="post" action=add.php>
                            <div class="form-group">
                                <label class="col-form-label">Matricula/SIAPE do usuário: </label>
                                <input type="number" id="matricula"
                                       placeholder="Matricula/SIAPE do usuário"
                                       name="matricula" required=""
                                >
                                <button type="submit" class="btn btn-primary btn-xs"><i
                                            class="fa fa-search">Pesquisar</i></button>
                            </div>
                        </form>
                    </div>
                    <?php if ($USER) : ?>
                        <form action=add.php method="post" enctype="multipart/form-data" name='form_add_emprestimo'
                              onsubmit="submete()" target="_blank">

                            <!-- area de campos do form -->
                            <?php if ($usuarios) : ?>
                                <?php foreach ($usuarios as $usuario) : ?>
                                    <?php if ($usuario['matricula'] == $USER) { ?>
                                        <div class="form-group">
                                            <label for="nome">Nome do usuário </label>
                                            <input type="text" class="form-control" id="nome"
                                                   placeholder="Nome do item perdido"
                                                   name="nome" required=""
                                                   maxlength="100" readonly="readonly"
                                                   value="<?php echo $usuario['nome'] ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="destinatario">Destinatário </label>
                                            <input type="text" class="form-control" id="destinatario"
                                                   placeholder="Nome do item perdido"
                                                   name="destinatario" required=""
                                                   maxlength="100" readonly="readonly"
                                                   value="<?php echo $usuario['categoria'] ?>">
                                        </div>
                                        <div class="form-group" style="display:none;">
                                            <label for="user_solicitou"></label>
                                            <input type="text" class="form-control" id="user_solicitou"
                                                   value="<?php echo $usuario['id'] ?>"
                                                   name="user_solicitou">
                                        </div>
                                        <div class="form-group" style="display:none;">
                                            <label for="matricula"></label>
                                            <input type="text" class="form-control" id="matricula"
                                                   value="<?php echo $usuario['matricula'] ?>"
                                                   name="matricula">
                                        </div>
                                    <?php } endforeach; ?>
                            <?php endif; ?>
                            <div class="form-group">
                                <label for="patrimonio_id">Patrimonio </label>
                                <select class="form-control select2" id="patrimonio_id"
                                        name="patrimonio['patrimonio_id'][]" multiple="multiple" required="">
                                    <option value=""></option>
                                    <?php if ($patrimonios) : ?>
                                        <?php foreach ($patrimonios as $patrimonio) : ?>
                                            <?php if ($patrimonio['permissao'] == 1 && ($patrimonio['status'] == NULL || $patrimonio['status'] == "disponivel")) : ?>
                                                <option value="<?php echo $patrimonio['id']; ?>"><?php echo $patrimonio['nome']; ?>
                                                    - <?php echo $patrimonio['tombo']; ?></option>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="title">
                                    <span class="required">Prazo de devolução </span>
                                </label>
                                <div class="item-cont">
                                    <input class="large" data-format="dd-mm-aaaa" type="date"
                                           name="data_prazo_devolucao" id="data_prazo_devolucao"
                                           required="required"/>
                                    <span class="icon-place"></span>
                                </div>
                            </div>
                            <div id="actions" class="row">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary" onclick="return validarData();">
                                        <i class="fa fa-file-pdf-o"></i> Realizar empréstimo
                                    </button>
                                    <a href="index.php" class="btn btn-default">
                                        <i class="fa fa-close"></i> Cancelar</a>
                                </div>
                            </div>
                        </form>
                    <?php endif; ?>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
            <!-- /.box -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</section>

<?php include(FOOTER_TEMPLATE); ?>

<!--Recarrega a páginas após a realização do emprestimo-->
<script>
    function submete() {
        setTimeout(function () {
            window.location.href = "index.php";
        }, 100);
    }
</script>


<script src="<?php echo BASEURL; ?>bower_components/select2/dist/js/select2.full.min.js"></script>


<script>
    $(function () {
        //Initialize Select2 Elements
        $('.select2').select2()
    })
</script>
