<?php
    include ('src/DAO/connectDAO.php');
    include('src/DAO/ClienteDAO.php');
    include('src/DAO/UserDAO.php');
    include('src/DAO/EquipmentDAO.php');
    include('src/DAO/FaultDAO.php');
    include('src/DAO/EstadoDAO.php');

    include ('src/classes/Client.php');
    include ('src/classes/Equipment.php');
    include ('src/classes/Fault.php');
    include ('src/classes/User.php');
    include ('src/classes/Estado.php');
?>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin - Bootstrap Admin Template</title>

    <!-- Bootstrap Core CSS -->
    <link href="web/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="web/css/sb-admin.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="web/css/plugins/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="web/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="web/js/DataTables/media/css/jquery.dataTables.css"/>
    <link rel="stylesheet" type="text/css" href="web/js/sweetalert-master/dist/sweetalert.css">
    <link rel="stylesheet" type="text/css" href="web/js/sweetalert-master/themes/facebook/facebook.css">
    <link rel="stylesheet" type="text/css" href="web/js/sweetalert-master/dist/swal-forms.css">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/animate.css/3.2.0/animate.min.css">
    <link type="text/css" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jsgrid/1.4.1/jsgrid.min.css" />
    <link type="text/css" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jsgrid/1.4.1/jsgrid-theme.min.css" />


    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
    <script type="text/javascript" src="web/js/jsPDF/dist/jspdf.min.js"></script>
    <script type="text/javascript" src="web/js/noty/js/noty/packaged/jquery.noty.packaged.min.js"></script>
    <script type="text/javascript" src="web/js/DataTables/media/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="web/js/jsPDF-AutoTable-master/dist/jspdf.plugin.autotable.js"></script>
    <script type="text/javascript" src="web/js/sweetalert-master/dist/sweetalert.min.js"></script> 
    <script type="text/javascript" src="web/js/sweetalert-master/dist/swal-forms.js"></script>
    <script type="text/javascript" src="web/js/animatedModal/animatedModal.js"></script> 
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jsgrid/1.4.1/jsgrid.min.js"></script>
    <script type="text/javascript" src="web/js/headerImgData.js"></script>
    <script src="web/js/plugins/morris/raphael.min.js"></script>
    <script src="web/js/plugins/morris/morris.min.js"></script>

    <script type="text/javascript" src="web/js/MyLib/buttonAddClient.js"></script>

</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php"><img style="height: 30px; float: left; margin-right: 5px" class="icon-bar" src="img/CRC.gif">Gestor de Clientes</a>
            </div>
            <!-- Top Menu Items -->
            <ul class="nav navbar-right top-nav">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> Utilizador<b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li class="divider"></li>
                        <li>
                            <a href="#"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                        </li>
                    </ul>
                </li>
            </ul>
            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav side-nav">
                    <li class="active">
                        <a href="index.php"><i class="fa fa-fw fa-dashboard"></i> Home</a>
                    </li>
                    <li>
                       <a href="gerirClientes.php"><i class="fa fa-users"></i> Clientes</a>
                       <ul>
                            <li>
                                <a class='novoClienteLink' href="#"><i class="fa fa-user"></i> Novo Cliente</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="gerirReparacoes.php"><i class="fa fa-cogs"></i> Reparações</a>
                        <ul>
                            <li>
                                <a class='novaReparacaoLink' href="novaAvaria.php"><i class="fa fa-cog"></i> Nova Entrada</a>
                            </li>
                            <li>
                                <a class='novoEquipamentoLink' href="#"><i class="fa fa-desktop"></i> Novo Equipamento</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="stock.php"><i class="fa fa-tasks"></i> Stock</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </nav>
        <script type="text/javascript">
            activeButtonLink();
        </script>
        <div id="page-wrapper">