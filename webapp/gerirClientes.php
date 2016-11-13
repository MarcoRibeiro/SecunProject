<?php include 'header.php' ?>

<div class="container-fluid">

    <!-- /.row -->
    <div class="row">
        <div class="x_panel">
            <div class="x_content">
                <div id='tableOfClients' class="table-responsive" ></div>
            </div>
        </div>
     </div>
</div>
<!-- /.container-fluid -->
<script>


$('#tableOfClients').jsGrid({
    width: "100%",
    sorting: true,
    paging: true,
    autoload: true,
    pageSize: 15,
    pageButtonCount: 5,
    scrollOffset: 0,
    rowClick : function(obj){
        window.location.href = 'cliente.php?id='+obj.item.id;
    },
    deleteItem: function(item) {
        swal({
              title: "Remover Registo",
              text: "Tem a certeza que quer apagar o registo do cliente "+ item.name +"?",
              showCancelButton: true,
              confirmButtonColor: "#DD6B55",
              confirmButtonText: "Sim",
              cancelButtonText: "Não",
              closeOnConfirm: false
            },
            function(isConfirm){
                if(isConfirm){
                    $.ajax({
                        url: "../src/operations/client/deleteClient.php",
                        dataType: "json",
                        type: 'POST',
                        data: item
                    }).done(function(response) {
                        if(response.status){
                            swal("Registado apagado!", "", "success");
                            $("#tableOfClients").jsGrid("render")
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
    controller: {
        loadData: function() {
            var d = $.Deferred();

            $.ajax({
                url: "../src/operations/client/getAllClients.php",
                dataType: "json"
            }).done(function(response) {

                var array = [];
                for( var x in response){
                    array.push(response[x]);
                }
                activeButtonLink();
                d.resolve(array);
            }).fail(function(response) {
                d.reject();
            });

            return d.promise();
        }
    },

    fields: [
        { name: "id", visible:false, title:"Id", type: "number", width: 20 },
        { name: "name", title: "Nome", type: "text", width: 200 },
        { name: "contact", title: "Contacto", type: "number", width: 75 },
        { name: "local", title: "Morada", type: "textarea", width: 100 },
        { name: "email", title: "Email", type: "text", width: 150 },
        { type: "control", modeSwitchButton: false, editButton: false,
        headerTemplate: function() {
            return $("<button class='jsgrid-button jsgrid-mode-button jsgrid-insert-mode-button novoClienteLink'>").attr("type", "button");
        }}
    ]
});

</script>

 <?php include 'footer.php' ?>