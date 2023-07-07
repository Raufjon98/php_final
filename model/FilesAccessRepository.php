<?php

class fileAccessRepository
{
    public static function loadByIdFile($idFile)
    {
        $conn = getConnection();
        try {
            $fileAccess = $conn->query(" SELECT id_user FROM `fileAccess` WHERE id_file =$idFile")->fetchAll(PDO::FETCH_CLASS, 'FileAccess');
            return $fileAccess;
        } catch (Exception $e) {
             exit($e->getMessage());
        }
    }
    public static function save(fileAccess $fileAccess)
    {
        //ask usage, because you have no class to this method
        $conn = getConnection();
        $data = self::accessSerialize($fileAccess);
        try {
            $sql = "INSERT INTO fileAccess(id_file, id_user) values (:id_file, :id_user)";
            $conn->prepare($sql)->execute($data);
            echo "Access added!";
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

    public static function delete(FileAccess $fileAccess)
    {
        //ask here too
        $conn = getConnection();
        $data = self::accessSerialize($fileAccess);
        try {
            $sql = "Delete from fileAccess where id_file =:id_file and id_user =:id_user";
            $conn->prepare($sql)->execute($data);
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

    private static function accessSerialize(fileAccess $fileAccess)
    {
        $data = [
            'id_user' => $fileAccess->id_user,
            'id_file' => $fileAccess->id_file
        ];
        return $data;
    }
}
