<?php 



class UserDAO{

	public function selectUser($id){
        $connection = new ConnectDB();
        $sql = 'SELECT * FROM utilizador WHERE utilizadorID='.$id;

        $resultSet = $connection->sql_query($sql);

        while($row = mysql_fetch_object($resultSet)){
            $result = new User($row->UtilizadorID,$row->Nome,$row->UserName,$row->Password,$row->tipo);
        }

		return $result;
	}


    public function verifyUser($userName, $password){
        $connection = new ConnectDB();
        $sql = 'SELECT * FROM utilizador WHERE UserName="'.$userName .'" AND Password="'.$password.'"';

        $resultSet = $connection->sql_query($sql);

        while($row = mysql_fetch_object($resultSet)){
            $result = new User($row->UtilizadorID,$row->Nome,$row->UserName,$row->Password,$row->tipo);
        }

        return $result;
    }


    public function selectAllUser($QueryBy,$LookFor){
        $connection = new ConnectDB();

        if($QueryBy !== ''){
            $sql = 'SELECT * FROM utilizador WHERE '. $QueryBy .' LIKE "%' .$LookFor .'%"';
        }else{
            $sql = 'SELECT * FROM utilizador';
        }


        $list = array();

        $resultSet = $connection->sql_query($sql);

        while($rows = mysql_fetch_object($resultSet)){
            $user = new User($rows->UtilizadorID,$rows->Nome,$rows->UserName,$rows->Password,$rows->tipo);
            $list[$user->id] = $user;
        }


        return $list;
    }

    public function updateUser($User){
        $connection = new ConnectDB();
        $sql = 'UPDATE utilizador SET Nome="'.
            $User->getName().
            '", UserName='.
            $User->getUserName().
            ' ,Password="'.
            $User->getPassword().
            '" ,tipo="'.
            $User->getType().
            '" WHERE UtilizadorID='.
            $User->getId();
        $connection->sql_query($sql);
    }

    public function insertUser($User){
        $connection = new ConnectDB();
        $sql = 'INSERT INTO utilizador (Nome,UserName,Password,tipo) VALUES ("'.
            $User->getName().
            '",'.
            $User->getUserName().
            ' ,"'.
            $User->getPassword().
            '","'.
            $User->getType().
            '")';
        $connection->sql_query($sql);
    }

    public function deleteUser($id){
        $connection = new ConnectDB();
        $sql = 'DELETE FROM utilizador WHERE clienteID='.$id;

        $connection->sql_query($sql);
    }

}



?>