<?php
require_once '../entity/Directory.php';
class DirectoryService
{
    public static function addDirectory($data)
    {
        $directory = self::directoryDeserialize($data);
        if ($data['parent_id']) {
            $parentDrectory = DirectoryRepository::loadById($data['parent_id']);
            $directoryToAdd = 'files/' . $parentDrectory->dirName . '/' . $directory->directoryName;
        } else {
            $directoryToAdd = 'files/' . $directory->directoryName;
        }


        if (file_exists($directoryToAdd)) {
            echo "The directory $directoryToAdd exists.";
            die;
        } else {
            mkdir($directoryToAdd);
            DirectoryRepository::save($directory);
            echo "The directory $directoryToAdd was successfully created.";
            exit;
        }
    }

    public static function renameDirectory($data)
    {
        $directory = self::directoryDeserialize($data);
        if (!is_dir($directory->directoryName)) {
            DirectoryRepository::update($directory);
        } else  echo "The directory" . $directory->directoryName . "exists.";
    }

    public static function loadById($id)
    {
        $directory = DirectoryRepository::loadById($id);
        return self::mapToDirectoryViewModel($directory);
    }

    public static function delete($id)
    {
        $directory = DirectoryRepository::loadById($id);
        $parentDerictory = DirectoryRepository::loadById($directory->parent_id);
        $dirPath  = 'files/' . $parentDerictory->dirName . '/' . $directory->dirName;
        if($parentDerictory->dirName!='')
        {
            self::remove($dirPath);
            DirectoryRepository::updateStatus(0, $id);
            echo ' Directory removed successfully!';
        }else{echo 'the path is not directory';}
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
        $directory->id = $data['id'];
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
