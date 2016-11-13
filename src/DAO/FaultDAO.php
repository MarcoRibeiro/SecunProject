<?php 

class stateCount {
    public $state;
    public $total;
}

class FaultDAO{

	public function selectFault($id){
        $connection = new ConnectDB();
        $sql = 'SELECT * FROM avaria WHERE AvariaID='.$id;

        $resultSet = $connection->sql_query($sql);

        while($row = mysql_fetch_object($resultSet)){
            $fault = new Fault($row->AvariaID,$row->EquipamentoID,$row->EstadoID,$row->UtilizadorID,$row->DataEntrada,$row->DataEntrega,$row->Orcamento,$row->Observacoes,$row->ClientID, $row->previsao);
        }

		return $fault;
	}

    public function selectClientFaultsGroupByStatus($clientID){
        $connection = new ConnectDB();
        if($clientID){
            $sql = 'select EstadoId as EstadoID, count(*) as total, sum(Orcamento) as orcamento from avaria where ClientID ='.$clientID.' group by EstadoId';
        }else{
            $sql = 'select EstadoId as EstadoID, count(*) as total, sum(Orcamento) as orcamento from avaria group by EstadoId';
        }

        $resultSet = $connection->sql_query($sql);

        $MyObjects = array();

        while($row = mysql_fetch_object($resultSet)){
            $MyObject = new stateCount;
            switch ($row->EstadoID) {
                case 2:
                    $MyObject->state = 'Em Reparação';
                    $MyObject->divID = 'emReparacaoID';
                    break;
                case 3:
                    $MyObject->state = 'Sem Reparação';
                    $MyObject->divID = 'semReparacaoID';
                    break;
                case 4:
                    $MyObject->state = 'Reparado';
                    $MyObject->divID = 'reparacaoID';
                    break;
                case 5:
                    $MyObject->state = 'Entregue';
                    $MyObject->divID = 'entregueID';
                    break;
                case 6:
                    $MyObject->state = 'Entregue s/Reparação';
                    $MyObject->divID = 'entregueReparacaoID';
                    break;
                default:
                    $MyObject->state = 'Em Analise';
                    $MyObject->divID = 'emAnaliseID';
                    break;
            }
            $MyObject->total = $row->total ;
            $MyObject->totalOrcamento = $row->orcamento ;

            $MyObjects[] = $MyObject;
        }

        return $MyObjects;
    }

    public function selectAllFaults($QueryBy,$LookFor){
        $connection = new ConnectDB();

        $sql = 'SELECT * FROM avaria';

        if($QueryBy !== ''){
            $sql = $sql . ' WHERE '. $QueryBy .' = "'.$LookFor.'"';
        }

        $list = array();

        $resultSet = $connection->sql_query($sql);

        while($row = mysql_fetch_object($resultSet)){
            $fault = new Fault($row->AvariaID,$row->EquipamentoID,$row->EstadoID,$row->UtilizadorID,$row->DataEntrada,$row->DataEntrega,$row->Orcamento,$row->Observacoes,$row->ClientID, $row->previsao);
            $list[$fault->id] = $fault;
        }

        return $list;
    }

    public function updateFault($Fault){
        $connection = new ConnectDB();
        $sql = 'UPDATE avaria SET EquipamentoID="'.
            $Fault->getEquipmentID().
            '", EstadoID='.
            $Fault->getStatusID().
            ' ,UtilizadorID="'.
            $Fault->getUserID().
            '" ,DataEntrada="'.
            $Fault->getDateIn().
            '" ,DataEntrega="'.
            $Fault->getDateOut().
            '" ,Orcamento="'.
            $Fault->getValues().
            '" ,Observacoes="'.
            $Fault->getObj().
            '" ,ClientID="'.
            $Fault->getClientID().
            '" ,previsao="'.
            $Fault->getPrediction().
            '" WHERE AvariaID='.
            $Fault->getId();
        return $connection->sql_query($sql);
    }

    public function insertFault($Fault){
        $connection = new ConnectDB();
        $sql = 'INSERT INTO avaria (EquipamentoID,EstadoID,UtilizadorID,DataEntrada,DataEntrega,Orcamento,ClientID,Observacoes,previsao) VALUES ("'.
            $Fault->getEquipmentID().
            '","'.
            $Fault->getStatusID().
            '" ,"'.
            $Fault->getUserID().
            '","'.
            $Fault->getDateIn().
            '","'.
            $Fault->getDateOut().
            '","'.
            $Fault->getValues().
            '","'.
            $Fault->getClientID().
             '","'.
            $Fault->getObj().
             '","'.
            $Fault->getPrediction().
            '")';
        $connection->sql_query($sql);

        $resultSet = $connection->sql_query('SELECT MAX( AvariaID ) as maxId FROM avaria');
        while($row = mysql_fetch_object($resultSet)){
            return $row->maxId;
        }
    }

    public function deleteFault($id){
        $connection = new ConnectDB();
        $sql = 'DELETE FROM avaria WHERE AvariaID='.$id;

        $connection->sql_query($sql);
    }

}




?>