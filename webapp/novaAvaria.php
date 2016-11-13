<?php include 'header.php';
$clientId = '';
$client = false;
if(isset($_GET['id'])){
  $ClientDAO = new ClientDAO();
  $clientId = $_GET['id'];
  $client=$ClientDAO->selectClient($clientId);
}
?>

<div class="container-fluid">
  <div class="row">
    <div class="x_panel">
      <div class="x_title">
        <h2>Nova Entrada<small></small></h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <form id="newFaultId" method="post" role="form" action="javascript:registarAvaria()" data-parsley-validate>
          <div class="row">
            <!-- left column -->
            <div class="col-md-7">
              <div class="col-md-8">
                <label>Data de Entrada:</label>
                <input type='date' class="form-control" name="dateIn" value="<?php echo date("Y-m-d"); ?>" disabled required/>
                <label>Previsão de Entrega:</label>
                <input type='date' class="form-control" name="predictionDate"  />
                <label>Orçamento:</label>
                <div class="form-group input-group">
                  <span class="input-group-addon"><i class="fa fa-eur"></i></span>
                  <input type='number' class="form-control" name="orcamento" />
                </div>
              </div>
              <div class="col-md-4">
                <label>Estado</label>
                <div class="radio">
                  <label><input type="radio" name="estado" id="optionsRadios1" value="1" checked>Em Analise</label>
                </div>
                <div class="radio">
                  <label><input type="radio" name="estado" id="optionsRadios2" value="2">Em Reparação</label>
                </div>
                <div class="radio">
                  <label><input type="radio" name="estado" id="optionsRadios3" value="3">Sem Reparação</label>
                </div>
                <div class="radio">
                  <label><input type="radio" name="estado" id="optionsRadios4" value="4">Reparado</label>
                </div>
                <div class="radio">
                  <label><input type="radio" name="estado" id="optionsRadios5" value="5">Entregue</label>
                </div>
                <div class="radio">
                  <label><input type="radio" name="estado" id="optionsRadios6" value="6">Entregue s/Reparação</label>
                </div>
              </div>
              <div class="col-md-12">
                <label>Observações:</label>
                <textarea class="form-control" name="obj" rows="6"></textarea>
              </div>
            </div>
            <!-- left column -->
            <!-- right column -->
            <div class="col-md-5">
              <?php if($client){ ?>
              <div class="form-group" >
                <div class="x_panel">
                  <div class="x_title">
                    <h3 class="panel-title">Cliente</h3>
                  </div>
                  <div class="x_content">
                    <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
                      <input class="form-control has-feedback-left" readonly="readonly" name="name" value="<?php echo $client->getName() ?>"/>
                      <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
                    </div>
                    <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
                      <input type="number" class="form-control has-feedback-left" name="contacto" readonly="readonly"  value="<?php echo $client->getContact() ?>"/>
                      <span class="fa fa-phone form-control-feedback left" aria-hidden="true"></span>
                    </div>
                    <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
                      <input class="form-control has-feedback-left" name="morada" readonly="readonly"  value="<?php echo $client->getLocal() ?>"/>
                      <span class="fa fa-home form-control-feedback left" aria-hidden="true"></span>
                    </div>
                    <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
                      <input type="email" class="form-control has-feedback-left" readonly="readonly"  name="email" value="<?php echo $client->getEmail() ?>"/>
                      <span class="fa fa-envelope form-control-feedback left" aria-hidden="true"></span>
                    </div>
                     <input type="hidden" id="novoCliente" name="novoCliente" value=""/>
                  </div>
                  <input type="hidden" id="select2Client-id" value="<?php echo $clientId;?>" name="idClient">
                </div>
              </div>
              <?php }else{ ?>
              <div class="form-group numCliente">
                <label >Cliente:</label>
                <div class="row">
                  <div class="col-md-9">
                     <select class="col-md-12 select2Client"></select>
                  </div>
                  <div class="col-md-3">
                    <a class="novoClienteLinkAvaria btn btn-dark">
                      <i class="fa fa-user-plus"></i> Novo
                    </a>
                  </div>
                </div>
                <input type="hidden" id="select2Client-id" value="<?php echo $clientId;?>" name="idClient">
                <p id="select2Client-description"></p>
              </div>
               <div class="form-group numNovoCliente " hidden>
                <div class="x_panel">
                  <div class="x_title">
                    <div class="row">
                      <div class="col-md-9">
                        <h3 class="panel-title">Novo Cliente</h3>
                      </div>
                      <div class="col-md-3">
                        <a class="cancelNovoCliente btn btn-dark">Cancelar</a>
                      </div>
                    </div>
                  </div>
                  <div class="x_content">
                    <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
                      <input class="form-control numNovoClienteRequered has-feedback-left" placeholder="Nome" name="name"/>
                      <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
                    </div>
                    <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
                      <input type="number" class="form-control numNovoClienteRequered has-feedback-left" name="contacto" placeholder="Contacto"/>
                      <span class="fa fa-phone form-control-feedback left" aria-hidden="true"></span>
                    </div>
                    <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
                      <input class="form-control has-feedback-left" name="morada" placeholder="Morada"/>
                      <span class="fa fa-home form-control-feedback left" aria-hidden="true"></span>
                    </div>
                    <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
                      <input type="email" class="form-control has-feedback-left" name="email" placeholder="Email"/>
                      <span class="fa fa-envelope form-control-feedback left" aria-hidden="true"></span>
                    </div>
                     <input type="hidden" id="novoCliente" name="novoCliente" value=""/>
                  </div>
                </div>
              </div>
              <?php } ?>
              <div class="form-group numEquip">
                <label >Equipamento:</label>
                <div class="row">
                  <div class="col-md-9">
                     <select class="col-md-12 select2Equipament"></select>
                  </div>
                  <div class="col-md-3">
                    <a class="novoEquipamentoLink btn btn-dark">
                      <i class="fa fa-laptop"></i> Novo
                    </a>
                  </div>
                </div>
                <input type="hidden" id="idEquip" name="idEquip">
                <p id="select2Client-description"></p>
              </div>
              <div class="form-group numNovoEquipment " hidden>
                <div class="x_panel">
                  <div class="x_title">
                    <div class="row">
                      <div class="col-md-9">
                        <h3 class="panel-title">Novo Equipamento</h3>
                      </div>
                      <div class="col-md-3">
                        <a class="cancelNovoEqui btn btn-dark">Cancelar</a>
                      </div>
                    </div>
                  </div>
                  <div class="x_content">
                    <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
                      <input class="form-control numNovoEquipmentRequered has-feedback-left" placeholder="Modelo" name="Modelo"/>
                      <span class="fa fa-desktop form-control-feedback left" aria-hidden="true"></span>
                    </div>
                    <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
                      <input class="form-control numNovoEquipmentRequered has-feedback-left" name="EMEI" placeholder="IMEI / Nº Serie"/>
                      <span class="form-control-feedback left" aria-hidden="true">#</span>
                    </div>
                    <div class="form-group">
                      <label>Observações:</label>
                      <textarea class="form-control" name="objEquip" rows="2"></textarea>
                     </div>
                     <input type="hidden" id="novoEquipamento" name="novoEquipamento" value=""/>
                  </div>
                </div>
              </div>
            </div>
            <!-- right column -->
          </div>

          <!--footer -->
          <div class="row">
            <div class="col-md-12 ln_solid"></div>
            <div class="form-group">
              <div class="col-md-12 col-sm-6 col-xs-12">
                <input type="hidden" value="2" name="userID">
                <input type="submit" name='submit' class="btn btn-dark" value="Registar"></input>
              </div>
            </div>
          </div>
          <!-- footer -->
        </form>
      </div>
    </div>
  </div>
