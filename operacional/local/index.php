<?php require_once '../../config.php'; ?>
<?php require_once DBAPI; ?>
<?php
    require_once LOGIN2;
    verificaLoginOperador();
?>
<?php
require_once LOCAL;
indexLocal();
?>	
<?php include(HEADER_TEMPLATE_OPERACIONAL); ?>

<section class="content-header">		
    <div class="row">			
        <div class="col-sm-6 text-left">				
            <ol class="breadcrumb">
                <li><a href="<?php echo BASEURL; ?>index.php"><i class="fa fa-home"></i>Página Inicial</a></li>
                <li><i class="fa fa-cube"></i>
                    <small> Listagem de Localidades</small>
                </li>
            </ol>		
        </div>
        <div class="breadcrumb text-right">		    	
            <a class="btn btn-default" href="index.php"><i class="fa fa-refresh"></i> Atualizar</a>		    
        </div>		
    </div>	
</section>

<section class="content">

    <!-- *****Alertas de Operações*****-->
    <?php include(ALERT_MSG); ?>

    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header text-center">
                    <h3>Listagem de locais do sitema</h3>
                    <hr/>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table id="example1" class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th title="Ordenar Tabela">Nome</th>
                            <th title="Ordenar Tabela">Rua</th>
                            <th title="Ordenar Tabela">Bairro</th>
                            <th title="Ordenar Tabela">Número</th>
                            <th>Ações</th>
                        </tr>
                        </thead>
                        <tbody>	
                            <?php if ($locais) : ?>	
                            <?php foreach ($locais as $local) : ?>
                                    <tr>
                                    <td><?php echo $local['nome']; ?></td>			
                                    <td><?php echo $local['rua']; ?></td>			
                                    <td><?php echo $local['Bairro']; ?></td>			
                                    <td><?php echo $local['numero']; ?></td>
                                        <td class="actions text-center">
                                            <a href="view.php?id=<?php echo $local['id']; ?>" class="btn btn-sm btn-success"><i class="fa fa-eye"></i> Visualizar</a>			
                                        </td>
                                    </tr>	
                                <?php endforeach; ?>	
                                <?php else : ?>		
                                <tr>			
                                    <td colspan="6">Nenhum registro encontrado.</td>		
                                </tr>	
                                <?php endif; ?>	
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Nome</th>
                                <th>Rua</th>
                                <th>Bairro</th>
                                <th>Número</th>
                                <th>Ações</th>
                            </tr>
                        </tfoot>
                    </table>
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