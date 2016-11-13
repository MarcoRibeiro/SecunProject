<!-- sidebar menu -->
<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
  <div class="menu_section">
    <h3>_____________________________</h3>
    <ul class="nav side-menu">
      <li><a  href="index.php"><i class="fa fa-home"></i> Home</a>
      </li>
      <li><a><i class="fa fa-users"></i> Clientes <span class="fa fa-chevron-down"></span></a>
        <ul class="nav child_menu">
          <li selected><a href="gerirClientes.php">Lista Cliente</a></li>
          <li><a class='' href="createClient.php">Novo Cliente</a></li>
        </ul>
      </li>
      <li><a><i class="fa fa-cogs"></i> Reparações <span class="fa fa-chevron-down"></span></a>
        <ul class="nav child_menu">
          <li><a href="gerirReparacoes.php"> Lista</a></li>
          <li><a class='novaReparacaoLink' href="novaAvaria.php"> Nova Entrada</a></li>
          <!--li><a class='novoEquipamentoLink' href="#"> Novo Equipamento</a></li-->
        </ul>
      </li>
      <li><a href="stock.php"><i class="fa fa-tasks"></i> Stock</a></a>
      </li>
    </ul>
  </div>

</div>
<!-- /sidebar menu -->
<!-- /menu footer buttons -->
<div class="sidebar-footer hidden-small">
  <a data-toggle="tooltip" data-placement="top" title="Settings">
    <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
  </a>
  <a data-toggle="tooltip" data-placement="top" title="FullScreen">
    <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
  </a>
  <a data-toggle="tooltip" data-placement="top" title="Lock">
    <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
  </a>
  <a class='logout-link' data-toggle="tooltip" data-placement="top" title="Logout">
    <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
  </a>
</div>
<!-- /menu footer buttons -->
