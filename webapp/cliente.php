<?php include 'header.php';
$clientDao = new ClientDAO();
//$faultDao = new FaultDao();
$client = $clientDao->selectClient($_GET['id']);
//$result = $faultDao->selectClientFaultsGroupByStatus($_GET['id']);
?>
<div class="container-fluid">
    <div class="row">
        <div class="x_panel">
          <div class="x_title">
            <h2>Dados do Cliente <small></small></h2>
            <ul class="nav navbar-right panel_toolbox">
              <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
              <li><a class="close-link"><i class="fa fa-close"></i></a></li>
            </ul>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">

            <div class="col-md-3 col-sm-3 col-xs-12 profile_left">

              <div class="profile_img">

                <!-- end of image cropping -->
                <div id="crop-avatar">
                  <!-- Current avatar -->
                  <img class="img-responsive avatar-view" src="images/user.png" alt="Avatar" title="Change the avatar">
                  <!-- Loading state -->
                  <div class="loading" aria-label="Loading" role="img" tabindex="-1"></div>
                </div>
                <!-- end of image cropping -->

              </div>
              <h3><?php echo $client->getName(); ?></h3>

              <ul class="list-unstyled user_data">
                <li><i class="fa fa-map-marker user-profile-icon"></i> </i> <?php echo $client->getLocal(); ?>
                </li>

                <li>
                  <i class="fa fa-phone user-profile-icon"></i> <?php echo $client->getContact(); ?>
                </li>

                <li class="m-top-xs">
                  <i class="fa fa-external-link user-profile-icon"></i> <?php echo $client->getEmail(); ?>
                </li>
              </ul>

              <a class="btn btn-success"><i class="fa fa-edit m-right-xs"></i> Editar</a>
              <a class="btn btn-success" href='novaAvaria.php?id=<?php echo $client->getId() ?>'><i class="fa fa-laptop m-right-xs"></i> Nova Avaria</a>
              <br />

              <!-- start skills -->
              <!--h4>Skills</h4>
              <ul class="list-unstyled user_data">
                <li>
                  <p>Web Applications</p>
                  <div class="progress progress_sm">
                    <div class="progress-bar bg-green" role="progressbar" data-transitiongoal="50"></div>
                  </div>
                </li>
                <li>
                  <p>Website Design</p>
                  <div class="progress progress_sm">
                    <div class="progress-bar bg-green" role="progressbar" data-transitiongoal="70"></div>
                  </div>
                </li>
                <li>
                  <p>Automation & Testing</p>
                  <div class="progress progress_sm">
                    <div class="progress-bar bg-green" role="progressbar" data-transitiongoal="30"></div>
                  </div>
                </li>
                <li>
                  <p>UI / UX</p>
                  <div class="progress progress_sm">
                    <div class="progress-bar bg-green" role="progressbar" data-transitiongoal="50"></div>
                  </div>
                </li>
              </ul-->
              <!-- end of skills -->

            </div>
            <div class="col-md-9 col-sm-9 col-xs-12">

              <div class="profile_title">
                <div class="col-md-6">
                  <h2>Estado dos Equipamentos</h2>
                </div>
              </div>
              <!-- start of user-activity-graph -->
              <div id="morris-bar-chart" style="width:100%; height:300px;"></div>
              <!-- end of user-activity-graph -->

              <div class="" role="tabpanel" data-example-id="togglable-tabs">
                <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                  <li role="presentation" class="active"><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Lista de Reparações</a>
                  </li>
                  <li role="presentation" class=""><a href="#tab_content2" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false">Lista de Equipamentos</a>
                  </li>
                </ul>
                <div id="myTabContent" class="tab-content">
                  <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab">
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
                  <div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="profile-tab">
                     <div class="table-responsive">
                        <table class="table table-hover table-striped" style="width:100%">
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
<script>
    $('.table').DataTable({
        bLengthChange: false
    });
    // Morris.js Charts sample data for SB Admin template
activeButtonLink(<?php echo $_GET['id'] ?>);

$(function() {

    $.ajax({
        type: 'POST',
        url: '../src/operations/fault/getUserFaultsGroupByState.php',
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


 <?php include 'footer.php' ?>