<?php
include 'header.php' ?>
<div class="container-fluid">
    <div class="row">
        <div id='cards'></div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="x_panel">
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
    </div>
    
    <!--div class="row">
      <div class="col-md-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>Calendario <small>Previsão de entregas</small></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                </li>
                <li><a class="close-link"><i class="fa fa-close"></i></a>
                </li>
            </ul>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <div class="col-md-9 col-sm-12 col-xs-12">
              <div id='calendar'></div>
            </div>
            <div class="col-md-3 col-sm-12 col-xs-12">
              <div>
                <ul class="list-unstyled top_profiles scroll-view">
                  <li class="media event">
                    <a class="pull-left border-aero profile_thumb">
                      <i class="fa fa-user aero"></i>
                    </a>
                    <div class="media-body">
                      <a class="title" href="#">Ms. Mary Jane</a>
                      <p><strong>$2300. </strong> Agent Avarage Sales </p>
                      <p> <small>12 Sales Today</small>
                      </p>
                    </div>
                  </li>
                  <li class="media event">
                    <a class="pull-left border-green profile_thumb">
                      <i class="fa fa-user green"></i>
                    </a>
                    <div class="media-body">
                      <a class="title" href="#">Ms. Mary Jane</a>
                      <p><strong>$2300. </strong> Agent Avarage Sales </p>
                      <p> <small>12 Sales Today</small>
                      </p>
                    </div>
                  </li>
                  <li class="media event">
                    <a class="pull-left border-blue profile_thumb">
                      <i class="fa fa-user blue"></i>
                    </a>
                    <div class="media-body">
                      <a class="title" href="#">Ms. Mary Jane</a>
                      <p><strong>$2300. </strong> Agent Avarage Sales </p>
                      <p> <small>12 Sales Today</small>
                      </p>
                    </div>
                  </li>
                  <li class="media event">
                    <a class="pull-left border-aero profile_thumb">
                      <i class="fa fa-user aero"></i>
                    </a>
                    <div class="media-body">
                      <a class="title" href="#">Ms. Mary Jane</a>
                      <p><strong>$2300. </strong> Agent Avarage Sales </p>
                      <p> <small>12 Sales Today</small>
                      </p>
                    </div>
                  </li>
                  <li class="media event">
                    <a class="pull-left border-green profile_thumb">
                      <i class="fa fa-user green"></i>
                    </a>
                    <div class="media-body">
                      <a class="title" href="#">Ms. Mary Jane</a>
                      <p><strong>$2300. </strong> Agent Avarage Sales </p>
                      <p> <small>12 Sales Today</small>
                      </p>
                    </div>
                  </li>
                </ul>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div-->
    </div>
</div>
<!-- /.container-fluid -->
<script>


$(function() {

    
    var buildCards = function(response){
        var element = $('#cards'),
            cardsDiv = $('<div class="row top_tiles"></div>'),
            cards = {
                emAnaliseID : {
                    type : 'Em Analise',
                    icon : 'fa-clock-o',
                    divID : 'emAnaliseID'
                },
                semReparacaoID : {
                    type : 'Sem Reparação',
                    icon : 'fa-ban',
                    divID : 'semReparacaoID'
                },
                emReparacaoID : {
                    type : 'Em Reparação',
                    icon : 'fa-cogs',
                    divID : 'emReparacaoID'
                },
                reparacaoID : {
                    type : 'Reparado',
                    icon : 'fa-check-square',
                    divID : 'reparacaoID'
                },
                entregueID : {
                    type : 'Entregue',
                    icon : 'fa-share-square-o',
                    divID : 'entregueID'
                },
                entregueReparacaoID : {
                    type : 'Entregue s/Reparação',
                    icon : 'fa-thumbs-o-down',
                    divID : 'entregueReparacaoID'
                }
            };

            for( var i = 0; i < response.length; i++ ){
                cards[response[i].divID].totalOrcamento = response[i].totalOrcamento;
                cards[response[i].divID].total = response[i].total;
            }



        for(var card in cards){
            cardsDiv.append('<div class="animated flipInY col-lg-2 col-md-2 col-sm-6 col-xs-12">'+
                                '<div class="tile-stats index-cards">'+
                                    '<div class="icon"><i class="fa '+ cards[card].icon +'"></i></div>'+
                                    '<div class="count">'+  (cards[card].total || 0 ) +'</div>'+
                                    '<h3>'+ cards[card].type +'</h3>'+
                                    '<p>Total em orçamentos: € '+ (cards[card].totalOrcamento || 0) +'</p>'+
                                '</div>' +
                            '</div>');
        }

        $(cardsDiv).find('.index-cards').off('click').on('click', function(){
            tabelaHomeAvarias.fnFilter($(this).find('h3').text() , 5, true);
        });

        cardsDiv.appendTo('#cards');
    };

    $.ajax({
        type: 'POST',
        url: '../src/operations/fault/getUserFaultsGroupByState.php',
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

    var tabelaHomeAvarias = $('#tabelaHomeAvarias').dataTable({
        bLengthChange: false
    });

    $('#tabelaHomeAvarias tbody').off('click').on('click', 'tr', function () {
        var data = tabelaHomeAvarias.row( this ).data();
        //window.location.href = 'cliente.php?id='+data[0];
    });

/*
      $(window).load(function() {
        var date = new Date(),
            d = date.getDate(),
            m = date.getMonth(),
            y = date.getFullYear(),
            started,
            categoryClass;

        var calendar = $('#calendar').fullCalendar({
          header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay'
          },
          height: '750',
          selectable: true,
          selectHelper: true,
          select: function(start, end, allDay) {
            $('#fc_create').click();

            started = start;
            ended = end;

            $(".antosubmit").on("click", function() {
              var title = $("#title").val();
              if (end) {
                ended = end;
              }

              categoryClass = $("#event_type").val();

              if (title) {
                calendar.fullCalendar('renderEvent', {
                    title: title,
                    start: started,
                    end: end,
                    allDay: allDay
                  },
                  true // make the event "stick"
                );
              }

              $('#title').val('');

              calendar.fullCalendar('unselect');

              $('.antoclose').click();

              return false;
            });
          },
          eventClick: function(calEvent, jsEvent, view) {
            $('#fc_edit').click();
            $('#title2').val(calEvent.title);

            categoryClass = $("#event_type").val();

            $(".antosubmit2").on("click", function() {
              calEvent.title = $("#title2").val();

              calendar.fullCalendar('updateEvent', calEvent);
              $('.antoclose2').click();
            });

            calendar.fullCalendar('unselect');
          },
          editable: true,
          events: [{
            title: 'All Day Event',
            start: new Date(y, m, 1)
          }, {
            title: 'Long Event',
            start: new Date(y, m, d - 5),
            end: new Date(y, m, d - 2)
          }, {
            title: 'Meeting',
            start: new Date(y, m, d, 10, 30),
            allDay: false
          }, {
            title: 'Lunch',
            start: new Date(y, m, d + 14, 12, 0),
            end: new Date(y, m, d, 14, 0),
            allDay: false
          }, {
            title: 'Birthday Party',
            start: new Date(y, m, d + 1, 19, 0),
            end: new Date(y, m, d + 1, 22, 30),
            allDay: false
          }, {
            title: 'Click for Google',
            start: new Date(y, m, 28),
            end: new Date(y, m, 29),
            url: 'http://google.com/'
          }]
        });
      });

      $('#calendar').fullCalendar('option', 'height', 40);*/

</script>

<?php include 'footer.php' ?>