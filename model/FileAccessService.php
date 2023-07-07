<?php 
class FileAccessService
{
    public static function loadAccess($idFile)
    {
        //ask
        $conn = getConnection();
        try {
            $accessArr = $conn->query("SELECT fullName  FROM `User` WHERE id IN(SELECT id_user FROM `fileAccess` WHERE id_file =$idFile)")->fetchAll();
            var_dump($accessArr);
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }
    public static function save($data)
    {
        $fileAccess = self::accessDeserialize($data);
        return FileAccessRepository::save($fileAccess);
    }
    public static function delete($data)
    {
       $fileAccess = self::accessDeserialize($data);
       return fileAccessRepository::delete($fileAccess);
    }
    private static function accessDeserialize($data)
    {
        $fileAccess = new fileAccess();
        $fileAccess->id_file = $data['id_file'];
        $fileAccess->id_user = $data['id_user'];
        return $fileAccess;
    }
}