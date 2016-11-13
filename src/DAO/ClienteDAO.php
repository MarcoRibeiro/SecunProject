<?php 



class ClientDAO{

	public function selectClient($id){
        $connection = new ConnectDB();
        $sql = 'SELECT * FROM cliente WHERE clienteID='.$id;

        $resultSet = $connection->sql_query($sql);

        while($clientBD = mysql_fetch_object($resultSet)){
            $client = new Client($clientBD->ClienteID,$clientBD->Nome,$clientBD->Contacto,$clientBD->Email,$clientBD->Morada);
        }

		return $client;
	}

    public function selectAllClients($QueryBy,$LookFor){
        $connection = new ConnectDB();

        if($QueryBy !== ''){
            $sql = 'SELECT * FROM cliente WHERE '. $QueryBy .' LIKE "%' .$LookFor .'%"';
        }else{
            $sql = 'SELECT * FROM cliente';
        }


        $listOfClients = array();

        $resultSet = $connection->sql_query($sql);

        while($clientBD = mysql_fetch_object($resultSet)){
            $client = new Client($clientBD->ClienteID,$clientBD->Nome,$clientBD->Contacto,$clientBD->Email,$clientBD->Morada);
            $listOfClients[$client->id] = $client;
        }


        return $listOfClients;
    }

    public function updateClient($Client){
        $connection = new ConnectDB();
        $sql = 'UPDATE cliente SET Nome="'.
            $Client->getName().
            '", Contacto='.
            $Client->getContact().
            ' ,Email="'.
            $Client->getEmail().
            '" ,Morada="'.
            $Client->getLocal().
            '" WHERE clienteID='.
            $Client->getId();
        $connection->sql_query($sql);
    }

    public function insertClient($Client){
        $connection = new ConnectDB();
        $sql = 'INSERT INTO cliente (Nome,Morada,Contacto,Email) VALUES ("'.
            $Client->getName().
            '","'.
            $Client->getLocal().
            '" ,'.
            $Client->getContact().
            ',"'.
            $Client->getEmail().
            '")';
        $connection->sql_query($sql);

        $resultSet = $connection->sql_query('SELECT MAX( clienteID ) as maxId FROM cliente');
        while($row = mysql_fetch_object($resultSet)){
            return $row->maxId;
        }
    }

    public function deleteClient($id){
        $connection = new ConnectDB();
        $sql = 'DELETE FROM cliente WHERE clienteID='.$id;

        return $connection->sql_query($sql);
    }

}



?>