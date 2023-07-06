<?

require_once 'src/Connection.php';

class File
{
    public static function fileList()
    {
        $conn = getConnection();
        try {
            $files = $conn->query("SELECT * FROM files")->fetchAll();
            return json_encode($files);
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

    public static function getFile($id)
    {
        $conn = getConnection();
        try {
            $file = $conn->query("SELECT * FROM files where id=$id ")->fetch();
            return json_encode($file);
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }
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
        try {
            $file = $conn->query("SELECT * FROM files where id=$idFile ")->fetch();
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
        try {
            $oldDir = $conn->query("SELECT * FROM directory where id={$file['id_dir']}")->fetch();
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
        try {
            $newDir = $conn->query("SELECT * FROM directory where id=$idDir")->fetch();
        } catch (PDOException $e) {
            exit($e->getMessage());
        }

        $fileNameCmps = explode(".", $file['realFileName']);
        $fileExtension = strtolower(end($fileNameCmps));
        $fileName = $newName . '.' . $fileExtension;
        if (rename('files/' . $oldDir['dirName'] . '/' . $file['fileName'], 'files/' . $newDir['dirName'] . '/' . $file['fileName'])) {
            echo 'File moved!';
        } else echo $oldDir['dirName'] . '/' . $file['fileName'], $newDir['dirName'] . '/' . $file['fileName'];
        try {
            $sql = " UPDATE files SET realFileName ='$fileName', id_dir = $idDir  where id=$idFile";
            $conn->prepare($sql)->execute();
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }
    public static function deleteFile($id)
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
    public static function addDir($data)
    {
        $conn = getConnection();
        try {
            $directory = $conn->query("SELECT * FROM directory where id={$data['parent_id']} ")->fetch();
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
        $dirName = 'files/' . $directory['dirName'] . '/' . $data['name'];

        if (file_exists($dirName)) {
            echo "The directory $dirName exists.";
            die;
        } else {
            mkdir($dirName);
            echo "The directory $dirName was successfully created.";
            exit;
        }
    }
    public static function renameDir($data)
    {
        $conn = getConnection();
        var_dump($data);
        if (!is_dir($data['name'])) {
            try {
                $sql = " UPDATE directory SET dirName ='{$data['name']}' where id= {$data['id']}";
                $conn->prepare($sql)->execute();
            } catch (PDOException $e) {
                exit($e->getMessage());
            }
        } else  echo "The directory" . $data['name'] . "exists.";
    }
    public static function getDir($id)
    {
        $conn = getConnection();
        try {
            $directory = $conn->query("Select * from directory where id=$id")->fetch();
            return json_encode($directory);
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }
    public static function deleteDir($id)
    {
        $conn = getConnection();
        try {
            $dir = $conn->query("SELECT * FROM directory where id=$id ")->fetch();
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
        echo  $dirPath  = 'files/' . $dir['dirName'];
        self::remove($dirPath);
        try {
            $sql = " UPDATE directory SET status = 0  where id= $id";
            $conn->prepare($sql)->execute();
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
        echo 'Directory removed successfully!';
    }
    public static function remove($dirPath)
    {
        if (!is_dir($dirPath)) {
            throw new InvalidArgumentException("$dirPath must be a directory");
        }
        if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
            $dirPath .= '/';
        }
        $files = glob($dirPath . '*', GLOB_MARK);
        foreach ($files as $file) {
            if (is_dir($file)) {
                self::remove($file);
            } else {
                unlink($file);
            }
        }
        rmdir($dirPath);
    }

    public static function fileAccess($idFile)
    {
        $conn = getConnection();
        try {
            $accessArr = $conn->query("SELECT fullName  FROM `User` WHERE id IN(SELECT id_user FROM `fileAccess` WHERE id_file =$idFile)")->fetchAll();
            var_dump( $accessArr);
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }
    public static function addAccess($idFile, $idUser){
        $conn = getConnection();
        try {
           $sql = "INSERT INTO fileAccess(id_file, id_user) values ($idFile, $idUser)";
           $conn->prepare($sql)->execute();
           echo "Access added!";
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }
    public static function removeAccess($idFile, $idUser){
        $conn = getConnection();
        try {
           $sql = "Delete from fileAccess where id_file = $idFile and id_user = $idUser";
           $conn->prepare($sql)->execute();
           echo 'Access removed!';
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }
}
