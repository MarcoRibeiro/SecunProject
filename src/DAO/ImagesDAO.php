<?php 



class ImagesDAO{

    public function selectAllImages($QueryBy,$LookFor){
        $connection = new ConnectDB();

        if($QueryBy !== ''){
            $sql = 'SELECT * FROM images WHERE '. $QueryBy .' LIKE "%' .$LookFor .'%"';
        }else{
            $sql = 'SELECT * FROM images';
        }


        $listOfImages = array();

        $resultSet = $connection->sql_query($sql);

        while($ImageDB = mysql_fetch_object($resultSet)){
            $Image = new Image($ImageDB->id,$ImageDB->imagem,$ImageDB->evtID);
            $listOfImages[$client->id] = $client;
        }


        return $listOfImages;
    }

    public function insertArrayImages($arrayImages){
        $connection = new ConnectDB();
        $sql = '';
        foreach ($arrayImages as $value) {
            $sql .= $this->generateSQLinsert($value));
        }
        $connection->sql_query($sql);
    }

    public function insertImage($Image){
        $connection = new ConnectDB();
        $sql = $this->generateSQLinsert($Image);
        $connection->sql_query($sql);
    }

    public function generateSQLinsert($Image){
        return 'INSERT INTO images(evtID, imagem) VALUES ("'. $Image->getEvtID() . '",'. $Image->getImage() .')';
    }

    public function deleteImage($id){
        $connection = new ConnectDB();
        $sql = 'DELETE FROM images WHERE evtID='.$id;
        $connection->sql_query($sql);
    }

}



?>