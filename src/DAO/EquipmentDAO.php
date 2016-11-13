<?php 



class EquipmentDAO{

	public function selectEquipment($id){
        $connection = new ConnectDB();
        $sql = 'SELECT * FROM equipamento WHERE equipamentoID='.$id;

        $resultSet = $connection->sql_query($sql);

        while($row = mysql_fetch_object($resultSet)){
            $eqp = new Equipment($row->EquipamentoID,$row->Modelo,$row->Emei,$row->observacoes,$row->ClientID);
        }

		return $eqp;
	}

    public function selectAllEquipment($QueryBy,$LookFor){
        $connection = new ConnectDB();
         $sql = 'SELECT * FROM equipamento';
        if($QueryBy !== ''){
            $sql .= ' WHERE '. $QueryBy .' = "'. $LookFor .'"';
        }

        $list = array();

        $resultSet = $connection->sql_query($sql);

        while($row = mysql_fetch_object($resultSet)){
            $eqp = new Equipment($row->EquipamentoID,$row->Modelo,$row->Emei,$row->observacoes,$row->ClientID);
            $list[$eqp->id] = $eqp;
        }


        return $list;
    }

    public function updateEquipment($Equipment){
        $connection = new ConnectDB();
        $sql = 'UPDATE equipamento SET Modelo="'.
            $Equipment->getModel().
            '", Emei='.
            $Equipment->getEmei().
            ' ,observacoes="'.
            $Equipment->getObj().
            ' ,ClienteID="'.
            $Equipment->getClienteID().
            '" WHERE EquipamentoID='.
            $Equipment->getId();
        $connection->sql_query($sql);
    }

    public function insertEquipment($Equipment){
        $connection = new ConnectDB();
        $sql = 'INSERT INTO equipamento (Modelo,Emei,observacoes,ClientID) VALUES ("'.
            $Equipment->getModel().
            '","'.
            $Equipment->getEmei().
            '","'.
            $Equipment->getObj().
            '" ,'.
            $Equipment->getClienteID().
            ')';
        $connection->sql_query($sql);

        $resultSet = $connection->sql_query('SELECT MAX( EquipamentoID ) as maxId FROM equipamento');
        while($row = mysql_fetch_object($resultSet)){
            return $row->maxId;
        }
    }

    public function deleteEquipment($id){
        $connection = new ConnectDB();
        $sql = 'DELETE FROM equipamento WHERE EquipamentoID='.$id;

        $connection->sql_query($sql);

    }

}



?>