<?php

require_once 'src/connection.php';
class DirectoryRepository
{
    public static function loadById($id)
    {
        $conn = getConnection();
        try {
            $directory = $conn->query("Select * from directory where id=$id")->fetchObject('Directory');
            return $directory;
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }
    public static function save(Directory $directory)
    {
        $conn = getConnection();
        $data = self::directorySerialize($directory);
        try {
            $sql = "INSERT INTO directory (dirName, parent_id, status) values(:directoryName, :parent_id, :status)";
            $conn->prepare($sql)->execute($data);
        } catch (Exception $e) {
            exit($e->getMessage());
        }
    }
    public static function update(Directory $directory)
    {
        $conn = getConnection();
        $oldDirectory = self::loadById($directory->id);
        var_dump($oldDirectory);
        $data = self::directorySerialize($directory);
        $data['id'] = $directory->id;
        if(is_null($directory->directoryName)){
            $data['directoryName'] = $oldDirectory->dirName;
        }
        if(is_null($directory->parent_id)){
            $data['parent_id'] = intval($oldDirectory->parent_id);
        }
     
        var_dump($data);
        try {
            $sql = "UPDATE directory SET dirName =:directoryName, parent_id=:parent_id, status=:status where id=:id";
            $conn->prepare($sql)->execute($data);
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }
    public static function updateStatus(int $status, $id)
    {
        $conn = getConnection();
        try {
            $sql = " UPDATE directory SET status = $status  where id= $id";
            $conn->prepare($sql)->execute();
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }
    public static function delete($id)
    {
        $conn = getConnection();
        try {
            $sql = " UPDATE directory SET status = 0  where id= $id";
            $conn->prepare($sql)->execute();
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }
    public static function directorySerialize(Directory $directory)
    {   
       
        $data = [
            // 'id'=>$directory->id, ask I need to id for update 
            'directoryName' => $directory->directoryName,
            'parent_id' => intval($directory->parent_id),
            'status' => 1
        ];
        return $data;
    }
}
