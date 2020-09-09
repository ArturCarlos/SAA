<?php require_once '../../config.php'; ?>
<?php require_once DBAPI; ?>
<?php
require_once LOGIN2;
verificaLoginAdmin();
?>

<?php
require_once SETOR;

indexSetor();

?>
<?php
require_once LOCAL;
?>


<?php
require_once CHAMADO;
add_acesso_chamado();

index_acesso_chamado();
?>
<?php include(HEADER_TEMPLATE); ?>

<!-- Main conteudoCentral -->

<section class="content-header">
    <div class="row">
        <div class="col-sm-6 text-left">
            <ol class="breadcrumb">
                <li><a href="<?php echo BASEURL; ?>index.php"><i class="fa fa-home"></i>Página Inicial</a></li>
                <li><a href="<?php echo BASEURL; ?>admin/chamado/gerenciar.php"><i class="fa fa-gears "></i>Gerenciar</a></li>
                <li><i class="fa fa-th-large"></i>

                    <small>Acesso</small>
                </li>
            </ol>
        </div>

    </div>
</section>

<section class="content">

    <div class='row'>
        <div class="col-xs-12">
            <div class='box'>
                <div class="box-header text-center">
                    <h3>Gerenciar acesso ao chamado</h3>
                    <hr/>
                </div>

                <div class="box-body">
                    <form action=acesso.php method="post">

                        <div class="form-group">
                            <h4>Setores com acesso ao chamado</h4>
                            <select class="form-control select2" id="setor_id"
                                    name="acesso_chamado['setor_id'][]" multiple="multiple" required="">
                                <?php if ($setores) : ?>

                                    <?php foreach ($setores as $setor) :
                                        $aux = true;
                                        foreach ($acesso_chamado as $ac_setor) :
                                            if (($setor['id'] == $ac_setor['setor_id'])) : ?>
                                                <option selected="selected"
                                                        value="<?php echo $ac_setor['setor_id']; ?>">
                                                    <?php echo $setor['nome']; ?>
                                                    - <?php echo $nome_setor = (nome_setor_local($setor['local_id'])); ?></option>
                                                <?php
                                                $aux = false;
                                                break;
                                            endif;
                                        endforeach;
                                        if ($aux):?>
                                            <option value="<?php echo $setor['id']; ?>">
                                                <?php echo $setor['nome']; ?>
                                                - <?php echo $nome_setor = (nome_setor_local($setor['local_id'])); ?></option>

                                        <?php endif;

                                    endforeach;
                                endif;

                                ?>

                            </select>
                        </div>
                        <div id="actions" class="row">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-check"></i> Cadastrar
                                </button>
                                <a href="gerenciar.php" class="btn btn-default">
                                    <i class="fa fa-close"></i> Cancelar</a>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</section>
<!-- /.content -->

<?php include('modal.php'); ?>
<?php include(FOOTER_TEMPLATE); ?>

<script src="<?php echo BASEURL; ?>bower_components/select2/dist/js/select2.full.min.js"></script>


<script>
    $(function () {
        //Initialize Select2 Elements
        $('.select2').select2()
    })
</script>
