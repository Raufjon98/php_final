<?php 

require_once '../entity/FileAccess.php';
class FileAccessService
{
    public static function loadAccess($idFile)
    {
        $filesAccess = self::loadByIdFile($idFile); //returns object
        return UserService::LoadByIdArray($filesAccess); //array of objeccts
    }
    public static function loadByIdFile($idFile)
    {
        //ask returns error not found class 
       return FileAccessRepository::loadByIdFile($idFile);
    }
    public static function save($data)
    {
        $fileAccess = self::accessDeserialize($data);
        return FileAccessRepository::save($fileAccess);
    }
    public static function delete($data)
    {
       $fileAccess = self::accessDeserialize($data);
       return FileAccessRepository::delete($fileAccess);
    }
    private static function accessDeserialize($data)
    {
        $fileAccess = new fileAccess();
        $fileAccess->id_file = $data['id_file'];
        $fileAccess->id_user = $data['id_user'];
        return $fileAccess;
    }
}