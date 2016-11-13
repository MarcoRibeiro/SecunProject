<?php include 'header.php' ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
               
                <small>Novo Cliente</small>
            </h1>
            <ol class="breadcrumb">
                <li>
                    <i class="fa fa-dashboard"></i>  <a href="index.php">Inicio</a>
                </li>
                <li class="active">
                    <i class="fa fa-file"></i> Novo Cliente
                </li>
            </ol>
        </div>
    </div>
	<div class="col-lg-12">
        <?php include 'security/newClient.php' ?>
        <form method="post" role="form">
            <h3>Novo Cliente</h3>
                                                   
            <div class="form-group">
                <label>Nome:</label>
                <input class="form-control" name="name" required/>
            </div>
            <div class="form-group">
                <label>Contacto:</label>
                <input class="form-control" name="contact" required/>
            </div>
            <div class="form-group">
                <label>Morada:</label>
                <input class="form-control" name="morada" required=/>
            </div>
            <div class="form-group">
                <label>Email:</label>
                <input class="form-control" name="email" required/>
            </div>                          
            <div class="col-lg-3">
              <input type="submit" name='submit' class="btn btn-primary" value="Registar"></input>
            </div>
        </form>                      
    </div>
</div>
<!-- /.container-fluid -->
<?php 'footer.php' ?>