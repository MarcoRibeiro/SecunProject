<?php include 'header.php' ?>

<div class="container-fluid">
    <div class="x_panel">
      <div class="x_title">
        <h2>Novo Cliente</h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <br>
        <form id="novo-client-form" data-parsley-validate="" class="form-horizontal form-label-left" novalidate="">

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Nome <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" id="first-name" name="nome" required="required" class="form-control col-md-7 col-xs-12">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="contact">Contacto <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="number" id="contact" name="contacto" required="required" class="form-control col-md-7 col-xs-12">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="Morada">Morada <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" id="Morada" name="morada" required="required" class="form-control col-md-7 col-xs-12">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="Email">Email <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" id="contact" name="email" required="required" class="form-control col-md-7 col-xs-12">
            </div>
          </div>
          <div class="ln_solid"></div>
          <div class="form-group">
            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
              <a href="#" id="registarCliente" class="btn btn-dark" >Registar</a>
            </div>
          </div>

        </form>
      </div>
    </div>
</div>
<!-- /.container-fluid -->
<script type="text/javascript">

$('#registarCliente').off('click').on('click', function(){
    var data = $('#novo-client-form').serialize();
     $.ajax({
            type: 'POST',
            url: '../src/operations/client/saveClient.php',
            data: data,
            dataType: 'json'
        }).done(function(response) {
            swal("Cliente registado!", "", "success");
            window.location.reload(true);
        }).fail(function(response){
            swal.showInputError('Impossivel registar','','error');
        });
});

</script>


<?php include 'footer.php' ?>