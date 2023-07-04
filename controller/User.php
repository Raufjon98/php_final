<?php
session_start();

require_once 'src/Connection.php';
require_once 'PHPMailer/src/PHPMailer.php';
require_once 'PHPMailer/src/SMTP.php';
require_once 'PHPMailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class User
{


    public static function login($email, $password)
    {
        $conn = getConnection();
        $checkingpassword = md5($password);
        try {
            $user = $conn->query("SELECT * FROM User where email='$email' and password = '$checkingpassword' limit 1")->fetch();
            if ($user) {
                $_SESSION['intrance'] = 1;
                $_SESSION['uid'] = $user['id'];
            } else  http_response_code(404);
            exit;
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

    public static function logout()
    {
        if ($_SESSION['intrance'] === 1) {
            session_destroy();
            header('location: http://final/');
        }
    }

    public static function resetPassword($email)
    {
        $conn = getConnection();
        $newPassword = uniqid(date('Y-m-d') + rand(1, 100) + $email);
        $md5Password = md5($newPassword);
        $smtpUserName = 'your@gmail.com';
        $smtpPassword = 'yourPassword';
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = $smtpUserName;
        $mail->Password = $smtpPassword;
        $mail->SMTPSecure = 'tls';
        $mail->Port = '587';
        $mail->setFrom('sneder@gmail.com', 'developer team');
        $mail->addAddress($email, 'mail owner!');
        $mail->Subject = 'Reset password!';
        $mail->Body = '<p>Dear user, Your password was reseted!</p>
        <a href = "http://final/resetPassword?action=reset&email=' . $email . '$key=' . $md5Password . '" target="_blank">Click here to add new password!</a>';
        try {
            $mail->send();
            echo 'Email sent successfully!';
            try {
                $sql = " UPDATE User SET password ='$md5Password', status = 4  where email=:email";
                $conn->prepare($sql)->execute(['email' => $email]);
            } catch (PDOException $e) {
                exit($e->getMessage());
            }

            try {
                $sql = "INSERT INTO reset_password ( email, key, expDate) values($email, $md5Password, date('Y-M-d')";
                $conn->prepare($sql)->execute();
            } catch (PDOException $e) {
                exit($e->getMessage());
            }
        } catch (Exception $e) {
            echo 'Email could not be sent. Error: ', $mail->ErrorInfo;
        }
    }

    public static function updatePassword($email, $password1, $password2)
    {
        $conn = getConnection();
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

    public  static function userList()
    {
        $conn = getConnection();
        try {
            $users = $conn->query("SELECT * FROM User where status = 2")->fetchAll();
            var_dump($users);
            // return json_encode($users);
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

    public static  function getUser($id)
    {
        $conn = getConnection();
        try {
            $user = $conn->query("SELECT * FROM User where id=$id ")->fetch();
            return json_encode($user);
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

    public static function create($data)
    {
        $conn = getConnection();
        try {
            $sql = "INSERT INTO User ( email, password, fullName, age, gender, status) values(:email, :password, :fullName, :age, :gender, :status)";
            $conn->prepare($sql)->execute($data);
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

    public static function delete($id)
    {
        $conn = getConnection();
        try {
            $sql = " UPDATE User SET status = 3 where id=:id";
            $conn->prepare($sql)->execute(['id' => $id]);
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

    public static function update($data, $id)
    {
        $conn = getConnection();
        try {
            $sql = "UPDATE User SET email=:email, password=:password, fullName=:fullName, age=:age, gender=:gender, status=:status WHERE id=$id";
            $conn->prepare($sql)->execute($data);
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

    public static function search($email)
    {
        $conn = getConnection();
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo  "Invalid email format";
        } else {
            try {
                $user= $conn->query( "Select * from User where email = '$email'")->fetch();
                var_dump($user);
            } catch (PDOException $e) {
                exit($e->getMessage());
            }
        }
    }
}
