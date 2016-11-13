<?php include 'header.php';

$FaultDAO = new FaultDAO();
$EstadoDAO = new EstadoDAO();
$EquipmentDAO = new EquipmentDAO();
$ClientDAO = new ClientDAO();
$fault=$FaultDAO->selectFault($_GET['id']);
?>


<div class="container-fluid">

         <div class="row">
         <form method="post" role="form">
          <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">Reparação</h3>
                    </div>
                    <div class="panel-body">
            <div class="col-lg-6">
                <div class="col-lg-8">
                    <div class="form-group">
                        <label>Data de Entrada:</label>

                        <input type='date' class="form-control" name="dateIn" value="<?php echo $fault->getDateIn() ?>" disabled required/>
                    </div>
                    <div class="form-group">
                        <label>Data de Entrega:</label>
                        <input type='date' id="dateOut" class="form-control" name="dateOut" value="<?php echo $fault->getDateOut() ?>"/>
                    </div>
                </div>
                <div class="col-lg-4">
                <div class="form-group">
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
                    </div>
                </div>
                <div class="col-lg-12">
               <div class="form-group">
                    <label>Observações:</label>
                     <textarea id="observacoesText" class="form-control" name="obj" rows="5"><?php echo $fault->getObj() ?></textarea>
                </div>
                 <label>Orçamento:</label>
                <div class="form-group input-group">
                    <span class="input-group-addon"><i class="fa fa-eur"></i></span>
                    <input class="form-control" name="orcamento" id="orcamento" value="<?php echo $fault->getValues() ?>"/>
                 </div>
             </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    <label>Numero do Cliente:</label>
                     <?php $client = $ClientDAO->selectClient($fault->getClientID()) ?>
                    <input id="selectClient"  disabled class="form-control" required value="<?php echo $client->getContact() ?>">
                    <input type="hidden" id="selectClient-id" name="idClient" value="<?php echo $fault->getClientID() ?>">
                    <p id="selectClient-description"><?php echo $client->getName() ?></p>
                </div>
                  <div class="form-group numNovoEquipment ">
                    <div class="panel panel-primary">
                    <div class="panel-heading">
                        <?php $Equipment=$EquipmentDAO->selectEquipment($fault->getEquipmentID()) ?>
                        <h3 class="panel-title">Equipamento</h3>
                    </div>
                    <div class="panel-body">
                       <div class="form-group">
                            <label>Modelo:</label>
                            <input disabled class="form-control numNovoEquipmentRequered" name="Modelo" value="<?php echo $Equipment->getModel() ?>"/>
                         </div>
                       <div class="form-group">
                            <label>IMEI:</label>
                            <input disabled class="form-control numNovoEquipmentRequered" name="EMEI" value="<?php echo $Equipment->getEmei() ?>"/>
                        </div>
                        <div class="form-group">
                            <label>Observações:</label>
                            <textarea disabled class="form-control" name="objEquip" id="objEquip" rows="3"><?php echo $Equipment->getObj() ?></textarea>
                         </div>
                         <input type="hidden" id="novoEquipamento" name="novoEquipamento" value="<?php echo $Equipment->getObj() ?>"/>
                    </div>
                </div>
                  </div>
                <div class="form-group">
                    <label>Imagens:</label>
                    <input type="file" multiple>
                </div>
            </div>
             </div>
             <div class="panel-footer">
                <input type="hidden" id='userId' value="2" name="userID">
                <a href="#" id='atualizar' name='submit' class="btn btn-primary" >Atualizar</a>
                <input type="submit" name='submit' class="btn btn-primary" value="Gerar PDF"></input>
            </div>
        </div>
        </form>
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
        data.values = $('#orcamento').val();
        data.obj = $('#observacoesText').text();
        data.clientID = $('#selectClient-id').val();

        $.ajax({
                type: 'POST',
                url: 'web/operations/fault/updateFault.php',
                data: data,
                dataType: 'json'
            }).done(function(response) {
                swal("Atualizado!", "", "success");
            }).fail(function(response){
                swal.showInputError('Impossivel atualizar','','error');
            });
    });




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
<?php 'footer.php' ?>