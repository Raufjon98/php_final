<?php 
require_once 'BaseEntity.php';
class File extends BaseEntity
{
   public $directoryId;
   public $realFileName;
   public $fileName;
   public $extension;
   public $status;
}