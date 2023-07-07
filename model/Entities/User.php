<?php

require_once 'BaseEntity.php';

class User extends BaseEntity
{
    public $email;
    public $password;
    public $fullName;
    public int $age;
    public $gender;
    public int $status;
}
