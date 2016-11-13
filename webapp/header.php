<?php
session_start();

if(!isset($_SESSION['userName'])){
  header("Location: login.php");
}

    include ('../src/DAO/connectDAO.php');
    include('../src/DAO/ClienteDAO.php');
    include('../src/DAO/UserDAO.php');
    include('../src/DAO/EquipmentDAO.php');
    include('../src/DAO/FaultDAO.php');
    include('../src/DAO/EstadoDAO.php');

    include ('../src/classes/Client.php');
    include ('../src/classes/Equipment.php');
    include ('../src/classes/Fault.php');
    include ('../src/classes/User.php');
    include ('../src/classes/Estado.php');
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>CRC - Admin</title>

    <!-- Bootstrap -->
    <link href="vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jsgrid/1.4.1/jsgrid.min.css" />
    <link type="text/css" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jsgrid/1.4.1/jsgrid-theme.min.css" />
    <!-- iCheck -->
    <link href="vendors/iCheck/skins/flat/blue.css" rel="stylesheet">
    <!-- bootstrap-wysiwyg -->
    <link href="vendors/google-code-prettify/bin/prettify.min.css" rel="stylesheet">
    <!-- Select2 -->
    <link href="vendors/select2/dist/css/select2.min.css" rel="stylesheet">
    <!-- Switchery -->
    <link href="vendors/switchery/dist/switchery.min.css" rel="stylesheet">
    <!-- starrr -->
    <link href="vendors/starrr/dist/starrr.css" rel="stylesheet">
    <!-- Custom Theme Style -->
    <link href="css/custom.css" rel="stylesheet">
    <!-- Dropzone.js -->
    <link href="vendors/dropzone/dist/min/dropzone.min.css" rel="stylesheet">
    <!-- FullCalendar -->
    <link href="vendors/fullcalendar/dist/fullcalendar.min.css" rel="stylesheet">
    <link href="vendors/fullcalendar/dist/fullcalendar.print.css" rel="stylesheet" media="print">


    <!-- jQuery -->
    <script src="vendors/jquery/dist/jquery.min.js"></script>
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jsgrid/1.4.1/jsgrid.min.js"></script>

    <link href="vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="vendors/DataTables/media/css/jquery.dataTables.css"/>
    <link rel="stylesheet" type="text/css" href="vendors/sweetalert-master/dist/sweetalert.css">
    <link rel="stylesheet" type="text/css" href="vendors/sweetalert-master/themes/facebook/facebook.css">
    <link rel="stylesheet" type="text/css" href="vendors/sweetalert-master/dist/swal-forms.css">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/animate.css/3.2.0/animate.min.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">

    <script type="text/javascript" src="vendors/jsPDF/dist/jspdf.min.js"></script>
    <script type="text/javascript" src="vendors/noty/js/noty/packaged/jquery.noty.packaged.min.js"></script>
    <script type="text/javascript" src="vendors/DataTables/media/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="vendors/jsPDF-AutoTable-master/dist/jspdf.plugin.autotable.js"></script>
    <script type="text/javascript" src="vendors/sweetalert-master/dist/sweetalert.min.js"></script>
    <script type="text/javascript" src="vendors/sweetalert-master/dist/swal-forms.js"></script>
    <script type="text/javascript" src="vendors/animatedModal/animatedModal.js"></script>
    <script type="text/javascript" src="vendors/headerImgData.js"></script>
    <script src="vendors/plugins/morris/raphael.min.js"></script>
    <script src="vendors/plugins/morris/morris.min.js"></script>
    <!-- Bootstrap -->
    <script src="vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- FastClick -->
    <script src="vendors/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="vendors/nprogress/nprogress.js"></script>
    <!-- bootstrap-progressbar -->
    <script src="vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
    <!-- iCheck -->
    <script src="vendors/iCheck/icheck.min.js"></script>
    <!-- bootstrap-daterangepicker -->
    <script src="js/moment/moment.min.js"></script>
    <script src="js/datepicker/daterangepicker.js"></script>
    <!-- bootstrap-wysiwyg -->
    <script src="vendors/bootstrap-wysiwyg/js/bootstrap-wysiwyg.min.js"></script>
    <script src="vendors/jquery.hotkeys/jquery.hotkeys.js"></script>
    <script src="vendors/google-code-prettify/src/prettify.js"></script>
    <!-- jQuery Tags Input -->
    <script src="vendors/jquery.tagsinput/src/jquery.tagsinput.js"></script>
    <!-- Switchery -->
    <script src="vendors/switchery/dist/switchery.min.js"></script>
    <!-- Select2 -->
    <script src="vendors/select2/dist/js/select2.full.min.js"></script>
    <!-- Parsley -->
    <script src="vendors/parsleyjs/dist/parsley.min.js"></script>
    <!-- Autosize -->
    <script src="vendors/autosize/dist/autosize.min.js"></script>
    <!-- jQuery autocomplete -->
    <script src="vendors/devbridge-autocomplete/dist/jquery.autocomplete.min.js"></script>
    <!-- starrr -->
    <script src="vendors/starrr/dist/starrr.js"></script>
    <!-- Dropzone.js -->
    <script src="vendors/dropzone/dist/min/dropzone.min.js"></script>
    <!-- ECharts -->
    <script src="vendors/echarts/dist/echarts.min.js"></script>
    <script src="vendors/echarts/map/js/world.js"></script>

    <!-- FullCalendar -->
    <script src="vendors/moment/min/moment.min.js"></script>
    <script src="vendors/fullcalendar/dist/fullcalendar.min.js"></script>

    <script type="text/javascript" src="js/MyLib/buttonAddClient.js"></script>



  </head>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col menu_fixed">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
              <a href="index.php" class="site_title"><img style="height: 45px; margin-right: 5px" class="icon-bar" src="images/CRC.gif"> <span>CRC - Admin</span></a>
            </div>

            <div class="clearfix"></div>

            <!-- menu profile quick info -->
            <div class="profile">
              <div class="profile_pic">
                <img src="images/user.png" alt="..." class="img-circle profile_img">
              </div>
              <div class="profile_info">
                <span>Bem-vindo,</span>
                <h2><?php echo $_SESSION['name']; ?></h2>
              </div>
            </div>
            <!-- /menu profile quick info -->

            <br />

            <!-- sidebar menu -->
            <?php include 'sidebar_menu.php' ?>
            <!-- /sidebar menu -->
          </div>
        </div>
        <?php include 'horizontal_menu.php' ?>
          <!-- page content -->
          <div class="right_col" role="main">

<script type="text/javascript">

$('.logout-link').off('click').on('click', function(){
  $.ajax({
    url: '../src/operations/user/logoutProcess.php',
    type: 'POST',
    data: {},
  })
  .done(function() {
   window.location.href = 'index.php';
  })
  .fail(function() {
    console.log("error");
  })
  .always(function() {
    console.log("complete");
  });
})
</script>