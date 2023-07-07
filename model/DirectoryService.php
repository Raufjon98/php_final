<?php 
class DirectoryService 
{
    public static function addDirectory($data)
    {
        $directory = DirectoryRepository::loadById($data['parent_id']);
        $dirName = 'files/' . $directory['dirName'] . '/' . $data['name'];
        if (file_exists($dirName)) {
            echo "The directory $dirName exists.";
            die;
        } else {
            //should write save directory to DB!!! i Think
            mkdir($dirName);
            echo "The directory $dirName was successfully created.";
            exit;
        }
    }

    public static function renameDirectory($data)
    {
        $conn = getConnection();
        if (!is_dir($data['name'])) {
            try {
                $sql = " UPDATE directory SET dirName ='{$data['name']}' where id= {$data['id']}";
                //ask how to update only dirname
                $conn->prepare($sql)->execute();
            } catch (PDOException $e) {
                exit($e->getMessage());
            }
        } else  echo "The directory" . $data['name'] . "exists.";
    }

    public static function loadById($id)
    {
       $directory = DirectoryRepository::loadById($id);
       return self::directoryDeserialize($directory); 
    }

    public static function delete($id)
    {
        $conn = getConnection();
        $dir = DirectoryRepository::loadById($id);
        $directory = self::directoryDeserialize($dir);
        
        echo  $dirPath  = 'files/' . $directory->directoryName;
        self::remove($dirPath);
        try {
            $sql = " UPDATE directory SET status = 0  where id= $id";
            //ask how to update only status
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

    private static function directoryDeserialize($data)
    {
        $directory = new Directory();
        $directory->directoryName = $data['directoryName'];
        $directory->parent_id = $data['parent_id'];
        $directory->status = 1;
        return $directory;
    }
    
    private static function mapToDirectoryViewModel(Directory $directory)
    {
        $directoryViewModel = new DirectoryViewModel();
        $directoryViewModel->directoryName = $directory->directoryName;
        $directoryViewModel->parent_id = $directory->parent_id; 
        return $directoryViewModel;
    }

}