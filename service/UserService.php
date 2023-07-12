<?php


require_once 'PHPMailer/src/PHPMailer.php';
require_once 'PHPMailer/src/SMTP.php';
require_once 'PHPMailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


class UserService
{
    public static function login($email, $password)
    {
        $checkingpassword = md5($password);
        try {
            $user = UserRepository::loadByEmailAndPassword($email, $password);
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
            header('location: http://final');
        }
    }

    public static function resetPassword($email)
    {
        $newPassword = md5(uniqid(date('Y-m-d') + rand(1, 100) + $email));
        self::sendEmail($email, $newPassword);
        UserRepository::resetPassword($email, $newPassword);
    }

    public static function sendEmail($email, $newPassword)
    {
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'raufjonaliboev77@gmail.com';
        $mail->Password = '';
        $mail->SMTPSecure = 'tls';
        $mail->Port = '587';
        $mail->setFrom('raufjonaliboev77@gmail.com', 'Developer Team');
        $mail->addAddress($email, 'Dear User');
        $mail->Subject = 'Reset password!';
        $email->Body = '<p>Dear user, Your password was reseted!</p>
        <a href = "http://final/resetPassword?action=reset&email=' . $email . '$key=' . $newPassword . '" target="_blank">Click here to add new password!</a>';
        try {
            $mail->send();
            echo 'Email sent successfully!';
        } catch (Exception $e) {
            echo 'Email could not be sent. Error: ', $mail->ErrorInfo;
        }
    }
    public static function search($email)
    {
        $user = UserRepository::search($email);
        return self::mapToUSerViewModel($user);
    }
    public static function load()
    {
        $users =  UserRepository::load();
        $result = [];
        foreach ($users as $user) {
            array_push($result, self::mapToUSerViewModel($user));
        }
        return $result;
    }

    public static function loadById(int $id)
    {

        $user = UserRepository::loadById($id);
        return self::mapToUSerViewModel($user);
    }

    public static function LoadByIdArray($array)
    {
        $idUsers='';
        foreach ($array as $object) {
            $idUsers .= ((int)$object->id_user).',';
        }
        $idUsers = substr($idUsers, 0, -1);
        var_dump($idUsers);
        $users = UserRepository::LoadByIdArray($idUsers);
        $result = [];
        foreach ($users as $user)
        {
            array_push($result, self::mapToUSerViewModel($user)->fullName);
        }
        return $result;
    }
    public static function save($data)
    {
        $user = self::userDeserialize($data);
        return UserRepository::save($user);
    }
    public static function update($data, $id)
    {
        $user = self::userDeserialize($data);
        return UserRepository::update($user, $id);
    }
    public static function delete($id)
    {
        return UserRepository::delete($id);
    }

    public static function updatePassword($email, $password1, $password2)
    {
        return UserRepository::updatePassword($email, $password1, $password2);
    }
    private static function userDeserialize($data)
    {
        $user  = new User();
        $user->age = intval($data['age']);
        $user->email = $data['email'];
        $user->fullName = $data['fullName'];
        $user->gender = $data['gender'];
        $user->password = $data['password'];
        $user->status = 1;
        return $user;
    }
    private static function mapToUSerViewModel(User $user)
    {
        $userViewModel = new UserViewModel();
        $userViewModel->age = $user->age;
        $userViewModel->email = $user->email;
        $userViewModel->fullName = $user->fullName;
        $userViewModel->gender = $user->gender;
        return $userViewModel;
    }
}
