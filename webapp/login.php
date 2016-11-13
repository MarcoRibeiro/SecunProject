<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>CRC - Admin </title>

    <!-- Bootstrap -->
    <link href="vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- jQuery -->
    <script src="vendors/jquery/dist/jquery.min.js"></script>
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
    <script src="vendors/jquery-validation/dist/jquery.validate.js"></script>

    <!-- Custom Theme Style -->
    <link href="css/custom.css" rel="stylesheet">
  </head>

  <body style="background:#F7F7F7;">
    <div class="">
      <a class="hiddenanchor" id="toregister"></a>
      <a class="hiddenanchor" id="tologin"></a>

      <div id="wrapper">
        <div id="login" class="form">
          <section class="login_content">
            <form method="Post" id="login-form">
             <h1><img style="height: 45px; margin-right: 5px" class="icon-bar" src="images/CRC.gif"> CRC - Admin</h1>
              <div id="error"><!-- error will be shown here ! --></div>
              <div class="form-group">
                <input type="text" class="form-control" placeholder="Username" name="Username" required="" />
              </div>
              <div class="form-group">
                <input type="password" class="form-control" placeholder="Password" name="Password" required="" />
              </div>
              <div class="form-group">
                <button type="submit" class="btn btn-default" name="btn-login" id="btn-login">Login</button>

                <a class="reset_pass" href="#">Lost your password?</a>
              </div>
              <div class="clearfix"></div>
              <div class="separator">

                <!--p class="change_link">New to site?
                  <a href="#toregister" class="to_register"> Create Account </a>
                </p-->
                <div class="clearfix"></div>
                <br />
              </div>
            </form>
          </section>
        </div>

        <div id="register" class=" form">
          <section class="login_content">
            <form>
              <h1><img style="height: 45px; margin-right: 5px" class="icon-bar" src="images/CRC.gif"> CRC - Admin</h1>
              <div class="form-group">
                <input type="text" class="form-control" placeholder="Username" required="" />
              </div>
              <div class="form-group">
                <input type="email" class="form-control" placeholder="Email" required="" />
              </div>
              <div class="form-group">
                <input type="password" class="form-control" placeholder="Password" required="" />
              </div>
              <div>
                <a class="btn btn-default submit" href="index.html">Submit</a>
              </div>
              <div class="clearfix"></div>
              <div class="separator">

                <p class="change_link">Already a member ?
                  <a href="#tologin" class="to_register"> Log in dasda </a>
                </p>
                <div class="clearfix"></div>
                <br />
                <div>
                  <h1><img style="height: 45px; margin-right: 5px" class="icon-bar" src="images/CRC.gif"> CRC - Admin</h1>
                </div>
              </div>
            </form>
          </section>
        </div>
<script type="text/javascript">
$('document').ready(function(){
     /* validation */
  $("#login-form").validate({
      rules:{
        Password: {
          required: true,
        },
        Username: {
          required: true
        },
      },
      messages:{
        Password:{
          required: "Por favor, peencha a password"
        },
        Username: "Por favor, preencha o seu nome de utilizador",
      },
      submitHandler: submitForm
      });
    /* validation */
    /* login submit */
  function submitForm(){
    var data = $("#login-form").serialize();

    $.ajax({
      type : 'POST',
      url  : '../src/operations/user/loginProcess.php',
      data : data,
      beforeSend: function(){
        $("#error").fadeOut();
        $("#btn-login").html('<span class="glyphicon glyphicon-transfer"></span> &nbsp; sending ...');
      },
      success :  function(response){
        if ( response=="ok" ){
          $("#btn-login").html('&nbsp; Signing In ...');
          setTimeout(' window.location.href = "index.php"; ',200);
        } else {
          $("#error").fadeIn(1000, function(){
            $("#error").html('<div class="alert alert-danger"> <span class="glyphicon glyphicon-info-sign"></span> &nbsp; '+response+' !</div>');
            $("#btn-login").html('<span class="glyphicon glyphicon-log-in"></span> &nbsp; Sign In');
          });
        }
     }
    });
    return false;
  }
    /* login submit */
});

</script>



      </div>
    </div>
  </body>
</html>