</div>

            <!-- /.container-fluid -->
<script>
$(function() {
  function formatRepo (repo) {
    if (repo.loading) return repo.contact;

    var markup = "<div class='row clearfix'>"+
                  "<div class='col-lg-2'><img style='height:50px;width:50px' src='images/user.png'/></div><div class='col-lg-10'>"+
                  "<div class=''>" + repo.name + "</div>" +
                  "<div class='select2-result-repository__description'>" + repo.contact + "</div>" +
                  "</div></div>" ;

    return markup;
  }

  function formatRepoEqui (repo) {
    if (repo.loading) return repo.model;
    var markup = "<div class='row clearfix'>"+
          "<div class='col-lg-10'>"+
          "<div class=''>Equipamento:  <strong>" + repo.model + "</strong></div>" +
          "<div class='select2-result-repository__description'>IMEI/Nº Serie:  <strong>" + repo.emei + "<strong></div>" +
          "</div></div>" ;

    return markup;
  }

  $( ".select2Client" ).select2({
    ajax: {
      url: "../src/operations/client/searchClients.php",
      dataType: 'json',
      delay: 250,
      data: function (params) {
        return {
          q: params.term // search term
        };
      },
      processResults: function (data, params) {
        return {
          results: data
        };
      },
      cache: true
    },
    escapeMarkup: function (markup) { return markup; },
    minimumInputLength: 1,
    templateResult: formatRepo,
    templateSelection: formatRepo
  }).on('change',function(event) {
    $( this ).parent().find('.select2-selection--single').animate({
      height: '60px'},
      500, function() {
      /* stuff to do after animation is complete */
    });;
    $('#select2Client-id').val($(this).val());
  });


  $( ".select2Equipament" ).select2({
      ajax: {
        url: "../src/operations/equipment/searchEquipment.php",
        dataType: 'json',
        delay: 250,
        data: function (params) {
          return {
            q: params.term // search term
          };
        },
        processResults: function (data, params) {
          return {
            results: data
          };
        },
        cache: true
      },
      escapeMarkup: function (markup) { return markup; },
      minimumInputLength: 1,
      templateResult: formatRepoEqui,
      templateSelection: formatRepoEqui
  }).on('change', function(e){
    $( this ).parent().find('.select2-selection--single').animate({
            height: '60px'},
            500, function() {
            /* stuff to do after animation is complete */
          });;
          $('#idEquip').val($( this ).val());
  });

  $('.novoEquipamentoLink').off('click').on('click', function(){
    $('.numEquip').hide('show');
    $('.numNovoEquipment').show('show');
    $('.numNovoEquipmentRequered').attr('required',true);
    $('.numEquipSelect').attr('required',false);
    $('#novoEquipamento').val('yes');
  });

$('.cancelNovoEqui').off('click').on('click', function(){
    $('.numEquip').show('show');
    $('.numNovoEquipment').hide('show');
    $('.numNovoEquipmentRequered').attr('required',false);
    $('.numEquipSelect').attr('required',true);
    $('#novoEquipamento').val('');
  });

$('.novoClienteLinkAvaria').off('click').on('click', function(){
    $('.numCliente').hide('show');
    $('.numNovoCliente').show('show');
    $('.numNovoClienteRequered').attr('required',true);
    $('#novoCliente').val('yes');
  });

$('.cancelNovoCliente').off('click').on('click', function(){
    $('.numCliente').show('show');
    $('.numNovoCliente').hide('show');
    $('.numNovoClienteRequered').attr('required',false);
    $('#novoCliente').val('');
  });

})


  function registarAvaria(){

    var data = $('#newFaultId').serialize();

    $.ajax({
        //Tipo do pedido que, neste caso, é POST
        type: 'POST',
        /*
         * URL do ficheiro que para o qual iremos enviar os dados.
         * Pode ser um url absoluto ou relativo.
         */
        url: '../src/security/newFault.php',
        //Que dados vamos enviar? A variável "data"
        data: data,
        //O tipo da informação da resposta
        dataType: 'json'
    }).done(function(response) {

        /*
         * Quando a chamada Ajax é terminada com sucesso,
         * o javascript confirma o status da operação
         * com a variável que enviámos no formato json.
         */
        if(response.status) {

            swal({
              title: "Registado!",
              text: "Pretendes gerar a Ficha de Entrada?",
              type: "success",
              showCancelButton: true,
              confirmButtonColor: "#DD6B55",
              confirmButtonText: "Sim",
              cancelButtonText: "Não",
              closeOnConfirm: false
            },
            function(isConfirm){
              if (isConfirm) {
                  var doc = new jsPDF('p','pt','a5'),
                    text = 'Ficha de Entrada de Equipamento',
                    xOffset = (doc.internal.pageSize.width / 2) - (doc.getStringUnitWidth(text) * doc.internal.getFontSize() / 2);


                var header = function (data) {
                  doc.setFontSize(20);
                  doc.setTextColor(30);
                  doc.setFontStyle('normal');
                  doc.addImage(headerImgData, 'JPG', data.settings.margin.left, 40, 30, 30);
                  doc.text(text, data.settings.margin.left + 35, 60);
                };

                var footer = function (data) {
                  text = doc.splitTextToSize('Conforme o artigo 1323º do código civil, se o equipamento não for levantado no prazo de 90 dias é considerado como abandonado, revertendo assim a favor da entidade reparadpra, perdendo o seu proprietário os direitos sobre o mesmo.', doc.internal.pageSize.width - 80, {});
                  doc.text(text, data.settings.margin.left, doc.internal.pageSize.height - 100);
                   doc.setTextColor(11);
                  doc.text('Contacto: 916817976                        Email: info@crc-si.com', data.settings.margin.left, doc.internal.pageSize.height - 40);
                };

                var options = {
                        beforePageContent: header,
                        afterPageContent: footer,
                        margin: {top: 80},
                        startY: 100,
                        drawHeaderRow: function() {
                            // Don't draw header row
                            return false;
                        },
                        columnStyles: {
                            first_name: {fillColor: [41, 128, 185], textColor: 255, fontStyle: 'bold'}
                        }
                      };

                doc.autoTable([ {title: "Nº Doc", dataKey: "number"}, {title: "Data de Entrada", dataKey: "dateIn"},{title: "Previsão de Entrega", dataKey: "predictionDate"}]
                  , [{ number: response.numDoc,dateIn: response.dateIn, predictionDate: response.predictionDate}],
                  {
                    startY: 100,
                    margin: {top: 80},
                    beforePageContent: header
                  }
                );

                doc.autoTable([ {title: "Cliente", dataKey: "client"}, {title: "Contacto", dataKey: "contact"}]
                  , [{ client: response.clientName , contact: response.clientContact}],
                  { startY: doc.autoTableEndPosY() + 10,
                    styles: {overflow: 'linebreak'},
                    bodyStyles: {valign: 'top'},
                  }
                );

                doc.autoTable([ {title: "Equipamento", dataKey: "equi"}]
                  , [{ equi: response.modeloEqui}],
                  {
                    startY: doc.autoTableEndPosY() + 10,
                    styles: {overflow: 'linebreak'},
                    bodyStyles: {valign: 'top'}
                  }
                );

                doc.autoTable([ {title: "Avaria", dataKey: "obser"}]
                  , [{ obser: response.obj}],
                  {
                    startY: doc.autoTableEndPosY() + 10,
                    styles: {overflow: 'linebreak'},
                    bodyStyles: {valign: 'top'}
                  }
                );

                doc.autoTable([ {title: "Reparação", dataKey: "repa"}]
                  , [{ repa: response.reparacao}],
                  {
                    startY: doc.autoTableEndPosY() + 10,
                    styles: {overflow: 'linebreak'},
                    bodyStyles: {valign: 'top'},
                    afterPageContent: footer
                  }
                );

                var posY = doc.autoTableEndPosY() + 30;
                doc.setTextColor(11);
                doc.setFontSize(11);
                doc.text('Documento Indispensável para levantamento dos Equipamentos', 40, posY);

                posY += 60;

                doc.save('Ficha'+response.numDoc+'.pdf');
                noty({text: "Ficha Gerada!", type: 'success'});
                window.location.reload(true);
              }else{
                window.location.reload(true);
              }
            });
        } else {
            //Caso contrário dizemos que aconteceu algum erro.
            noty({text: 'Não foi possivel gravar!', type: 'error'});
        }

    }).fail(function(xhr, desc, err) {
        /*
         * Caso haja algum erro na chamada Ajax,
         * o utilizador é alertado e serão enviados detalhes
         * para a consola javascript que pode ser visualizada
         * através das ferramentas de desenvolvedor do browser.
         */
        noty({text: 'Ocorreu um erro!', type: 'error'});
        console.log(xhr);
        console.log("Detalhes: " + desc + "nErro:" + err);
    });
}
  </script>

 <?php include 'footer.php' ?>

