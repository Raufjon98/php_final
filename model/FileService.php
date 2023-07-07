<?php

require_once 'Entities/File.php';
require_once 'src/connection.php';

class FileService
{
    public static function addFile($data, $idDir)
    {
        $conn = getConnection();
        $maxFilesize = 2097152;
        $tmpPath = $_FILES['file']['tmp_name'];
        $fileName  = $_FILES['file']['name'];
        $fileSize  = $_FILES['file']['size'];
        $fileType = $_FILES['file']['type'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));
        $newFileName = uniqid('file_') . '.' .  $fileExtension;
        $allowedfileExtension = array('png', 'jpg', 'docx', 'doc', 'pdf');
        if ($fileSize <= $maxFilesize) {
            if (in_array($fileExtension, $allowedfileExtension)) {
                $uploadPath = 'files/doc';
                $filePath = $uploadPath . '/' . $newFileName;

                if (move_uploaded_file($tmpPath, $filePath)) {
                    try {
                        //ask how to use method
                        $sql = "INSERT INTO files (id, id_dir, realFileName, fileName, extension) values(default, $idDir, '$fileName', '$newFileName', '$fileExtension' )";
                        $conn->prepare($sql)->execute();
                        echo 'File successfully uploaded!';
                    } catch (PDOException $e) {
                        exit($e->getMessage());
                    }
                } else {
                    echo 'Moving error!';
                }
            } else {
                echo 'Extension error!';
            }
        } else {
            echo 'File size error!';
        }
    }

    public static function moveFile($newName, $idDir, $idFile)
    {
        $conn = getConnection();
        $file = FileRepository::loadById($idFile);
        $oldDir = DirectoryService::loadById($file['id_dir']);
        $newDir = DirectoryService::loadById($idDir);
        $fileNameCmps = explode(".", $file['realFileName']);
        $fileExtension = strtolower(end($fileNameCmps));
        $fileName = $newName . '.' . $fileExtension;
        if (rename('files/' . $oldDir->directoryName . '/' . $file['fileName'], 'files/' . $newDir->directoryName . '/' . $file->fileName)) {
            echo 'File moved!';
        } else echo $oldDir->directoryName . '/' . $file->fileName, $newDir->directoryName . '/' . $file->fileName;
        try {
            //ask how to use method to update not full properties
            $sql = " UPDATE files SET realFileName ='$fileName', id_dir = $idDir  where id=$idFile";
            $conn->prepare($sql)->execute();
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }



    public static function load()
    {
        $files = FileRepository::load();
        $result = [];
        foreach ($files as $file) {
            array_push($result, self::mapToFileViewModel($file));
        }
        return $result;
    }
    public static function loadById($id)
    {
        $file = FileRepository::loadById($id);
        $fileView = self::mapToFileViewModel($file);
        return $fileView;
    }

    public static function save($data)
    {
        $file = self::fileDesetialize($data);
        return FileRepository::save($file);
    }
    public static function update($data, $id)
    {
        $file = self::fileDesetialize($data);
        return FileRepository::update($file, $id);
    }

    public static function delete($id)
    {
        return FileRepository::delete($id);
    }

    
    private static function fileDesetialize($data)
    {
        $file = new File();
        $file->directoryId = $data['directoryID'];
        $file->realFileName = $data['realFileName'];
        $file->fileName = $data['fileName'];
        $file->extension = $data['extension'];
        $file->status = 1;
        return $file;
    }

    public static function mapToFileViewModel(File $file)
    {
        $fileViewModel = new FileViewModel();
        $fileViewModel->fileName = $file->realFileName;
        $fileViewModel->extension = $file->extension;
        return $fileViewModel;
    }
}
