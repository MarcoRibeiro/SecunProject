<?php

class EstadoDAO{

	public function selectEstado($id){
        $connection = new ConnectDB();
        $sql = 'SELECT * FROM estado WHERE EstadoID='.$id;

        $resultSet = $connection->sql_query($sql);

        while($row = mysql_fetch_object($resultSet)){
            $estado = new Estado($row->EstadoID,$row->Descricao,$row->class);
        }

		return $estado;
	}

}

?>