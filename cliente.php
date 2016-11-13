<?php include 'header.php' ?>

    <div class="container-fluid">
        <?php
            $clientDao = new ClientDAO();
            //$faultDao = new FaultDao();
            $client = $clientDao->selectClient($_GET['id']);
            //$result = $faultDao->selectClientFaultsGroupByStatus($_GET['id']);
        ?>
        <!-- /.row -->
        <div class="row">
            <div class="col-lg-5">
                <div class="row">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title">Dados</h3>
                        </div>
                        <div class="panel-body">
                            <div class="col-lg-12">
                                <i class="fa fa-user"></i> <?php echo $client->getName(); ?>
                            </div>
                            <div class="col-lg-12">
                                 <i class="fa fa-home"></i> <?php echo $client->getLocal(); ?>
                            </div>
                            <div class="col-lg-12">
                                 <i class="fa fa-envelope"></i> <?php echo $client->getEmail(); ?>
                            </div>
                            <div class="col-lg-12">
                                <i class="fa fa-phone"></i> <?php echo $client->getContact(); ?>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <span class="input-group-btn"><a class="btn btn-primary" href='#'>Editar</a></span>
                            <span class="input-group-btn"><a class="btn btn-primary" href='novaAvaria.php?id=<?php echo $client->getId() ?>'>Nova Avaria</a></span>
                            <span class="input-group-btn novoEquipamentoLink"><a class="btn btn-primary" href='#'>Novo Equipamento</a></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title">Equipamentos do Cliente</h3>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-striped">
                                    <thead>
                                        <tr>
                                            <th>IMEI</th>
                                            <th>Modelo</th>
                                            <th>Observações</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                         <?php include 'listaEquipments.php' ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-7">
                <div class="row">
                    <div class="panel panel-primary"  style="margin-left:10px">
                        <div class="panel-heading">
                            <h3 class="panel-title">Entradas</h3>
                        </div>
                        <div class="panel-body">
                            <div id="morris-bar-chart" style="height:200px"></div>
                            <div class="table-responsive" >
                                <table class="table table-hover table-striped">
                                    <thead>
                                        <tr>
                                            <th>Numero</th>
                                            <th>Equipamento</th>
                                            <th>Data de Entrada</th>
                                            <th>Data de Saida</th>
                                            <th>Orçamento</th>
                                            <th>Estado</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php include 'listaFaults.php' ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- /.container-fluid -->
<script>
    $('.table').DataTable({
        bLengthChange: false
    });
    // Morris.js Charts sample data for SB Admin template
activeButtonLink(<?php echo $_GET['id'] ?>);

$(function() {

    $.ajax({
        type: 'POST',
        url: 'web/operations/fault/getUserFaultsGroupByState.php',
        data: {id:<?php echo $_GET['id']; ?>},
        dataType: 'json'
    }).done(function(response) {
        // Bar Chart
        Morris.Bar({
            element: 'morris-bar-chart',
            data: response,
            xkey: 'state',
            ykeys: ['total'],
            labels: ['Total'],
            xLabelMargin: 10,
            hideHover: 'auto',
            resize: true,
            barColors: function (row, series, type) {
                if(row.label == "Em Analise") return "#337ab7";
                else if(row.label == "Em Reparação") return "#DEBB27";
                else if(row.label == "Sem Reparação") return "#AD1D28";
                else if(row.label == "Reparado") return "#a2cd5a";
                else if(row.label == "Entregue") return "#1AB244";
            }
        });
    });
});


</script>


 <?php 'footer.php' ?>