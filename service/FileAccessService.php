<?php 

class FileAccessService
{
    public static function loadAccess($idFile)
    {
        $filesAccess = self::loadByIdFile($idFile); 
        return UserService::LoadByIdArray($filesAccess); 
    }
    public static function loadByIdFile($idFile)
    {
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
        $fileAccess = new FileAccess();
        $fileAccess->id_file = $data['id_file'];
        $fileAccess->id_user = $data['id_user'];
        return $fileAccess;
    }
}