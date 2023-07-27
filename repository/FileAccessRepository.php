<?php
// require_once '../config/connection.php';
// require_once '../entity/FileAccess.php';
class FileAccessRepository extends BaseRepository
{
    public static function loadByIdFile($idFile)
    {
        $conn = self::getConnection();
        try {
            $fileAccess = $conn->query(" SELECT DISTINCT id_user FROM `fileAccess` WHERE id_file =$idFile")->fetchAll(PDO::FETCH_CLASS, 'FileAccess');
            return $fileAccess;
        } catch (Exception $e) {
            exit($e->getMessage());
        }
    }
    public static function save(fileAccess $fileAccess)
    {
        $conn = self::getConnection();
        $data = self::accessSerialize($fileAccess);
        try {
            $sql = "INSERT INTO fileAccess(id_file, id_user) values (:id_file, :id_user)";
            $conn->prepare($sql)->execute($data);
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

    public static function delete(FileAccess $fileAccess)
    {
        $conn = self::getConnection();
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
