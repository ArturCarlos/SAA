<!DOCTYPE html>
<html lang="pt-br" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>SAA-EMCM</title>
    <!-- �?cone da aba do navegador -->
    <link rel="icon" href="<?php echo BASEURL; ?>dist/img/icon.png"/>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="<?php echo BASEURL; ?>bower_components/bootstrap/dist/css/bootstrap.min.css">
    <!--formatacao imagens-->
    <link rel="stylesheet" href="<?php echo BASEURL; ?>dist/css/imagens/imagens.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo BASEURL; ?>bower_components/font-awesome/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="<?php echo BASEURL; ?>bower_components/Ionicons/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo BASEURL; ?>dist/css/AdminLTE.min.css">
    <!-- DataTables -->
    <link rel="stylesheet"
          href="<?php echo BASEURL; ?>bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="<?php echo BASEURL; ?>dist/css/skins/_all-skins.min.css">
    <!-- jvectormap -->
    <link rel="stylesheet" href="<?php echo BASEURL; ?>bower_components/jvectormap/jquery-jvectormap.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="<?php echo BASEURL; ?>bower_components/select2/dist/css/select2.min.css">
    <!-- Date Picker -->
    <link rel="stylesheet"
          href="<?php echo BASEURL; ?>bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="<?php echo BASEURL; ?>bower_components/bootstrap-daterangepicker/daterangepicker.css">
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="<?php echo BASEURL; ?>plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">

    <!-- Google Font -->
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

    <header class="main-header">
        <!-- Logo -->
        <a href="<?php echo BASEURL; ?>admin/index.php" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><b>SAA</b></span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg"><b>SAA</b> - EMCM</span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>

            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <li>
                        <div style="margin-right: 10px; margin-top:-6px;">
                            <h3 class="label-primary"><i class="ion ion-clock" title="tempo de sessão"></i></h3>
                        </div>
                    </li>
                    <li>
                        <div style="margin-top:20px">
                            <h6 class="label-primary"><b><span title="tempo de sessão" id="cronometro"
                                                               onload="startCountdown();"> </span></b></h6>
                        </div>
                    </li>
                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">

                            <!--Recupera imagem do usuário-->
                            <?php require_once IMAGENS ?>

                            <?php $imagem = nome_foto_usuario($_SESSION['id']) ?>

                            <!--Verifica se a imagem está disponivel-->
                            <?php if ($imagem != null) { ?>
                                <img src="<?php echo BASEURL; ?>imagens/usuario/<?php echo $imagem ?>"
                                     class="user-image" alt="User Image">
                            <?php } else { ?>
                                <img src="<?php echo BASEURL; ?>dist/img/iconousuario.jpg" class="user-image"
                                     alt="User Image">

                            <?php } ?>

                            <span class="hidden-xs">
                                <?php
                                /*Recupera nome do usuario*/
                                $user = nome_usuario($_SESSION['id']);
                                /*Mostra o primeiro nome*/
                                $nome = explode(" ", $user);
                                echo $nome[0] ?>
                            </span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- User image -->
                            <li class="user-header">
                                <!--Recupera imagem do usuário-->
                                <?php $imagem = nome_foto_usuario($_SESSION['id']) ?>
                                <!--Verifica se a imagem está disponivel-->
                                <?php if ($imagem != null) { ?>
                                    <img src="<?php echo BASEURL; ?>imagens/usuario/<?php echo $imagem ?>"
                                         class="img-circle" alt="User Image">
                                <?php } else { ?>
                                    <img src="<?php echo BASEURL; ?>dist/img/iconousuario.jpg" class="img-circle"
                                         alt="User Image">

                                <?php } ?>
                                <p>
                                    <?php echo $user ?>
                                    <br>Administrador
                                    <small>Departamento de Tecnologia</small>
                                </p>
                            </li>

                            <!-- Menu Footer-->
                            <li class="user-footer">
                                <div class="pull-left">
                                    <a href="<?php echo BASEURL; ?>admin/usuario/view.php?id=<?php echo $_SESSION['id']; ?>"
                                       class="btn btn-default btn-flat">Perfil</a>
                                </div>
                                <div class="pull-right">
                                    <a href="<?php echo BASEURL; ?>model/logout/funcoes.php?id=sair"
                                       class="btn btn-default btn-flat">Sair</a>
                                </div>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
            <ul class="sidebar-menu" data-widget="tree">

                <li class="header">MENU DE NAVEGAÇÃO</li>
                <!-- ACHADOS E PERDIDOS -->
                <li>
                    <a href="<?php echo BASEURL; ?>admin/achados_e_perdidos/index.php">
                        <i class="glyphicon glyphicon-search"></i><span>Achados e perdidos</span>
                    </a>
                </li>
                <!-- AGENDA DA EMCM -->
                <li>
                    <a href="<?php echo BASEURL; ?>admin/agenda/agenda.php">
                        <i class="glyphicon glyphicon-calendar"></i><span>Agenda</span>
                    </a>
                </li>
                <!-- EMPRÉSTIMOS-->
                <li class="treeview">
                    <a href="#">
                        <i class="glyphicon glyphicon-list-alt"></i>
                        <span>Empréstimos</span>
                        <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="<?php echo BASEURL; ?>admin/emprestimos/consulta.php"><i
                                        class="fa fa-circle-o"></i> Consultar itens emprestáveis</a></li>
                        <li><a href="<?php echo BASEURL; ?>admin/emprestimos/index.php"><i class="fa fa-circle-o"></i>
                                Gerenciar Empréstimos</a></li>
                    </ul>
                </li>
                <!-- FORMUL�?RIOS-->
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-edit"></i> <span>Formulários</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="<?php echo BASEURL; ?>admin/formGraduacao/index.php"><i class="fa fa-circle-o"></i>
                                Alunos Graduação</a></li>
                        <li><a href="<?php echo BASEURL; ?>admin/formResidencia/index.php"><i
                                        class="fa fa-circle-o"></i> Alunos Residência</a></li>
                    </ul>
                </li>

                <!-- GERENCIAR LOCALIDADES-->
                <li>
                    <a href="<?php echo BASEURL; ?>admin/local/index.php">
                        <i class="fa fa-cube"></i><span>Gerenciar Localidades</span>
                    </a>
                </li>

                <!-- GERENCIAR PATRIMÔNIOS-->
                <li>
                    <a href="<?php echo BASEURL; ?>admin/patrimonio/index.php">
                        <i class="fa fa-bank"></i><span>Gerenciar Patrimônios</span>
                    </a>
                </li>

                <!-- GERENCIAR SETORES-->
                <li>
                    <a href="<?php echo BASEURL; ?>admin/setor/index.php">
                        <i class="fa fa-cubes"></i><span>Gerenciar Setores</span>
                    </a>
                </li>

                <!-- GERENCIAR USUÁRIOS-->
                <li>
                    <a href="<?php echo BASEURL; ?>admin/usuario/index.php">
                        <i class="fa fa-users"></i><span>Gerenciar Usuários</span>
                    </a>
                </li>
            </ul>
        </section>
    </aside>

    <!-- Div conteúdo central -->
    <div class="content-wrapper">