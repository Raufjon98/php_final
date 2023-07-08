<?php
 class ValidationService
 {
    public static function checkFileValid($_POST)
    {
        if (!isset($_POST['uploadBtn']) && $_POST['uploadBtn'] == 'upload') {
          throw new Exception('Enter uploadBtn with value upload!');
        }
        if (!isset($_POST['action']) && $_POST['action'] === 'add') {
            throw new Exception('Enter action with  value add');
        }
        if (!isset($_POST['id_dir'])){
            throw new Exception('Enter id_dir value');
        }
        if (!isset($_FILES))
        {
            throw new Exception ('Upload file');
        }
        if(!isset($_POST['directoryId']))
        {
            throw new Exception('Enter directoryId!');
        }
    }
    public static function renameFileValid($_POST)
    {
        if (!isset($_POST['uploadBtn']) && $_POST['uploadBtn'] == 'upload') {
            throw new Exception('Enter uploadBtn with value upload!');
          }
          if (!isset($_POST['action']) && $_POST['action'] === 'move') {
              throw new Exception('Enter action with  value move');
          }
          if (!isset($_POST['newName'])){
              throw new Exception('Enter newName value');
          }
          if(!isset($_POST['id_dir']))
          {
              throw new Exception('Enter id_dir!');
          }
          if(!isset($_POST['id_file']))
          {
            throw new Exception('Enter id_file!');
          }
//parent id is not required
    }
 }