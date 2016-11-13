<?php include 'header.php' ?>
<div class="container-fluid">
    <!-- /.row -->
   
    <div class="row">
        <div class="col-lg-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2> Stock</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div id='stockChart'></div>
                    <div class="chart-legend row">
                        <div class="x_panel">
                            <div class="x_content">
                                <div class="row">
                                    <div class="col-lg-3">
                                        <div class='col-lg-1' style="height:15px;background-color:#26B99A"></div>
                                        <span class='col-lg-9' style="font-size: smaller;">Ocas</span>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class='col-lg-1' style="height:15px;background-color:#34495E"></div>
                                        <span class='col-lg-9' style="font-size: smaller;">Aros Brancos</span>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class='col-lg-1' style="height:15px;background-color:#0a0e12"></div>
                                        <span class='col-lg-9' style="font-size: smaller;">Aros Pretos</span>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class='col-lg-1' style="height:15px;background-color:#2d285f"></div>
                                        <span class='col-lg-9' style="font-size: smaller;">Vidros Brancos</span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3">
                                        <div class='col-lg-1' style="height:15px;background-color:#1e1a3f"></div>
                                        <span class='col-lg-9' style="font-size: smaller;">Vidros Pretos</span>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class='col-lg-1' style="height:15px;background-color:#605d0a"></div>
                                        <span class='col-lg-9' style="font-size: smaller;">Pelicula Polarizada</span>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class='col-lg-1' style="height:15px;background-color:#393706"></div>
                                        <span class='col-lg-9' style="font-size: smaller;">Pelicula Temperada</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
     <div class="row">
        <div class="x_panel">
            <div class="x_title">
                <h2>Stock</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="table-responsive" id='tabelaDeStock'></div>
            </div>
        </div>
    </div>
</div>
            <!-- /.container-fluid -->
<script>


$.ajax({
        type: 'POST',
        url: '../src/operations/stock/getAllStock.php',
        dataType: 'json'
    }).done(function(response) {
        var array = [];
        for( var x in response){
            array.push(response[x]);
        }

        Morris.Bar({
              element: 'stockChart',
              data: array ,
              xkey: 'equipamento',
              barColors: ['#26B99A', '#34495E',  '#0a0e12', '#2d285f', '#1e1a3f', '#605d0a', '#393706'],
              ykeys: ['ocas', 'arosBrancos', 'arosPretos', 'vidrosBrancos', 'vidrosPretos', 'peliculaPolarizada', 'peliculaTemperada'],
              labels: ['Ocas', 'Aros Brancos', 'Aros Pretos', 'Vidros Brancos', 'Vidros Pretos', 'Pelicula Polarizada', 'Pelicula Temperada'],
              xLabelMargin: 10,
                hideHover: 'auto',
                resize: true,
            });

    });


$('#tabelaDeStock').jsGrid({
    width: "100%",
    editing: true,
    sorting: true,
    paging: true,
    autoload: true,
    inserting: true,
    pageSize: 15,
    pageButtonCount: 5,
    deleteItem: function(item) {
        swal({
              title: "Remover equipamento",
              text: "Tem a certeza que quer apagar o equipamento "+ item.equipamento +"?",
              showCancelButton: true,
              confirmButtonColor: "#DD6B55",
              confirmButtonText: "Sim",
              cancelButtonText: "Não",
              closeOnConfirm: false
            },
            function(isConfirm){
                if(isConfirm){
                    $.ajax({
                        url: "../src/operations/stock/deleteStock.php",
                        dataType: "json",
                        type: 'POST',
                        data: item
                    }).done(function(response) {
                        if(response.status ){
                            swal("Equipamento apagado!", "", "success");
                            $("#tabelaDeStock").jsGrid("render");
                            d.resolve(response);
                        }else{
                            swal({  title: "Impossivel apagar!",   text: response.responseText,   html: true, type: 'error' });
                            d.reject();
                        }
                    }).fail(function(response) {

                        swal({  title: "Impossivel apagar!",   text: response.responseText,   html: true, type: 'error' });
                        d.reject();
                    });
                }
            });
            return;
    },

    controller: {
        insertItem: function(item) {
            var d = $.Deferred();

            $.ajax({
                url: "../src/operations/stock/saveStock.php",
                dataType: "json",
                type: 'POST',
                data: item
            }).done(function(response) {
                if(response.status){
                    swal("Equipamento inserido!", "", "success");
                    $("#tabelaDeStock").jsGrid("render")
                    d.resolve(response);
                }else{
                    swal("Impossivel inserir!", "", "error");
                    d.reject();
                }
            }).fail(function(response) {
                swal("Impossivel inserir!", response.responseText, "error");
                d.reject();
            });

            return d.promise();
        },
        updateItem:  function(item) {
            var d = $.Deferred();

            $.ajax({
                url: "../src/operations/stock/updateStock.php",
                dataType: "json",
                type: 'POST',
                data: item
            }).done(function(response) {
                if(response.status){
                    swal("Atualizado!", "", "success");
                    $("#tabelaDeStock").jsGrid("render");
                    d.resolve(response);
                }else{
                    swal("Impossivel atualizar!", "", "error");
                    d.reject();
                }
            }).fail(function(response) {
                swal({  title: "Impossivel apagar!",   text: response.responseText,   html: true, type: 'error' });
                d.reject();
            });

            return d.promise();
        },
        loadData: function() {
            var d = $.Deferred();

            $.ajax({
                url: "../src/operations/stock/getAllStock.php",
                dataType: "json"
            }).done(function(response) {

                var array = [];
                for( var x in response){
                    array.push(response[x]);
                }
                d.resolve(array);
            }).fail(function(response) {
                d.reject();
            });

            return d.promise();
        }
    },

    fields: [
        { name: "id", visible:false, title:"Id", type: "number", width: 20 },
        { name: "equipamento", title:"Equipamento", type: "text", width: 200, validate: "required" },
        { name: "ocas", title: "Ocas", type: "number", width: 100 },
        { name: "arosBrancos", title: "Aros Brancos", type: "number", width: 100 },
        { name: "arosPretos", title: "Aros Pretos", type: "number", width: 100 },
        { name: "vidrosBrancos", title: "Vidros Brancos", type: "number", width: 100 },
        { name: "vidrosPretos", title: "Vidros Pretos", type: "number", width: 100 },
        { name: "peliculaPolarizada", title: "Peliculas Polarizadas", type: "number", width: 100 },
        { name: "peliculaTemperada", title: "Peliculas Temperadas", type: "number", width: 100 },
        { type: "control" }
    ]
});

</script>

<?php include 'footer.php' ?>