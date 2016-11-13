<?php include 'header.php' ?>

<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">

<script>
     (function( $ ) {
    $.widget( "custom.combobox", {
      _create: function() {
        this.wrapper = $( "<span>" )
          .addClass( "custom-combobox" )
          .insertAfter( this.element );

        this.element.hide();
        this._createAutocomplete();
        this._createShowAllButton();
      },

      _createAutocomplete: function() {
        var selected = this.element.children( ":selected" ),
          value = selected.val() ? selected.text() : "";

        this.input = $( "<input>" )
          .appendTo( this.wrapper )
          .val( value )
          .attr( "title", "" ).attr('style','height:30px;')
          .addClass( "custom-combobox-input ui-widget ui-widget-content ui-state-default ui-corner-left" )
          .autocomplete({
            delay: 0,
            minLength: 0,
            source: $.proxy( this, "_source" ),
            select: function( event, ui ) {
                    $( "#selectEquip-description" ).html( "Nome: " + ui.item.label ); 
                    $( "#idEquip" ).val( ui.item.value ); 
                    return false;
                  }
          })
          .tooltip({
            tooltipClass: "ui-state-highlight"
          });

        this._on( this.input, {
          autocompleteselect: function( event, ui ) {
            ui.item.option.selected = true;
            this._trigger( "select", event, {
              item: ui.item.option
            });
          },

          autocompletechange: "_removeIfInvalid"
        });
      },

      _createShowAllButton: function() {
        var input = this.input,
          wasOpen = false;

        $( "<a>" )
          .attr( "tabIndex", -1 )
          .attr( "title", "Mostrar todos" ).attr('style','height:30px;')
          .tooltip()
          .appendTo( this.wrapper )
          .button({
            icons: {
              primary: "ui-icon-triangle-1-s"
            },
            text: false
          })
          .removeClass( "ui-corner-all" )
          .addClass( "custom-combobox-toggle ui-corner-right" )
          .mousedown(function() {
            wasOpen = input.autocomplete( "widget" ).is( ":visible" );
          })
          .click(function() {
            input.focus();

            // Close if already visible
            if ( wasOpen ) {
              return;
            }

            // Pass empty string as value to search for, displaying all results
            input.autocomplete( "search", "" );
          });
      },

      _source: function( request, response ) {
        var matcher = new RegExp( $.ui.autocomplete.escapeRegex(request.term), "i" );
        response( this.element.children( "option" ).map(function() {
          var text = $( this ).text();
          if ( this.value && ( !request.term || matcher.test(text) ) )
            return {
              label: text,
              value: this.value,
              option: this
            };
        }) );
      },

      _removeIfInvalid: function( event, ui ) {

        // Selected an item, nothing to do
        if ( ui.item ) {
          return;
        }

        // Search for a match (case-insensitive)
        var value = this.input.val(),
          valueLowerCase = value.toLowerCase(),
          valid = false;
        this.element.children( "option" ).each(function() {
          if ( $( this ).text().toLowerCase() === valueLowerCase ) {
            this.selected = valid = true;
            return false;
          }
        });

        // Found a match, nothing to do
        if ( valid ) {
          return;
        }

        // Remove invalid value
        this.input
          .val( "" )
          .attr( "title", "Não existem registos deste equipamento!Registe o equipamento..." )
          .tooltip( "open" );
        this.element.val( "" );
        this._delay(function() {
          this.input.tooltip( "close" ).attr( "title", "" );
        }, 2500 );
        this.input.autocomplete( "instance" ).term = "";
        $('.numEquip').hide('show');
          $('.numEquipSelect').attr('required',false);
        $('.numNovoEquipment').show('show');
        $('.numNovoEquipmentRequered').attr('required', true);
        $('#novoEquipamento').val('yes');
      },

      _destroy: function() {
        this.wrapper.remove();
        this.element.show();
      }
    });
  })( jQuery );

  $(function() {
    $( "#comboboxEMEI" ).combobox();
    $( "#toggle" ).click(function() {
      $( "#comboboxEMEI" ).toggle();
    });
  });

  $(function() {
    $( ".mostrarCombo" ).on('click',function(){
        $('.numEquip').show('show');
        $('.numNovoEquipment').hide('show');
         $('.numNovoEquipmentRequered').attr('required',false);
         $('.numEquipSelect').attr('required',true);
         $('#novoEquipamento').val('');
    });
  });


  $(function() {
    <?php
    $clientDao = new ClientDAO();

    if(!isset($_GET['id'])){
        $array=$clientDao->selectAllClients('','');
        echo 'var projects = [';

        foreach($array as $x => $client) {
            echo '{
                    value:"' .$client->getId(). '",
                    label:"' .$client->getContact().'",
                    desc: "'.$client->getName().'",
                },';
        }

        echo '];';
        echo '$( "#selectClient" ).autocomplete({
                minLength: 0,
                source: projects,
                  focus: function( event, ui ) {
                    $( "#selectClient" ).val( ui.item.label );
                    return false;
                  },
                  select: function( event, ui ) {
                    $( "#selectClient" ).val( ui.item.label );
                    $( "#selectClient-id" ).val( ui.item.value );
                    $( "#selectClient-description" ).html( "Nome: " + ui.item.desc ); 
                    return false;
                  }
                })
                .autocomplete( "instance" )._renderItem = function( ul, item ) {
                  return $( "<li>" )
                    .append( "<a>" + item.label + "<br>" + item.desc + "</a>" )
                    .appendTo( ul );
                };';
    }else{
         $client = $clientDao->selectClient($_GET['id']);
         ?>
            $( "#selectClient" ).attr("disabled", true);
            $( "#selectClient" ).val(<?php echo $client->getContact(); ?>);
            $( "#selectClient-id" ).val(<?php echo $_GET['id']; ?>);
            $( "#selectClient-description" ).html("Nome: " +    "<?php echo $client->getName(); ?>"); 
    <?php
    }

    ?>
  });

  function registarAvaria(){

    var data = $('#newFaultId').serialize();

    $.ajax({
        //Tipo do pedido que, neste caso, é POST
        type: 'POST',
        /*
         * URL do ficheiro que para o qual iremos enviar os dados.
         * Pode ser um url absoluto ou relativo.
         */
        url: 'src/security/newFault.php',
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
                  doc.text(text, data.settings.margin.left, doc.internal.pageSize.height - 60);
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

                doc.autoTable([ {title: "Nº Doc", dataKey: "number"}, {title: "Data de Entrada", dataKey: "dateIn"},{title: "Previsão de Entrega", dataKey: "dateOut"}]
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

                doc.text('Data', 40, posY);
                doc.text('Colaborador', xOffset, posY);

                doc.save('Ficha'+response.numDoc+'.pdf');
                swal("Ficha Gerada!", "", "success");
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

<div class="container-fluid">
  <div class="row">
  <form id="newFaultId" method="post" role="form" action="javascript:registarAvaria()">
    <div class="panel panel-primary">
      <div class="panel-heading">
        <h3 class="panel-title">Nova Entrada</h3>
      </div>
        <div class="panel-body">
          <div class="col-lg-6">
            <div class="col-lg-8">
              <div class="form-group">
                  <label>Data de Entrada:</label>
                  <input type='date' class="form-control" name="dateIn" value="<?php echo date("Y-m-d"); ?>" disabled required/>
              </div>
              <div class="form-group">
                  <label>Data de Entrega:</label>
                  <input type='date' class="form-control" name="dateOut"  />
              </div>
            </div>
            <div class="col-lg-4">
              <div class="form-group">
                <label>Estado</label>
                <div class="radio">
                    <label>
                        <input type="radio" name="estado" id="optionsRadios1" value="1" checked>Em Analise
                    </label>
                </div>
                <div class="radio">
                    <label>
                        <input type="radio" name="estado" id="optionsRadios2" value="2">Em Reparação
                    </label>
                </div>
                <div class="radio">
                    <label>
                        <input type="radio" name="estado" id="optionsRadios3" value="3">Sem Reparação
                    </label>
                </div>
                <div class="radio">
                    <label>
                        <input type="radio" name="estado" id="optionsRadios4" value="4">Reparado
                    </label>
                </div>
                <div class="radio">
                    <label>
                        <input type="radio" name="estado" id="optionsRadios5" value="5">Entrege
                    </label>
                </div>
              </div>
            </div>
            <div class="col-lg-12">
              <label>Orçamento:</label>
              <div class="form-group input-group">
                <span class="input-group-addon"><i class="fa fa-eur"></i></span>
                <input class="form-control" name="orcamento" />
              </div>
              <div class="form-group">
                <label>Observações:</label>
                <textarea class="form-control" name="obj" rows="5"></textarea>
              </div>
            </div>
          </div>
          <div class="col-lg-6">
            <div class="form-group">
              <label>Numero do Cliente:</label>
              <input id="selectClient"  class="form-control" required value="">
              <input type="hidden" id="selectClient-id" name="idClient">
              <p id="selectClient-description"></p>
            </div>
            <div class="form-group numEquip">
              <label>IMEI do Equipamento: </label>
              <div class="ui-widget">
                <select id="comboboxEMEI" class="numEquipSelect" required>
                  <option value="">Escolhe um...</option>
                  <?php
                      $EquipmentDAO = new EquipmentDAO();
                      $arrayEquipment = $EquipmentDAO->selectAllEquipment('','');
                      foreach ($arrayEquipment as $x => $Equipamento) {
                          echo '<option value="'.$Equipamento->getId().'">'.$Equipamento->getEmei().'</option>';
                      }
                  ?>
                </select>
                <input type="hidden" id="idEquip" name="idEquip">
                <p id="selectEquip-description"></p>
              </div>
            </div>
            <div class="form-group numNovoEquipment " hidden>
              <div class="panel panel-primary">
                <div class="panel-heading">
                  <h3 class="panel-title">Novo Equipamento</h3>
                </div>
                <div class="panel-body">
                  <div class="form-group">
                    <label>Modelo:</label>
                    <input class="form-control numNovoEquipmentRequered" name="Modelo"/>
                  </div>
                  <div class="form-group">
                    <label>IMEI:</label>
                    <input class="form-control numNovoEquipmentRequered" name="EMEI"/>
                  </div>
                  <div class="form-group">
                    <label>Observações:</label>
                    <textarea class="form-control" name="objEquip" rows="3"></textarea>
                   </div>
                   <a class="mostrarCombo">Mostrar escolhas...</a>
                   <input type="hidden" id="novoEquipamento" name="novoEquipamento" value=""/>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label>Adicionar imagens:</label>
              <input type="file">
            </div>
            </div>
          </div>
          <div class="panel-footer">
            <input type="hidden" value="2" name="userID">
            <input type="submit" name='submit' class="btn btn-primary" value="Registar"></input>
          </div>
        </div>
      </form>
    </div>
  </div>
            <!-- /.container-fluid -->


 <?php 'footer.php' ?>

