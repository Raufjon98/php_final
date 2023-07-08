<?php

require_once '../entity/File.php';
require_once '../../src/connection.php';

class FileRepository
{
    public static function load()
    {
        $conn = getConnection();
        try {
            $files = $conn->query("SELECT * FROM files where status=1")->fetchAll(PDO::FETCH_CLASS, 'File');
            return $files;
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

    public static function loadById($id)
    {
        $conn = getConnection();
        try {
            $file = $conn->query("SELECT * FROM files where id=$id and status=1")->fetchObject('File');
            return $file;
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }
    public static function save(File $file)
    {
        $conn = getConnection();
        $data = self::fileSerialize($file);
        try {
            $sql = "INSERT INTO files (id_dir, realFileName, fileName, extension, status) values(:directoryId, :realFileName, :fileName', :extention, 1)";
            $conn->prepare($sql)->execute($data);
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }
    public static function update(File $file, $id)
    {
        $conn = getConnection();
        $data = self::fileSerialize($file);
        try {
            $sql = " UPDATE files SET id_dir=:directoryId, realFileName=:realFileName, filename=:FileName, extention=:extensio status=:status WHERE id=$id";
            $conn->prepare($sql)->execute($data);
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }
    public static function delete($id)
    {
        $conn = getConnection();
        try {
            $sql = " UPDATE files SET status = 0 where id=:id";
            $conn->prepare($sql)->execute(['id' => $id]);
            echo 'File removed!';
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

    private static function fileSerialize(File $file)
    {
        $data = [
            'directoryId' => $file->directoryId,
            'realfileName' => $file->realFileName,
            'fileName' => $file->fileName,
            'extention' => $file->extension,
            'status' => $file->status
        ];
        return $data;
    }
}
