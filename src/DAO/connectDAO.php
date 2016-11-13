<?php

/**
*
*/
class ConnectDB
{
	var $host = "localhost";
    var $user = "root";
    var $password = "";
    var $dbase = "secun";

    /*var $host = "localhost";
    var $user = "wwwcrc_admin";
    var $password = "secon666!";
    var $dbase = "wwwcrc_gestor";*/

    var $query;
    var $link;
    var $resulSet;
    var $lastId;

    function MySQL(){

    }


    function conecta(){
        $this->link = @mysql_connect($this->host,$this->user,$this->password);
        if(!$this->link){
            print "Ocorreu um Erro na conexão MySQL:";
      		print "<b>".mysql_error()."</b>";
      		die();
        }elseif(!mysql_select_db($this->dbase,$this->link)){
            print "Ocorreu um Erro em selecionar a base de dados:";
      		print "<b>".mysql_error()."</b>";
      		die();
        }
    }


    function sql_query($query){
        $this->conecta();
        $this->query = $query;


        if($this->resultSet = mysql_query($this->query)){
             $this->lastId = mysql_insert_id();
            $this->desconecta();
            return $this->resultSet;
        }else{
            print "Ocorreu um erro ao executar a Query MySQL: <b>$query</b>";
      		print "<br><br>";
      		print "Erro no MySQL: <b>".mysql_error()."</b>";
      		die();
            $this->desconecta();
        }
    }

    function desconecta(){
        return mysql_close($this->link);
    }

}

?>