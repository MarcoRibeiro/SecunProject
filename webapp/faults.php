<?php include 'header.php';

$FaultDAO = new FaultDAO();
$EstadoDAO = new EstadoDAO();
$EquipmentDAO = new EquipmentDAO();
$ClientDAO = new ClientDAO();
$fault=$FaultDAO->selectFault($_GET['id']);
$client = $ClientDAO->selectClient($fault->getClientID());
$Equipment=$EquipmentDAO->selectEquipment($fault->getEquipmentID());
?>

<div class="container-fluid">
    <div class="row">
        <div class="x_panel">
            <div class="x_title">
                <h2>Reparação #<?php echo $_GET['id']?></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <form method="post" role="form">
                    <div class="row">
                        <!-- left column -->
                        <div class="col-md-7">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label>Data de Entrada:</label>
                                    <input type='date' class="form-control" name="dateIn" value="<?php echo $fault->getDateIn() ?>" disabled required/>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>Previsão de Entrega:</label>
                                    <input type='date' id="predictionDate" class="form-control" name="predictionDate" value="<?php echo $fault->getPrediction() ?>"/>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>Data de Entrega:</label>
                                    <input type='date' id="dateOut" class="form-control" name="dateOut" value="<?php echo $fault->getDateOut() ?>"/>
                                </div>
                                <label>Orçamento:</label>
                                <div class="form-group input-group">
                                    <span class="input-group-addon"><i class="fa fa-eur"></i></span>
                                    <input type='number' class="form-control" name="orcamento" id="orcamento" value="<?php echo $fault->getValues() ?>"/>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label>Estado</label>
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="estado" id="optionsRadios1" value="1" <?php if($fault->getStatusID() == 1){ echo "checked";} ?>>Em Analise
                                    </label>
                                </div>
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="estado" id="optionsRadios2" value="2"<?php if($fault->getStatusID() == 2){ echo "checked";} ?>>Em Reparação
                                    </label>
                                </div>
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="estado" id="optionsRadios3" value="3"<?php if($fault->getStatusID() == 3){ echo "checked";} ?>>Sem Reparação
                                    </label>
                                </div>
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="estado" id="optionsRadios4" value="4"<?php if($fault->getStatusID() == 4){ echo "checked";} ?>>Reparado
                                    </label>
                                </div>
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="estado" id="optionsRadios5" value="5" <?php if($fault->getStatusID() == 5){ echo "checked";} ?>>Entrege
                                    </label>
                                </div>
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="estado" id="optionsRadios6" value="6" <?php if($fault->getStatusID() == 6){ echo "checked";}?> >Entregue s/Reparação
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label>Observações:</label>
                                <textarea id="observacoesText" class="form-control" name="obj" rows="9"><?php echo $fault->getObj() ?></textarea>
                            </div>
                        </div>
                        <!-- left column -->
                        <!-- right column -->
                        <div class="col-md-5">
                            <div class="form-group">
                                <div class="x_panel">
                                    <div class="x_title">
                                       <h3 class="panel-title">Cliente</h3>
                                    </div>
                                    <div class="x_content">
                                        <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <input class="form-control has-feedback-left" readonly="readonly" name="name" value="<?php echo $client->getName() ?>"/>
                                                 <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <input type="number" class="form-control has-feedback-left" name="contacto" readonly="readonly"  value="<?php echo $client->getContact() ?>"/>
                                                <span class="fa fa-phone form-control-feedback left" aria-hidden="true"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <input class="form-control has-feedback-left" name="morada" readonly="readonly"  value="<?php echo $client->getLocal() ?>"/>
                                                <span class="fa fa-home form-control-feedback left" aria-hidden="true"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <input type="email" class="form-control has-feedback-left" readonly="readonly"  name="email" value="<?php echo $client->getEmail() ?>"/>
                                                <span class="fa fa-envelope form-control-feedback left" aria-hidden="true"></span>
                                            </div>
                                        </div>
                                        <input type="hidden" id="selectClient-id" name="idClient" value="<?php echo $fault->getClientID() ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="x_panel">
                                    <div class="x_title">
                                       <h3 class="panel-title">Equipamento</h3>
                                    </div>
                                    <div class="x_content">
                                        <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <input readonly="readonly" class="form-control has-feedback-left" name="Modelo" value="<?php echo $Equipment->getModel() ?>"/>
                                                <span class="fa fa-desktop form-control-feedback left" aria-hidden="true"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <input readonly="readonly" class="form-control has-feedback-left" name="EMEI" value="<?php echo $Equipment->getEmei() ?>"/>
                                                <span class="form-control-feedback left" aria-hidden="true">#</span>
                                            </div>
                                        </div>
                                        <input type="hidden" id="novoEquipamento" name="novoEquipamento" value="<?php echo $Equipment->getObj() ?>"/>
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
                                <input type="hidden" id='userId' value="2" name="userID">
                                <a href="#" id='atualizar' name='submit' class="btn btn-dark" >Atualizar</a>
                                <a href="#" id='gerarPDF' name='submit' class="btn btn-dark" >Gerar PDF</a>
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
    <script type="text/javascript">

    $('#atualizar').off('click').on('click',function(){
        var data = {};

        data.id = <?php echo $_GET['id']; ?>;
        data.equipmentID = <?php echo $fault->getEquipmentID(); ?>;
        data.statusID =  $('input:radio[name="estado"]:checked').val();
        data.userID = $('#userId').val();
        data.dateIn = $('input[name=dateIn]').val();
        data.dateOut = $('input[name=dateOut]').val();
        data.predictionDate = $('input[name=predictionDate]').val();
        data.values = $('#orcamento').val();
        data.obj = $('#observacoesText').val();
        data.clientID = $('#selectClient-id').val();

        $.ajax({
                type: 'POST',
                url: '../src/operations/fault/updateFault.php',
                data: data,
                dataType: 'json'
            }).done(function(response) {
                if(response.status) {

                    swal({
                      title: "Atualizado!",
                      text: "Pretendes gerar a Ficha?",
                      type: "success",
                      showCancelButton: true,
                      confirmButtonColor: "#DD6B55",
                      confirmButtonText: "Sim",
                      cancelButtonText: "Não",
                      closeOnConfirm: false
                    },
                    function(isConfirm){
                      if (isConfirm) {
                        gerarFicha(response);
                        window.location.reload(true);
                      }else{
                        window.location.reload(true);
                      }
                    });
            } else {
                //Caso contrário dizemos que aconteceu algum erro.
                noty({text: 'Não foi possivel gravar!', type: 'error'});
            }
        }).fail(function(response){
            swal.showInputError('Impossivel atualizar','','error');
        });
    });

    $('#gerarPDF').off('click').on('click',function(){
        var data = {};
        data['modeloEqui'] = <?php echo json_encode($Equipment->getModel()) ?>;
        data['estado'] = <?php echo json_encode($fault->getStatusID()) ?>;
        data['clientName'] = <?php echo json_encode($client->getName()) ?>;
        data['clientContact'] = <?php echo json_encode($client->getContact()) ?>;
        data['dateIn'] = <?php echo json_encode($fault->getDateIn()) ?>;
        data['predictionDate'] = <?php echo json_encode($fault->getPrediction()) ?>;
        data['dateOut'] = <?php echo json_encode($fault->getDateOut()) ?>;
        data['orcamento'] = <?php echo json_encode($fault->getValues()) ?>;
        data['obj'] = <?php echo json_encode($fault->getObj()) ?>;
        data['numDoc'] = <?php echo json_encode($fault->getId()) ?>;

        gerarFicha(data);
    });


function gerarFicha(response){
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

    doc.autoTable([ {title: "Nº Doc", dataKey: "number"}, {title: "Data de Entrada", dataKey: "dateIn"},{title: "Data de Entrega", dataKey: "dateOut"}]
      , [{ number: response.numDoc,dateIn: response.dateIn, dateOut: response.dateOut}], 
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
}




    $('#optionsRadios5').off('click').on('click',function(){
        var today = new Date(),
            dd = today.getDate(),
            mm = today.getMonth()+1,
            yyyy = today.getFullYear();

        if(dd<10) {
            dd='0'+dd
        } 

        if(mm<10) {
            mm='0'+mm
        } 

        today = yyyy+'-'+mm+'-'+dd;
        if($(this).is(':checked')){
            $('#dateOut').val(today);
        }
    });
    </script>
<?php include 'footer.php' ?>