<?php
include 'header.php' ?>
<div class="container-fluid">

    <div class="row">
        <div id='cards'></div>
    </div>
    <div class="row">
    <!-- Nav tabs -->
        <ul class="nav nav-tabs nav-tabs-ar nav-tabs-ar-white">
            <li class="active"><a href="#listReparacoes" data-toggle="tab">Lista De Reparações</a></li>
            <li><a href="#listaClientes" data-toggle="tab">Lista Clientes</a></li>
            <li><a href="#listaEquipamentos" data-toggle="tab">Lista Equipamentos</a></li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">
            <div class="tab-pane active" id="listReparacoes">
                <div class="col-lg-12">
                    </br>
                    <div class="panel panel-primary">
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table id='tabelaHomeAvarias' class="table table-hover table-striped">
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
            <div class="tab-pane" id="listaClientes">
                <div class="col-lg-12">
                    </br>
                    <div class="panel panel-primary">
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table id='tabelaHomeClientes' class="table table-hover table-striped" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>id</th>
                                            <th>Nome</th>
                                            <th>Contacto</th>
                                            <th>Morada</th>
                                            <th>Email</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php include 'listaClientes.php' ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane" id="listaEquipamentos">
                <div class="col-lg-12">
                    </br>
                    <div class="panel panel-primary">
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table id='tabelaHomeEqui' class="table table-hover table-striped" style="width:100%">
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
        </div>

    </div>
</div>
<!-- /.container-fluid -->
<script>


$(function() {

    var buildCards = function(response){
        var element = $('#cards');
        for(var i = 0; i < response.lenght; i++){
            element.append('<div class="panel panel-primary">div class="panel-heading"><div class="row"><div class="col-xs-3"> <i class="fa fa-comments fa-5x"></i></div><div class="col-xs-9 text-right">'+
                                        '<div class="huge">26</div>'+
                                        '<div>New Comments!</div>'+
                                    '</div></div></div><a href="#"><div class="panel-footer"><span class="pull-left">View Details</span>'+
                                    '<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>'+
                                    '<div class="clearfix"></div>'+
                                '</div>'+
                           ' </a>'+
                        '</div>');
        }
    };

    $.ajax({
        type: 'POST',
        url: 'operations/fault/getUserFaultsGroupByState.php',
        data: {},
        dataType: 'json'
    }).done(function(response) {
        // Bar Chart
        /*Morris.Bar({
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
        });*/
        buildCards(response);
    }).fail(function(response){
        console.log(response);
    });
});


    var tabelaHomeClientes = $('#tabelaHomeClientes').DataTable({
        bLengthChange: false,
        columnDefs: [{
                "targets": [ 0 ],
                "visible": false,
                "searchable": false
                }]
    });

    $('#tabelaHomeClientes tbody').off('click').on('click', 'tr', function () {
        var data = tabelaHomeClientes.row( this ).data();
        window.location.href = 'cliente.php?id='+data[0];
    });

    var tabelaHomeEqui = $('#tabelaHomeEqui').DataTable({
        bLengthChange: false
    });

    $('#tabelaHomeEqui tbody').off('click').on('click', 'tr', function () {
        var data = tabelaHomeEqui.row( this ).data();
        //window.location.href = 'cliente.php?id='+data[0];
    });

    var tabelaHomeAvarias = $('#tabelaHomeAvarias').DataTable({
        bLengthChange: false
    });

    $('#tabelaHomeAvarias tbody').off('click').on('click', 'tr', function () {
        var data = tabelaHomeAvarias.row( this ).data();
        //window.location.href = 'cliente.php?id='+data[0];
    });

</script>

<?php include 'footer.php' ?>