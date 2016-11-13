<?php include 'header.php' ?>

<div class="container-fluid">
    <!-- /.row -->
    <div class="row">
       <div class="x_panel">
            <div class="x_content">
                <div id='tableOfFaults' class="table-responsive" ></div>
            </div>
        </div>
    </div>
</div>
<!-- /.container-fluid -->


<script>
var grid = $("#tableOfFaults"),
    prmSearch = {multipleSearch:true,overlay:false};

grid.jsGrid({
    width: "100%",
    sorting: true,
    paging: true,
    autoload: true,
    pageSize: 15,
    pageButtonCount: 5,
    scrollOffset: 0,
    search:true,
    deleteItem: function(item) {
        swal({
              title: "Remover Registo",
              text: "Tem a certeza que quer apagar o registo da reparação "+ item.model +"?",
              showCancelButton: true,
              confirmButtonColor: "#DD6B55",
              confirmButtonText: "Sim",
              cancelButtonText: "Não",
              closeOnConfirm: false
            },
            function(isConfirm){
                if(isConfirm){
                    $.ajax({
                        url: "../src/operations/fault/deleteFault.php",
                        dataType: "json",
                        type: 'POST',
                        data: item
                    }).done(function(response) {
                        if(response.status){
                            swal("Registado apagado!", "", "success");
                            $("#tableOfFaults").jsGrid("render")
                        }else{
                            swal("Impossivel apagar!", "", "error");
                        }
                    }).fail(function(response) {
                        swal("Impossivel apagar!", "", "error");
                    });
                }
            });
            return;
    },
    editItem: function(item){
         window.location.href = 'faults.php?id='+item.id;
    },
    controller: {
        loadData: function() {
            var d = $.Deferred();

            $.ajax({
                url: "../src/operations/fault/getAllFaults.php",
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
        { name: "id", title:"Numero", type: "number", width: 50 },
        { name: "model", title: "Equipamento", type: "text", width: 250 },
        { name: "dateIn", title: "Data de Entrada", type: "date", width: 50 },
        { name: "dataOut", title: "Data de Saida", type: "date", width: 50 },
        { name: "values", title: "Orçamento", type: "number", width: 50 },
        { name: "state", title: "Estado", type: "text", width: 100 },
        { type: "control", modeSwitchButton: false, deleteButton: false,
        headerTemplate: function() {
            return $("<button class='jsgrid-button jsgrid-mode-button jsgrid-insert-mode-button'>").attr("type", "button").on("click", function () {
                window.location.href = 'novaAvaria.php';
            });
        }}
    ]
});
//grid.searchGrid(prmSearch);

</script>

 <?php include 'footer.php' ?>