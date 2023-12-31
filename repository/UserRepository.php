<?php

// require_once '../entity/User.php';
// require_once '../../src/connection.php';

class UserRepository extends BaseRepository
{
    public static function load()
    {
        $conn = self::getConnection();
        try {
            $users = $conn->query("SELECT * FROM User where status = 2")->fetchAll(PDO::FETCH_CLASS, 'User');
            return $users;
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

    public static function loadById(int $id)
    {
        $conn = self::getConnection();
        try {
            $user = $conn->query("SELECT * FROM User where id=$id")->fetchObject('User');
            return $user;
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

    public static function LoadByIdArray($arrayOfId)
    {
        
        $conn = self::getConnection();
        try{
            echo $users = $conn->query("SELECT * FROM `User` WHERE id IN($arrayOfId)")->fetchAll(PDO::FETCH_CLASS, 'User');
            return $users;
        }catch(Exception $e){
            exit($e->getMessage());
        }

    }
    public static function save(User $user)
    {
        $conn = self::getConnection();
        $data = self::userSerialize($user);
        try {
            $sql = "INSERT INTO User ( email, password, fullName, age, gender, status) values(:email, :password, :fullName, :age, :gender, :status)";
            $conn->prepare($sql)->execute($data);
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

    public static function update(User $user)
    {
        $conn = self::getConnection();
        $data = self::userSerialize($user);
        try {
            $sql = "UPDATE User SET email=:email, password=:password, fullName=:fullName, age=:age, gender=:gender, status=:status WHERE id=:id";
            $conn->prepare($sql)->execute($data);
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

    public static function delete($id)
    {
        $conn = self::getConnection();
        try {
            $sql = " UPDATE User SET status = 3 where id=:id";
            $conn->prepare($sql)->execute(['id' => $id]);
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

    public static function loadByEmailAndPassword($email, $password)
    {
        $conn = self::getConnection();
        $checkingpassword = md5($password);
        try {
            $user = $conn->query("SELECT * FROM User where email='$email' and password = '$checkingpassword' limit 1")->fetch(PDO::FETCH_CLASS, 'User');
            return $user;
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

    public static function resetPassword($email, $password)
    {
        $conn = self::getConnection();
        try {
            $sql = " UPDATE User SET password ='$password', status = 4  where email=:email";
            $conn->prepare($sql)->execute(['email' => $email]);
        } catch (PDOException $e) {
            exit($e->getMessage());
        }

        try {
            $sql = "INSERT INTO reset_password ( email, key, expDate) values($email, $password, date('Y-M-d')";
            $conn->prepare($sql)->execute();
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

    public static function updatePassword($email, $password1, $password2)
    {
        $conn = self::getConnection();
        if ($password1 != $password2) {
            echo 'Password don`t match. Passwords are should be same!';
        } else {
            try {
                $sql = " UPDATE User SET password = $password1 where email = $email";
                $conn->prepare($sql)->execute();
            } catch (PDOException $e) {
                exit($e->getMessage());
            }
            try {
                $sql = "Delete from reset_password where email = $email";
                $conn->prepare($sql)->execute();
            } catch (PDOException $e) {
                exit($e->getMessage());
            }
        }
    }

    public static function search($email)
    {
        $conn = self::getConnection();
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo  "Invalid email format";
        } else {
            try {
                $user = $conn->query("Select * from User where email = '$email'")->fetch(PDO::FETCH_CLASS, 'User');
                return $user;
            } catch (PDOException $e) {
                exit($e->getMessage());
            }
        }
    }
    private static function userSerialize(User $user)
    {
        $data = [
            'fullName' => $user->fullName,
            'age' => $user->age,
            'email' => $user->email,
            'gender' => $user->gender,
            'password' => $user->password,
            'id' =>$user->id,
            'status' => 1
        ];
        return $data;
    }
}
