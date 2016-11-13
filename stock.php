<?php include 'header.php' ?>
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="row">
        <div class="col-lg-12">
            <ol class="breadcrumb">
                <li>
                    <i class="fa fa-dashboard"></i>  <a href="home.php">Home</a>
                </li>
                <li class="active">
                    <i class="fa fa-file"></i> Gerir Clientes
                </li>
            </ol>
        </div>
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="panel panel-primary">
            <div class="panel-body">
                <div class="table-responsive" id='tabelaDeStock'></div>
            </div>
        </div>
    </div>
</div>
            <!-- /.container-fluid -->
<script>

$('#tabelaDeStock').jsGrid({
    height: "100%",
    width: "100%",
    editing: true,
    sorting: true,
    paging: true,
    autoload: true,
    inserting: true,
    pageSize: 15,
    pageButtonCount: 5,

    deleteConfirm: "Do you really want to delete the client?",

    controller: {
        loadData: function() {
            var d = $.Deferred();

            /*$.ajax({
                url: "http://services.odata.org/V3/(S(3mnweai3qldmghnzfshavfok))/OData/OData.svc/Products",
                dataType: "json"
            }).done(function(response) {
                d.resolve(response.value);
            });*/
            var response = [
                {modelo: 'iPhone 5s', numVidrosBrancos:'5', numVidrosPretos:'6', qualquerCoisa:'12', numPeliculas:'10' },
                {modelo: 'iPhone 5', numVidrosBrancos:'3', numVidrosPretos:'2', qualquerCoisa:'2',numPeliculas:'8' },
                {modelo: 'iPhone 6s', numVidrosBrancos:'7', numVidrosPretos:'4', qualquerCoisa:'1',numPeliculas:'2' },
                {modelo: 'iPhone 6', numVidrosBrancos:'8', numVidrosPretos:'12', qualquerCoisa:'17',numPeliculas:'17' },
                {modelo: 'iPhone 7', numVidrosBrancos:'0', numVidrosPretos:'4', qualquerCoisa:'5',numPeliculas:'0' },
            ];

            d.resolve(response);

            return d.promise();
        }
    },

    fields: [
        { name: "modelo", title:"Modelo", type: "text", width: 200 },
        { name: "numVidrosBrancos", title: "Nº Vidros Pretos", type: "number", width: 100 },
        { name: "numVidrosPretos", title: "Nº Vidros Brancos", type: "number", width: 100 },
        { name: "numPeliculas", title: "Nº Peliculas", type: "number", width: 100 },
        { name: "qualquerCoisa", title: "Nº Qualquer Coisa", type: "number", width: 100 },
        { type: "control" }
    ]
});

</script>

<?php 'footer.php' ?>