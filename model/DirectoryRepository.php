<?php

require_once 'Entities/Directory.php';

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

    public static function update(Directory $directory)
    {
        $conn = getConnection();
        $data = self::directorySerialize($directory);
        try {
            $sql = "UPDATE directory SET dirName =:directoryName, parent_id=:parent_id where id=:id";
            $conn->prepare($sql)->execute($data);
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
            'directoryName' => $directory->directoryName,
            'parent_id' => $directory->parent_id,
            'status' => 1
        ];
        return $data;
    }
}