<?php

class StockDAO{

    public function selectAllStock($QueryBy,$LookFor){
        $connection = new ConnectDB();

        $sql = 'SELECT * FROM stock';
        if($QueryBy !== ''){
            $sql .= ' WHERE '. $QueryBy .' = "'. $LookFor .'"';
        }

        $list = array();

        $resultSet = $connection->sql_query($sql);

        while($row = mysql_fetch_object($resultSet)){
            $stock = new Stock($row->id,$row->equipamento,$row->ocas,$row->aros_brancos,$row->aros_pretos,$row->vidros_brancos,$row->vidros_pretos,$row->pelicula_polarizada,$row->pelicula_temperada);
            $list[$stock->id] = $stock;
        }


        return $list;
    }

    public function updateStock($Stock){
        $connection = new ConnectDB();
        $sql = 'UPDATE stock SET equipamento="'.
            $Stock->equipamento .
            '", ocas='.
            $Stock->ocas .
            ' ,aros_brancos='.
            $Stock->arosBrancos .
            ' ,aros_pretos='.
            $Stock->arosPretos .
            ' ,vidros_brancos='.
            $Stock->vidrosBrancos .
            ' ,vidros_pretos='.
            $Stock->vidrosPretos .
            ' ,pelicula_polarizada='.
            $Stock->peliculaPolarizada .
            ' ,pelicula_temperada='.
            $Stock->peliculaTemperada .
            ' WHERE id='.
            $Stock->id ;
        return $connection->sql_query($sql);
    }

    public function insertStock($Stock){
        $connection = new ConnectDB();
        $sql = 'INSERT INTO stock (id,equipamento,ocas,aros_brancos,aros_pretos,vidros_brancos,vidros_pretos,pelicula_polarizada,pelicula_temperada) VALUES (
            NULL,"'.
            $Stock->equipamento .
            '",'.
            $Stock->ocas .
            ','.
            $Stock->arosBrancos .
            ' ,'.
            $Stock->arosPretos .
            ' ,'.
            $Stock->vidrosBrancos .
            ' ,'.
            $Stock->vidrosPretos .
            ' ,'.
            $Stock->peliculaPolarizada .
            ' ,'.
            $Stock->peliculaTemperada .
            ')';
        $connection->sql_query($sql);

        $resultSet = $connection->sql_query('SELECT MAX( id ) as maxId FROM stock');
        while($row = mysql_fetch_object($resultSet)){
            return $row->maxId;
        }
    }

    public function deleteStock($id){
        $connection = new ConnectDB();
        $sql = 'DELETE FROM stock WHERE id='.$id;

        return $connection->sql_query($sql);

    }

}



?>